<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 08-09-2015
 * Time: 06:35 PM
 */

App::uses('AppModel', 'Model');

class Fee extends AppModel {

    public $hasMany = array(
        'FeeStandardMap' => array(
            'className' => 'FeeStandardMap',
            'foreignKey' => 'fee_id',
        ),
    );

    public function add($data) {

        $data['date_added'] = $data['date_modified'] = date("Y-m-d H:i:s");
        $data['school_id'] = CakeSession::read('Auth.User.school_id');
        $data['start_date'] = date("Y-m-d",strtotime($data['start_date']));
        $data['due_date'] = date("Y-m-d",strtotime($data['due_date']));

        if($this->save($data)){
            $fee_id = $this->id;
            if(isset($data['standard_fee']) && $data['standard_fee']) {
                $Map = ClassRegistry::init('FeeStandardMap');
                foreach($data['standard_fee'] as $val) {
                    $Map->create();
                    $Map->save(array(
                        'fee_id' => $fee_id,
                        'standard_id' => $val['standard_id'],
                        'amount' => $val['amount']
                    ));
                }
            }
            return true;
        }
    }

    public function update($data,$fee_id) {

        $date_modified = date("Y-m-d H:i:s");
        $data['school_id'] = CakeSession::read('Auth.User.school_id');
        $data['start_date'] = date("Y-m-d",strtotime($data['start_date']));
        $data['due_date'] = date("Y-m-d",strtotime($data['due_date']));


        //pr($data);die;
        //update staff details
        if($this->updateAll(
            array('Fee.name' => "'{$data['name']}'",'Fee.description' => "'{$data['description']}'",'Fee.start_date' => "'{$data['start_date']}'",'Fee.due_date' => "'{$data['due_date']}'",'Fee.date_modified' => "'{$date_modified}'"),
            array('Fee.id' => $fee_id)
        )){

            if(isset($data['standard_fee']) && $data['standard_fee']) {
                $Map = ClassRegistry::init('FeeStandardMap');
                $Map->deleteAll(array('FeeStandardMap.fee_id' => $fee_id));

                foreach($data['standard_fee'] as $val) {
                    $Map->create();
                    $Map->save(array(
                        'fee_id' => $fee_id,
                        'standard_id' => $val['standard_id'],
                        'amount' => $val['amount']
                    ));
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