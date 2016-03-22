<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 08-09-2015
 * Time: 04:23 PM
 */

App::uses('AppModel', 'Model');

class Section extends AppModel {


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

    public function update($data,$section_id) {

        $date_modified = date("Y-m-d H:i:s");
        $data['school_id'] = CakeSession::read('Auth.User.school_id');

        //update staff details
        if($this->updateAll(
            array('Section.name' => "'{$data['name']}'",'Section.is_active' => "'{$data['is_active']}'",'Section.date_modified' => "'{$date_modified}'"),
            array('Section.id' => $section_id)
        )){
            return true;
        }else{
            return false;
        }
    }
}