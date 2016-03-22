<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 07-09-2015
 * Time: 11:04 AM
 */

App::uses('AppController', 'Controller');

class ExamsController extends AppController {

    private $error = array();

    public function index() {

        $this->loadModel('Standard');
        $standards = $this->Standard->getStandards();

        $this->set('standards',$standards);

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
        if($this->request->is('post')){
            //echo strlen($this->request->data['name']);die;
            if(!isset($this->request->data['name']) || !(trim($this->request->data['name']))){
                $json['error']['name'] = 'Please enter exam name';
            }

            if(!$json) {
                //pr($this->request->data);die;
                if(!$this->request->data['exam_id']) {
                    if ($this->Exam->add($this->request->data)) {
                        $json['success'] = 'Successfully Added';
                    }
                }else{
                    if ($this->Exam->update($this->request->data,$this->request->data['exam_id'])) {
                        $json['success'] = 'Successfully Updated';
                    }
                }
            }
        }else{
            $json['error'] = 'Parameter missing';
        }

        echo json_encode($json);
        $this->autoRender = false;
    }

    public function saveDetails() {

        //pr($this->request->data);die;

        if($this->request->is('post')){
            $this->loadModel('ExamDetail');
            if($this->ExamDetail->add($this->request->data)) {
                $this->Session->setFlash('Exam Detail Added Successfully','flash');
                $this->redirect(array('controller' => 'exams', 'action' => 'manage','?' => array('exam_id' => $this->request->data['exam_id'])));
            }
        }

        $this->manage();
    }

    public function saveMarks() {

        if($this->request->is('post')){
            $this->loadModel('Result');
            if($this->Result->add($this->request->data)) {
                $this->Session->setFlash('Marks Added Successfully','flash');
                $this->redirect(array('controller' => 'exams', 'action' => 'result','?' => array('exam_detail_id' => $this->request->data['exam_detail_id'])));
            }
        }

        $this->manage();

    }

    public function updateDetail() {

        $json = [];

        if(!(trim($this->request->data['start_time']))){
            $json['error']['start-time'] = 'Start time require';
        }

        if(!(trim($this->request->data['maximum_mark'])) || !is_numeric($this->request->data['maximum_mark'])){
            $json['error']['max'] = 'Maximum mark require & must be numeric';
        }

        if(!(trim($this->request->data['passing_mark'])) || !is_numeric($this->request->data['passing_mark'])){
            $json['error']['min'] = 'Passing mark mark require & must be numeric';
        }

        if(!$json){
            $this->loadModel('ExamDetail');
            $this->ExamDetail->update($this->request->data);
            $json['success'] = 'Success';
        }

        echo json_encode($json);
        $this->autoRender = false;
    }

    public function updateResult() {

        $json = [];

        if(!(trim($this->request->data['obtain_mark'])) || !is_numeric($this->request->data['obtain_mark'])){
            $json['error']['obtain'] = 'Obtain Mark Required & Must be numeric';
        }

        if(!$json){
            $this->loadModel('Result');
            $this->Result->update($this->request->data);
            $json['success'] = 'Success';
        }

        echo json_encode($json);
        $this->autoRender = false;

    }

    public function delete() {

        $json = [];

        if($this->request->is('post')){
            $this->loadModel('ExamDetail');
            $this->Exam->deleteAll(array('Exam.id' => $this->request->data['exam_id']));
            $this->ExamDetail->deleteAll(array('Exam.exam_id' => $this->request->data['exam_id']));
            $json['success'] = 'Success';
        }else{
            $json['success'] = 'Error';
        }

        echo json_encode($json);
        $this->autoRender = false;
    }

    public function deleteResult() {

        $json = [];

        if($this->request->is('post')){
            $this->loadModel('Result');
            $this->Result->deleteAll(array('Result.id' => $this->request->data['result_id']));
            $json['success'] = 'Success';
        }else{
            $json['success'] = 'Error';
        }

        echo json_encode($json);
        $this->autoRender = false;
    }

