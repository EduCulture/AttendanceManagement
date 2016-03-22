<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 07-09-2015
 * Time: 11:04 AM
 */

App::uses('AppController', 'Controller');

class FeesController extends AppController {

    private $error = array();

    public function index() {
        $this->getList();
    }

    public function category() {
        $this->getCategoryList();
    }

    public function collect() {

        $this->loadModel('Standard');
        $standards = $this->Standard->getStandards();

        $this->set('standards',$standards);
        //$this->getStudentList();
    }

    public function add() {

        if($this->request->is('post') && $this->validateForm()){
            if($this->Fee->add($this->request->data)) {
                $this->Session->setFlash('Fee Added Successfully','flash');
                $this->redirect(array('controller' => 'fees', 'action' => 'getCategoryList'));
            }
        }

        $this->getForm();

        $this->view = 'form';
    }

    public function edit() {

        //pr($this->request->data);die;
        if($this->request->is('post') && $this->validateForm()){

            if($this->Fee->update($this->request->data,$this->request->data['fee_id'])) {
                $this->Session->setFlash('Fee Updated Successfully','flash');
                $this->redirect(array('controller' => 'fees', 'action' => 'getCategoryList'));
            }
        }

        $this->getForm();

        $this->view = 'form';
    }

    public function getCategoryList() {

        //$this->recursive = -1;
        $fees = $this->Fee->find('all',array(
            'conditions' => array('Fee.is_delete' => 0,'Fee.school_id' => CakeSession::read('Auth.User.school_id'))
        ));

        //pr($standards);die;
        $this->set('fees',$fees);

        $this->view = 'category_list';
    }

    public function getStudentList() {

        if(isset($this->request->data['standard_id']) && $this->request->data['section_id']) {
            //Fee Details
            $this->loadModel('FeeStandardMap');

            $fee_details = $this->FeeStandardMap->getFeeDetails($this->request->data['fee_id'],$this->request->data['standard_id']);

            $total = $fee_details['total_fee'];
            //pr($fee_details);die;
            $this->set('details',$fee_details['fee_data']);
            $this->set('total',$total);
            $this->set('fee_id',$this->request->data['fee_id']);

            //Students Deatils
            $this->loadModel('Student');
            $this->Student->recursive = -1;
            $student_details = $this->Student->find('all',array(
                'conditions' => array('Student.standard_id' => $this->request->data['standard_id'],'Student.section_id' => $this->request->data['section_id']),
                /*'fields' => array('SUM(StudentFeeMap.amount) as paid_amount','Student.first_name','Student.last_name','Student.roll_number','Student.id'),
                'joins' => array(
                    array(
                        'table' => 'student_fee_mapping',
                        'alias' => 'StudentFeeMap',
                        'type' => 'LEFT',
                        'conditions' => array(
                            'Student.id = StudentFeeMap.student_id'
                        )
                    )
                ),*/
            ));

            //echo $this->Student->getLastQuery();die;
            //pr($student_details);die;

            $total_paid = $total_remaining =  0;
            $student_list = [];
            if($student_details){

                $this->loadModel('StudentFeeMap');
                foreach($student_details as $detail){

                    $student_fee_details = $this->StudentFeeMap->find('first',array(
                       'conditions' => array('StudentFeeMap.student_id' => $detail['Student']['id'],'StudentFeeMap.fee_id' => $this->request->data['fee_id']),
                       'fields' => array('SUM(StudentFeeMap.amount) as paid_amount'),
                       'group' => array('StudentFeeMap.fee_id')
                    ));

                    //pr()

                    if($student_fee_details){
                        $total_paid += $student_fee_details[0]['paid_amount'];
                        $total_remaining += ($total - $student_fee_details[0]['paid_amount']);
                    }else{
                        $total_remaining += $total;
                    }
                    //pr($student_fee_details);die;


                    $student_list[] = array(
                       'id' => $detail['Student']['id'],
                       'name' => $detail['Student']['first_name'].' '.$detail['Student']['last_name'],
                       'roll_number' => $detail['Student']['roll_number'],
                       'paid_amount' => ($student_fee_details) ? number_format($student_fee_details[0]['paid_amount'],2) : 0.00,
                       'remaining_amount' => ($student_fee_details) ? number_format(($total - $student_fee_details[0]['paid_amount']),2) : number_format($total,2)
                    );
                }
            }
            $this->set('total_paid',$total_paid);
            $this->set('total_remaining',$total_remaining);
            $this->set('students',$student_list);

            $this->view = 'student_list';
            $this->layout = 'ajax';
        }
    }

