<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 08-09-2015
 * Time: 04:23 PM
 */

App::uses('AppModel', 'Model');

class Assignment extends AppModel {

    public $belongsTo = array(
        'Staff' => array(
            'className' => 'Staff',
            'foreignKey' => 'staff_id',
        ),
        'Subject' => array(
            'className' => 'Subject',
            'foreignKey' => 'subject_id',
        ),
    );

    public function add($data) {

        $data['date_added'] = $data['date_modified'] = date("Y-m-d H:i:s");

        $UserClass = ClassRegistry::init('User');
        $staff = $UserClass->getLoggedUserDetails();

        if($this->save(array(
            'standard_id' => $data['standard_id'],
            'section_id' => $data['section_id'],
            'title' => $data['title'],
            'description' => $data['description'],
            'start_date' => date("Y-m-d",strtotime($data['start_date'])),
            'end_date' => date("Y-m-d",strtotime($data['end_date'])),
            'staff_id' => $staff['Staff']['id'],
            'subject_id' => $data['subject_id'],
            'date_added' => date("Y-m-d H:i:s"),
            'date_modified' => date("Y-m-d H:i:s"),
        ))){
            return true;
        }else{
            return false;
        }
    }

    public function update($data) {

        $date_modified = date("Y-m-d H:i:s");
        $start_date = date("Y-m-d",strtotime($data['start_date']));
        $end_date = date("Y-m-d",strtotime($data['end_date']));
        //pr($data);die;

        if($this->updateAll(
            array('Assignment.title' => "'" . Sanitize::escape($data['title']) . "'",'Assignment.description' => "'" . Sanitize::escape($data['description']) . "'",'Assignment.start_date' => "'{$start_date}'",'Assignment.end_date' => "'{$end_date}'",'Assignment.subject_id' => "'{$data['subject_id']}'",'Assignment.date_modified' => "'{$date_modified}'"),
            array('Assignment.id' => $data['assignment_id'])
        )){
            return true;
        }else{
            return false;
        }
    }
}