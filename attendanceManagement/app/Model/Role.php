<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 07-09-2015
 * Time: 01:31 PM
 */

App::uses('AppModel', 'Model');

class Role extends AppModel {

    public function add($data){

        //pr($data);die;
        $data['date_added'] = date("Y-m-d H:i:s");
        $data['date_modified'] = date("Y-m-d H:i:s");

        if(isset($data['permission'])) {
            $data['permission'] = serialize($data['permission']);
        }else{
            $data['permission'] = serialize(array());
        }

        if($this->save($data)){
            return true;
        }else{
            return false;
        }
    }

    public function update($data,$role_id){

        if(isset($data['permission'])) {
            $permission = serialize($data['permission']);
        }else{
            $permission = serialize(array());
        }

        //pr($data);die;
        $this->updateAll(
            array('Role.name' => "'{$data['name']}'",'Role.permission' => "'{$permission}'"),
            array('Role.id' => $role_id)
        );

        return true;
    }
}