    public function deleteSchedule() {

        $json = [];

        if($this->request->is('post')) {
            $this->loadModel('ExamDetail');
            $this->ExamDetail->deleteAll(array('ExamDetail.id' => $this->request->data['detail_id']));
            $json['success'] = 'Success';
        }else{
            $json['success'] = 'Error';
        }

        echo json_encode($json);
        $this->autoRender = false;
    }

    public function getList() {

        $this->loadModel('Standard');
        $this->set('standard',$this->Standard->findById($this->request->data['standard_id']));
        $this->set('standard_id',$this->request->data['standard_id']);

        $this->loadModel('Section');
        $this->set('section',$this->Section->findById($this->request->data['section_id']));
        $this->set('section_id',$this->request->data['section_id']);

        $this->loadModel('ExamType');
        $exam_types = $this->ExamType->find('all',array(
            'conditions' => array('ExamType.school_id' => CakeSession::read('Auth.User.school_id'))
        ));

        $this->loadModel('User');
        $user_details = $this->User->getLoggedUserDetails();
        $staff_id = $user_details['Staff']['id'];

        //pr($exam_types);die;
        $exam_details = [];
        if($exam_types) {
            foreach($exam_types as $exam_type) {

                if(!$exam_type['ExamType']['is_available']) {
                    $exams = $this->Exam->find('all', array(
                        'conditions' => array('Exam.standard_id' => $this->request->data['standard_id'], 'Exam.section_id' => $this->request->data['section_id'], 'Exam.exam_type_id' => $exam_type['ExamType']['id'])
                    ));
                }else{
                    $exams = $this->Exam->find('all', array(
                        'conditions' => array('Exam.standard_id' => $this->request->data['standard_id'], 'Exam.section_id' => $this->request->data['section_id'], 'Exam.exam_type_id' => $exam_type['ExamType']['id'],'Exam.staff_id' => $staff_id)
                    ));
                }
                //pr($exams);die;

                $exam_details[] = array(
                   'exam_category' => $exam_type['ExamType']['name'],
                   'is_available' => $exam_type['ExamType']['is_available'],
                   'exams' => $exams
                );
            }
        }

        //pr($exams);die;
        $this->set('exam_details',$exam_details);
        $this->set('exam_types',$exam_types);

        $this->view = 'list';
        $this->layout = 'ajax';
    }

    public function manage() {

        $exam_id = 0;

        if(isset($this->request->query['exam_id'])){
            $exam_id = $this->request->query['exam_id'];
        }else if($this->request->data['exam_id']){
            $exam_id = $this->request->data['exam_id'];
        }

        if($exam_id){

            $this->Exam->recursive = 2;
            $details = $this->Exam->findById($exam_id);

            $this->loadModel('SubjectTeacherMap');
            $subjects = $this->SubjectTeacherMap->getStandardStaffSubjects($details['Exam']['standard_id'],$details['Exam']['section_id']);
            //pr($subjects);die;

            $remaining = [];
            foreach($subjects as $subject){
                if($details['ExamDetail']){
                    $valid = true;
                    foreach($details['ExamDetail'] as $detail){
                        if($detail['subject_id'] == $subject['subject_id']){
                            $valid = false;
                            break;
                        }
                    }

                    if($valid) {
                        $remaining[] = array(
                            'subject_id' => $subject['subject_id'],
                            'subject_name' => $subject['subject']
                        );
                    }
                }else{
                    $remaining[] = array(
                        'subject_id' => $subject['subject_id'],
                        'subject_name' => $subject['subject']
                    );
                }
            }

            //pr($remaining);die;
            //pr($details);die;

            $this->set('exam_id',$exam_id);
            $this->set('remainings',$remaining);

            $this->set('exam',$details);
        }else{
            $this->redirect(array('controller' => 'exams','action' => 'index'));
        }
    }

