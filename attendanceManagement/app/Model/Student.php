<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 08-09-2015
 * Time: 04:23 PM
 */

App::uses('AppModel', 'Model');

class Student extends AppModel {

    private $role_id = 4;

    public $hasMany = array(
        'StudentParentMap' => array(
            'className' => 'StudentParentMap',
            'foreignKey' => 'student_id',
        ),
        /*'StudentFeeMap' => array(
            'className' => 'StudentFeeMap',
            'foreignKey' => 'student_id',
            //'fields' => array('SUM(amount) as paid_fee','fee_id','student_id')
        ),*/
    );

    public $belongsTo = array(
        'Standard' => array(
            'className' => 'Standard',
            'foreignKey' => 'standard_id',
        ),
        'Section' => array(
            'className' => 'Section',
            'foreignKey' => 'section_id',
        ),
        'School' => array(
            'className' => 'School',
            'foreignKey' => 'school_id',
        ),
    );

    public function add($data) {

        //pr($data['student_parents']);die;
        $data['date_added'] = $data['date_modified'] = date("Y-m-d H:i:s");
        $data['school_id'] = CakeSession::read('Auth.User.school_id');
        $data['birthdate'] = date("Y-m-d",strtotime($data['birthdate']));

        //insert users details
        if($this->save($data)){
            $student_id = $this->id;

            $user_detail = $this->find('first',array(
               'fields' => array('Student.user_id'),
               'conditions' => array('Student.contact_number' => $data['contact_number'])
            ));

            $data['role_id'] = $this->role_id;

            if(!$user_detail) {
                $userClass = ClassRegistry::init('User');

                $data['username'] = substr($data['first_name'], 0, 3) . $student_id;
                $data['password'] = 'demo';

                $userClass->save($data);

                $user_id = $userClass->id;
            }else{
                $user_id = $user_detail['Student']['user_id'];
            }

            //update user id
            $this->saveField('user_id',$user_id);

            $parentClass = ClassRegistry::init('Parents');

            if(isset($data['student_parents']) && $data['student_parents']){
                $parentClass->add($data['student_parents'],$student_id);
            }
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
            array('Student.admission_number' => "'{$data['admission_number']}'",'Student.roll_number' => "'{$data['roll_number']}'",'Student.standard_id' => "'{$data['standard_id']}'",'Student.section_id' => "'{$data['section_id']}'",'Student.first_name' => "'{$data['first_name']}'",'Student.last_name' => "'{$data['last_name']}'",'Student.address' => "'{$data['address']}'",'Student.profile_pic' => "'{$data['profile_pic']}'",'Student.contact_number' => "'{$data['contact_number']}'",'Student.gender' => "'{$data['gender']}'",'Student.birthdate' => "'{$data['birthdate']}'",'Student.is_active' => "'{$data['is_active']}'",'Student.date_modified' => "'{$date_modified}'"),
            array('Student.id' => $student_id)
        );

        //update school admin
        $data['school_id'] = CakeSession::read('Auth.User.school_id');

        $parentClass = ClassRegistry::init('Parents');
        $parentMapClass = ClassRegistry::init('StudentParentMap');

        if(isset($data['student_parents']) && $data['student_parents']){
            $parentMapClass->deleteAll(array('StudentParentMap.student_id' => $student_id),true);
            $parentClass->add($data['student_parents'],$student_id);
        }

        return true;
    }

    public function getStandardAndSection($student_id) {

        $data = $this->find('first',array(
           'conditions' => array('Student.id' => $student_id)
        ));

        if($data){
            return array('standard_id' => $data['Student']['standard_id'],'section_id' => $data['Student']['section_id']);
        }else{
            return false;
        }
    }
}