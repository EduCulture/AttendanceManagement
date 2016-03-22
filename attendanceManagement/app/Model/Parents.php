<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 08-09-2015
 * Time: 04:12 PM
 */


App::uses('AppModel', 'Model');

class Parents extends AppModel {

    public $useTable = 'parents';


    public function add($data,$student_id) {

        $parentMapClass = ClassRegistry::init('StudentParentMap');

        foreach($data as $parent_detail){
            //insert into parents table
            $this->save(array(
                'name' => $parent_detail['name'],
                'contact_number' => $parent_detail['contact_number'],
                'relation' => $parent_detail['relation'],
                'date_added' => date("Y-m-d H:i:s"),
                'date_modified' => date("Y-m-d H:i:s")
            ));
            $parent_id = $this->id;

            //insert into mapping table
            $parentMapClass->create();
            $parentMapClass->save(array(
                'parent_id' => $parent_id,
                'student_id' => $student_id
            ));
        }

        return true;
    }
}