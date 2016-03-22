<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');
App::uses('CakeEmail', 'Network/Email');
App::uses('Sanitize', 'Utility');
App::uses('ImageComponent', 'Controller/Component');
App::uses('HtmlHelper', 'View/Helper');
App::uses('AndroidNotification', 'Lib');
App::uses('IosNotification', 'Lib/ios');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

    public $imageSizes = array(
        'thumb-width' => 150,
        'thumb-height' => 150,
        'preview-width' => 300,
        'preview-height' => 225,
        'original-width' => 800,
        'original-height' => 600
    );

    public $imageQuality = array(
        'original',
        'preview',
        'thumb',
    );

    public  $known_mime_types=array(
        "pdf" => "application/pdf",
        "txt" => "text/plain",
        "html" => "text/html",
        "htm" => "text/html",
        "exe" => "application/octet-stream",
        "zip" => "application/zip",
        "doc" => "application/msword",
        "xls" => "application/vnd.ms-excel",
        "ppt" => "application/vnd.ms-powerpoint",
        "gif" => "image/gif",
        "png" => "image/png",
        "jpeg"=> "image/jpg",
        "jpg" =>  "image/jpg",
        "php" => "text/plain"
    );

    public function formatMessages($msg = null, $success = false, $data = null) {
        $message = array(
            'success' => $success,
            'message' => $msg
        );
        if(empty($success)) {
            $message['error'] = $data;
        } else {
            $message['data'] = $data;
        }
        return $message;
    }

    public function getLastQuery() {
        $dbo = $this->getDatasource();
        $logData = $dbo->getLog();
        $getLog = end($logData['log']);
        return $getLog['query'];
    }

    public function sendEmail($to,$subject,$message,$template) {
        $Email = new CakeEmail('smtp');
        $Email->to($to);
        $Email->emailFormat('html');
        $Email->template($template)->viewVars( array('to'=>$to,'message' => $message), null);
        $Email->subject($subject);
        // $Email->replyTo('noreply@carsoffer.com.au');
        $Email->from ('testing.iapps.3@gmail.com');
        $Email->send();
        return true;
    }

    public function uploadImage($image) {

        if($image && $image['tmp_name']) {
            $MyImageCom = new ImageComponent();

            $base_path = WWW_ROOT . 'uploads/';
            $tmp = $image['tmp_name'];

            $file_name = basename($image['name']);

            foreach ($this->imageQuality as $quality) {
                $img_path = $base_path .$quality .'/'. $file_name;
                if (file_exists($img_path)) {
                    unlink($img_path);
                }
                $MyImageCom->prepare($tmp);
                $MyImageCom->resize($this->imageSizes[$quality . '-width'], $this->imageSizes[$quality . '-height']);//width,height,Red,Green,Blue
                $MyImageCom->save($img_path);
            }

            return $file_name;

        }else{
            return false;
        }
    }

    public function uploadAttachment($file) {

        if($file && $file['tmp_name']) {

            $base_path = WWW_ROOT . 'uploads/notice/';
            $file_name = basename($file['name']);

            if($file['error'] == 0) {
                $upload_path = $base_path . $file_name;

                if (file_exists($upload_path)) {
                    unlink($upload_path);
                }
                move_uploaded_file($file['tmp_name'],$upload_path);
            }
            return $file_name;
        }else{
            return false;
        }
    }

    public function getImageUrl($name,$type = 'original') {

        $htmlHelper = new HtmlHelper(new View());

        return $htmlHelper->assetUrl($name, array(
            'fullBase' => true,
            'pathPrefix' => 'uploads/'.$type.'/'
        ));
    }

    public function getPushTokens() {

        $User = ClassRegistry::init ('User');

        $User->recursive = 2;
        $details = $User->find('all',array(

        ));

        //pr($details);die;

        $tokens['iphn']['gujarati'] = array();
        $tokens['iphn']['hindi'] = array();
        $tokens['andr']['gujarati'] = array();
        $tokens['andr']['hindi'] = array();

        foreach($details as $detail) {
            foreach($detail['Map'] as $device) {
                if($device['Device']) {
                    if ($device['Device']['platform'] == 'IPHN') {
                        if ($device['DeviceConfig']['language_id'] == 1) {
                            $tokens['iphn']['gujarati'][] = $device['Device']['push_token_id'];
                        } else {
                            $tokens['iphn']['hindi'][] = $device['Device']['push_token_id'];
                        }
                    } else if ($device['Device']['platform'] == 'ANDR') {
                        if ($device['DeviceConfig']['language_id'] == 1) {
                            $tokens['andr']['gujarati'][] = $device['Device']['push_token_id'];
                        } else {
                            $tokens['andr']['hindi'][] = $device['Device']['push_token_id'];
                        }
                    }
                }
            }
        }

        return $tokens;
    }


    public function sendPush($data = array(),$alert='') {

        $tokens = $this->getPushTokens();

        $andr_notification = new AndroidNotification();
        $ios_notification = new IosNotification();

        $controller = Router::getParam();
    }

    public function getRolePermission($role_id) {

        $Role = ClassRegistry::init ('Role');
        $data = $Role->find('first',array(
            'conditions' => array('Role.id' => $role_id)
        ));

        $permissions = [];
        if($data) {
            $permissions = unserialize($data['Role']['permission']);

            if(isset($permissions['access'])){
                return $permissions['access'];
            }
        }
        return $permissions;
    }

    public function getUserRoleId() {

        $User = ClassRegistry::init ('User');
        $User->recursive = -1;
        $detail = $User->findById(CakeSession::read("Auth.User.id"));

        return $detail['User']['role_id'];
    }

    public function checkPermission($controller) {

        $role_id = $this->getUserRoleId();

        $permissions = $this->getRolePermission($role_id);

        if($permissions){
            if(in_array(ucfirst($controller),$permissions)){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function getModules() {

        /*$RolePermission = ClassRegistry::init('RolePermission');

        $RolePermission->recursive = -1;
        $details = $RolePermission->find('all',array(
            'fields' => array('Module.id','Module.module_name','Module.icon'),
            'joins' => array(
                array(
                    'table' => 'module_actions',
                    'alias' => 'ModuleAction',
                    'type' => 'INNER',
                    'conditions' => array(
                        'ModuleAction.id = RolePermission.module_action_id'
                    )
                ),
                array(
                    'table' => 'modules',
                    'alias' => 'Module',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Module.id = ModuleAction.module_id'
                    )
                ),
            ),
            'conditions' => array('RolePermission.role_id' => $this->getUserRoleId()),
            'group' => array('Module.id')
        ));

        //pr($details);die;

        return $details;*/

        $school_admin_modules = array(
            array(
                'Dashboard' => array(
                    'name' => 'Dashboard',
                    'controller' => 'dashboard',
                    'icon' => '<i class="fa fa-dashboard"></i>',
                    'action' => 'index',
                    'child' => array()
                ),
            ),
            array(
                'Staffs' => array(
                    'name' => 'Staff',
                    'icon' => '<i class="fa fa-user-md"></i>',
                    'child' => array(
                        array(
                            'name' => 'Manage Staff',
                            'icon' => '<i class="fa fa-users"></i>',
                            'controller' => 'staffs',
                            'action' => 'index'
                        )
                    )
                ),
            ),
            array(
                'Students' => array(
                    'name' => 'Students',
                    'icon' => '<i class="fa fa-users"></i>',
                    'child' => array(
                        array(
                            'name' => 'Manage Students',
                            'icon' => '<i class="fa fa-users"></i>',
                            'controller' => 'students',
                            'action' => 'index'
                        ),
                        array(
                            'name' => 'Report',
                            'icon' => '<i class="fa fa-line-chart"></i>',
                            'controller' => 'students',
                            'action' => 'report'
                        )
                    )
                ),
            ),
            array(
                'Events' => array(
                    'name' => 'Event Management',
                    'controller' => 'events',
                    'icon' => '<i class="fa fa-flag"></i>',
                    'action' => 'index',
                    'child' => array()
                ),
            ), 
            array(
                'Standards' => array(
                    'name' => 'Cluster Management',
                    'icon' => '<i class="fa fa-sitemap"></i>',
                    'child' => array(
                        array(
                            'name' => 'Cluster',
                            'controller' => 'standards',
                            'icon' => '<i class="fa fa-building-o"></i>',
                            'action' => 'index'
                        ),
                        array(
                            'name' => 'Batch',
                            'controller' => 'sections',
                            'icon' => '<i class="fa fa-share-alt"></i>',
                            'action' => 'index'
                        )
                    )
                ),
            ),
            array(
                'Subjects' => array(
                    'name' => 'Subjects',
                    'controller' => 'subjects',
                    'icon' => '<i class="fa fa-book"></i>',
                    'action' => 'index',
                    'child' => array()
                )
            ),
            /*array(
                'Schools' => array(
                    'name' => 'Schools',
                    'controller' => 'schools',
                    'icon' => '<i class="fa fa-building-o"></i>',
                    'action' => 'index',
                    'child' => array()
                )
            ),
            array(
                'Roles' => array(
                    'name' => 'Roles',
                    'controller' => 'roles',
                    'icon' => '<i class="fa fa-cogs"></i>',
                    'action' => 'index',
                    'child' => array()
                )
            ),*/
            array(
                'Fees' => array(
                    'name' => 'Fee',
                    'icon' => '<i class="fa fa-money fa-fw"></i>',
                    'child' => array(
                        array(
                            'name' => 'Category',
                            'icon' => '<i class="fa fa-building-o"></i>',
                            'controller' => 'fees',
                            'action' => 'category'
                        ),
                        array(
                            'name' => 'Collect fees',
                            'icon' => '<i class="fa fa-share-alt"></i>',
                            'controller' => 'fees',
                            'action' => 'collect'
                        )
                    )
                )
            ),
            array(
                'Notices' => array(
                    'name' => 'Communication',
                    'icon' => '<i class="fa fa-comments"></i>',
                    'child' => array(
                        array(
                            'name' => 'Circulars',
                            'icon' => '<i class="fa fa-columns"></i>',
                            'controller' => 'notices',
                            'action' => 'index'
                        )
                    )
                )
            ),
            array(
                'Timetable' => array(
                    'name' => 'Schedule',
                    'icon' => '<i class="fa fa-calendar-o"></i>',
                    'child' => array(
                        array(
                            'name' => 'Class Timing',
                            'icon' => '<i class="glyphicon glyphicon-time"></i>',
                            'controller' => 'timing',
                            'action' => 'index'
                        ),
                        array(
                            'name' => 'Schedule Class',
                            'icon' => '<i class="fa fa-calendar"></i>',
                            'controller' => 'timetable',
                            'action' => 'index'
                        )
                    )
                )
            ),
            array(
                'Exams' => array(
                    'name' => 'Examination',
                    'icon' => '<i class="fa fa-clipboard"></i>',
                    'child' => array(
                        array(
                            'name' => 'Exams Category',
                            'icon' => '<i class="fa fa-link"></i>',
                            'controller' => 'examtype',
                            'action' => 'index'
                        ),
                        array(
                            'name' => 'Exam Group',
                            'icon' => '<i class="fa fa-link"></i>',
                            'controller' => 'exams',
                            'action' => 'index'
                        ),
                        /*array(
                            'name' => 'Add Result',
                            'icon' => '<i class="fa fa-check-circle"></i>',
                            'controller' => 'exams',
                            'action' => 'result'
                        ),*/
                        array(
                            'name' => 'Grade Level',
                            'icon' => '<i class="glyphicon glyphicon-stats"></i>',
                            'controller' => 'grades',
                            'action' => 'index'
                        ),
                        array(
                            'name' => 'Result Summary',
                            'icon' => '<i class="glyphicon glyphicon-th-list"></i>',
                            'controller' => 'exams',
                            'action' => 'summary'
                        )
                    )
                )
            )
        );

        //staff modules
        $staff_modules = array(
            array(
                'Dashboard' => array(
                    'name' => 'Dashboard',
                    'controller' => 'dashboard',
                    'icon' => '<i class="fa fa-dashboard"></i>',
                    'action' => 'index',
                    'child' => array()
                ),
            ),
            array(
                'Students' => array(
                    'name' => 'Students',
                    'icon' => '<i class="fa fa-users"></i>',
                    'child' => array(
                        array(
                            'name' => 'Manage Students',
                            'icon' => '<i class="fa fa-users"></i>',
                            'controller' => 'students',
                            'action' => 'index'
                        ),
                    )
                ),
            ),
            array(
                'Remarks' => array(
                    'name' => 'Remarks',
                    'controller' => 'remarks',
                    'icon' => '<i class="fa fa-comments"></i>',
                    'action' => 'index',
                    'child' => array()
                ),
            ), 
            array(
                'Events' => array(
                    'name' => 'Event Management',
                    'controller' => 'events',
                    'icon' => '<i class="fa fa-flag"></i>',
                    'action' => 'index',
                    'child' => array()
                ),
            ), 
            array(
                'Assignment' => array(
                    'name' => 'Assignment',
                    'controller' => 'assignment',
                    'icon' => '<i class="fa fa-edit"></i>',
                    'action' => 'index',
                    'child' => array()
                )
            ),
            array(
                'Attendance' => array(
                    'name' => 'Attendance',
                    'icon' => '<i class="fa fa-check-square-o"></i>',
                    'child' => array(
                        array(
                            'name' => 'Take Attendance',
                            'icon' => '<i class="fa fa-check-square-o"></i>',
                            'controller' => 'attendance',
                            'action' => 'index'
                        ),
                        array(
                            'name' => 'Report',
                            'icon' => '<i class="fa fa-line-chart"></i>',
                            'controller' => 'attendance',
                            'action' => 'report'
                        )
                    )
                )
            ),
            array(
                'Notices' => array(
                    'name' => 'Communication',
                    'icon' => '<i class="fa fa-comments"></i>',
                    'child' => array(
                        array(
                            'name' => 'Circulars',
                            'icon' => '<i class="fa fa-columns"></i>',
                            'controller' => 'notices',
                            'action' => 'index'
                        )
                    )
                )
            ),
            array(
                'Timetable' => array(
                    'name' => 'Schedule',
                    'icon' => '<i class="fa fa-calendar-o"></i>',
                    'child' => array(
                        array(
                            'name' => 'Schedule',
                            'icon' => '<i class="fa fa-calendar"></i>',
                            'controller' => 'timetable',
                            'action' => 'index'
                        )
                    )
                )
            ),
            array(
                'Exams' => array(
                    'name' => 'Examination',
                    'icon' => '<i class="fa fa-clipboard"></i>',
                    'child' => array(
                        array(
                            'name' => 'Exam Group',
                            'icon' => '<i class="fa fa-link"></i>',
                            'controller' => 'exams',
                            'action' => 'index'
                        ),
                        /*array(
                            'name' => 'Add Result',
                            'icon' => '<i class="fa fa-check-circle"></i>',
                            'controller' => 'exams',
                            'action' => 'result'
                        ),*/
                        array(
                            'name' => 'Result Summary',
                            'icon' => '<i class="glyphicon glyphicon-th-list"></i>',
                            'controller' => 'exams',
                            'action' => 'summary'
                        )
                    )
                )
            )
        );

        $admin_modules = array(
            array(
                'Dashboard' => array(
                    'name' => 'Dashboard',
                    'controller' => 'dashboard',
                    'icon' => '<i class="fa fa-dashboard"></i>',
                    'action' => 'index',
                    'child' => array()
                ),
            ),
            array(
                'Schools' => array(
                    'name' => 'Classes',
                    'controller' => 'schools',
                    'icon' => '<i class="fa fa-building-o"></i>',
                    'action' => 'index',
                    'child' => array()
                )
            ),
            array(
                'Roles' => array(
                    'name' => 'Roles',
                    'controller' => 'roles',
                    'icon' => '<i class="fa fa-cogs"></i>',
                    'action' => 'index',
                    'child' => array()
                )
            ),
        );


        $role_id = $this->getUserRoleId();
        /*$permissions = $this->getRolePermission($role_id);

        //pr($modules);die;
        foreach($modules as $key => $module){
            $module_name = array_keys($module)[0];
            $valid = false;
            foreach($permissions as $permission){
                if($permission == $module_name){
                    $valid = true;
                    break;
                }
            }

            if(!$valid){
                unset($modules[$key]);
            }
        }*/

        if($role_id == 2){
            return $school_admin_modules;
        }else if($role_id ==3) {
            return $staff_modules;
        }else{
            return $admin_modules;
        }

        //pr($modules);die;
    }
}
