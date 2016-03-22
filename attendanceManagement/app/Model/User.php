<?php
/**
 * Created by PhpStorm.
 * User: deep.gandhi
 * Date: 29-07-2015
 * Time: 14:54
 */


App::uses('AppModel', 'Model');

class User extends AppModel {

    public $belongsTo = array(
        'Role' => array(
            'className' => 'Role',
            'foreignKey' => 'role_id',
        )
    );

    public function beforeSave($options = array()){
        if(isset($this->data[$this->alias]['password']) && !empty($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
            $this->data[$this->alias]['date_added'] = date("Y-m-d H:i:s");
            $this->data[$this->alias]['date_modified'] = date("Y-m-d H:i:s");
        }
    }

    public function add($data){
        $data['school_id'] = 0;
        $data['role_id'] = 1;
        if($this->save($data)){
            return true;
        }else{
            return false;
        }
    }

    public function update($data,$user_id){

        $modified = date("Y-m-d H:i:s");
        //pr($data);die;
        //echo $data['email']."==".$data['username']."==".$data['school_id'];die;
        if($this->updateAll(
            array('User.role_id' => "'{$data['role_id']}'",'User.date_modified' => "'{$modified}'"),
            array('User.id' => $user_id)
        )){
            return true;
        }else{
            return false;
        }
    }

    public function checkValidUserName($username){

        if($this->findByUsername($username)){
            return true;
        }else{
            return false;
        }
    }

    public function getLoggedUserDetails() {

        if(CakeSession::read('Auth.User.role_id') == 2 || CakeSession::read('Auth.User.role_id') == 3){
            $StaffClass = ClassRegistry::init('Staff');

            $staff = $StaffClass->find('first',array(
                'conditions' => array('Staff.user_id' => CakeSession::read('Auth.User.id'))
            ));

            if($staff) {
                return $staff;
            }
            return false;
        }else{

            $StudentClass = ClassRegistry::init('Student');

            $student = $StudentClass->find('first',array(
                'conditions' => array('Student.user_id' => CakeSession::read('Auth.User.id'))
            ));

            if($student) {
                return $student;
            }
            return false;
        }
    }

    public function getLoggedUserId() {

    }
}