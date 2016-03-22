<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 07-09-2015
 * Time: 01:31 PM
 */

App::uses('AppModel', 'Model');

class School extends AppModel
{

    public $hasMany = array(
        'Staff' => array(
            'className' => 'Staff',
            'foreignKey' => 'school_id',
            //'fields' => array('ModuleAction.id','ModuleAction.action_id')
        )
    );

    public function add($data){

        //pr($data);die;
        $data['date_added'] = date("Y-m-d H:i:s");
        $data['date_modified'] = date("Y-m-d H:i:s");

        //insert school
        if($this->save($data)){

            $school_id = $this->id;

            //insert school admin(users table)
            $data['school_id'] = $school_id;
            $userClass = ClassRegistry::init('User');
            $userClass->save($data);

            $user_id = $userClass->id;

            //insert into staff record
            $this->Staff->save(array(
               'school_id' => $school_id,
               'user_id' => $user_id,
               'date_added' => date("Y-m-d H:i:s"),
               'date_modified' => date("Y-m-d H:i:s"),
            ));

            return true;
        }else{
            return false;
        }
    }

    public function update($data,$school_id){

        $date_modified = date("Y-m-d H:i:s");

        //pr($data);die;
        //insert school
        $this->updateAll(
            array('School.name' => "'{$data['name']}'",'School.address' => "'{$data['address']}'",'School.logo' => "'{$data['logo']}'",'School.contact_number' => "'{$data['contact_number']}'",'School.description' => "'{$data['description']}'",'School.is_active' => "'{$data['is_active']}'",'School.date_modified' => "'{$date_modified}'"),
            array('School.id' => $school_id)
        );

        //update school admin
        $data['school_id'] = $school_id;
        $userClass = ClassRegistry::init('User');
        if($userClass->update($data,$data['user_id'])){

            /*//update staff
            $this->Staff->updateAll(
                array('school_id' => "'{$school_id}'", 'user_id' => "'{$data['user_id']}'", 'date_modified' => "'{$date_modified}'"),
                array('')
            );*/

            return true;
        }
    }
}