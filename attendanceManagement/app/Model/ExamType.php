<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 07-09-2015
 * Time: 01:31 PM
 */

App::uses('AppModel', 'Model');

class ExamType extends AppModel
{
    //public $useTable = 'event_types';

    public function add($data){

        //pr($data);die;
        $data['date_added'] = date("Y-m-d H:i:s");
        $data['date_modified'] = date("Y-m-d H:i:s");
        $data['school_id'] = CakeSession::read('Auth.User.school_id');

        if(isset($data['is_available'])){
            $data['is_available'] = 1;
        }else{
            $data['is_available'] = 0;
        }

        if($this->save($data)){
            return true;
        }else{
            return false;
        }
    }

    public function update($data,$type_id){

        $date_modified = date("Y-m-d H:i:s");
        //pr($data);die;
        $available = 0;
        if(isset($data['is_available'])){
            $available = 1;
        }
        if($this->updateAll(
            array('ExamType.name' => "'{$data['name']}'",'ExamType.is_available' => "'{$available}'",'ExamType.date_modified' => "'{$date_modified}'"),
            array('ExamType.id' => $type_id)
        )){
            return true;
        }else{
            return false;
        }
    }
}