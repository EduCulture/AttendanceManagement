<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 07-09-2015
 * Time: 11:04 AM
 */

App::uses('AppController', 'Controller');

class AssignmentController extends AppController {

    private $error = array();

    public function index() {

        $this->loadModel('SubjectTeacherMap');
        $this->set('standards',$this->SubjectTeacherMap->getStandards());

        if(isset($this->request->query['standard_id'])){
            $this->set('standard_id',$this->request->query['standard_id']);
        }else{
            $this->set('standard_id','');
        }

        if(isset($this->request->query['section_id'])){
            $this->set('section_id',$this->request->query['section_id']);
        }else{
            $this->set('section_id','');
        }
    }

    public function save() {

        $json = [];

        $this->loadModel('Assignment');
        if($this->request->is('post')){

            if(!trim($this->request->data['title'])){
                $json['error']['title'] = 'Title Required';
            }

            if(!trim($this->request->data['start_date'])){
                $json['error']['start-date'] = 'Start date Required';
            }

            if(!trim($this->request->data['end_date'])){
                $json['error']['end-date'] = 'End date Required';
            }else if($this->request->data['end_date'] < $this->request->data['start_date']){
                $json['error']['end-date'] = 'End date must greater than or equal to start date';
            }

            //pr($json);die;

            if(!trim($this->request->data['subject_id'])){
                $json['error']['subject'] = 'Subject Required';
            }
            //pr($this->request->data);die;

            if(!$json) {
                if($this->request->data['assignment_id']){

                    $this->Assignment->update($this->request->data);
                    $this->Session->setFlash('Assignment Update Successfully', 'flash');
                    $json['success'] = 'Success';

                }else {
                    if ($this->Assignment->add($this->request->data)) {
                        $this->Session->setFlash('Assignment Added Successfully', 'flash');
                        $json['success'] = 'Success';
                    }else{
                        $json['error']['title'] = 'Error while adding data';
                    }
                }
            }
        }

        echo json_encode($json);
        $this->autoRender = false;
    }

    public function getAssignmentList() {

        if(isset($this->request->data['standard_id']) && $this->request->data['section_id']) {

            $this->set('standard_id',$this->request->data['standard_id']);
            $this->set('section_id',$this->request->data['section_id']);

            //Students Deatils
            $this->loadModel('Assignment');
            $this->Assignment->recursive = 2;

            $assignment_details = $this->Assignment->find('all',array(
                'conditions' => array('Assignment.standard_id' => $this->request->data['standard_id'],'Assignment.section_id' => $this->request->data['section_id'])
            ));

            $this->set('assignments',$assignment_details);

            $this->loadModel('SubjectTeacherMap');
            $subjects = $this->SubjectTeacherMap->getStandardWiseSubject($this->request->data['standard_id'],$this->request->data['section_id']);

            $this->set('subjects',$subjects);
            //pr($subjects);die;

            $this->view = 'list';
            $this->layout = 'ajax';
        }
    }

    public function delete() {

        $json = [];
        //pr($this->request->data);die;

        $this->loadModel('Assignment');
        if($this->request->is('post') && isset($this->request->data['assignment_id'])){
            $this->Assignment->deleteAll(array('Assignment.id' => $this->request->data['assignment_id']));
            $json['success'] = 'Success';
        }else{
            $json['error'] = 'Invalid id';
        }

        echo json_encode($json);
        $this->autoRender = false;
    }

    public function services_getAssignments() {

        $this->loadModel('Assignment');

        if(isset($this->request->data['student_id'])){
            $this->loadModel('Student');

            $standard_detail = $this->Student->getStandardAndSection($this->request->data['student_id']);

            if($standard_detail){
                $this->Assignment->recursive = -1;

                $dates = $this->Assignment->find('all',array(
                    'conditions' => array('Assignment.standard_id' => $standard_detail['standard_id'],'Assignment.section_id' => $standard_detail['section_id']),
                    'fields' => array('Assignment.end_date'),
                    'group' => array('Assignment.end_date')
                ));
                //pr($dates);die;
                if($dates){
                    foreach($dates as $date){
                        $assignment_detail[] = array(
                            'isSection' => true,
                            'weekday' => date('l', strtotime($date['Assignment']['end_date'])),
                            'date' => date("d",strtotime($date['Assignment']['end_date'])),
                            'month' => date('F', strtotime($date['Assignment']['end_date'])),
                            'year' => date('Y', strtotime($date['Assignment']['end_date'])),
                            'title' => false,
                            'subTitle' => false,
                            'iconURI' => false,
                            'description' => false
                        );

                        $this->Assignment->recursive = -2;
                        $assignments = $this->Assignment->find('all',array(
                            'conditions' => array('Assignment.standard_id' => $standard_detail['standard_id'],'Assignment.section_id' => $standard_detail['section_id'],'Assignment.end_date' => date("Y-m-d",strtotime($date['Assignment']['end_date']))),
                            //'group' => array('Assignment.end_date')
                        ));

                        foreach($assignments as $assignment){
                            $assignment_detail[] = array(
                                'isSection' => false,
                                'weekday' => date('l', strtotime($assignment['Assignment']['end_date'])),
                                'date' => date("d",strtotime($assignment['Assignment']['end_date'])),
                                'month' => date('F', strtotime($assignment['Assignment']['end_date'])),
                                'year' => date('Y', strtotime($assignment['Assignment']['end_date'])),
                                'title' => $assignment['Subject']['name'],
                                'subTitle' => $assignment['Assignment']['title'],
                                'iconURI' => false,
                                'description' => $assignment['Assignment']['description']
                            );
                        }

                        //pr($assignment_detail);die;
                    }

                    //$assignment_detail = new st;
                    $data = $this->Assignment->formatMessages('Assignment details',true,$assignment_detail);
                }else{
                    $data = $this->Assignment->formatMessages('No assignments available',true);
                }

            }else{
                $data = $this->Assignment->formatMessages('Invalid Student id');
            }
        }else{
            $data = $this->Assignment->formatMessages('Parameters missing');
        }

        $this->set('data',$data);
    }
}