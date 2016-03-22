<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 08-09-2015
 * Time: 04:23 PM
 */

App::uses('AppModel', 'Model');

class StandardSectionMap extends AppModel {

    public $useTable = 'standard_sections_mapping';

    public $belongsTo = array(
        'Section' => array(
            'className' => 'Section',
            'foreignKey' => 'section_id',
        ),
        'Standard' => array(
            'className' => 'Standard',
            'foreignKey' => 'standard_id',
        )
    );

    public $hasMany = array(
        'SubjectTeacherMap' => array(
            'className' => 'SubjectTeacherMap',
            'foreignKey' => 'standard_section_mapping_id',
        ),
    );

    public function add($data,$standard_id) {

        $this->query("DELETE FROM subject_teacher_mapping WHERE standard_section_mapping_id IN (SELECT id FROM standard_sections_mapping WHERE `standard_id` = '".$standard_id."' )");

        $this->deleteAll(array('standard_id' => $standard_id));

        if($data) {
            foreach ($data as $val) {
                $this->create();
                $this->save(array(
                    'standard_id' => $standard_id,
                    'section_id' => $val['section_id'],
                    'staff_id' => $val['class_teacher_id'],
                ));
                $standard_section_map_id = $this->id;

                if(isset($val['details']) && $val['details']){
                    $SubjectTeacherMap = ClassRegistry::init('SubjectTeacherMap');
                    $SubjectTeacherMap->add($val['details'],$standard_section_map_id);
                }
            }
            return true;
        }else{
            return false;
        }
    }

    public function getMapId($standard_id,$section_id){

        $data = $this->find('first',array(
           'fields' => array('id'),
           'conditions' => array('StandardSectionMap.standard_id' => $standard_id,'StandardSectionMap.section_id' => $section_id)
        ));

        if($data){
            return $data['StandardSectionMap']['id'];
        }else{
            return false;
        }
    }

    public function getStandardSectionId($map_id){

        $data = $this->find('first',array(
            'fields' => array('StandardSectionMap.standard_id,StandardSectionMap.section_id'),
            'conditions' => array('StandardSectionMap.id' => $map_id)
        ));

        if($data){
            return array(
                'standard_id' => $data['StandardSectionMap']['standard_id'],
                'section_id' => $data['StandardSectionMap']['section_id'],
            );
        }else{
            return false;
        }

    }
}