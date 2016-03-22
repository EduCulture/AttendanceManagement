<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 07-09-2015
 * Time: 01:31 PM
 */

App::uses('AppModel', 'Model');

class EventType extends AppModel
{
    //public $useTable = 'event_types';

    public function add($data){

        //pr($data);die;
        $data['date_added'] = date("Y-m-d H:i:s");
        $data['date_modified'] = date("Y-m-d H:i:s");
        $data['school_id'] = CakeSession::read('Auth.User.school_id');


        //insert event
        if($this->save($data)){
            return true;
        }else{
            return false;
        }
    }

    public function update($data,$event_id){

        $date_modified = date("Y-m-d H:i:s");
        $data['event_date'] = date("Y-m-d",strtotime($data['event_date']));

        //pr($data);die;
        //insert school
        if($this->updateAll(
            array('Event.tittle' => "'{$data['tittle']}'",'Event.description' => "'{$data['description']}'",'Event.event_date' => "'{$data['event_date']}'",'Event.date_modified' => "'{$date_modified}'"),
            array('Event.id' => $event_id)
        )){
            return true;
        }else{
            return false;
        }
    }
}