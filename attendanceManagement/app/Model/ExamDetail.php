<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 08-09-2015
 * Time: 04:23 PM
 */

App::uses('AppModel', 'Model');

class ExamDetail extends AppModel {

    public $useTable = 'exam_details';

    public $hasMany = array(
        'Result' => array(
            'className' => 'Result',
            'foreignKey' => 'exam_detail_id',
        ),
    );

    public $belongsTo = array(
        'Subject' => array(
            'className' => 'Subject',
            'foreignKey' => 'subject_id',
            'fields' => array('Subject.id','Subject.name')
        ),
    );

    public function add($data) {

        foreach($data['details'] as $subject_id => $val) {
            if($val['maximum_mark'] && $val['minimum_mark'] && $val['start_time']){
                $this->create();
                $this->save(array(
                    'exam_id' => $data['exam_id'],
                    'subject_id' => $subject_id,
                    'maximum_mark' => (int)$val['maximum_mark'],
                    'passing_mark' => (int)$val['minimum_mark'],
                    'start_time' => date("Y-m-d",strtotime($val['start_time'])),
                ));
            }
        }

        return true;
    }

    public function update($data) {

        $start_time =date("Y-m-d",strtotime($data['start_time']));

        if($this->updateAll(
            array('ExamDetail.exam_id' => "'{$data['exam_id']}'",'ExamDetail.subject_id' => "'{$data['subject_id']}'",'ExamDetail.maximum_mark' => "'{$data['maximum_mark']}'",'ExamDetail.passing_mark' => "'{$data['passing_mark']}'",'ExamDetail.start_time' => "'{$start_time}'"),
            array('ExamDetail.id' => $data['detail_id'])
        )){
            return true;
        }else{
            return false;
        }
    }
}