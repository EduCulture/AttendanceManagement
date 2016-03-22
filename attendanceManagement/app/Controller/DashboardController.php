<?php
/**
 * User: deep.gandhi
 * Date: 28-07-2015
 * Time: 18:26
 */

App::uses('AppController', 'Controller');


class DashboardController extends AppController {

    public function index() {

        $this->loadModel('Message');
        $messages = $this->Message->find('all',array(
            'conditions' => array('Message.school_id' => CakeSession::read('Auth.User.school_id'),'Message.is_delete' => 0)
        ));
        $this->set('messages',$messages);
        //pr($messages);die;

        $this->loadModel('Notice');
        $notices = $this->Notice->find('all',array(
           'conditions' => array('Notice.school_id' => CakeSession::read('Auth.User.school_id'),'Notice.is_delete' => 0)
        ));

        $all = [];
        $students = [];
        $staffs = [];

        if($notices) {
            foreach($notices as $notice) {
                switch ((int)$notice['Notice']['user_type']) {
                    case  3 : {
                        $all[] = array(
                           'title' => $notice['Notice']['title'],
                           'description' => $notice['Notice']['description'],
                           'notice_date' => date("d-M-y",strtotime($notice['Notice']['notice_date']))
                        );
                        break;
                    }
                    case 1 : {
                        $students[] = array(
                            'title' => $notice['Notice']['title'],
                            'description' => $notice['Notice']['description'],
                            'notice_date' => date("d-M-y",strtotime($notice['Notice']['notice_date']))
                        );
                        break;
                    }
                    case 2 : {
                        $staffs[] = array(
                            'title' => $notice['Notice']['title'],
                            'description' => $notice['Notice']['description'],
                            'notice_date' => date("d-M-y",strtotime($notice['Notice']['notice_date']))
                        );
                    }
                }
            }
        }

        //pr($all);die;

        $this->set('all',$all);
        $this->set('students',$students);
        $this->set('staffs',$staffs);

        $this->loadModel('Staff');
        $staff_count = $this->Staff->find('count',array(
            'conditions' => array('Staff.school_id' => CakeSession::read('Auth.User.school_id'),'Staff.is_delete' => 0)
        ));
        $this->set('staff_count',$staff_count);

        $this->loadModel('Student');
        $student_count = $this->Student->find('count',array(
            'conditions' => array('Student.school_id' => CakeSession::read('Auth.User.school_id'),'Student.is_delete' => 0)
        ));
        $this->set('student_count',$student_count);

        $this->loadModel('Subject');
        $subject_count = $this->Subject->find('count',array(
            'conditions' => array('Subject.school_id' => CakeSession::read('Auth.User.school_id'),'Subject.is_delete' => 0)
        ));
        $this->set('subject_count',$subject_count);


        //Events Type
        $this->loadModel('EventType');
        $event_type = $this->EventType->find('all',array(
            'conditions' => array('EventType.school_id' => CakeSession::read('Auth.User.school_id')),
            'order' => array('EventType.id DESC')
        ));
        $this->set('event_types',$event_type);

    }

