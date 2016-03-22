<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 08-09-2015
 * Time: 04:23 PM
 */

App::uses('AppModel', 'Model');

class StaffSubjectMap extends AppModel {

    public $useTable = 'staff_subject_mapping';

    public $belongsTo = array(
        'Staff' => array(
            'className' => 'Staff',
            'foreignKey' => 'staff_id',
        ),
        'Subject' => array(
            'className' => 'Subject',
            'foreignKey' => 'subject_id',
        )
    );

    public function add($data,$staff_id) {

        $this->deleteAll(array('staff_id' => $staff_id));

        if($data) {
            foreach ($data as $subject_id) {
                $this->create();
                $this->save(array(
                    'staff_id' => $staff_id,
                    'subject_id' => $subject_id
                ));
            }
            return true;
        }else{
            return false;
        }
    }
}