    public function result() {

        $exam_detail_id = 0;

        if(isset($this->request->query['exam_detail_id'])){
            $exam_detail_id = $this->request->query['exam_detail_id'];
        }else if($this->request->data['exam_detail_id']){
            $exam_detail_id = $this->request->data['exam_detail_id'];
        }

        $this->loadModel('ExamDetail');
        if($exam_detail_id && $details = $this->ExamDetail->findById($exam_detail_id)){

            $this->ExamDetail->recursive = 2;
            $details = $this->ExamDetail->findById($exam_detail_id);


            $exam_details = $this->Exam->findById($details['ExamDetail']['exam_id']);
            //pr($details);die;

            //$standard_id = $exam_details['Standard']['id'];
            //$section_id = $exam_details['Section']['id'];

            $array = array(
               'standard' => $exam_details['Standard']['name'],
               'section' => $exam_details['Section']['name'],
               'type' =>  $exam_details['ExamType']['name'],
               'exam_name' => $exam_details['Exam']['name'],
               'maximum_mark' => $details['ExamDetail']['maximum_mark'],
               'passing_mark' => $details['ExamDetail']['passing_mark'],
               'start_time' => $details['ExamDetail']['start_time'],
               'subject' => $details['Subject']['name']
            );

            $this->set('exam_details',$array);

            $this->loadModel('Student');
            $this->Student->recursive = -1;
            $students = $this->Student->query("SELECT * FROM `students` Student WHERE Student.id NOT IN (SELECT student_id FROM `results` r WHERE r.exam_detail_id = '".$exam_detail_id."')");

            $this->set('students',$students);
            $this->set('results',$details);

            $this->set('exam_detail_id',$exam_detail_id);

        }else{
            $this->redirect(array('controller' => 'exams','action' => 'index'));
        }
    }

    public function summary() {


    }

    public function getStudentExamReport() {

        if(isset($this->request->data['student_id']) && isset($this->request->data['standard_id']) && isset($this->request->data['section_id'])){

            $this->Exam->recursive = 2;
            $exams = $this->Exam->find('all',array(
               'conditions' => array('Exam.standard_id' => $this->request->data['standard_id'],'Exam.section_id' => $this->request->data['section_id'] )
            ));


            $this->loadModel('Student');
            $this->Student->recursive = 2;
            $student_detail = $this->Student->findById($this->request->data['student_id']);

            //pr($exams);die;
            $details = [];
            if($exams){
                foreach($exams as $exam){

                    $detail_value = [];
                    $total_marks = $total_obtain = $total_percentage = 0;
                    $total_result = true;
                    $result_available = false;

                    if($exam['ExamDetail']){
                        foreach($exam['ExamDetail'] as $exam_detail){

                            $this->loadModel('Result');
                            $result = $this->Result->find('first',array(
                               'conditions' => array('Result.exam_detail_id' => $exam_detail['id'],'Result.student_id' => $this->request->data['student_id'])
                            ));

                            if(isset($result['Result'])){
                                if((int)$result['Result']['obtain_mark'] >= (int)$exam_detail['passing_mark']){
                                    $note = 'Pass';
                                }else{
                                    $note = 'Fail';
                                    $total_result = false;
                                }
                                $result_available = true;
                                $total_obtain = $total_obtain + $result['Result']['obtain_mark'];
                                $percentage = number_format((($result['Result']['obtain_mark']*100)/$exam_detail['maximum_mark']),2);
                            }else{
                                $note = 'Not attended';
                                $percentage = 0;
                            }

                            $total_marks = $total_marks + $exam_detail['maximum_mark'];

                            $detail_value[] = array(
                               'subject_name' => $exam_detail['Subject']['name'],
                               'maximum_mark' => $exam_detail['maximum_mark'],
                               'passing_mark' => $exam_detail['passing_mark'],
                               'date' => date("d-M-Y",strtotime($exam_detail['start_time'])),
                               'obtain_mark' => isset($result['Result']['obtain_mark']) ? $result['Result']['obtain_mark'] : '-',
                               'remark' => isset($result['Result']['remark']) ? $result['Result']['remark'] : '-',
                               'result' => $note,
                               'percentage' => $percentage
                            );
                        }
                    }

                    if($total_marks) {
                        $total_percentage = number_format((($total_obtain * 100) / $total_marks), 2);
                    }

                    $details[] = array(
                       'exam_name' => $exam['Exam']['name'],
                       'type' => ($exam['Exam']['type'] == 1) ? 'Marks' : 'Grade',
                       'details' => $detail_value,
                       'total_marks' => $total_marks,
                       'total_obtain' => $total_obtain,
                       'total_percentage' => $total_percentage,
                       'result' => $total_result,
                       'result_available' => $result_available
                    );
                }
            }

            $this->set('student',array('standard' => $student_detail['Standard']['name'],
                'section' => $student_detail['Section']['name'],'student_name' => $student_detail['Student']['first_name']. ' '.$student_detail['Student']['last_name'] ,
                'roll_number' => $student_detail['Student']['roll_number'],
                'profile' => $student_detail['Student']['profile_pic'],));

            //pr($details);
            $this->set('exams',$details);

        }

        $this->view = 'report';
        $this->layout = 'ajax';
    }

