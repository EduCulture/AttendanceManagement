<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 07-09-2015
 * Time: 11:04 AM
 */

App::uses('AppController', 'Controller');

class TimingController extends AppController {

    private $error = array();

    public function index() {

        $this->loadModel('Standard');
        $standards = $this->Standard->getStandards();

        if(isset($this->request->query['standard_id'])){
            $standard_id = $this->request->query['standard_id'];
        }else{
            $standard_id = 0;
        }

        $this->set('standards',$standards);
        $this->set('standard_id',$standard_id);
    }

    public function save() {

        $json = [];
        if($this->request->is('post')){
            //echo strlen($this->request->data['name']);die;
            if(strlen(trim($this->request->data['name'])) < 3){
                $json['error']['name'] = 'Name must be greater than 3 character';
            }

            if(!$this->request->data['start_time']){
                $json['error']['start'] = 'Start Time Required';
            }

            if(!$this->request->data['end_time']){
                $json['error']['end'] = 'End Time Required';
            }else if($this->request->data['start_time'] >= $this->request->data['end_time']){
                $json['error']['end'] = 'End Time Must be greater than end time';
            }

            if(!$this->request->data['time_id']) {
                $standard_id = json_decode($this->request->data['standard_id']);
                if (!$standard_id) {
                    $json['error']['standard'] = 'One standard required';
                } else {
                    $this->request->data['standard_id'] = $standard_id;
                }

                if(!$json) {
                    $this->loadModel('Timing');
                    foreach ($standard_id as $val) {
                        $available = $this->Timing->find('first', array(
                            'conditions' => array('Timing.standard_id' => $val, 'Timing.start_time >=' => date("H:i:s", strtotime($this->request->data['start_time'])), 'Timing.end_time <' => date("H:i:s", strtotime($this->request->data['end_time'])))
                        ));

                        if($available){
                            $json['error']['start'] = 'This timing is already available between this start & end time for standard' . $val;
                            $json['error']['end'] = 'This timing is already available between this start & end time for standard' . $val;
                            break;
                        }
                    }
                }
            }

            if(!$json) {
                if(!$this->request->data['time_id']) {
                    if ($this->Timing->add($this->request->data)) {
                        $json['success'] = 'Successfully Added';
                    }
                }else{
                    if ($this->Timing->update($this->request->data,$this->request->data['time_id'])) {
                        $json['success'] = 'Successfully Updated';
                    }
                }
            }
        }else{
            $json['error'] = 'Invalid';
        }

        echo json_encode($json);
        $this->autoRender = false;
    }

    public function edit() {

        //pr($this->request->data);die;
        if($this->request->is('post') && $this->validateForm()){

            if($this->Fee->update($this->request->data,$this->request->data['fee_id'])) {
                $this->Session->setFlash('Fee Updated Successfully','flash');
                $this->redirect(array('controller' => 'fees', 'action' => 'getCategoryList'));
            }
        }

        $this->getForm();

        $this->view = 'form';
    }

    public function delete() {

        $json = [];
        $this->loadModel('Timing');
        if($this->request->is('post')){
            //$this->Timing->id = $this->request->data['time_id'];

            $detail = $this->Timing->find('first',array(
               'conditions' => array('Timing.id' => $this->request->data['time_id'])
            ));

            $this->Timing->updateAll(
               array('Timing.is_delete' => 1),
               array('Timing.standard_id' => $detail['Timing']['standard_id'],'Timing.start_time' => $detail['Timing']['start_time'],'Timing.end_time' => $detail['Timing']['end_time'])
            );
            //$this->Timing->saveField('is_delete',1);
            $json['success'] = 'Success';
        }else{
            $json['success'] = 'Error';
        }

        echo json_encode($json);
        $this->autoRender = false;
    }

    public function getList() {

        $this->loadModel('Timing');
        $timing = $this->Timing->find('all',array(
           'conditions' => array('Timing.standard_id' => $this->request->data['standard_id'],'Timing.is_delete' => 0),
           'group' => 'Timing.name'
        ));

        //pr($timing);die;
        $this->set('standard_id',$this->request->data['standard_id']);
        //$this->set('section_id',$this->request->data['section_id']);
        $this->set('timing',$timing);

        $this->view = 'list';
        $this->layout = 'ajax';
    }
}