<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 07-09-2015
 * Time: 11:04 AM
 */

App::uses('AppController', 'Controller');
App::uses('ControllerListComponent', 'Controller/Component');

class RolesController extends AppController {

    private $error = array();

    public function index() {
        $this->getList();
    }

    public function add() {

        //pr($this->request->data);die;
        if($this->request->is('post') && $this->validateForm()){

            if($this->Role->add($this->request->data)) {
                $this->Session->setFlash('Group Added Successfully','flash');
                $this->redirect(array('controller' => 'roles', 'action' => 'index'));
            }
        }

        $this->getForm();

        $this->view = 'form';
    }

    public function edit() {

        if($this->request->is('post') && $this->validateForm()){

            if($this->Role->update($this->request->data,$this->request->data['role_id'])) {
                $this->Session->setFlash('Role Updated Successfully','flash');
                $this->redirect(array('controller' => 'roles', 'action' => 'index'));
            }
        }

        $this->getForm();

        $this->view = 'form';
    }

    public function getList() {

        $data = $this->Role->find('all',array(
            'conditions' => array('Role.is_delete' => 0)
        ));

        //pr($data);die;
        $this->set('roles',$data);

    }

    public function getForm() {

        if(isset($this->request->data['role_id'])){
            $this->set('role_id',$this->request->data['role_id']);
        } else if(isset($this->request->query['role_id']) && $this->request->query['role_id']) {

            $details = $this->Role->find('first',array(
                'conditions' => array('Role.id' => $this->request->query['role_id'])
            ));
            $this->set('role_id',$this->request->query['role_id']);

        }else{
            $this->set('role_id','');
        }

        if(isset($this->request->data['name'])){
            $this->set('name',$this->request->data['name']);
        }else if(isset($details['Role']['name'])){
            $this->set('name',$details['Role']['name']);
        }else{
            $this->set('name','');
        }

        $controllerList = new ControllerListComponent();

        $permissions = $controllerList->get();
        $this->set('permissions',$permissions);
        //pr($permissions);die;

        if (isset($this->request->post['permission']['access'])) {
            $access = $this->request->post['permission']['access'];
        } elseif (isset($details['Role']['permission'])) {
            $access = unserialize($details['Role']['permission']);
        } else {
            $access = array();
        }

        $this->set('access_permission',$access);

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

        if (strlen($this->request->data['name']) < 3) {
            $this->error['name'] = 'Role name must be greater than 3 characters';
        }

        if($this->error){
            $this->error['warning'] = 'Please Check Below Errors';
        }

        return !$this->error;
    }
}