    public function services_getExams() {

        $this->loadModel('Student');

        if(isset($this->request->data['student_id'])){

            $student_id = $this->request->data['student_id'];
            $standard_detail = $this->Student->getStandardAndSection($this->request->data['student_id']);
            //pr($standard_detail);die;

            if($standard_detail) {

                $this->Exam->recursive = 2;
                $exams = $this->Exam->find('all', array(
                    'conditions' => array('Exam.standard_id' => $standard_detail['standard_id'], 'Exam.section_id' => $standard_detail['section_id'])
                ));

                if ($exams) {
                    foreach ($exams as $exam) {

                        $detail_value = [];
                        $total_marks = $total_obtain = $total_percentage = 0;
                        $total_result = true;
                        $result_available = false;

                        //pr($exam['ExamDetail']);die;
                        if ($exam['ExamDetail']) {
                            foreach ($exam['ExamDetail'] as $exam_detail) {

                                $this->loadModel('Result');
                                $result = $this->Result->find('first', array(
                                    'conditions' => array('Result.exam_detail_id' => $exam_detail['id'], 'Result.student_id' => $this->request->data['student_id'])
                                ));

                                if (isset($result['Result'])) {
                                    if ((int)$result['Result']['obtain_mark'] >= (int)$exam_detail['passing_mark']) {
                                        $note = 'Pass';
                                    } else {
                                        $note = 'Fail';
                                        $total_result = false;
                                    }
                                    $result_available = true;
                                    $total_obtain = $total_obtain + $result['Result']['obtain_mark'];
                                    $percentage = number_format((($result['Result']['obtain_mark'] * 100) / $exam_detail['maximum_mark']), 2);
                                } else {
                                    $note = 'Not attended';
                                    $percentage = 0;
                                }

                                $total_marks = $total_marks + $exam_detail['maximum_mark'];

                                $detail_value[] = array(
                                    'subject' => $exam_detail['Subject']['name'],
                                    'maxMarks' => number_format($exam_detail['maximum_mark'], 0),
                                    'scoredMarks' => isset($result['Result']['obtain_mark']) ? number_format($result['Result']['obtain_mark'], 0) : '-',
                                    //'scoredMarks' => $exam_detail['passing_mark'],
                                    //'date' => date("d-M-Y",strtotime($exam_detail['start_time'])),
                                    //'remark' => isset($result['Result']['remark']) ? $result['Result']['remark'] : '-',
                                    //'result' => $note,
                                    //'percentage' => $percentage
                                );
                            }
                        }

                        /*if($total_marks) {
                            $total_percentage = number_format((($total_obtain * 100) / $total_marks), 2);
                        }*/

                        $details['exams'][] = array(
                            'examtype' => $exam['Exam']['name'],
                            'result' => $detail_value,
                            //$exam['Exam']['name'] => $detail_value
                        );
                    }

                    $data = $this->Student->formatMessages('Exam details', true, $details);
                }else{
                    $data = $this->Student->formatMessages('Exam details', true, array());
                }

            }else{
                $data = $this->Student->formatMessages('Invalid Student id');
            }
        }else{
            $data = $this->Student->formatMessages('Parameters missing');
        }
        $this->set('data',$data);
    }
}