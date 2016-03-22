<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 08-09-2015
 * Time: 04:23 PM
 */

App::uses('AppModel', 'Model');

class Exam extends AppModel {

    public $hasMany = array(
        'ExamDetail' => array(
            'className' => 'ExamDetail',
            'foreignKey' => 'exam_id',
        ),
    );

    public $belongsTo = array(
        'Standard' => array(
            'className' => 'Standard',
            'foreignKey' => 'standard_id',
        ),
        'Section' => array(
            'className' => 'Section',
            'foreignKey' => 'section_id',
        ),
        'ExamType' => array(
            'className' => 'ExamType',
            'foreignKey' => 'exam_type_id',
        ),
    );

    public function add($data) {

        $UserClass = ClassRegistry::init('User');
        $staff = $UserClass->getLoggedUserDetails();

        $data['date_added'] = $data['date_modified'] = date("Y-m-d H:i:s");
        $data['exam_type_id'] = $data['type'];
        $data['staff_id'] = $staff['Staff']['id'];

        if($this->save($data)){
            return true;
        }else{
            return false;
        }
    }

    public function update($data,$exam_id) {

        $date_modified = date("Y-m-d H:i:s");

        if($this->updateAll(
            array('Exam.name' => "'" . Sanitize::escape($data['name']) . "'",'Exam.exam_type_id' => "'{$data['type']}'",'Exam.date_modified' => "'{$date_modified}'"),
            array('Exam.id' => $exam_id)
        )){
            return true;
        }else{
            return false;
        }
    }
}