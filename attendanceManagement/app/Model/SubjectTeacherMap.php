<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 08-09-2015
 * Time: 04:14 PM
 */

App::uses('AppModel', 'Model');

class SubjectTeacherMap extends AppModel {

    public $useTable = 'subject_teacher_mapping';

    public $belongsTo = array(
        'Subject' => array(
            'className' => 'Subject',
            'foreignKey' => 'subject_id',
        ),
        'Staff' => array(
            'className' => 'Staff',
            'foreignKey' => 'staff_id',
        ),
        'StandardSectionMap' => array(
            'className' => 'StandardSectionMap',
            'foreignKey' => 'standard_section_mapping_id',
        ),
    );

    public function add($data,$standard_section_map_id) {

        //delete data
        $this->deleteAll(array('SubjectTeacherMap.standard_section_mapping_id' => $standard_section_map_id));

        if($data) {
            foreach ($data as $val) {
                $this->create();
                $this->save(array(
                    'standard_section_mapping_id' => $standard_section_map_id,
                    'subject_id' => $val['subject_id'],
                    'staff_id' => $val['staff_id'],
                    'date_added' => date("Y-m-d H:i:s"),
                    'date_modified' => date("Y-m-d H:i:s")
                ));
            }
        }
        return true;
    }

    public function getStandardWiseSubject($standard_id,$section_id) {

        $this->recursive = 2;
        $data = $this->find('all',array(
           'conditions' => array('StandardSectionMap.standard_id' => $standard_id, 'StandardSectionMap.section_id' => $section_id)
        ));

        $return = [];
        if($data){
            foreach($data as $val) {
                $return[] = array(
                   'subject' => $val['Subject']['name'],
                   'subject_id' => $val['Subject']['id']
                );
            }
        }

        return $return;
    }

    public function getStandardStaffSubjects($standard_id,$section_id) {

        $UserClass = ClassRegistry::init('User');
        $staff = $UserClass->getLoggedUserDetails();

        $this->recursive = 2;
        $data = $this->find('all',array(
            'conditions' => array('StandardSectionMap.standard_id' => $standard_id, 'StandardSectionMap.section_id' => $section_id,'SubjectTeacherMap.staff_id' => $staff['Staff']['id'])
        ));

        $return = [];
        if($data){
            foreach($data as $val) {
                $return[] = array(
                    'subject' => $val['Subject']['name'],
                    'subject_id' => $val['Subject']['id']
                );
            }
        }

        return $return;
    }

    public function getSubjectTeacher($standard_id,$section_id,$subject_id) {

        $this->recursive = 1;
        $data = $this->find('first',array(
            'conditions' => array('StandardSectionMap.standard_id' => $standard_id, 'StandardSectionMap.section_id' => $section_id,'SubjectTeacherMap.subject_id' => $subject_id)
        ));
        //pr($data);die;

        return $data;
    }

    public function getStandards() {

        $UserClass = ClassRegistry::init('User');
        $staff = $UserClass->getLoggedUserDetails();

        $this->recursive = 2;
        $data = $this->find('all',array(
            'conditions' => array('SubjectTeacherMap.staff_id' => $staff['Staff']['id']),
            'group' => array('StandardSectionMap.standard_id')
        ));
        //pr($data);die;
        $standards = [];
        if($data){
            foreach($data as $val){
                if(isset($val['StandardSectionMap']['Standard']['id'])) {
                    $standards[] = array(
                        'id' => $val['StandardSectionMap']['Standard']['id'],
                        'name' => $val['StandardSectionMap']['Standard']['name'],
                    );
                }
            }
        }
        //pr($standards);die;
        return $standards;
    }

    public function getSections($standard_id) {


        $UserClass = ClassRegistry::init('User');
        $staff = $UserClass->getLoggedUserDetails();

        $this->recursive = 2;
        $data = $this->find('all',array(
            'conditions' => array('SubjectTeacherMap.staff_id' => $staff['Staff']['id'],'StandardSectionMap.standard_id' => $standard_id),
            'group' => array('StandardSectionMap.section_id')
        ));

        //echo $this->getLastQuery();die;
        //pr($data);die;

        $sections = [];
        if($data){
            foreach($data as $val){
                $sections[] = array(
                    'section_id' => $val['StandardSectionMap']['Section']['id'],
                    'section_name' => $val['StandardSectionMap']['Section']['name'],
                );
            }
        }
        //pr($standards);die;
        return $sections;
    }
	
	public function getStandardsByStaffId($staff_id) {

        //$UserClass = ClassRegistry::init('User');
        //$staff = $UserClass->getLoggedUserDetails();

        $this->recursive = 2;
        $data = $this->find('all',array(
            'conditions' => array('SubjectTeacherMap.staff_id' => $staff_id),
            'group' => array('StandardSectionMap.standard_id')
        ));
        //pr($data);die;
        $standards = [];
        if($data){
            foreach($data as $val){
                if(isset($val['StandardSectionMap']['Standard']['id'])) {
					$sections = $this->getSectionsByStaffId($staff_id, $val['StandardSectionMap']['Standard']['id']);
					
                    $standards[] = array(
                        'id' => $val['StandardSectionMap']['Standard']['id'],
                        'name' => $val['StandardSectionMap']['Standard']['name'],
						'data' => $sections,
                    );
					
                }
            }
        }
        //pr($standards);die;
        return $standards;
    }
	
	public function getSectionsByStaffId($staff_id, $standard_id) {


        //$UserClass = ClassRegistry::init('User');
        //$staff = $UserClass->getLoggedUserDetails();

        $this->recursive = 2;
        $data = $this->find('all',array(
            'conditions' => array('SubjectTeacherMap.staff_id' => $staff_id,'StandardSectionMap.standard_id' => $standard_id),
            'group' => array('StandardSectionMap.section_id')
        ));

        //echo $this->getLastQuery();die;
        //pr($data);die;

        $sections = [];
        if($data){
            foreach($data as $val){
				$subjects = $this->getStandardStaffSubjectsByStaffId($staff_id, $standard_id, $val['StandardSectionMap']['Section']['id']);
				
                $sections[] = array(
                    'id' => $val['StandardSectionMap']['Section']['id'],
                    'name' => $val['StandardSectionMap']['Section']['name'],
					'data' => $subjects,
                );
            }
        }
        //pr($standards);die;
        return $sections;
    }
	
	public function getStandardStaffSubjectsByStaffId($staff_id, $standard_id, $section_id) {

        /* $UserClass = ClassRegistry::init('User');
        $staff = $UserClass->getLoggedUserDetails(); */

        $this->recursive = 2;
        $data = $this->find('all',array(
            'conditions' => array('StandardSectionMap.standard_id' => $standard_id, 'StandardSectionMap.section_id' => $section_id,'SubjectTeacherMap.staff_id' => $staff_id)
        ));

        $return = [];
        if($data){
            foreach($data as $val) {
                $return[] = array(
                    'name' => $val['Subject']['name'],
                    'id' => $val['Subject']['id']
                );
            }
        }

        return $return;
    }
}