    public function getForm() {

        //pr($sections);die;
        if(isset($this->request->data['fee_id'])){
            $this->set('fee_id',$this->request->data['fee_id']);
            $this->set('standard_fee',$this->request->data['standard_fee']);
        } else if(isset($this->request->query['fee_id']) && $this->request->query['fee_id']) {
            $this->Fee->recursive = 2;
            $details = $this->Fee->find('first',array(
                'conditions' => array('Fee.id' => $this->request->query['fee_id'])
            ));

            $standard_fee = [];
            //pr($details);die;
            if($details){
                foreach($details['FeeStandardMap'] as $detail) {
                    $standard_fee[] = array(
                        'standard_name' => $detail['Standard']['name'],
                        'standard_id' => $detail['standard_id'],
                        'amount' => $detail['amount'],
                    );
                }
            }
            //pr($standard_fee);die;
            $this->set('standard_fee',$standard_fee);
            $this->set('fee_id',$this->request->query['fee_id']);
        }else{
            $this->set('standard_fee',array());
            $this->set('fee_id','');
        }

        if(isset($this->request->data['name'])){
            $this->set('name',$this->request->data['name']);
        }else if(isset($details['Fee']['name'])){
            $this->set('name',$details['Fee']['name']);
        }else{
            $this->set('name','');
        }

        if(isset($this->request->data['description'])){
            $this->set('description',$this->request->data['description']);
        }else if(isset($details['Fee']['description'])){
            $this->set('description',$details['Fee']['description']);
        }else{
            $this->set('description','');
        }

        if(isset($this->request->data['start_date'])){
            $this->set('start_date',$this->request->data['start_date']);
        }else if(isset($details['Fee']['start_date'])){
            $this->set('start_date',$details['Fee']['start_date']);
        }else{
            $this->set('start_date','');
        }

        if(isset($this->request->data['due_date'])){
            $this->set('due_date',$this->request->data['due_date']);
        }else if(isset($details['Fee']['due_date'])){
            $this->set('due_date',$details['Fee']['due_date']);
        }else{
            $this->set('due_date','');
        }

        /*if(isset($this->request->data['standard_fee'])){
            $this->set('standard_fee',$this->request->data['standard_fee']);
        }else if(isset($this->request->query['fee_id'])){

            $this->Fee->recursive = 2;
            $details = $this->Fee->find('first',array(
               'conditions' => array('Fee.id' => $this->request->query['fee_id'])
            ));

            $standard_fee = [];
            //pr($details);die;
            if($details){
                foreach($details['FeeStandardMap'] as $detail) {
                    $standard_fee[] = array(
                        'standard_name' => $detail['Standard']['name'],
                        'standard_id' => $detail['id'],
                        'amount' => $detail['amount'],
                    );
                }
            }
            //pr($standard_fee);die;
            $this->set('standard_fee',$standard_fee);
        }else{
            $this->set('standard_fee',array());
        }*/

        //pr($this->request->data['staff_subject']);die;

        if (isset($this->error['warning'])) {
            $this->set('error_warning',$this->error['warning']);
        } else {
            $this->set('error_warning','');
        }

        if (isset($this->error['name'])) {
            $this->set('error_name',$this->error['name']);
        } else {
            $this->set('error_name','');
        }

        if (isset($this->error['start_date'])) {
            $this->set('error_start_date',$this->error['start_date']);
        } else {
            $this->set('error_start_date','');
        }

        if (isset($this->error['due_date'])) {
            $this->set('error_due_date',$this->error['due_date']);
        } else {
            $this->set('error_due_date','');
        }

        if (isset($this->error['amount'])) {
            $this->set('error_amount',$this->error['amount']);
        } else {
            $this->set('error_amount','');
        }
    }

