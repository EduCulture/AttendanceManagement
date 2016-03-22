<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 07-09-2015
 * Time: 11:04 AM
 */

App::uses('AppController', 'Controller');

class AttendanceController extends AppController {

    private $error = array();

    public function index() {
        //$this->getList();
		
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

    public function add() {

        if(isset($this->request->query['standard_id']) && $this->request->query['section_id']) {

            $UserClass = ClassRegistry::init('User');
            $staff = $UserClass->getLoggedUserDetails();

			$this->loadModel('SubjectTeacherMap');
			$this->set('standards',$this->SubjectTeacherMap->getStandards());
			
            /* $this->loadModel('StandardSectionMap');
            $this->StandardSectionMap->recursive = 1;
            $data = $this->StandardSectionMap->find('all',array(
                'conditions' => array('StandardSectionMap.staff_id' => $staff['Staff']['id'],'StandardSectionMap.standard_id' => $this->request->query['standard_id'],'StandardSectionMap.section_id' => $this->request->query['section_id']),
            ));

            if(!$data){
                $this->redirect(array('controller' => 'attendance','action' => 'index'));
            } */

            $this->set('standard_id',$this->request->query['standard_id']);
            $this->set('section_id',$this->request->query['section_id']);

            //standard
            $this->loadModel('Standard');
            $this->Standard->recursive = 0;
            $standard = $this->Standard->find('first',array(
               'conditions' => array('Standard.id' => $this->request->query['standard_id'])
            ));
            $this->set('standard',$standard);

            //section
            $this->loadModel('Section');
            $this->Section->recursive = 0;
            $section = $this->Section->find('first',array(
                'conditions' => array('Section.id' => $this->request->query['section_id'])
            ));
            $this->set('section',$section);

            //staff
            $this->loadModel('Staff');
            $this->set('staffs',$this->Staff->getAllStaffs());

            if(isset($this->request->query['filter_date'])){
                $filter_date = date("Y-m-d",strtotime($this->request->query['filter_date']));
            }else{
                $filter_date = date("Y-m-d",strtotime($this->request->query['attendance_date']));
            }

            $this->set('filter_date',$filter_date);

            $this->Attendance->recursive = 1;
            $attendances = $this->Attendance->find('all',array(
               'conditions' => array('Attendance.attendance_date' => $filter_date,'Student.school_id' => CakeSession::read('Auth.User.school_id'))
            ));
            $this->set('attendances',$attendances);
            //pr($attendances);die;

            //students
            $this->loadModel('Student');
            $students = $this->Student->find('all',array(
                'conditions' => array('Student.standard_id' => $this->request->query['standard_id'],'Student.section_id' => $this->request->query['section_id']),
            ));
            $this->set('students',$students);
        }else{
            $this->redirect(array('controller' => 'attendance','action' => 'index'));
        }

        $this->getForm();

        $this->view = 'add_attendance';
    }

    public function save() {

        if($this->request->is('post')){
            if($this->Attendance->add($this->request->data)) {
                $this->Session->setFlash('Attendance Added Successfully', 'flash');
                $this->redirect(array('controller' => 'attendance','action' => 'index'));
            }
        }

        $this->redirect(array('controller' => 'attendance'));
    }

    public function update() {
        $json = [];
        if($this->request->is('post')){
            if($this->Attendance->update($this->request->data)) {
                $this->Session->setFlash('Attendance Update Successfully', 'flash');
                $json['success'] = 'Successfully updated';
            }else{
                $json['error'] = 'Failed to update';
            }
        }

        echo json_encode($json);
        $this->autoRender = false;
    }


    public function getList() {

        $UserClass = ClassRegistry::init('User');
        $staff = $UserClass->getLoggedUserDetails();

        $this->loadModel('StandardSectionMap');
        $this->StandardSectionMap->recursive = 1;
        $data = $this->StandardSectionMap->find('all',array(
            'conditions' => array('StandardSectionMap.staff_id' => $staff['Staff']['id']),
            'group' => array('StandardSectionMap.standard_id')
        ));

        //pr($data);die;

        $detail = [];
        if($data){
            $detail = array(
                'standard_id' => $data['Standard']['id'],
                'standard_name' => $data['Standard']['name'],
                'section_id' => $data['Section']['id'],
                'section_name' => $data['Section']['name'],
            );
        }
        //pr($detail);die;
        $this->set('details',$detail);
    }

    public function getStudentList() {

        if(isset($this->request->data['standard_id']) && $this->request->data['section_id'] && $this->request->data['date']) {

            $this->set('standard_id',$this->request->data['standard_id']);
            $this->set('section_id',$this->request->data['section_id']);
            $this->set('attendance_date',date("Y-m-d",strtotime($this->request->data['date'])));

            //Students Deatils
            $this->loadModel('Student');
            $this->Student->recursive = -1;
            $student_details = $this->Student->find('all',array(
                'conditions' => array('Student.standard_id' => $this->request->data['standard_id'],'Student.section_id' => $this->request->data['section_id'],'Attendance.attendance_date' => date("Y-m-d",strtotime($this->request->data['date']))),
                'fields' => array('Attendance.attendance_date','Attendance.attendance_status','Attendance.remark','Student.first_name','Student.last_name','Student.roll_number','Attendance.id','Student.id','Staff.first_name','Staff.last_name'),
                'joins' => array(
                    array(
                        'table' => 'attendances',
                        'alias' => 'Attendance',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Student.id = Attendance.student_id'
                        )
                    ),
                    array(
                        'table' => 'staffs',
                        'alias' => 'Staff',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Staff.id = Attendance.staff_id'
                        )
                    )
                ),
                'order' => array('Attendance.attendance_date DESC')
            ));
            //pr($student_details);die;
            $students = [];
            if($student_details){
                foreach($student_details as $val){
                    $students[] = array(
                       'attendance_id' => $val['Attendance']['id'],
                       'attendance_date' => $val['Attendance']['attendance_date'],
                       'student_id' => $val['Student']['id'],
                       'student_name' => $val['Student']['first_name'] . ' ' . $val['Student']['last_name'],
                       'staff_name' =>  $val['Staff']['first_name'] . ' ' . $val['Staff']['last_name'],
                       'attendance_status' => $val['Attendance']['attendance_status'],
                       'remark' => $val['Attendance']['remark']
                    );
                }
            }

            $this->set('students',$students);

            $this->view = 'student_list';
            $this->layout = 'ajax';
        }
    }


    public function getForm() {


    }

    public function validateForm() {

        //pr($this->request->data);die;

        if (!$this->request->data['name']) {
            $this->error['name'] = 'Standard name can not be empty';
        }

        if (!$this->request->data['start_date']) {
            $this->error['start_date'] = 'Start date can not be empty';
        }

        if (!$this->request->data['end_date']) {
            $this->error['end_date'] = 'End date can not be empty';
        }

        if (!$this->request->data['due_date']) {
            $this->error['due_date'] = 'Due date can not be empty';
        }

        if(isset($this->request->data['standard_fee']) && is_array($this->request->data['standard_fee']) && $this->request->data['standard_fee']){
            foreach($this->request->data['standard_fee'] as $val){
                if(!$val['amount'] || !is_numeric($val['amount'])){
                    $this->error['amount'][] = 'Invalid amount';
                }
            }
        }

        //pr($this->error);die;
        if (!$this->request->data['due_date']) {
            $this->error['due_date'] = 'Due date can not be empty';
        }

        if($this->error){
            $this->error['warning'] = 'Please Check Below Errors';
        }

        return !$this->error;
    }

    public function report() {



        /*for ($i = 1; $i <= 12; $i++) {
            $attendance_data[$i] = array(
                'present' => 0,
                'absent' => 0
            );
        }
        //pr($attendance_data);die;

        $this->loadModel('Student');
        $attendance_query = $this->Student->query("SELECT COUNT(*) AS total,attendance_date,sum(case when attendance_status = 1 then 1 else 0 end) as present_count,sum(case when attendance_status = 0 then 1 else 0 end) as absent_count FROM `attendances` WHERE student_id IN (SELECT `id` FROM `students` WHERE `school_id` = '".CakeSession::read('Auth.User.school_id')."') AND YEAR(`attendance_date`) = YEAR(NOW()) GROUP BY MONTH(attendance_date)");
        //pr($attendance_query);die;
        if($attendance_query) {
            foreach ($attendance_query as $result) {
                //echo date('n', strtotime($result['attendances']['attendance_date']));die;
                //print_r($result)."<br/>";
                $attendance_data[date('n', strtotime($result['attendances']['attendance_date']))] = array(
                    'present' => $result[0]['present_count'],
                    'absent' => $result[0]['absent_count']
                );
            }
        }

        //pr($attendance_data);die;

        foreach($attendance_data as $val){
            $present[] = (int)$val['present'];
            $absent[] = (int)$val['absent'];
        }

        $this->set('present',json_encode($present));
        $this->set('absent',json_encode($absent));*/
    }

    public function getReport() {

        $UserClass = ClassRegistry::init('User');
        $staff = $UserClass->getLoggedUserDetails();

        $this->loadModel('StandardSectionMap');
        $this->StandardSectionMap->recursive = 1;
        $data = $this->StandardSectionMap->find('first',array(
            'conditions' => array('StandardSectionMap.staff_id' => $staff['Staff']['id']),
            'group' => array('StandardSectionMap.standard_id')
        ));

        $report_data = [];
        if($data){
            $this->loadModel('Student');
            $students = $this->Student->find('all',array(
                'conditions' => array('Student.standard_id' => $data['Standard']['id'],'Student.section_id' => $data['Section']['id'])
            ));

            /*$start = date("Y-m-d",strtotime($this->request->data['to_date']));
            $end = date("Y-m-d",strtotime($this->request->data['from_date']));

            $days_between = ceil(abs($end - $start) / 86400);
            echo $days_between;die;*/

            $this->loadModel('Attendance');
            foreach($students as $student) {
                $attendance_data = $this->Attendance->query("SELECT SUM(IF(Attendance.attendance_status = 1, 1, 0)) AS present_day,SUM(IF(Attendance.attendance_status = 0, 1, 0)) AS absent_day FROM `Attendances` as Attendance WHERE Attendance.attendance_date >= '".date("Y-m-d",strtotime($this->request->data['to_date']))."' AND Attendance.attendance_date <= '".date("Y-m-d",strtotime($this->request->data['from_date']))."' AND Attendance.student_id = '".$student['Student']['id']."'");


                $report_data[] = array(
                   'student_id' => $student['Student']['id'],
                   'student_name' => $student['Student']['first_name'] . ' ' .$student['Student']['last_name'],
                   'roll_number' => $student['Student']['roll_number'],
                   'present_day' => $attendance_data[0][0]['present_day'],
                   'absent_day' => $attendance_data[0][0]['absent_day'],
                );
            }
        }

        $this->set('report_data',$report_data);

        $this->view = 'view_report';
        $this->layout = 'ajax';
    }

    public function getStudentAttendanceReport() {

        if($this->request->query['student_id']){

            $attendance_details = $this->Attendance->find('all',array(
                'conditions' => array('Attendance.student_id' => $this->request->query['student_id']),
            ));

            $students = [];
            if($attendance_details){
                foreach($attendance_details as $val){
                    $students[] = array(
                        'attendance_id' => $val['Attendance']['id'],
                        'attendance_date' => $val['Attendance']['attendance_date'],
                        'student_id' => $val['Student']['id'],
                        'student_name' => $val['Student']['first_name'] . ' ' . $val['Student']['last_name'],
                        'staff_name' =>  $val['Staff']['first_name'] . ' ' . $val['Staff']['last_name'],
                        'status' => $val['Attendance']['attendance_status'],
                        'remark' => $val['Attendance']['remark'],
                        'backgroundColor' => ($val['Attendance']['attendance_status']==0) ? '#DD4B39' : '#00A65A'
                    );
                }
            }

            echo json_encode($students);
            $this->autoRender = false;
        }
    }


    public function services_getAttendance() {

        $this->loadModel('Attendance');

        if(isset($this->request->data['student_id'])){
            $this->loadModel('Student');

            $attendances = $this->Attendance->find('all',array(
                'conditions' => array('Attendance.student_id' => $this->request->data['student_id'],'Attendance.attendance_status' => 0),
            ));

            //pr($attendances);die;
            $attendance_detail = [];
            foreach($attendances as $attendance) {
                $attendance_detail[] = array(
                    'weekday' => date('l', strtotime($attendance['Attendance']['attendance_date'])),
                    'date' => date("d", strtotime($attendance['Attendance']['attendance_date'])),
                    'month' => date('F', strtotime($attendance['Attendance']['attendance_date'])),
                    'year' => date('Y', strtotime($attendance['Attendance']['attendance_date'])),
                    'type' => 'absent'
                );
            }

            $data = $this->Attendance->formatMessages('Attendance Detail',true,$attendance_detail);

        }else{
            $data = $this->Attendance->formatMessages('Parameters missing');
        }

        $this->set('data',$data);
    }


    public function getAbsentDates(){

        //pr($this->request->data);die;

        $this->loadModel('Attendance');
        $this->Attendance->recursive = -1;
        $dates = $this->Attendance->find('all',array(
           'fields' => array('Attendance.attendance_date'),
           'conditions' => array('Attendance.student_id' => $this->request->data['student_id'],'Attendance.attendance_date >=' => date("Y-m-d",strtotime($this->request->data['to_date'])), 'Attendance.attendance_date <=' =>  date("Y-m-d",strtotime($this->request->data['from_date'])), 'Attendance.attendance_status = 0')
        ));

        //echo $this->Attendance->getLastQuery();die;
        $return = [];
        if($dates){
            foreach($dates as $date){
                $return[] = date("d-M-Y",strtotime($date['Attendance']['attendance_date']));
            }
        }

        echo json_encode($return);
        $this->autoRender = false;

        //pr($dates);die;
    }
	
	public function services_saveAttendance() {

			
        if($this->request->is('post') && isset($this->request->data)){
			
			//$attendance_data = $this->request->data['data'];
			
			//$standard_id = $attendance_data['standard_id'];
			
			//$this->loadModel('StandardSectionMap');
			//$this->StandardSectionMap->recursive = 1;
			
			/* $data = $this->StandardSectionMap->find('first',array(
			   'conditions' => array('StandardSectionMap.standard_id' => $this->request->data['standard_id'],
										'StandardSectionMap.section_id' => $this->request->data[['section_id'])
			)); 

			$standardSectionId = $data['StandardSectionMap']['id'];*/
			
			/* $attendance_detail = [];
            foreach($this->request->data['students'] as $attendance) {
                $attendance_detail[] = array(
                    'studentId' => $attendance['studentId'],
                    'attendance' => $attendance['attendance'],
					'remark' => $attendance['remark'],
                );
            } */
			
			/* $attendance_detail = [];
            foreach($this->request->data['students'] as $attendance) {
                $attendance_detail[] = array(
                    'studentId' => '1',
                    'attendance' => 'true',
					'remark' => '',
                );
            } */
			
			/* $attendance_data = array(
					'staffId' => $this->request->data['staff_id'],
					'remark' => $this->request->data['standard_id'],
					'attendanceDate' => $this->request->data['attendance_date'],
					'subjectId' => $this->request->data['subject_id'],
					'listStudents' => $attendance_detail,
			
			);  */
			
            /* if($this->Attendance->addFromApp($attendance_data, $standardSectionId)) {
                $data = $this->Attendance->formatMessages('Attendance successful',true);
            }
			else{
				$data = $this->Attendance->formatMessages('Attendance failed',true);
			} */
			$data = $this->Attendance->formatMessages('Failed',true, $this->request->data);
        }
		else{
			$data = $this->Attendance->formatMessages('Student list empty',false);
		} 

        $this->set('data',$data);
    }
	
}