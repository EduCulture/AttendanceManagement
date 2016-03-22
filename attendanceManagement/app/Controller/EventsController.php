<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 07-09-2015
 * Time: 11:04 AM
 */

App::uses('AppController', 'Controller');

class EventsController extends AppController {

    private $error = array();

    public $paginate = array(
        'limit' => 15,
        'order' => array(
            'Event.id' => 'DESC'
        )
    );

    public function index() {
        $this->loadModel('EventType');
        $event_type = $this->EventType->find('all',array(
            'conditions' => array('EventType.school_id' => CakeSession::read('Auth.User.school_id')),
            'order' => array('EventType.id DESC')
        ));
        $this->set('event_types',$event_type);
    }

    public function addEventType() {

        if($this->request->is('post')){
            $this->loadModel('EventType');
            if($this->EventType->add($this->request->data)){
                $this->redirect(array('controller' => 'events', 'action' => 'index'));
            }
        }
    }

    public function deleteEventType() {
        $json = [];
        if($this->request->is('post')){
            $this->loadModel('EventType');
            if($this->EventType->deleteAll(array(
                'EventType.id' => $this->request->data['event_category_type']
            ))){

                $this->Event->deleteAll(array(
                   'Event.event_type_id' => $this->request->data['event_category_type']
                ));
                $json['success'] = 'Successfully Deleted';
            }
        }

        echo json_encode($json);
        $this->autoRender = false;
    }

    public function add() {

        $json = [];
        if($this->request->is('post')){

            if (strlen(trim($this->request->data['tittle'])) < 3) {
                $json['error']['tittle'] = 'Tittle length must be greater than 3 character';
            }

            if (strlen(trim(strip_tags($this->request->data['description']))) < 6) {
                $json['error']['description'] = 'Description must be between 6 to 128 character';
            }
            //echo date("Y-m-d",strtotime($this->request->data['event_date'])) . "==".date("Y-m-d");

            if (!$this->request->data['event_date']) {
                $json['error']['event-date'] = 'Event date cannot be empty';
            }else if(date("Y-m-d",strtotime($this->request->data['event_date'])) < date("Y-m-d")){
                $json['error']['event-date'] = 'Event date must be greater than today\'s date';
            }

            if (!$this->request->data['event_date']) {
                $json['error']['event-date'] = 'Event date cannot be empty';
            }

            if (!isset($this->request->data['event_type_id']) || !$this->request->data['event_type_id']) {
                $json['error']['type-id'] = 'Event type cannot be empty';
            }

            if(!$json) {
                if ($this->Event->add($this->request->data)) {
                    $json['success'] = 'Event Added Successfully';
                } else {
                    $json['error'] = 'Error wihle adding event';
                }
            }
        }else{
            $json['error'] = 'Error wihle adding event';
        }

        echo json_encode($json);
        $this->autoRender = false;
        //$this->getForm();

        //$this->view = 'form';
    }

    public function edit() {

        $json = [];
        if($this->request->is('post')){

            if (strlen(trim($this->request->data['tittle'])) < 3) {
                $json['error']['tittle'] = 'Tittle length must be greater than 3 character';
            }

            if (strlen(trim(strip_tags($this->request->data['description']))) < 6) {
                $json['error']['description'] = 'Description must be between 6 to 128 character';
            }
            //echo date("Y-m-d",strtotime($this->request->data['event_date'])) . "==".date("Y-m-d");

            if (!$this->request->data['event_date']) {
                $json['error']['event-date'] = 'Event date cannot be empty';
            }

            if (!isset($this->request->data['event_type_id']) || !$this->request->data['event_type_id']) {
                $json['error']['type-id'] = 'Event type cannot be empty';
            }

            if(!$json) {
                if ($this->Event->update($this->request->data, $this->request->data['event_id'])) {
                    $json['success'] = 'Event updated Successfully';
                } else {
                    $json['error'] = 'Error wihle updating event';
                }
            }
        }else{
            $json['error'] = 'Error while updating event';
        }

        echo json_encode($json);
        $this->autoRender = false;
    }

    public function delete() {

        $json = [];
        if($this->request->is('post')) {
            if (isset($this->request->data['event_id']) && $this->Event->findById($this->request->data['event_id'])) {
                $this->Event->deleteAll(array('Event.id' => $this->request->data['event_id']));
                $json['success'] = 'Successfully Deleted';
            }else{
                $json['error']['event_id'] = 'Event id not valid';
            }
        }else{
            $json['error'] = 'Error while deleting event';
        }

        echo json_encode($json);
        $this->autoRender = false;
    }

    public function getEvents() {
        $events = $this->Event->find('all',array(
            'conditions' => array('Event.school_id' => CakeSession::read('Auth.User.school_id'))
        ));

        //pr($events);die;
        $details = [];
        if($events){
            foreach($events as $event){
                $details[] = array(
                    'event_id' => $event['Event']['id'],
                    'tittle' => $event['Event']['tittle'],
                    'start' => date("Y-m-d",strtotime($event['Event']['event_date'])),
                    'description' => $event['Event']['description'],
                    'event_type' => $event['EventType']['name'],
                    'backgroundColor' => $event['EventType']['color_code'],
                    'textColor' => '#ffffff'
                );
            }
        }

        echo json_encode($details);
        $this->autoRender = false;
    }