    public function validateForm() {

        //pr($this->request->data);die;

        if (!$this->request->data['name']) {
            $this->error['name'] = 'Standard name can not be empty';
        }

        if (!$this->request->data['start_date']) {
            $this->error['start_date'] = 'Start date can not be empty';
        }

        if (!$this->request->data['due_date']) {
            $this->error['due_date'] = 'Due date can not be empty';
        }else if($this->request->data['due_date'] <=  $this->request->data['start_date']){
            $this->error['due_date'] = 'Due date must be greater than Start Date';
        }

        if(isset($this->request->data['standard_fee']) && is_array($this->request->data['standard_fee']) && $this->request->data['standard_fee']){
            foreach($this->request->data['standard_fee'] as $val){
                if(!$val['amount'] || !is_numeric($val['amount'])){
                    $this->error['amount'][] = 'Invalid amount';
                }
            }
        }

        //pr($this->error);die;
        if (!$this->request->data['due_date']) {
            $this->error['due_date'] = 'Due date can not be empty';
        }

        if($this->error){
            $this->error['warning'] = 'Please Check Below Errors';
        }

        return !$this->error;
    }

    public function getDivisions() {

        $this->loadModel('StandardSectionMap');
        $return = [];
        if(isset($this->request->data['standard_id'])){
            $sections = $this->StandardSectionMap->find('all',array(
               'conditions' => array('StandardSectionMap.standard_id' => $this->request->data['standard_id'])
            ));

            //pr($sections);die;
            if($sections){
                foreach($sections as $section){
                    $return[] = array(
                       'section_id' => $section['Section']['id'],
                       'section_name' => $section['Section']['name']
                    );
                }
                //pr($return);die;
            }
        }
        echo json_encode($return);
        $this->autoRender = false;
    }


    public function getSuggestion(){

        $return = [];
        if(isset($this->request->query['filter_name'])){

            $sectionClass = ClassRegistry::init('Section');

            $sections = $sectionClass->find('all',array(
                'conditions' => array('Section.is_delete' => 0,'Section.school_id' => CakeSession::read('Auth.User.school_id'),'Section.is_active' => 1,'Section.name LIKE' => $this->request->query['filter_name'].'%')
            ));

            //pr($sections);die;
            if($sections){
                foreach($sections as $section){
                    $return[] = array(
                        'section_id' => $section['Section']['id'],
                        'section_name' => $section['Section']['name']
                    );
                }
                //pr($return);die;
            }
        }
        echo json_encode($return);
        $this->autoRender = false;
    }

