<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 07-09-2015
 * Time: 11:04 AM
 */

App::uses('AppController', 'Controller');

class ExamtypeController extends AppController {

    private $error = array();

    public function index() {
        $this->getList();
    }

    public function add() {

        //pr($this->request->data);die;
        if($this->request->is('post') && $this->validateForm()){

            $this->loadModel('ExamType');
            if($this->ExamType->add($this->request->data)) {
                $this->Session->setFlash('Exam Type Added Successfully','flash');
                $this->redirect(array('controller' => 'examtype', 'action' => 'index'));
            }
        }

        $this->getForm();

        $this->view = 'form';
    }

    public function edit() {

        if($this->request->is('post') && $this->validateForm()){

            $this->loadModel('ExamType');
            if($this->ExamType->update($this->request->data,$this->request->data['type_id'])) {
                $this->Session->setFlash('Exam Type Updated Successfully','flash');
                $this->redirect(array('controller' => 'examtype', 'action' => 'index'));
            }
        }

        $this->getForm();

        $this->view = 'form';
    }

    public function getList() {

        $this->loadModel('ExamType');
        $types = $this->ExamType->find('all',array(
            'conditions' => array('ExamType.school_id' => CakeSession::read('Auth.User.school_id'))
        ));

        //pr($standards);die;
        $this->set('types',$types);
    }

    public function getForm() {

        //pr($this->request->data);die;
        if(isset($this->request->data['type_id'])){
            $this->set('type_id',$this->request->data['type_id']);
        } else if(isset($this->request->query['type_id']) && $this->request->query['type_id']) {

            $this->loadModel('ExamType');
            $details = $this->ExamType->find('first',array(
                'conditions' => array('ExamType.id' => $this->request->query['type_id'])
            ));
            $this->set('type_id',$this->request->query['type_id']);

        }else{
            $this->set('type_id','');
        }

        if(isset($this->request->data['name'])){
            $this->set('name',$this->request->data['name']);
        }else if(isset($details['ExamType']['name'])){
            $this->set('name',$details['ExamType']['name']);
        }else{
            $this->set('name','');
        }

        if(isset($this->request->data['is_available'])){
            $this->set('is_available',$this->request->data['is_available']);
        }else if(isset($details['ExamType']['is_available'])){
            $this->set('is_available',$details['ExamType']['is_available']);
        }else{
            $this->set('is_available','');
        }

        if (isset($this->error['warning'])) {
            $this->set('error_warning',$this->error['warning']);
        } else {
            $this->set('error_warning','');
        }

        if (isset($this->error['name'])) {
            $this->set('error_name',$this->error['name']);
        } else {
            $this->set('error_name','');
        }
    }

    public function validateForm() {

        //pr($this->request->data);die;

        if (!$this->request->data['name']) {
            $this->error['name'] = 'Event type cannot be empty';
        }else{

            $condition = array('ExamType.name LIKE' => $this->request->data['name']);

            if(isset($this->request->data['type_id'])){
                $condition['ExamType.id'] = '<> '.$this->request->data['type_id'];
            }

            $this->loadModel('ExamType');
            $sdetails = $this->ExamType->find('first',array(
                'conditions' => $condition
            ));

            if($sdetails){
                $this->error['name'] = 'Exam type name already exists! Please try another name';
            }
        }

        if($this->error){
            $this->error['warning'] = 'Please Check Below Errors';
        }

        return !$this->error;
    }

    public function delete() {

        if(isset($this->request->data['subject_id']) && $this->request->data['subject_id']){

            $this->Subject->updateAll(
                array('Subject.is_delete' => 1),
                array('Subject.id' => $this->request->data['subject_id'])
            );
            $this->Session->setFlash('Subject Deleted Successfully','flash');
        }
        $this->redirect(array('controller' => 'subjects', 'action' => 'index'));
    }
}