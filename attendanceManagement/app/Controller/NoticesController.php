<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 07-09-2015
 * Time: 11:04 AM
 */

App::uses('AppController', 'Controller');

class NoticesController extends AppController {

    private $error = array();

    public $paginate = array(
        'limit' => 15,
        'order' => array(
            'Notice.id' => 'DESC'
        )
    );

    public function index() {

        $is_filter = false;

        $filter = array('Notice.is_delete' => 0,'Notice.school_id' => CakeSession::read('Auth.User.school_id'));
        /*if(isset($this->request->query['filter_user_type']) && $this->request->query['filter_user_type']){
            $is_filter = true;
            $filter['Message.role_id'] = $this->request->query['filter_user_type'];
        }*/

        $this->Paginator->settings = $this->paginate;
        $data = $this->Paginator->paginate('Notice',$filter);

        //pr($data);die;
        $this->set('notices',$data);
        $this->set('is_filter',$is_filter);

        $this->view = 'notice_list';
    }

    public function add() {

        //pr($this->request->data);die;
        if($this->request->is('post') && $this->validateForm()){

            if(!isset($this->request->data['active'])){
                $this->request->data['is_active'] = 0;
            }else{
                $this->request->data['is_active'] = 1;
            }

            if($this->Notice->add($this->request->data)) {
                $this->Session->setFlash('Notice Added Successfully','flash');
                $this->redirect(array('controller' => 'notices', 'action' => 'index'));
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

            if($this->Notice->update($this->request->data,$this->request->data['notice_id'])) {
                $this->Session->setFlash('Notice Updated Successfully','flash');
                $this->redirect(array('controller' => 'notices', 'action' => 'index'));
            }
        }

        $this->getForm();

        $this->view = 'form';
    }

    public function getForm() {

        //pr($this->request->data);die;
        if(isset($this->request->data['notice_id'])){
            $this->set('notice_id',$this->request->data['notice_id']);

        } else if(isset($this->request->query['notice_id']) && $this->request->query['notice_id']) {

            $details = $this->Notice->find('first',array(
                'conditions' => array('Notice.id' => $this->request->query['notice_id'])
            ));
            $this->set('notice_id',$this->request->query['notice_id']);

        }else{
            $this->set('notice_id','');
        }

        if(isset($this->request->data['title'])){
            $this->set('title',$this->request->data['title']);
        }else if(isset($details['Notice']['title'])){
            $this->set('title',$details['Notice']['title']);
        }else{
            $this->set('title','');
        }

        if(isset($this->request->data['description'])){
            $this->set('description',$this->request->data['description']);
        }else if(isset($details['Notice']['description'])){
            $this->set('description',$details['Notice']['description']);
        }else{
            $this->set('description','');
        }

        if(isset($this->request->data['notice_date'])){
            $this->set('notice_date',$this->request->data['notice_date']);
        }else if(isset($details['Message']['notice_date'])){
            $this->set('notice_date',$details['Notice']['notice_date']);
        }else{
            $this->set('notice_date','');
        }

        if(isset($this->request->data['user_type'])){
            $this->set('user_type',$this->request->data['user_type']);
        }else if(isset($details['Notice']['user_type'])){
            $this->set('user_type',$details['Notice']['user_type']);
        }else{
            $this->set('user_type','');
        }

        if(isset($this->request->data['notice_date'])){
            $this->set('notice_date',$this->request->data['notice_date']);
        }else if(isset($details['Notice']['notice_date'])){
            $this->set('notice_date',$details['Notice']['notice_date']);
        }else{
            $this->set('notice_date','');
        }

        if(isset($details['Notice']['upload_file_name']) && $details['Notice']['upload_file_name']){
            $this->set('uploaded_file',$details['Notice']['upload_file_name']);
        }else{
            $this->set('uploaded_file','');
        }

        if(isset($this->request->data['active'])){
            $this->set('active',$this->request->data['active']);
        }else if(isset($details['Notice']['is_active'])){
            $this->set('active',$details['Notice']['is_active']);
        }else{
            $this->set('active','');
        }

        if (isset($this->error['warning'])) {
            $this->set('error_warning',$this->error['warning']);
        } else {
            $this->set('error_warning','');
        }

        if (isset($this->error['title'])) {
            $this->set('error_title',$this->error['title']);
        } else {
            $this->set('error_title','');
        }

        if (isset($this->error['user_type'])) {
            $this->set('error_user_type',$this->error['user_type']);
        } else {
            $this->set('error_user_type','');
        }

    }

    public function validateForm() {

        //pr($this->request->data);die;

        if (strlen(trim($this->request->data['title'])) < 3) {
            $this->error['title'] = 'Title must be greater than 2 characters';
        }

       // if(CakeSession::read("Auth.User.role_id") == 2) {
            if (!isset($this->request->data['user_type'])) {
                $this->error['user_type'] = 'User type required';
            }
       //}

        if($this->error){
            $this->error['warning'] = 'Please Check Below Errors';
        }

        return !$this->error;
    }

    public function services_getCirculars() {

        $this->loadModel('Notice');

        if(isset($this->request->data['student_id'])){
            $this->loadModel('Student');

            $student_id = $this->request->data['student_id'];
            $student_detail = $this->Student->findById($student_id);

            if($student_detail){

                $school_id = $student_detail['Student']['school_id'];
                $this->Notice->recursive = -1;

                $dates = $this->Notice->find('all',array(
                    'conditions' => array('Notice.school_id' => $school_id,'Notice.user_type' => 3),
                    'fields' => array('Notice.notice_date'),
                    'group' => 'Notice.notice_date'
                ));

                //echo $this->Remark->getLastQuery();die;

                //pr($dates);die;
                if($dates){
                    foreach($dates as $date){
                        $notice_detail[] = array(
                            'isSection' => true,
                            'weekday' => date('l', strtotime($date['Notice']['notice_date'])),
                            'date' => date("d",strtotime($date['Notice']['notice_date'])),
                            'month' => date('F', strtotime($date['Notice']['notice_date'])),
                            'year' => date('Y', strtotime($date['Notice']['notice_date'])),
                            'title' => false,
                            'subTitle' => false,
                            'iconURI' => false,
                            'description' => false
                        );

                        $this->Notice->recursive = -2;
                        $notices = $this->Notice->find('all',array(
                            'conditions' => array('Notice.school_id' => $school_id,'Notice.notice_date' => date("Y-m-d",strtotime($date['Notice']['notice_date']))),
                            //'group' => array('Assignment.end_date')
                        ));

                        //echo $this->Remark->getLastQuery();die;
                        //pr($remarks);die;

                        foreach($notices as $notice){
                            $notice_detail[] = array(
                                'isSection' => false,
                                'weekday' => date('l', strtotime($notice['Notice']['notice_date'])),
                                'date' => date("d",strtotime($notice['Notice']['notice_date'])),
                                'month' => date('F', strtotime($notice['Notice']['notice_date'])),
                                'year' => date('Y', strtotime($notice['Notice']['notice_date'])),
                                'title' => $notice['Notice']['title'],
                                'subTitle' => false,
                                'iconURI' => false,
                                'description' => html_entity_decode($notice['Notice']['description'])
                            );
                        }

                        //pr($assignment_detail);die;
                    }

                    $data = $this->Notice->formatMessages('Notice details',true,$notice_detail);
                }else{
                    $data = $this->Notice->formatMessages('No Notice available',true);
                }

            }else{
                $data = $this->Notice->formatMessages('Invalid Student id');
            }
        }else{
            $data = $this->Notice->formatMessages('Parameters missing');
        }

        $this->set('data',$data);
    }
}