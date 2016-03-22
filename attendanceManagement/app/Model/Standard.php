<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 08-09-2015
 * Time: 06:35 PM
 */

App::uses('AppModel', 'Model');

class Standard extends AppModel {

    public $hasMany = array(
        'StandardSectionMap' => array(
            'className' => 'StandardSectionMap',
            'foreignKey' => 'standard_id',
        ),
    );

    public function add($data) {

        $data['date_added'] = $data['date_modified'] = date("Y-m-d H:i:s");
        $data['school_id'] = CakeSession::read('Auth.User.school_id');

        if($this->save($data)){
            $standard_id = $this->id;
            if(isset($data['staff_subject']) && $data['staff_subject']) {
                $Map = ClassRegistry::init('StandardSectionMap');
                if($Map->add($data['staff_subject'],$standard_id)){
                    return true;
                }else{
                    return false;
                }
            }
            return true;
        }
    }

    public function update($data,$standard_id) {

        //pr($data);die;
        $date_modified = date("Y-m-d H:i:s");
        $data['school_id'] = CakeSession::read('Auth.User.school_id');

        //update staff details
        if($this->updateAll(
            array('Standard.name' => "'{$data['name']}'",'Standard.date_modified' => "'{$date_modified}'"),
            array('Standard.id' => $standard_id)
        )){

            if(isset($data['staff_subject']) && $data['staff_subject']) {
                $Map = ClassRegistry::init('StandardSectionMap');
                if($Map->add($data['staff_subject'],$standard_id)){
                    return true;
                }else{
                    return false;
                }
            }

            return true;
        }else{
            return false;
        }
    }

    public function getStandards() {

        $this->recursive = 0;
        $data = $this->find('all',array(
           'conditions' => array('Standard.school_id' => CakeSession::read('Auth.User.school_id'))
        ));

        //pr($data);die;
        return $data;
    }
}