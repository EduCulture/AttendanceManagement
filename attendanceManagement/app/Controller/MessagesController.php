<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 07-09-2015
 * Time: 11:04 AM
 */

App::uses('AppController', 'Controller');

class MessagesController extends AppController {

    private $error = array();

    public $paginate = array(
        'limit' => 15,
        'order' => array(
            'Message.id' => 'DESC'
        )
    );

    public function index() {

        $is_filter = false;

        $filter = array('Message.is_delete' => 0,'Message.school_id' => CakeSession::read('Auth.User.school_id'));
        if(isset($this->request->query['filter_user_type']) && $this->request->query['filter_user_type']){
            $is_filter = true;
            $filter['Message.role_id'] = $this->request->query['filter_user_type'];
        }

        $this->Paginator->settings = $this->paginate;
        $data = $this->Paginator->paginate('Message',$filter);

        //pr($data);die;
        $this->set('messages',$data);
        $this->set('is_filter',$is_filter);

        $this->view = 'message_list';
    }

    public function add() {

        //pr($this->request->data);die;
        if($this->request->is('post') && $this->validateForm()){

            if(!isset($this->request->data['active'])){
                $this->request->data['is_active'] = 0;
            }else{
                $this->request->data['is_active'] = 1;
            }

            if($this->Message->add($this->request->data)) {
                $this->Session->setFlash('Message Added Successfully','flash');
                $this->redirect(array('controller' => 'messages', 'action' => 'index'));
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

            if($this->Message->update($this->request->data,$this->request->data['message_id'])) {
                $this->Session->setFlash('Message Updated Successfully','flash');
                $this->redirect(array('controller' => 'messages', 'action' => 'index'));
            }
        }

        $this->getForm();

        $this->view = 'form';
    }

    public function getForm() {



        //pr($this->request->data);die;
        if(isset($this->request->data['message_id'])){
            $this->set('message_id',$this->request->data['message_id']);

        } else if(isset($this->request->query['message_id']) && $this->request->query['message_id']) {

            $details = $this->Message->find('first',array(
                'conditions' => array('Message.id' => $this->request->query['message_id'])
            ));
            $this->set('message_id',$this->request->query['message_id']);

        }else{
            $this->set('message_id','');
        }


        if(isset($this->request->data['message'])){
            $this->set('message',$this->request->data['message']);
        }else if(isset($details['Message']['message'])){
            $this->set('message',$details['Message']['message']);
        }else{
            $this->set('message','');
        }

        if(isset($this->request->data['user_type'])){
            $this->set('user_type',$this->request->data['user_type']);
        }else if(isset($details['Message']['user_type'])){
            $this->set('user_type',$details['Message']['user_type']);
        }else{
            $this->set('user_type','');
        }

        if(isset($this->request->data['active'])){
            $this->set('active',$this->request->data['active']);
        }else if(isset($details['Message']['is_active'])){
            $this->set('active',$details['Message']['is_active']);
        }else{
            $this->set('active','');
        }

        if (isset($this->error['warning'])) {
            $this->set('error_warning',$this->error['warning']);
        } else {
            $this->set('error_warning','');
        }

        if (isset($this->error['message'])) {
            $this->set('error_message',$this->error['message']);
        } else {
            $this->set('error_message','');
        }

        if (isset($this->error['user_type'])) {
            $this->set('error_user_type',$this->error['user_type']);
        } else {
            $this->set('error_user_type','');
        }

    }

    public function validateForm() {

        //pr($this->request->data);die;

        if (strlen(trim($this->request->data['message'])) < 3) {
            $this->error['message'] = 'Message must be greater than 2 characters';
        }

        if (!isset($this->request->data['user_type'])) {
            $this->error['user_type'] = 'User type required';
        }

        if($this->error){
            $this->error['warning'] = 'Please Check Below Errors';
        }

        return !$this->error;
    }
}