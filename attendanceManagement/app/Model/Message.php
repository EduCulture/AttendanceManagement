<?php
/**
 * Created by PhpStorm.
 * User: hitesh.kubavat
 * Date: 29-07-2015
 * Time: 10:05
 */

class Message extends AppModel {


    public function add($data) {

        $data['date_added'] = date("Y-m-d H:i:s");
        $data['date_modified'] = date("Y-m-d H:i:s");
        $data['school_id'] = CakeSession::read('Auth.User.school_id');

        if($this->save($data)){
            return true;
        }else{
            return false;
        }
    }

    //update staff
    public function update($data,$message_id) {

        $date_modified = date("Y-m-d H:i:s");
        //pr($data);die;

        if($this->updateAll(
            array('Message.message' => "'{$data['message']}'",'Message.user_type' => "'{$data['user_type']}'",'Message.is_active' => "'{$data['is_active']}'",'Message.date_modified' => "'{$date_modified}'"),
            array('Message.id' => $message_id)
        )){
            return true;
        }else{
            return false;
        }
    }
}
