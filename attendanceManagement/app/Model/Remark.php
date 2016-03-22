<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 08-09-2015
 * Time: 04:23 PM
 */

App::uses('AppModel', 'Model');

class Remark extends AppModel {

    public $belongsTo = array(
        'Staff' => array(
            'className' => 'Staff',
            'foreignKey' => 'staff_id',
            'fields' => array('Staff.first_name','Staff.last_name','Staff.id')
        ),
        'Student' => array(
            'className' => 'Student',
            'foreignKey' => 'student_id',
            'fields' => array('Student.first_name','Student.last_name','Student.id')
        ),
    );

    public function add($data) {

        $data['date_added'] = $data['date_modified'] = date("Y-m-d H:i:s");

        $UserClass = ClassRegistry::init('User');

        if($staff_detail = $UserClass->getLoggedUserDetails()){
            $staff_id = $staff_detail['Staff']['id'];
            $data['staff_id'] = $staff_id;
        }

        if($this->save($data)){
            return true;
        }else{
            return false;
        }
    }

    public function update($data,$student_id) {

        $date_modified = date("Y-m-d H:i:s");
        $data['birthdate'] = date("Y-m-d",strtotime($data['birthdate']));
        //pr($data);die;

        //update staff details
        $this->updateAll(
            array('Student.admission_number' => "'{$data['admission_number']}'",'Student.roll_number' => "'{$data['roll_number']}'",'Student.first_name' => "'{$data['first_name']}'",'Student.last_name' => "'{$data['last_name']}'",'Student.address' => "'{$data['address']}'",'Student.profile_pic' => "'{$data['profile_pic']}'",'Student.contact_number' => "'{$data['contact_number']}'",'Student.gender' => "'{$data['gender']}'",'Student.birthdate' => "'{$data['birthdate']}'",'Student.is_active' => "'{$data['is_active']}'",'Student.date_modified' => "'{$date_modified}'"),
            array('Student.id' => $student_id)
        );

        //update school admin
        $data['school_id'] = CakeSession::read('Auth.User.school_id');
        $userClass = ClassRegistry::init('User');
        if($userClass->update($data,$data['user_id'])){

            $parentClass = ClassRegistry::init('Parents');
            $parentMapClass = ClassRegistry::init('StudentParentMap');

            if(isset($data['student_parents']) && $data['student_parents']){
                $parentMapClass->deleteAll(array('StudentParentMap.student_id' => $student_id),true);
                if($parentClass->add($data['student_parents'],$student_id)) {
                    return true;
                }else{
                    return false;
                }
            }

            return true;
        }
    }
}