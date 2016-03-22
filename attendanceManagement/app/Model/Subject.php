<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 08-09-2015
 * Time: 04:23 PM
 */

App::uses('AppModel', 'Model');

class Subject extends AppModel {

    public function add($data) {

        //pr($data['student_parents']);die;
        $data['date_added'] = $data['date_modified'] = date("Y-m-d H:i:s");
        $data['school_id'] = CakeSession::read('Auth.User.school_id');

        //insert users details
        if($this->save($data)){
            return true;
        }else{
            return false;
        }
    }

    public function update($data,$subject_id) {

        $date_modified = date("Y-m-d H:i:s");

        //update staff details
        if($this->updateAll(
            array('Subject.name' => "'{$data['name']}'",'Subject.logo' => "'{$data['logo']}'",'Subject.is_active' => "'{$data['is_active']}'",'Subject.date_modified' => "'{$date_modified}'"),
            array('Subject.id' => $subject_id)
        )){
            return true;
        }else{
            return false;
        }
    }

    public function getAllSubjects() {
        $data = $this->find('all',array(
           'conditions' => array('Subject.school_id' => CakeSession::read('Auth.User.school_id'))
        ));

        if($data){
            return $data;
        }else{
            return false;
        }
    }


}