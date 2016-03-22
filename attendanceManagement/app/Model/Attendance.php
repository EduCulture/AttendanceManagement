<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 07-09-2015
 * Time: 04:26 PM
 */

App::uses('AppModel', 'Model');

class Attendance extends AppModel {

    public $belongsTo = array(
        'Student' => array(
            'className' => 'Student',
            'foreignKey' => 'student_id',
        ),
        'Staff' => array(
            'className' => 'Staff',
            'foreignKey' => 'staff_id',
        ),
    );

    public function add($data) {

        //pr($data);die;

        $User = ClassRegistry::init('User');
        $user_data = $User->getLoggedUserDetails();

        $staff_id = $user_data['Staff']['id'];
        //pr($staff_id);die;

        //insert attendance
        if(isset($data['student']) && $data['student']) {
            foreach ($data['student'] as $val) {
                //pr($val);die;
                $save = [];
                $save['student_id'] = $val['id'];
                $save['attendance_status'] = isset($val['attendance']) ? 1 : 0;
                $save['attendance_date'] = date("Y-m-d",strtotime($data['attendance_date']));
                $save['staff_id'] = $staff_id;
                $save['remark'] = isset($val['remark']) ? $val['remark'] : NULL;
                $save['date_added'] = date("Y-m-d H:i:s");
                $save['date_modified'] = date("Y-m-d H:i:s");
                $this->create();
                /*$this->save(array(
                    'Attendance.student_id' => 2,
                    'Attendance.attendance_status' => isset($val['attendance']) ? 1 : 0,
                    'Attendance.attendance_date' => date("Y-m-d",strtotime($data['attendance_date'])),
                    'Attendance.staff_id' => $staff_id,
                    'Attendance.remark' => isset($val['remark']) ? $val['remark'] : NULL,
                    'Attendance.date_added' => date("Y-m-d H:i:s"),
                    'Attendance.date_modified' => date("Y-m-d H:i:s"),
                ));*/
                $this->save($save);

            }
            return true;
        }else{
            return false;
        }
    }
	
	public function addFromApp($data, $standardSectionId) {

        //insert attendance
        if(isset($data['listStudents']) && $data['listStudents']) {
            foreach ($data['listStudents'] as $val) {
                //pr($val);die;
                $save = [];
                $save['student_id'] = $val['studentId'];
                $save['attendance_status'] = $val['attendance'] == 'true' ? 1 : 0;
                $save['attendance_date'] = date("Y-m-d",strtotime($data['attendanceDate']));
                $save['staff_id'] = $data[staffId];
				$save['subject_id'] = $data[subjectId];
                $save['remark'] = isset($val['remark']) ? $val['remark'] : NULL;
                $save['date_added'] = date("Y-m-d H:i:s");
                $save['date_modified'] = date("Y-m-d H:i:s");
				$save['std_section_id'] = $standardSectionId;
                $this->create();
                
                $this->save($save);

            }
            return true;
        }else{
            return false;
        }
    }

    //update staff
    public function update($data) {

        //pr($data);die;
        $date_modified = date("Y-m-d H:i:s");

        $User = ClassRegistry::init('User');
        $user_data = $User->getLoggedUserDetails();
        $staff_id = $user_data['Staff']['id'];

        if($data['attendance_status']){
            $remark = '';
        }else{
            $remark = $data['remarks'];
        }

        //update staff details
        if($this->updateAll(
            array('Attendance.student_id' => "'{$data['student_id']}'",'Attendance.attendance_status' => "'{$data['attendance_status']}'",'Attendance.remark' => "'{$remark}'",'Attendance.staff_id' => "'{$staff_id}'",'Attendance.date_modified' => "'{$date_modified}'"),
            array('Attendance.id' => $data['attendance_id'])
        )){
            return true;
        }

        return false;
    }
}