    public function getForm() {

        if(isset($this->request->data['event_id'])){
            $this->set('event_id',$this->request->data['event_id']);
        } else if(isset($this->request->query['event_id']) && $this->request->query['event_id']) {

            //$this->School->query("SET CHARACTER SET utf8;");
            $details = $this->Event->find('first',array(
                'conditions' => array('Event.id' => $this->request->query['event_id'])
            ));
            $this->set('event_id',$this->request->query['event_id']);

        }else{
            $this->set('event_id','');
        }


        if(isset($this->request->data['tittle'])){
            $this->set('tittle',$this->request->data['tittle']);
        }else if(isset($details['Event']['tittle'])){
            $this->set('tittle',$details['Event']['tittle']);
        }else{
            $this->set('tittle','');
        }

        if(isset($this->request->data['description'])){
            $this->set('description',$this->request->data['description']);
        }else if(isset($details['Event']['description'])){
            $this->set('description',$details['Event']['description']);
        }else{
            $this->set('description','');
        }

        if(isset($this->request->data['event_date'])){
            $this->set('event_date',$this->request->data['event_date']);
        }else if(isset($details['Event']['event_date'])){
            $this->set('event_date',$details['Event']['event_date']);
        }else{
            $this->set('event_date','');
        }

        if(isset($this->error['tittle'])){
            $this->set('error_tittle',$this->error['tittle']);
        }else{
            $this->set('error_tittle','');
        }

        if(isset($this->error['description'])){
            $this->set('error_description',$this->error['description']);
        }else{
            $this->set('error_description','');
        }

        if(isset($this->error['event_date'])){
            $this->set('error_event_date',$this->error['event_date']);
        }else{
            $this->set('error_event_date','');
        }

        if (isset($this->error['warning'])) {
            $this->set('error_warning',$this->error['warning']);
        } else {
            $this->set('error_warning','');
        }
    }

    public function validateForm() {

        $json = [];
        if (strlen($this->request->data['tittle']) < 3) {
            $json['error']['tittle'] = 'Tittle length must be greater than 3 character';
        }

        if (strlen($this->request->data['description']) < 6) {
            $json['error']['description'] = 'Description must be between 6 to 128 character';
        }
        //echo date("Y-m-d",strtotime($this->request->data['event_date'])) . "==".date("Y-m-d");

        if (date("Y-m-d",strtotime($this->request->data['event_date'])) <= date("Y-m-d")) {
            $json['error']['event_date'] = 'Event date must be greater than today\'s date';
        }

        if($this->error){
            $json['error']['warning'] = 'Please Check Below Errors';
        }

        return !$json['error'];
    }

    public function services_getEvents() {

        if(isset($this->request->data['student_id'])){

            $this->loadModel('Student');

            $student_id = $this->request->data['student_id'];
            $student_detail = $this->Student->findById($student_id);

            if($student_detail){

                $school_id = $student_detail['Student']['school_id'];

                $events = $this->Event->find('all',array(
                    'conditions' => array('Event.school_id' => $school_id),
                ));

                //pr($events);die;
                $events_detail = [];
                if($events){
                    foreach($events as $event){
                        $events_detail[] = array(
                            'weekday' => date('l', strtotime($event['Event']['event_date'])),
                            'date' => date("d", strtotime($event['Event']['event_date'])),
                            'month' => date('F', strtotime($event['Event']['event_date'])),
                            'year' => date('Y', strtotime($event['Event']['event_date'])),
                            'title' => $event['Event']['tittle'],
                            'subtitle' => $event['EventType']['name'],
                            'description' => $event['Event']['description'],
                            'iconURI' => NULL,
                            'type' => 'event'
                        );
                        //pr($assignment_detail);die;
                    }
                }
                $data = $this->Event->formatMessages('Event details',true,$events_detail);

            }else{
                $data = $this->Event->formatMessages('Invalid Student id');
            }
        }else{
            $data = $this->Event->formatMessages('Parameters missing');
        }

        $this->set('data',$data);
    }

    public function services_getUpcomingEvents() {

        if(isset($this->request->data['student_id'])){

            $this->loadModel('Student');

            $student_id = $this->request->data['student_id'];
            $student_detail = $this->Student->findById($student_id);

            if($student_detail){

                $school_id = $student_detail['Student']['school_id'];

                $events = $this->Event->find('all',array(
                    'conditions' => array('Event.school_id' => $school_id,'Event.event_date >' => date("Y-m-d")),
                    'order' => 'Event.event_date ASC',
                    'limit' => 5
                ));

                //pr($events);die;
                $events_detail = [];
                if($events){
                    foreach($events as $event){
                        $events_detail[] = array(
                            'weekday' => date('l', strtotime($event['Event']['event_date'])),
                            'date' => date("d", strtotime($event['Event']['event_date'])),
                            'month' => date('F', strtotime($event['Event']['event_date'])),
                            'year' => date('Y', strtotime($event['Event']['event_date'])),
                            'title' => $event['Event']['tittle'],
                            'subtitle' => $event['EventType']['name'],
                            'description' => $event['Event']['description'],
                            'iconURI' => NULL,
                            'type' => 'event'
                        );
                        //pr($assignment_detail);die;
                    }
                }
                $data = $this->Event->formatMessages('Event details',true,$events_detail);

            }else{
                $data = $this->Event->formatMessages('Invalid Student id');
            }
        }else{
            $data = $this->Event->formatMessages('Parameters missing');
        }

        $this->set('data',$data);
    }

}