    public function getSchoolChartDetails() {

        $this->loadModel('Dashboard');

        if(isset($this->request->query['range'])){
            $range = $this->request->query['range'];
        }else{
            $range = 'week';
        }

        $json['andr'] = array();
        $json['iphn'] = array();
        $json['win'] = array();
        $json['xaxis'] = array();

        $json['andr']['label'] = 'Android';
        $json['andr']['data'] = array();
        $json['iphn']['label'] = ' Apple (iOS)';
        $json['iphn']['data'] = array();
        $json['win']['label'] = ' Windows';
        $json['win']['data'] = array();

        switch ($range) {
            default:
            case 'day':
                $results = $this->model_report_sale->getTotalOrdersByDay();

                foreach ($results as $key => $value) {
                    $json['order']['data'][] = array($key, $value['total']);
                }

                $results = $this->model_report_customer->getTotalCustomersByDay();

                foreach ($results as $key => $value) {
                    $json['customer']['data'][] = array($key, $value['total']);
                }

                for ($i = 0; $i < 24; $i++) {
                    $json['xaxis'][] = array($i, $i);
                }
                break;
            case 'week':

                $date_start = strtotime('-' . date('w') . ' days');

                $device_data = $this->Dashboard->getDeviceDetails('week',$date_start);

                foreach ($device_data['andr'] as $key => $value) {
                    $json['andr']['data'][] = array($key, $value['total']);
                }

                foreach ($device_data['iphn'] as $key => $value) {
                    $json['iphn']['data'][] = array($key, $value['total']);
                }

                foreach ($device_data['win'] as $key => $value) {
                    $json['win']['data'][] = array($key, $value['total']);
                }

                for ($i = 0; $i < 7; $i++) {
                    $date = date('Y-m-d', $date_start + ($i * 86400));

                    $json['xaxis'][] = array(date('w', strtotime($date)), date('D', strtotime($date)));
                }

                break;
            case 'month':

                $device_data = $this->Dashboard->getDeviceDetails('month');
                //pr($device_data);die;
                foreach ($device_data['andr'] as $key => $value) {
                    $json['andr']['data'][] = array($key, $value['total']);
                }

                foreach ($device_data['iphn'] as $key => $value) {
                    $json['iphn']['data'][] = array($key, $value['total']);
                }

                foreach ($device_data['win'] as $key => $value) {
                    $json['win']['data'][] = array($key, $value['total']);
                }

                for ($i = 1; $i <= date('t'); $i++) {
                    $date = date('Y') . '-' . date('m') . '-' . $i;

                    $json['xaxis'][] = array(date('j', strtotime($date)), date('d', strtotime($date)));
                }
                break;
            case 'year':

                $device_data = $this->Dashboard->getDeviceDetails('year');

                foreach ($device_data['andr'] as $key => $value) {
                    $json['andr']['data'][] = array($key, $value['total']);
                }

                foreach ($device_data['iphn'] as $key => $value) {
                    $json['iphn']['data'][] = array($key, $value['total']);
                }

                foreach ($device_data['win'] as $key => $value) {
                    $json['win']['data'][] = array($key, $value['total']);
                }

                for ($i = 1; $i <= 12; $i++) {
                    $json['xaxis'][] = array($i, date('M', mktime(0, 0, 0, $i)));
                }
                break;
        }

        echo json_encode($json);

        $this->autoRender = false;
    }

    public function getUserChartDetails() {

        $this->loadModel('Dashboard');

        if(isset($this->request->query['range'])){
            $range = $this->request->query['range'];
        }else{
            $range = 'week';
        }

        $json['ggl_user'] = array();
        $json['ggl_user']['label'] = 'Google  +';
        $json['ggl_user']['data'] = array();

        $json['fb_user'] = array();
        $json['fb_user']['label'] = 'Facebook';
        $json['fb_user']['data'] = array();

        $json['user'] = array();
        $json['user']['label'] = 'MedDic';
        $json['user']['data'] = array();

        $json['xaxis'] = array();

        //echo "Ok";die;
        switch ($range) {
            default:
            case 'week':

                $date_start = strtotime('-' . date('w') . ' days');

                $user_data = $this->Dashboard->getUserDetails('week',$date_start);

                foreach ($user_data['ggl_user'] as $key => $value) {
                    $json['ggl_user']['data'][] = array($key, $value['total']);
                }

                foreach ($user_data['fb_user'] as $key => $value) {
                    $json['fb_user']['data'][] = array($key, $value['total']);
                }

                foreach ($user_data['user'] as $key => $value) {
                    $json['user']['data'][] = array($key, $value['total']);
                }

                for ($i = 0; $i < 7; $i++) {
                    $date = date('Y-m-d', $date_start + ($i * 86400));

                    $json['xaxis'][] = array(date('w', strtotime($date)), date('D', strtotime($date)));
                }

                break;
            case 'month':

                $user_data = $this->Dashboard->getUserDetails('month');

                foreach ($user_data['ggl_user'] as $key => $value) {
                    $json['ggl_user']['data'][] = array($key, $value['total']);
                }

                foreach ($user_data['fb_user'] as $key => $value) {
                    $json['fb_user']['data'][] = array($key, $value['total']);
                }

                foreach ($user_data['user'] as $key => $value) {
                    $json['user']['data'][] = array($key, $value['total']);
                }

                for ($i = 1; $i <= date('t'); $i++) {
                    $date = date('Y') . '-' . date('m') . '-' . $i;

                    $json['xaxis'][] = array(date('j', strtotime($date)), date('d', strtotime($date)));
                }
                break;
            case 'year':

                $user_data = $this->Dashboard->getUserDetails('year');

                foreach ($user_data['ggl_user'] as $key => $value) {
                    $json['ggl_user']['data'][] = array($key, $value['total']);
                }

                foreach ($user_data['fb_user'] as $key => $value) {
                    $json['fb_user']['data'][] = array($key, $value['total']);
                }

                foreach ($user_data['user'] as $key => $value) {
                    $json['user']['data'][] = array($key, $value['total']);
                }

                for ($i = 1; $i <= 12; $i++) {
                    $json['xaxis'][] = array($i, date('M', mktime(0, 0, 0, $i)));
                }
                break;
        }

        echo json_encode($json);

        $this->autoRender = false;
    }

}