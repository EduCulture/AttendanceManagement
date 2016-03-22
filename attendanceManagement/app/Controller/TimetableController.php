<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 07-09-2015
 * Time: 11:04 AM
 */

App::uses('AppController', 'Controller');

class TimetableController extends AppController {

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

        if(CakeSession::read('Auth.User.role_id') == 3) {

            $this->loadModel('Day');
            $days = $this->Day->find('all', array(
                'order' => array('Day.id' => 'ASC')
            ));

            $this->loadModel('User');
            $staff_detail = $this->User->getLoggedUserDetails();
            $staff_id = $staff_detail['Staff']['id'];

            //pr($days);die;
            $this->set('days', $days);

            $assign = [];
            $this->loadModel('Timetable');
            foreach ($days as $day) {
                $this->Timetable->recursive = 2;
                $detail = $this->Timetable->find('all', array(
                    'conditions' => array('day_id' => $day['Day']['id'], 'staff_id' => $staff_id)
                ));
                //pr($detail);die;

                if ($detail) {
                    foreach ($detail as $val) {
                        $assign[$day['Day']['name']][] = array(
                            'day_id' => $day['Day']['id'],
                            'start_time' => date("h:i A", strtotime($val['Timing']['start_time'])),
                            'end_time' => date("h:i A", strtotime($val['Timing']['end_time'])),
                            'subject' => $val['Subject']['name'],
                            'standard' => isset($val['Timing']['Standard']['name']) ? $val['Timing']['Standard']['name'] : '-',
                            'section' => isset($val['Timing']['Section']['name']) ? $val['Timing']['Section']['name'] : '-',
                            'time_table_id' => isset($val['Timetable']['id']) ? $val['Timetable']['id'] : 0
                        );
                    }
                }
            }

            $this->set('timetable', $assign);
        }
    }

    public function save() {

        $json = [];
        if($this->request->is('post')){
            //echo strlen($this->request->data['name']);die;

            $this->loadModel('Timetable');

            if(!isset($this->request->data['subject_id']) || !$this->request->data['subject_id']){
                $json['error']['subject'] = 'Please Select Subject';
            }

            if(!isset($this->request->data['staff_id']) || !$this->request->data['staff_id']){
                $json['error']['staff'] = 'Please Select Staff';
            }

            if($this->request->data['modal_day_id'] && $this->request->data['modal_time_id'] && $this->request->data['staff_id'] && !$this->request->data['timetable_id']){
                $available = $this->Timetable->find('first',array(
                   'conditions' => array('Timetable.day_id' => $this->request->data['modal_day_id'],'Timetable.class_timing_id' => $this->request->data['modal_time_id'],'Timetable.staff_id' => $this->request->data['staff_id'])
                ));

                if($available){
                    $json['error']['staff'] = 'This staff has been already assigned to another class';
                }
            }

            /*if(!isset($this->request->data['modal_day_id']) && $this->request->data['modal_day_id']){
                $json['error']['day'] = 'Day id missing';
            }

            if(isset($this->request->data['modal_time_id']) && $this->request->data['modal_time_id']){
                $json['error']['time'] = 'Time id missing';
            }*/

            if(!$json) {
                if(!$this->request->data['timetable_id']) {
                    if ($this->Timetable->add($this->request->data)) {
                        $json['success'] = 'Successfully Added';
                    }
                }else{
                    if ($this->Timetable->update($this->request->data,$this->request->data['timetable_id'])) {
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

    public function edit() {

        //pr($this->request->data);die;
        if($this->request->is('post') && $this->validateForm()){

            if($this->Fee->update($this->request->data,$this->request->data['fee_id'])) {
                $this->Session->setFlash('Fee Updated Successfully','flash');
                $this->redirect(array('controller' => 'fees', 'action' => 'getCategoryList'));
            }
        }

        $this->getForm();

        $this->view = 'form';
    }

    public function delete() {

        $json = [];
        $this->loadModel('Timetable');
        if($this->request->is('post')){
            $this->Timetable->id = $this->request->data['timetable_id'];
            $this->Timetable->deleteAll(array('Timetable.id' => $this->request->data['timetable_id']));
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

        $this->loadModel('Section');
        $this->set('section',$this->Section->findById($this->request->data['section_id']));

        $this->loadModel('Timing');
        $timing = $this->Timing->find('all',array(
           'conditions' => array('Timing.standard_id' => $this->request->data['standard_id'],'Timing.section_id' => $this->request->data['section_id'],'Timing.is_delete' => 0),

        ));

        $this->loadModel('Day');
        $days = $this->Day->find('all',array(
            'order' => array('Day.id' => 'ASC')
        ));
        $this->set('days',$days);

        $this->loadModel('Timetable');

        $timetable = [];
        if($timing){
            foreach($timing as $time_val) {
                $assign = [];
                foreach($days as $day) {
                    $detail = $this->Timetable->find('first',array(
                       'conditions' => array('day_id' => $day['Day']['id'],'class_timing_id' => $time_val['Timing']['id'])
                    ));

                    $subject = [];
                    $staff = [];
                    if($detail){
                       $subject = array(
                          'id' => $detail['Subject']['id'],
                          'name' => $detail['Subject']['name']
                       );
                       $staff = array(
                           'id' => $detail['Staff']['id'],
                           'name' => $detail['Staff']['first_name'].' '.$detail['Staff']['last_name']
                       );
                    }
                    $assign[$day['Day']['name']] = array(
                        'day_id' => $day['Day']['id'],
                        'subject' => $subject,
                        'staff' => $staff,
                        'time_table_id' => isset($detail['Timetable']['id']) ? $detail['Timetable']['id'] : 0
                    );
                }

                $timetable[] = array(
                    'timing_id' => $time_val['Timing']['id'],
                    'time' => date("h:i A", strtotime($time_val['Timing']['start_time'])) . " - " . date("h:i A", strtotime($time_val['Timing']['end_time'])),
                    'days' => $assign,
                    'name' => $time_val['Timing']['name'],
                    'is_break' => $time_val['Timing']['is_break']
                );
            }
        }

        //pr($timetable);die;


        $this->loadModel('SubjectTeacherMap');
        $subjects = $this->SubjectTeacherMap->getStandardWiseSubject($this->request->data['standard_id'],$this->request->data['section_id']);
        $this->set('subjects',$subjects);

        $this->set('timetable',$timetable);
        //pr($timetable);die;

        $this->set('standard_id',$this->request->data['standard_id']);
        $this->set('section_id',$this->request->data['section_id']);
        $this->set('timing',$timing);

        $this->view = 'list';
        $this->layout = 'ajax';
    }


    public function services_getTimetable() {

        //$this->loadModel('Student');

        if(isset($this->request->data['staff_id'])){

            //$student_id = $this->request->data['student_id'];
            //$standard_detail = $this->Student->getStandardAndSection($this->request->data['student_id']);
            //pr($standard_detail);die;

            //if($this->request->data['student_id']){

                /* $this->loadModel('Timing');
                $timing = $this->Timing->find('all',array(
                    'conditions' => array('Timing.standard_id' => $standard_detail['standard_id'],'Timing.section_id' => $standard_detail['section_id'],'Timing.is_delete' => 0)
                )); */
                //pr($timing);die;

                $this->loadModel('Day');
                $days = $this->Day->find('all',array(
                    'order' => array('Day.id' => 'ASC')
                ));

                //pr($days);die;
                $this->loadModel('Timetable');
                $return = [];
                //if($timing){

                    foreach($days as $day) {

                        $timetable = [];
						
						$schedule_detail = $this->Timetable->find('all', array(
                                'conditions' => array('day_id' => $day['Day']['id'], 'staff_id' => $this->request->data['staff_id']),
								'order' => array('start_time' => 'ASC')
                            ));

                        foreach($schedule_detail as $detail) {
                            /* $detail = $this->Timetable->find('first', array(
                                'conditions' => array('day_id' => $day['Day']['id'], 'class_timing_id' => $time_val['Timing']['id'])
                            )); */

                            $title = $sub_title = 'NA';
                            //if($detail){
                                $title = $detail['Subject']['name'];
                                //$sub_title = $detail['Timing']['Standard']['name'] . " " . $detail['Timing']['Section']['name'];
								$standard_id = $detail['Timing']['standard_id'];
								$this->loadModel('Standard');
								$standard_detail = $this->Standard->find('first', array(
									'conditions' => array('id' => $standard_id)
									));
								$standard_name = $standard_detail['Standard']['name'];
								
								$section_id = $detail['Timing']['section_id'];
								$this->loadModel('Section');
								$section_detail = $this->Section->find('first', array(
									'conditions' => array('id' => $section_id)
									));
								$section_name = $section_detail['Section']['name'];
								
								$sub_title = $standard_name.' '.$section_name;
                            

                            $timetable[] = array(
                                'timeslot' => date("h:i A", strtotime($detail['Timing']['start_time'])) . " - " . date("h:i A", strtotime($detail['Timing']['end_time'])),
                                'title' => $title,
                                'subtitle' => $sub_title,
                                'iconURI' => '',
                            );
                        }

                        $return[strtolower($day['Day']['name'])] = $timetable;
                    }
                    //pr($return);die;
                //}

                $data = $this->Timetable->formatMessages('Timetable details',true,$return);

            /* }else{
                $data = $this->Student->formatMessages('Invalid Student id');
            } */
        }else{
            $data = $this->Timetable->formatMessages('Parameters missing');
        }
        $this->set('data',$data);
    }
}