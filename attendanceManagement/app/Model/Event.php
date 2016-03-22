<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 07-09-2015
 * Time: 01:31 PM
 */

App::uses('AppModel', 'Model');

class Event extends AppModel
{

    public $belongsTo = array(
        'EventType' => array(
            'className' => 'EventType',
            'foreignKey' => 'event_type_id',
        ),
    );

    public function add($data){

        //pr($data);die;
        $data['date_added'] = date("Y-m-d H:i:s");
        $data['date_modified'] = date("Y-m-d H:i:s");
        $data['school_id'] = CakeSession::read('Auth.User.school_id');
        $data['event_date'] = date("Y-m-d",strtotime($data['event_date']));

        //insert event
        if($this->save($data)){
            return true;
        }else{
            return false;
        }
    }

    public function update($data,$event_id){

        $data['date_added'] = date("Y-m-d H:i:s");
        $data['date_modified'] = date("Y-m-d H:i:s");
        $data['school_id'] = CakeSession::read('Auth.User.school_id');
        $data['event_date'] = date("Y-m-d",strtotime($data['event_date']));

        //pr($data);die;

        $this->deleteAll(array('Event.id' => $event_id));
        if($this->save($data)){
            return true;
        }else{
            return false;
        }
    }
}