    public function transaction(){

        if(isset($this->request->query['student_id']) && isset($this->request->query['fee_id'])) {

            $this->set('student_id',$this->request->query['student_id']);
            $this->set('fee_id',$this->request->query['fee_id']);

            $this->loadModel('Student');
            $details = $this->Student->find('first',array(
                'conditions' => array('Student.id' => $this->request->query['student_id'])
            ));
            //pr($details);die;
            $this->set('student_details',$details);

            $this->loadModel('FeeStandardMap');
            $fee_details = $this->FeeStandardMap->getFeeDetails($this->request->query['fee_id'],$details['Standard']['id']);
            $total = $fee_details['total_fee'];

            //pr($fee_details);die;

            $this->set('details',$fee_details['fee_data']);
            $this->set('total',$total);

            $this->loadModel('StudentFeeMap');
            $student_fee_details = $this->StudentFeeMap->find('first',array(
                'conditions' => array('StudentFeeMap.student_id' => $this->request->query['student_id'],'StudentFeeMap.fee_id' => $this->request->query['fee_id']),
                'fields' => array('SUM(StudentFeeMap.amount) as paid_amount'),
                'group' => array('StudentFeeMap.fee_id')
            ));

            $total_paid = $total_remaining = 0;

            if($student_fee_details){
                $total_paid = $student_fee_details[0]['paid_amount'];
                $total_remaining = ($total - $student_fee_details[0]['paid_amount']);
            }else{
                $total_remaining = $total;
            }
            //pr($student_fee_details);die;

            $this->set('total_paid',number_format($total_paid,2));
            $this->set('total_remaining',$total_remaining);


            //fee history
            $student_fee_history = $this->StudentFeeMap->find('all',array(
                'conditions' => array('StudentFeeMap.student_id' => $this->request->query['student_id'],'StudentFeeMap.fee_id' => $this->request->query['fee_id']),
            ));
            //pr($student_fee_history);die;
            $this->set('fees_history',$student_fee_history);

            //$this->set('fee_id',$this->request->data['fee_id']);

            //fee details
            //$fee_details = $this->FeeStandardMap->getFeeDetails($this->request->data['standard_id']);
            //$this->set('fee_details',$fee_details);
            //pr($details);die;
        }
    }

    public function getFeesCategory() {

        $this->loadModel('FeeStandardMap');
        $return = [];
        if(isset($this->request->data['standard_id'])){
            $fees = $this->FeeStandardMap->find('all',array(
                'conditions' => array('FeeStandardMap.standard_id' => $this->request->data['standard_id'])
            ));

            //pr($fees);die;
            if($fees){
                foreach($fees as $fee){
                    $return[] = array(
                        'fee_id' => $fee['Fee']['id'],
                        'fee_name' => $fee['Fee']['name']
                    );
                }
                //pr($return);die;
            }
        }
        //pr($return);die;
        echo json_encode($return);
        $this->autoRender = false;
    }

    public function updateStudentFee() {

        $json = [];

        //pr($this->request->data);die;

        if(isset($this->request->data['student_fee_map_id'])) {
            $this->loadModel('StudentFeeMap');

            $payment_date = date("Y-m-d",strtotime($this->request->data['payment_date']));
            $date_modified = date("Y-m-d H:i:s");

            if($this->request->data['student_fee_map_id']) {

                $this->StudentFeeMap->updateAll(
                    array('StudentFeeMap.receipt_no' => $this->request->data['receipt_no'], 'StudentFeeMap.amount' => $this->request->data['amount'], 'StudentFeeMap.payment_type' => $this->request->data['payment_type'], 'StudentFeeMap.cheque_no' => $this->request->data['cheque_no'], 'StudentFeeMap.payment_date' => $payment_date, 'StudentFeeMap.date_modified' => $date_modified),
                    array('StudentFeeMap.id' => $this->request->data['student_fee_map_id'])
                );
            }else{
                $this->StudentFeeMap->save(array(
                    'student_id' => $this->request->data['student_id'],
                    'fee_id' => $this->request->data['fee_id'],
                    'amount' => $this->request->data['amount'],
                    'payment_type' => $this->request->data['payment_type'],
                    'cheque_no' => $this->request->data['cheque_no'],
                    'payment_date' => date("Y-m-d",strtotime($this->request->data['fee_id'])),
                    'date_added' => date("Y-m-d H:i:s"),
                    'date_modified' => date("Y-m-d H:i:s"),
                ));
            }

            $json['success'] = 'success';
        }else{
            $json['error'] = 'invalid';
        }

        echo json_encode($json);
        $this->autoRender = false;
    }

    public function deleteStudentFee() {

        $json = [];

        if(isset($this->request->data['student_fee_map_id'])) {
            $this->loadModel('StudentFeeMap');
            $this->StudentFeeMap->deleteAll(array('StudentFeeMap.id' => $this->request->data['student_fee_map_id']));

            $json['success'] = 'success';
        }else{
            $json['error'] = 'invalid';
        }

        echo json_encode($json);
        $this->autoRender = false;
    }
}