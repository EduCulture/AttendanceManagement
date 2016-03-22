<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 07-09-2015
 * Time: 11:04 AM
 */

App::uses('AppController', 'Controller');

class SubjectsController extends AppController {

    private $error = array();

    public function index() {
        $this->getList();
    }

    public function add() {

        //pr($this->request->data);die;
        if($this->request->is('post') && $this->validateForm()){

            if(!isset($this->request->data['active'])){
                $this->request->data['is_active'] = 0;
            }else{
                $this->request->data['is_active'] = 1;
            }

            if($this->Subject->add($this->request->data)) {
                $this->Session->setFlash('Subject Added Successfully','flash');
                $this->redirect(array('controller' => 'subjects', 'action' => 'index'));
            }
        }

        $this->getForm();

        $this->view = 'form';
    }

    public function edit() {

        if($this->request->is('post') && $this->validateForm()){

            if(!isset($this->request->data['active'])){
                $this->request->data['is_active'] = 0;
            }else{
                $this->request->data['is_active'] = 1;
            }

            if($this->Subject->update($this->request->data,$this->request->data['section_id'])) {
                $this->Session->setFlash('Subject Updated Successfully','flash');
                $this->redirect(array('controller' => 'subjects', 'action' => 'index'));
            }
        }

        $this->getForm();

        $this->view = 'form';
    }

    public function getList() {

        $this->recursive = -1;
        $subjects = $this->Subject->find('all',array(
            'conditions' => array('Subject.is_delete' => 0,'Subject.school_id' => CakeSession::read('Auth.User.school_id'))
        ));

        //pr($standards);die;
        $this->set('subjects',$subjects);
    }

    public function getForm() {

        //pr($this->request->data);die;
        if(isset($this->request->data['subject_id'])){
            $this->set('subject_id',$this->request->data['subject_id']);
        } else if(isset($this->request->query['subject_id']) && $this->request->query['subject_id']) {

            $details = $this->Subject->find('first',array(
                'conditions' => array('Subject.id' => $this->request->query['subject_id'])
            ));
            $this->set('subject_id',$this->request->query['subject_id']);

        }else{
            $this->set('subject_id','');
        }

        if(isset($this->request->data['name'])){
            $this->set('name',$this->request->data['name']);
        }else if(isset($details['Subject']['name'])){
            $this->set('name',$details['Subject']['name']);
        }else{
            $this->set('name','');
        }

        if(isset($this->request->data['logo'])){
            $this->set('logo',$this->request->data['logo']);
        }else if(isset($details['Subject']['logo'])){
            $this->set('logo',$details['Subject']['logo']);
        }else{
            $this->set('logo','');
        }

        if(isset($this->request->data['active'])){
            $this->set('active',$this->request->data['active']);
        }else if(isset($details['Subject']['is_active'])){
            $this->set('active',$details['Subject']['is_active']);
        }else{
            $this->set('active','');
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
            $this->error['name'] = 'Subject name cannot be empty';
        }else{

            $condition = array('Subject.name LIKE' => $this->request->data['name']);

            if(isset($this->request->data['subject_id'])){
                $condition['Subject.id'] = '<> '.$this->request->data['subject_id'];
            }

            $sdetails = $this->Subject->find('first',array(
                'conditions' => $condition
            ));

            if($sdetails){
                $this->error['name'] = 'Subject name already exists! Please try another name';
            }
        }

        if($this->error){
            $this->error['warning'] = 'Please Check Below Errors';
        }

        return !$this->error;
    }

    public function getSuggestion() {

        $data = $this->Subject->find('all',array(
           'conditions' => array('Subject.name LIKE' => $this->request->query['filter_name'].'%')
        ));

        //pr($data);die;
        $return = [];
        if($data){
            foreach($data as $val){
                $return[] = array(
                   'id' => $val['Subject']['id'],
                   'name' => $val['Subject']['name']
                );
            }
        }

        echo json_encode($return);
        $this->autoRender = false;
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


    public function getSubjectStaff() {

        $this->loadModel('StaffSubjectMap');
        $data = $this->StaffSubjectMap->find('all',array(
            'conditions' => array('StaffSubjectMap.subject_id' => $this->request->data['subject_id'])
        ));

        $return = [];
        if($data){
            foreach($data as $val){
                $return[] = array(
                    'staff_id' => $val['Staff']['id'],
                    'staff_name' => $val['Staff']['first_name'] .' '. $val['Staff']['last_name'],
                );
            }
        }

        echo json_encode($return);
        $this->autoRender = false;
    }
}