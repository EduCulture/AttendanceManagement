<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 07-09-2015
 * Time: 11:04 AM
 */

App::uses('AppController', 'Controller');

class SchoolsController extends AppController {

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

            if($this->School->add($this->request->data)) {
                $this->Session->setFlash('School Added Successfully','flash');
                $this->redirect(array('controller' => 'schools', 'action' => 'index'));
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

            if($this->School->update($this->request->data,$this->request->data['school_id'])) {
                $this->Session->setFlash('School Updated Successfully','flash');
                $this->redirect(array('controller' => 'schools', 'action' => 'index'));
            }
        }

        $this->getForm();

        $this->view = 'form';
    }

    public function getList() {

        //$this->School->query("SET CHARACTER SET utf8;");

        $is_filter = false;

        $filter = array('School.is_delete' => 0);
        if(isset($this->request->query['filter_name']) && $this->request->query['filter_name']){
            $is_filter = true;
            $filter['School.name LIKE'] = $this->request->query['filter_name'] .'%';
        }

        if(isset($this->request->query['filter_type']) && $this->request->query['filter_type'] != ''){
            $is_filter = true;
            $filter['School.is_active'] = $this->request->query['filter_type'];
        }

        $this->Paginator->settings = $this->paginate;
        $data = $this->Paginator->paginate('School',$filter);

        //pr($data);die;
        $this->set('schools',$data);
        $this->set('is_filter',$is_filter);

    }

    public function getForm() {

        if(isset($this->request->data['school_id'])){
            $this->set('school_id',$this->request->data['school_id']);
            $this->set('user_id',$this->request->data['user_id']);
        } else if(isset($this->request->query['school_id']) && $this->request->query['school_id']) {

            //$this->School->query("SET CHARACTER SET utf8;");
            $details = $this->School->find('first',array(
                'conditions' => array('School.id' => $this->request->query['school_id'])
            ));
            $this->set('school_id',$this->request->query['school_id']);

            $this->loadModel('User');
            $admin_details = $this->User->find('first',array(
                'conditions' => array('User.school_id' => $this->request->query['school_id'],'role_id' => 2)
            ));
            $this->set('user_id',$admin_details['User']['id']);

        }else{
            $this->set('school_id','');
            $this->set('user_id','');
        }


        if(isset($this->request->data['name'])){
            $this->set('name',$this->request->data['name']);
        }else if(isset($details['School']['name'])){
            $this->set('name',$details['School']['name']);
        }else{
            $this->set('name','');
        }

        if(isset($this->request->data['logo'])){
            $this->set('logo',$this->request->data['logo']);
        }else if(isset($details['School']['logo'])){
            $this->set('logo',$details['School']['logo']);
        }else{
            $this->set('logo','');
        }

        if(isset($this->request->data['address'])){
            $this->set('address',$this->request->data['address']);
        }else if(isset($details['School']['address'])){
            $this->set('address',$details['School']['address']);
        }else{
            $this->set('address','');
        }

        if(isset($this->request->data['description'])){
            $this->set('description',$this->request->data['description']);
        }else if(isset($details['School']['description'])){
            $this->set('description',$details['School']['description']);
        }else{
            $this->set('description','');
        }

        if(isset($this->request->data['contact_number'])){
            $this->set('contact_number',$this->request->data['contact_number']);
        }else if(isset($details['School']['contact_number'])){
            $this->set('contact_number',$details['School']['contact_number']);
        }else{
            $this->set('contact_number','');
        }

        if(isset($this->request->data['active'])){
            $this->set('active',$this->request->data['active']);
        }else if(isset($details['School']['is_active'])){
            $this->set('active',$details['School']['is_active']);
        }else{
            $this->set('active','');
        }

        //School Admin Details
        if(isset($this->request->data['email'])){
            $this->set('email',$this->request->data['email']);
        }else if(isset($admin_details['User']['email'])){
            $this->set('email',$admin_details['User']['email']);
        }else{
            $this->set('email','');
        }

        if(isset($this->request->data['username'])){
            $this->set('username',$this->request->data['username']);
        }else if(isset($admin_details['User']['username'])){
            $this->set('username',$admin_details['User']['username']);
        }else{
            $this->set('username','');
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

        if (isset($this->error['address'])) {
            $this->set('error_address',$this->error['address']);
        } else {
            $this->set('error_address','');
        }

        if (isset($this->error['contact_number'])) {
            $this->set('error_contact_number',$this->error['contact_number']);
        } else {
            $this->set('error_contact_number','');
        }

        if (isset($this->error['email'])) {
            $this->set('error_email',$this->error['email']);
        } else {
            $this->set('error_email','');
        }

        if (isset($this->error['username'])) {
            $this->set('error_username',$this->error['username']);
        } else {
            $this->set('error_username','');
        }

        if (isset($this->error['password'])) {
            $this->set('error_password',$this->error['password']);
        } else {
            $this->set('error_password','');
        }
    }

    public function validateForm() {

        if (strlen($this->request->data['name']) < 3) {
            $this->error['name'] = 'School name must be greater than 3 characters';
        }else{
            $condition = array('School.name LIKE' => $this->request->data['name']);

            if(isset($this->request->data['school_id'])){
                $condition['School.id'] = '<> '.$this->request->data['school_id'];
            }

            $details = $this->School->find('first',array(
                'conditions' => $condition
            ));

            if($details){
                $this->error['name'] = 'School name already exists';
            }
        }

        if (strlen($this->request->data['address']) < 3) {
            $this->error['address'] = 'Address must be greater than 3 characters';
        }

        if (strlen($this->request->data['contact_number']) < 3 || !is_numeric($this->request->data['contact_number'])) {
            $this->error['contact_number'] = 'Contact number must be greater than 3 characters & In Numeric format';
        }

        if ((strlen($this->request->data['email']) > 96) || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->data['email'])) {
            $this->error['email'] = 'Invalid email address';
        }

        if (strlen($this->request->data['username']) < 3 || strlen($this->request->data['username']) > 10) {
            $this->error['username'] = 'Invalid username';
        }else{
            $this->loadModel('User');

            $condition = array('User.username LIKE' => $this->request->data['username']);

            if(isset($this->request->data['user_id'])){
                $condition['User.id'] = '<> '.$this->request->data['user_id'];
            }

            $udetails = $this->User->find('first',array(
                'conditions' => $condition
            ));

            if($udetails){
                $this->error['username'] = 'Username already exists! Please try another username';
            }
        }

        if(!isset($this->request->data['school_id'])){
            if (strlen($this->request->data['password']) < 3 || strlen($this->request->data['password']) > 10) {
                $this->error['password'] = 'Password must be between 4 to 10 character long';
            }
        }else if($this->request->data['school_id'] && $this->request->data['password']){
            if (strlen($this->request->data['password']) < 3 || strlen($this->request->data['password']) > 10) {
                $this->error['password'] = 'Password must be between 4 to 10 character long';
            }
        }

        if($this->error){
            $this->error['warning'] = 'Please Check Below Errors';
        }

        return !$this->error;
    }
}