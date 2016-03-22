<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 08-09-2015
 * Time: 04:23 PM
 */

App::uses('AppModel', 'Model');

class Grade extends AppModel {

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

    public function update($data,$grade_id) {

        $date_modified = date("Y-m-d H:i:s");

        //update staff details
        if($this->updateAll(
            array('Grade.name' => "'" . Sanitize::escape($data['name']) . "'",'Grade.minimum_mark' => "'{$data['minimum_mark']}'",'Grade.maximum_mark' => "'{$data['maximum_mark']}'",'Grade.date_modified' => "'{$date_modified}'"),
            array('Grade.id' => $grade_id)
        )){
            return true;
        }else{
            return false;
        }
    }
}