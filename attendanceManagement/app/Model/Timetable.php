<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 08-09-2015
 * Time: 04:23 PM
 */

App::uses('AppModel', 'Model');

class Timetable extends AppModel {

    public $useTable = 'time_table';

    public $belongsTo = array(
        'Subject' => array(
            'className' => 'Subject',
            'foreignKey' => 'subject_id',
            'fields' => array('Subject.id','Subject.name')
        ),
        'Staff' => array(
            'className' => 'Staff',
            'foreignKey' => 'staff_id',
            'fields' => array('Staff.id','Staff.first_name','Staff.last_name')
        ),
        'Timing' => array(
            'className' => 'Timing',
            'foreignKey' => 'class_timing_id',

        ),
        'Day' => array(
            'className' => 'Day',
            'foreignKey' => 'day_id',
        ),
    );

    public function add($data) {

        $data['date_added'] = $data['date_modified'] = date("Y-m-d H:i:s");

        if($this->save(array(
           'day_id' => $data['modal_day_id'],
           'class_timing_id' => $data['modal_time_id'],
           'subject_id' => $data['subject_id'],
           'staff_id' => $data['staff_id']
        ))){
            return true;
        }else{
            return false;
        }
    }

    public function update($data,$timetable_id) {

        $date_modified = date("Y-m-d H:i:s");

        if($this->updateAll(
            array('Timetable.day_id' => "'{$data['modal_day_id']}'",'Timetable.class_timing_id' => (int)"'{$data['modal_time_id']}'",'Timetable.subject_id' => (int)"'{$data['subject_id']}'",'Timetable.staff_id' => (int)"'{$data['staff_id']}'",'Timetable.date_modified' => "'{$date_modified}'"),
            array('Timetable.id' => $timetable_id)
        )){
            return true;
        }else{
            return false;
        }
    }
}