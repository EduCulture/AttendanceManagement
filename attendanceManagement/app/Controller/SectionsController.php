<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 07-09-2015
 * Time: 11:04 AM
 */

App::uses('AppController', 'Controller');

class SectionsController extends AppController {

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

            if($this->Section->add($this->request->data)) {
                $this->Session->setFlash('Section Added Successfully','flash');
                $this->redirect(array('controller' => 'sections', 'action' => 'index'));
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

            if($this->Section->update($this->request->data,$this->request->data['section_id'])) {
                $this->Session->setFlash('Section Updated Successfully','flash');
                $this->redirect(array('controller' => 'sections', 'action' => 'index'));
            }
        }

        $this->getForm();

        $this->view = 'form';
    }

    public function getList() {

        $this->recursive = -1;
        $sections = $this->Section->find('all',array(
            'conditions' => array('Section.is_delete' => 0,'Section.school_id' => CakeSession::read('Auth.User.school_id'))
        ));

        //pr($standards);die;
        $this->set('sections',$sections);
    }

    public function getForm() {

        //pr($this->request->data);die;
        if(isset($this->request->data['section_id'])){
            $this->set('section_id',$this->request->data['section_id']);
        } else if(isset($this->request->query['section_id']) && $this->request->query['section_id']) {

            $details = $this->Section->find('first',array(
                'conditions' => array('Section.id' => $this->request->query['section_id'])
            ));
            $this->set('section_id',$this->request->query['section_id']);

        }else{
            $this->set('section_id','');
        }

        if(isset($this->request->data['name'])){
            $this->set('name',$this->request->data['name']);
        }else if(isset($details['Section']['name'])){
            $this->set('name',$details['Section']['name']);
        }else{
            $this->set('name','');
        }

        if(isset($this->request->data['active'])){
            $this->set('active',$this->request->data['active']);
        }else if(isset($details['Section']['is_active'])){
            $this->set('active',$details['Section']['is_active']);
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
            $this->error['name'] = 'Section name must be greater than 2 characters';
        }

        if($this->error){
            $this->error['warning'] = 'Please Check Below Errors';
        }

        return !$this->error;
    }
}