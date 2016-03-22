<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 08-09-2015
 * Time: 04:23 PM
 */

App::uses('AppModel', 'Model');

class Timing extends AppModel {

    public $useTable = 'class_timing';

    public $belongsTo = array(
        'Standard' => array(
            'className' => 'Standard',
            'foreignKey' => 'standard_id',
        ),
        'Section' => array(
            'className' => 'Section',
            'foreignKey' => 'section_id',
        ),
    );

    public function add($data) {

        //pr($data);die;
        $data['date_added'] = $data['date_modified'] = date("Y-m-d H:i:s");

        $StandardSectionMap = ClassRegistry::init('StandardSectionMap');

        foreach($data['standard_id'] as $val) {

            $sections = $StandardSectionMap->find('all',array(
                'conditions' => array('StandardSectionMap.standard_id' => $val)
            ));

            //pr($sections);die;
            if($sections) {
                foreach($sections as $section) {
                    $this->create();
                    $this->save(array(
                        'standard_id' => $val,
                        'section_id' => $section['Section']['id'],
                        'name' => $data['name'],
                        'start_time' => date("H:i:s", strtotime($data['start_time'])),
                        'end_time' => date("H:i:s", strtotime($data['end_time'])),
                        'is_break' => (int)$data['is_break'],
                        'date_added' => date("Y-m-d H:i:s"),
                        'date_modified' => date("Y-m-d H:i:s"),
                    ));
                }
            }
        }

        return true;
    }

    public function update($data,$timing_id) {

        $date_modified = date("Y-m-d H:i:s");
        $start_time = date("H:i:s",strtotime($data['start_time']));
        $end_time = date("H:i:s",strtotime($data['end_time']));
        //pr($data);die;

        if($this->updateAll(
            array('Timing.name' => "'" . Sanitize::escape($data['name']) . "'",'Timing.start_time' => "'{$start_time}'",'Timing.end_time' => "'{$end_time}'",'Timing.is_break' => "'{$data['is_break']}'",'Timing.date_modified' => "'{$date_modified}'"),
            array('Timing.id' => $timing_id)
        )){
            return true;
        }else{
            return false;
        }
    }
}