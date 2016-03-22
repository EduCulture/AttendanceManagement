<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 07-09-2015
 * Time: 04:26 PM
 */

App::uses('AppModel', 'Model');

class Staff extends AppModel {

     public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
        ),
		'School' => array(
            'className' => 'School',
            'foreignKey' => 'school_id',
        ),
		
    ); 
    private $role_id = 3;

    //add staff
    public function add($data) {

        $data['date_added'] = date("Y-m-d H:i:s");
        $data['date_modified'] = date("Y-m-d H:i:s");
        $data['birthdate'] = date("Y-m-d",strtotime($data['birthdate']));
        $data['school_id'] = CakeSession::read('Auth.User.school_id');

        //insert staff
        if($this->save($data)){

            $staff_id = $this->id;

            //insert into users table
            $data['role_id'] = $this->role_id;
            $userClass = ClassRegistry::init('User');

            $data['username'] = substr($data['first_name'],0,3).substr($data['contact_number'],5,5);
            $data['password'] = 'demo';

            $userClass->save($data);

            $user_id = $userClass->id;
            //update user id
            $this->saveField('user_id',$user_id);

            if(isset($data['staff_subjects']) && $data['staff_subjects']){
                $StaffSubject = ClassRegistry::init('StaffSubjectMap');
                $StaffSubject->add($data['staff_subjects'],$staff_id);
            }

            return true;
        }else{
            return false;
        }
    }

    //update staff
    public function update($data,$staff_id) {

        //pr($data);die;
        $date_modified = date("Y-m-d H:i:s");
        $data['birthdate'] = date("Y-m-d",strtotime($data['birthdate']));
        //pr($data);die;

        //update staff details
        $this->updateAll(
            array('Staff.first_name' => "'" . Sanitize::escape($data['first_name']) . "'",'Staff.last_name' => "'" . Sanitize::escape($data['last_name']) . "'",'Staff.address' => "'" . Sanitize::escape($data['address']) . "'",'Staff.profile_pic' => "'{$data['profile_pic']}'",'Staff.contact_number' => "'{$data['contact_number']}'",'Staff.qualification' => "'" . Sanitize::escape($data['qualification']) . "'",'Staff.type' => "'{$data['type']}'",'Staff.gender' => "'{$data['gender']}'",'Staff.birthdate' => "'{$data['birthdate']}'",'Staff.emp_id' => "'{$data['emp_id']}'",'Staff.joining_date' => "'{$data['joining_date']}'",'Staff.basic_salary' => "'{$data['basic_salary']}'",'Staff.experience' => "'{$data['experience']}'",'Staff.is_active' => "'{$data['is_active']}'",'Staff.date_modified' => "'{$date_modified}'"),
            array('Staff.id' => $staff_id)
        );

        $userClass = ClassRegistry::init('User');

        $userClass->update($data,$data['user_id']);

        $data['school_id'] = CakeSession::read('Auth.User.school_id');

        if(isset($data['staff_subjects']) && $data['staff_subjects']){
            $StaffSubject = ClassRegistry::init('StaffSubjectMap');
            $StaffSubject->add($data['staff_subjects'],$staff_id);
        }

        return true;
    }

    public function getAllStaffs() {

        $data = $this->find('all',array(
            'conditions' => array('Staff.school_id' => CakeSession::read('Auth.User.school_id'),'User.role_id' => 3)
        ));

        if($data){
            return $data;
        }else{
            return false;
        }
    }
}