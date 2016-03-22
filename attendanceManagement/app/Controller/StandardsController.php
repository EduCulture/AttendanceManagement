<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 07-09-2015
 * Time: 11:04 AM
 */

App::uses('AppController', 'Controller');

class StandardsController extends AppController {

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

            if($this->Standard->add($this->request->data)) {
                $this->Session->setFlash('Standard Added Successfully','flash');
                $this->redirect(array('controller' => 'standards', 'action' => 'index'));
            }
        }

        $this->getForm();

        $this->view = 'form';
    }

    public function edit() {

        //pr($this->request->data);die;
        if($this->request->is('post') && $this->validateForm()){

            if(!isset($this->request->data['active'])){
                $this->request->data['is_active'] = 0;
            }else{
                $this->request->data['is_active'] = 1;
            }

            if($this->Standard->update($this->request->data,$this->request->data['standard_id'])) {
                $this->Session->setFlash('Standard Updated Successfully','flash');
                $this->redirect(array('controller' => 'standards', 'action' => 'index'));
            }
        }

        $this->getForm();

        $this->view = 'form';
    }

    public function getList() {

        $this->recursive = -1;
        $standards = $this->Standard->find('all',array(
            'conditions' => array('Standard.is_delete' => 0,'Standard.school_id' => CakeSession::read('Auth.User.school_id'))
        ));

        //pr($standards);die;
        $this->set('standards',$standards);
    }

    public function getForm() {

        //pr($sections);die;
        if(isset($this->request->data['standard_id'])){
            $this->set('standard_id',$this->request->data['standard_id']);
        } else if(isset($this->request->query['standard_id']) && $this->request->query['standard_id']) {

            $this->Standard->recursive = 1;
            $details = $this->Standard->find('first',array(
                'conditions' => array('Standard.id' => $this->request->query['standard_id'])
            ));
            $standar_sec_array = array();
            foreach($details['StandardSectionMap'] as $val){
                $standar_sec_array[] = array(
                    'section_id' => $val['section_id']
                );
            }
            //pr($standar_sec_array);die;
            $this->set('standard_id',$this->request->query['standard_id']);
            $this->set('standard_sections',$standar_sec_array);
        }else{
            $this->set('standard_id','');
        }

        if(isset($this->request->data['name'])){
            $this->set('name',$this->request->data['name']);
        }else if(isset($details['Standard']['name'])){
            $this->set('name',$details['Standard']['name']);
        }else{
            $this->set('name','');
        }

        if(isset($this->request->data['active'])){
            $this->set('active',$this->request->data['active']);
        }else if(isset($details['Standard']['is_active'])){
            $this->set('active',$details['Standard']['is_active']);
        }else{
            $this->set('active','');
        }

        $this->loadModel('Subject');
        $this->set('subjects',$this->Subject->getAllSubjects());

        $this->loadModel('Staff');
        $this->set('staffs',$this->Staff->getAllStaffs());

        if(isset($this->request->data['staff_subject'])){
            $this->set('staff_subject',$this->request->data['staff_subject']);
        }else if(isset($this->request->query['standard_id'])){

            $this->loadModel('StandardSectionMap');
            $this->StandardSectionMap->recursive = 2;
            $data = $this->StandardSectionMap->find('all',array(
               'conditions' => array('StandardSectionMap.standard_id' => $this->request->query['standard_id'])
            ));
            //pr($data);die;
            $staff_subject = [];
            if($data){
                foreach($data as $val){
                    $details = [];
                    if($val['SubjectTeacherMap']){
                        foreach($val['SubjectTeacherMap'] as $subject_staff_val) {
                            $details[] = array(
                                'subject_id' => $subject_staff_val['subject_id'],
                                'staff_id' => $subject_staff_val['staff_id'],
                                'subject_name' => $subject_staff_val['Subject']['name'],
                                'staff_name' => ($subject_staff_val['Staff']['first_name'].' '.$subject_staff_val['Staff']['last_name']),
                            );
                        }
                    }
                    $staff_subject[] = array(
                        'section_id' => $val['Section']['id'],
                        'section_name' => $val['Section']['name'],
                        'class_teacher_id' => $val['StandardSectionMap']['staff_id'],
                        'details' => $details
                    );
                }
            }
            //pr($staff_subject);die;
            $this->set('staff_subject',$staff_subject);
        }else{
            $this->set('staff_subject',array());
        }

        //pr($this->request->data['staff_subject']);die;

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
            $this->error['name'] = 'Standard name can not be empty';
        }

        if($this->error){
            $this->error['warning'] = 'Please Check Below Errors';
        }

        return !$this->error;
    }

    public function getDivisions(){

        $this->loadModel('SubjectTeacherMap');
        $return = [];
        if(isset($this->request->data['standard_id'])){

            $return = $this->SubjectTeacherMap->getSections($this->request->data['standard_id']);

            //pr($sections);die;

        }
        echo json_encode($return);
        $this->autoRender = false;
    }

    public function getAllDivisions(){

        $this->loadModel('SubjectTeacherMap');
        $return = [];
        if(isset($this->request->data['standard_id'])){

            $this->loadModel('StandardSectionMap');
            $data = $this->StandardSectionMap->find('all',array(
                'conditions' => array('StandardSectionMap.standard_id' => $this->request->data['standard_id'])
            ));

            if($data){
                foreach($data as $val){
                    $return[] = array(
                        'section_id' => $val['Section']['id'],
                        'section_name' => $val['Section']['name']
                    );
                }
            }

            //pr($sections);die;
        }
        echo json_encode($return);
        $this->autoRender = false;
    }

    //section suggestion
    public function getSuggestion(){

        $return = [];
        if(isset($this->request->query['filter_name'])){

            $sectionClass = ClassRegistry::init('Section');

            $sections = $sectionClass->find('all',array(
                'conditions' => array('Section.is_delete' => 0,'Section.school_id' => CakeSession::read('Auth.User.school_id'),'Section.is_active' => 1,'Section.name LIKE' => $this->request->query['filter_name'].'%')
            ));

            //pr($sections);die;
            if($sections){
                foreach($sections as $section){
                    $return[] = array(
                        'section_id' => $section['Section']['id'],
                        'section_name' => $section['Section']['name']
                    );
                }
                //pr($return);die;
            }
        }
        echo json_encode($return);
        $this->autoRender = false;
    }

    //standard suggestion
    public function getStandardSuggestion(){

        $return = [];
        if(isset($this->request->query['filter_name'])){

            $standards = $this->Standard->find('all',array(
                'conditions' => array('Standard.is_delete' => 0)
            ));

            //pr($standards);die;
            if($standards){
                foreach($standards as $standard){
                    $return[] = array(
                        'standard_id' => $standard['Standard']['id'],
                        'standard_name' => $standard['Standard']['name']
                    );
                }
                //pr($return);die;
            }
        }
        echo json_encode($return);
        $this->autoRender = false;
    }

    public function getSubjectTeacher() {

        $this->loadModel('SubjectTeacherMap');
        $data = $this->SubjectTeacherMap->getSubjectTeacher($this->request->data['standard_id'],$this->request->data['section_id'],$this->request->data['subject_id']);

        $return = [];
        if($data){
            $return = array(
                'id' => $data['Staff']['id'],
                'name' => $data['Staff']['first_name'].' '.$data['Staff']['last_name']
            );
        }

        echo json_encode($return);
        $this->autoRender = false;
    }

    /*public function getSections($standard_id){



    }*/
}