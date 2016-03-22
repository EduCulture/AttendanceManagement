<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 08-09-2015
 * Time: 04:23 PM
 */

App::uses('AppModel', 'Model');

class Result extends AppModel {

    public $belongsTo = array(
        'Student' => array(
            'className' => 'Student',
            'foreignKey' => 'student_id',
        )
    );

    public function add($data) {

        //pr($data['student_parents']);die;
        $data['date_added'] = $data['date_modified'] = date("Y-m-d H:i:s");
        if($data['result']) {
            foreach ($data['result'] as $student_id => $result){
                if($result['obtain_mark'] && is_numeric($result['obtain_mark'])) {
                    $this->create();
                    $this->save(array(
                        'exam_detail_id' => $data['exam_detail_id'],
                        'student_id' => $student_id,
                        'obtain_mark' => (int)$result['obtain_mark'],
                        'remark' => $result['remark']
                    ));
                }
            }
        }

        return true;
    }

    public function update($data) {

        $date_modified = date("Y-m-d H:i:s");

        if($this->updateAll(
            array('Result.obtain_mark' => "'{$data['obtain_mark']}'",'Result.remark' => "'{$data['remark']}'",'Result.date_modified' => "'{$date_modified}'"),
            array('Result.id' => $data['result_id'])
        )){
            return true;
        }else{
            return false;
        }
    }
}