<?php
/**
 * Created by PhpStorm.
 * User: hitesh.kubavat
 * Date: 29-07-2015
 * Time: 10:05
 */

class Notice extends AppModel {


    public function add($data) {

        $data['date_added'] = date("Y-m-d H:i:s");
        $data['date_modified'] = date("Y-m-d H:i:s");
        $data['school_id'] = CakeSession::read('Auth.User.school_id');
        $data['notice_date'] = date("Y-m-d",strtotime($data['notice_date']));

        if(isset($_FILES)){
            if($file_name = $this->uploadAttachment($_FILES['attachment'])){
                $data['upload_file_name'] = $file_name;
            }
        }

        /*if(CakeSession::read("Auth.User.role_id") == 3) {

        }*/

        $UserClass = ClassRegistry::init('User');
        $staff_detail = $UserClass->getLoggedUserDetails();
        $data['staff_id'] = $staff_detail['Staff']['id'];

        if($this->save($data)){
            return true;
        }else{
            return false;
        }
    }

    public function update($data,$notice_id) {

        $date_modified = date("Y-m-d H:i:s");
        $notice_date = date("Y-m-d",strtotime($data['notice_date']));

        if(isset($_FILES)){
            if($file_name = $this->uploadAttachment($_FILES['attachment'])){
                $data['upload_file_name'] = $file_name;
            }
        }else{
            $file = $this->find('first',array(
               'fields' => array('Notice.upload_file_name'),
               'conditions' => array('Notice.id' => $notice_id)
            ));

            $file_name = $file['Notice']['upload_file_name'];
        }

        /*$UserClass = ClassRegistry::init('User');
        $staff_detail = $UserClass->getLoggedUserDetails();
        $staff_id = $staff_detail['Staff']['id'];*/

        if($this->updateAll(
            array('Notice.title' => "'" . Sanitize::escape($data['title']) . "'",'Notice.description' => "'" . Sanitize::escape($data['description']) . "'",'Notice.user_type' => "'" . Sanitize::escape($data['user_type']) . "'",'Notice.upload_file_name' => "'" . Sanitize::escape($file_name) . "'",'Notice.notice_date' => "'{$notice_date}'",'Notice.is_active' => "'{$data['is_active']}'",'Notice.date_modified' => "'{$date_modified}'"),
            array('Notice.id' => $notice_id)
        )){
            return true;
        }else{
            return false;
        }
    }
}
