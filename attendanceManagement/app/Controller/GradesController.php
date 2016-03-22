<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 07-09-2015
 * Time: 11:04 AM
 */

App::uses('AppController', 'Controller');

class GradesController extends AppController {

    private $error = array();

    public function index() {
        $this->getList();
    }

    public function add() {

        //pr($this->request->data);die;
        if($this->request->is('post') && $this->validateForm()){
            if($this->Grade->add($this->request->data)) {
                $this->Session->setFlash('Grade Added Successfully','flash');
                $this->redirect(array('controller' => 'grades', 'action' => 'index'));
            }
        }

        $this->getForm();

        $this->view = 'form';
    }

    public function edit() {

        if($this->request->is('post') && $this->validateForm()){
            if($this->Grade->update($this->request->data,$this->request->data['grade_id'])) {
                $this->Session->setFlash('Grade Updated Successfully','flash');
                $this->redirect(array('controller' => 'grades', 'action' => 'index'));
            }
        }

        $this->getForm();

        $this->view = 'form';
    }

    public function getList() {

        //$this->recursive = -1;
        $grades = $this->Grade->find('all',array(
            'conditions' => array('Grade.school_id' => CakeSession::read('Auth.User.school_id'))
        ));

        //pr($standards);die;
        $this->set('grades',$grades);
    }

    public function getForm() {

        //pr($this->request->data);die;
        if(isset($this->request->data['grade_id'])){
            $this->set('grade_id',$this->request->data['grade_id']);
        } else if(isset($this->request->query['grade_id']) && $this->request->query['grade_id']) {

            $details = $this->Grade->find('first',array(
                'conditions' => array('Grade.id' => $this->request->query['grade_id'])
            ));
            $this->set('grade_id',$this->request->query['grade_id']);

        }else{
            $this->set('grade_id','');
        }

        if(isset($this->request->data['name'])){
            $this->set('name',$this->request->data['name']);
        }else if(isset($details['Grade']['name'])){
            $this->set('name',$details['Grade']['name']);
        }else{
            $this->set('name','');
        }

        if(isset($this->request->data['minimum_mark'])){
            $this->set('minimum_mark',$this->request->data['minimum_mark']);
        }else if(isset($details['Grade']['minimum_mark'])){
            $this->set('minimum_mark',$details['Grade']['minimum_mark']);
        }else{
            $this->set('minimum_mark','');
        }

        if(isset($this->request->data['maximum_mark'])){
            $this->set('maximum_mark',$this->request->data['maximum_mark']);
        }else if(isset($details['Grade']['maximum_mark'])){
            $this->set('maximum_mark',$details['Grade']['maximum_mark']);
        }else{
            $this->set('maximum_mark','');
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

        if (isset($this->error['minimum_mark'])) {
            $this->set('error_minimum_mark',$this->error['minimum_mark']);
        } else {
            $this->set('error_minimum_mark','');
        }

        if (isset($this->error['maximum_mark'])) {
            $this->set('error_maximum_mark',$this->error['maximum_mark']);
        } else {
            $this->set('error_maximum_mark','');
        }
    }

    public function validateForm() {

        //pr($this->request->data);die;

        if (!$this->request->data['name']) {
            $this->error['name'] = 'Section name must be greater than 2 characters';
        }

        if (!$this->request->data['minimum_mark'] || !is_numeric($this->request->data['minimum_mark'])) {
            $this->error['minimum_mark'] = 'Invalid';
        }

        if (!$this->request->data['maximum_mark'] || !is_numeric($this->request->data['maximum_mark'])) {
            $this->error['maximum_mark'] = 'Invalid';
        }

        if($this->error){
            $this->error['warning'] = 'Please Check Below Errors';
        }

        return !$this->error;
    }
}