<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 07-09-2015
 * Time: 11:04 AM
 */

App::uses('AppController', 'Controller');
App::uses('IOFactory', 'Lib/PHPExcel');

class StudentsController extends AppController {

    private $error = array();

    public $paginate = array(
        'limit' => 15,
        'order' => array(
            'Student.id' => 'DESC'
        )
    );

    public function services_demo() {

        echo "hello world";
        /*if(isset($this->request->data['student_id'])){
            $student_data = $this->Student->find('first',array(
                'conditions' => array('Student.id' => $this->request->data['student_id'])
            ));

            $data = $this->Student->formatMessages('Success',true,$student_data);
        }else{
            $data = $this->Student->formatMessages('Invalid Student Id');
        }

        $this->set('data',$data);*/
    }

    public function index() {
        $this->getList();
    }

    public function add() {

        //pr($this->request->data);die;
        if($this->request->is('post') && $this->validateForm()){

            if(!isset($this->request->data['active'])){
                $this->request->data['is_active'] = 0;
            }else{
                $this->request->data['is_active'] = 1;
            }

            if($this->Student->add($this->request->data)) {
                $this->Session->setFlash('Student Added Successfully','flash');
                $this->redirect(array('controller' => 'students', 'action' => 'index'));
            }
        }

        $this->getForm();

        $this->view = 'form';
    }

    public function edit() {

        if($this->request->is('post') && $this->validateForm()){

            if(!isset($this->request->data['active'])){
                $this->request->data['is_active'] = 0;
            }else{
                $this->request->data['is_active'] = 1;
            }

            if($this->Student->update($this->request->data,$this->request->data['student_id'])) {
                $this->Session->setFlash('Student Updated Successfully','flash');
                $this->redirect(array('controller' => 'students', 'action' => 'index'));
            }
        }

        $this->getForm();

        $this->view = 'form';
    }

    public function getList() {

        //$this->School->query("SET CHARACTER SET utf8;");

        $is_filter = false;

        $filter = array('Student.is_delete' => 0,'Student.school_id' => CakeSession::read('Auth.User.school_id'));
        if(isset($this->request->query['filter_name']) && $this->request->query['filter_name']){
            $is_filter = true;
            $filter['CONCAT (Staff.first_name," ",Staff.last_name) LIKE'] = '%'.$this->request->query['filter_name'] .'%';
        }

        if(isset($this->request->query['filter_admission_number']) && $this->request->query['filter_admission_number']){
            $is_filter = true;
            $filter['Student.admission_number'] = $this->request->query['filter_admission_number'];
        }

        if(isset($this->request->query['filter_roll_number']) && $this->request->query['filter_roll_number']){
            $is_filter = true;
            $filter['Student.roll_number'] = $this->request->query['filter_roll_number'];
        }

        $this->Paginator->settings = $this->paginate;
        $data = $this->Paginator->paginate('Student',$filter);

        //pr($data);die;
        $this->set('students',$data);
        $this->set('is_filter',$is_filter);
    }

    public function getForm() {

        $this->loadModel('Standard');
        $standards = $this->Standard->getStandards();

        $this->set('standards',$standards);

        //pr($this->request->data);die;
        if(isset($this->request->data['student_id'])){
            $this->set('student_id',$this->request->data['student_id']);
            $this->set('user_id',$this->request->data['user_id']);

        } else if(isset($this->request->query['student_id']) && $this->request->query['student_id']) {

            //$this->School->query("SET CHARACTER SET utf8;");
            $details = $this->Student->find('first',array(
                'conditions' => array('Student.id' => $this->request->query['student_id'])
            ));
            $this->set('student_id',$this->request->query['student_id']);

            //for username & password
            $this->loadModel('User');
            $user_details = $this->User->find('first',array(
                'conditions' => array('User.id' => $details['Student']['user_id'])
            ));
            $this->set('user_id',$user_details['User']['id']);

        }else{
            $this->set('student_id','');
            $this->set('user_id','');
        }

        if(isset($this->request->data['student_parents'])){
            $this->set('student_parents',$this->request->data['student_parents']);
        }else if(isset($this->request->query['student_id']) && $this->request->query['student_id']){

            $this->loadModel('StudentParentMap');
            $parents_details = $this->StudentParentMap->find('all',array(
                'conditions' => array('StudentParentMap.student_id' => $this->request->query['student_id'])
            ));
            //pr($parents_details);die;
            $array = [];
            if($parents_details){
                foreach($parents_details as $value) {
                    $array[] = array(
                        'relation' => $value['Parents']['relation'],
                        'name' => $value['Parents']['name'],
                        'contact_number' => $value['Parents']['contact_number'],
                        'address' => $value['Parents']['address']
                    );
                }
            }
            $this->set('student_parents',$array);
        }else{
            $this->set('student_parents',array());
        }

        if(isset($this->request->data['first_name'])){
            $this->set('first_name',$this->request->data['first_name']);
        }else if(isset($details['Student']['first_name'])){
            $this->set('first_name',$details['Student']['first_name']);
        }else{
            $this->set('first_name','');
        }

        if(isset($this->request->data['last_name'])){
            $this->set('last_name',$this->request->data['last_name']);
        }else if(isset($details['Student']['last_name'])){
            $this->set('last_name',$details['Student']['last_name']);
        }else{
            $this->set('last_name','');
        }

        if(isset($this->request->data['address'])){
            $this->set('address',$this->request->data['address']);
        }else if(isset($details['Student']['address'])){
            $this->set('address',$details['Student']['address']);
        }else{
            $this->set('address','');
        }

        if(isset($this->request->data['contact_number'])){
            $this->set('contact_number',$this->request->data['contact_number']);
        }else if(isset($details['Student']['contact_number'])){
            $this->set('contact_number',$details['Student']['contact_number']);
        }else{
            $this->set('contact_number','');
        }

        if(isset($this->request->data['profile_pic'])){
            $this->set('profile_pic',$this->request->data['profile_pic']);
        }else if(isset($details['Student']['profile_pic'])){
            $this->set('profile_pic',$details['Student']['profile_pic']);
        }else{
            $this->set('profile_pic','');
        }

        if(isset($this->request->data['gender'])){
            $this->set('gender',$this->request->data['gender']);
        }else if(isset($details['Student']['gender'])){
            $this->set('gender',$details['Student']['gender']);
        }else{
            $this->set('gender','');
        }

        if(isset($this->request->data['birthdate'])){
            $this->set('birthdate',$this->request->data['birthdate']);
        }else if(isset($details['Student']['birthdate'])){
            $this->set('birthdate',$details['Student']['birthdate']);
        }else{
            $this->set('birthdate','');
        }

        if(isset($this->request->data['admission_number'])){
            $this->set('admission_number',$this->request->data['admission_number']);
        }else if(isset($details['Student']['admission_number'])){
            $this->set('admission_number',$details['Student']['admission_number']);
        }else{
            $this->set('admission_number','');
        }

        if(isset($this->request->data['roll_number'])){
            $this->set('roll_number',$this->request->data['roll_number']);
        }else if(isset($details['Student']['roll_number'])){
            $this->set('roll_number',$details['Student']['roll_number']);
        }else{
            $this->set('roll_number','');
        }

        if(isset($this->request->data['standard_id'])){
            $this->set('standard_id',$this->request->data['standard_id']);
        }else if(isset($details['Student']['standard_id'])){
            $this->set('standard_id',$details['Student']['standard_id']);
        }else{
            $this->set('standard_id','');
        }

        if(isset($this->request->data['section_id'])){
            $this->set('section_id',$this->request->data['section_id']);
        }else if(isset($details['Student']['section_id'])){
            $this->set('section_id',$details['Student']['section_id']);
        }else{
            $this->set('section_id','');
        }

        if(isset($this->request->data['section_id'])){
            $this->set('section_id',$this->request->data['section_id']);
        }else if(isset($details['Student']['section_id'])){
            $this->set('section_id',$details['Student']['section_id']);
        }else{
            $this->set('section_id','');
        }

        if(isset($this->request->data['active'])){
            $this->set('active',$this->request->data['active']);
        }else if(isset($details['Student']['is_active'])){
            $this->set('active',$details['Student']['is_active']);
        }else{
            $this->set('active','');
        }

        //Users Details(for login)
        if(isset($this->request->data['email'])){
            $this->set('email',$this->request->data['email']);
        }else if(isset($user_details['User']['email'])){
            $this->set('email',$user_details['User']['email']);
        }else{
            $this->set('email','');
        }

        if(isset($this->request->data['username'])){
            $this->set('username',$this->request->data['username']);
        }else if(isset($user_details['User']['username'])){
            $this->set('username',$user_details['User']['username']);
        }else{
            $this->set('username','');
        }

        if (isset($this->error['warning'])) {
            $this->set('error_warning',$this->error['warning']);
        } else {
            $this->set('error_warning','');
        }

        if (isset($this->error['first_name'])) {
            $this->set('error_first_name',$this->error['first_name']);
        } else {
            $this->set('error_first_name','');
        }

        if (isset($this->error['last_name'])) {
            $this->set('error_last_name',$this->error['last_name']);
        } else {
            $this->set('error_last_name','');
        }

        if (isset($this->error['admission_number'])) {
            $this->set('error_admission_number',$this->error['admission_number']);
        } else {
            $this->set('error_admission_number','');
        }

        if (isset($this->error['roll_number'])) {
            $this->set('error_roll_number',$this->error['roll_number']);
        } else {
            $this->set('error_roll_number','');
        }

        if (isset($this->error['standard_id'])) {
            $this->set('error_standard_id',$this->error['standard_id']);
        } else {
            $this->set('error_standard_id','');
        }

        if (isset($this->error['section_id'])) {
            $this->set('error_section_id',$this->error['section_id']);
        } else {
            $this->set('error_section_id','');
        }

        if (isset($this->error['contact_number'])) {
            $this->set('error_contact_number',$this->error['contact_number']);
        } else {
            $this->set('error_contact_number','');
        }

        if (isset($this->error['email'])) {
            $this->set('error_email',$this->error['email']);
        } else {
            $this->set('error_email','');
        }

        if (isset($this->error['username'])) {
            $this->set('error_username',$this->error['username']);
        } else {
            $this->set('error_username','');
        }

        if (isset($this->error['password'])) {
            $this->set('error_password',$this->error['password']);
        } else {
            $this->set('error_password','');
        }

        if (isset($this->error['parents'])) {
            $this->set('error_parents',$this->error['parents']);
        } else {
            $this->set('error_parents',array());
        }
    }

    public function validateForm() {

        //pr($this->request->data);die;

        if (strlen($this->request->data['first_name']) < 3) {
            $this->error['first_name'] = 'First name must be greater than 2 characters';
        }

        if (strlen($this->request->data['last_name']) < 3) {
            $this->error['last_name'] = 'Last name must be greater than 2 characters';
        }

        if (strlen($this->request->data['contact_number']) < 3 || !is_numeric($this->request->data['contact_number'])) {
            $this->error['contact_number'] = 'Contact number must be greater than 3 characters & In Numeric format';
        }

        if (!$this->request->data['admission_number']) {
            $this->error['admission_number'] = 'Invalid Admission Number';
        }

        if (!$this->request->data['roll_number'] && !is_numeric($this->request->data['roll_number'])) {
            $this->error['roll_number'] = 'Invalid Role Number';
        }

        if (!$this->request->data['standard_id']) {
            $this->error['standard_id'] = 'Invalid Standard Id';
        }

        if (!isset($this->request->data['section_id']) || !$this->request->data['section_id']) {
            $this->error['section_id'] = 'Invalid Section Id';
        }

        if ((strlen($this->request->data['email']) > 96) || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->data['email'])) {
            $this->error['email'] = 'Invalid email address';
        }else{
            $this->loadModel('User');

            $condition = array('User.email LIKE' => $this->request->data['email']);

            if(isset($this->request->data['user_id'])){
                $condition['User.id'] = '<> '.$this->request->data['user_id'];
            }

            $udetails = $this->User->find('first',array(
                'conditions' => $condition
            ));

            if($udetails){
                $this->error['username'] = 'Email already exists! Please try another username';
            }
        }

        //validate parents info
        if(isset($this->request->data['student_parents'])){
            $row = 0;
            foreach($this->request->data['student_parents'] as $parent){
                if(!$parent['name']){
                    $this->error['parents'][$row]['name'] = 'Name Required';
                }

                if(!$parent['relation']){
                    $this->error['parents'][$row]['relation'] = 'Relation Required';
                }

                if(!$parent['contact_number'] && !is_numeric($parent['contact_number'])){
                    $this->error['parents'][$row]['contact_number'] = 'Invalid Contact Number';
                }
                $row++;
            }
        }

        //pr($this->error['parents']);die;

        if($this->error){
            $this->error['warning'] = 'Please Check Below Errors';
        }

        return !$this->error;
    }

    public function report() {


        for ($i = 1; $i <= 12; $i++) {
            $user_data[$i] =  0;
        }

        $this->loadModel('Student');
        $user_query = $this->Student->query("SELECT COUNT(*) AS total,date_added FROM `students` WHERE school_id = '".CakeSession::read('Auth.User.school_id')."' AND YEAR(`date_added`) = YEAR(NOW()) GROUP BY MONTH(date_added)");
        //pr($user_query);die;
        if($user_query) {
            foreach ($user_query as $result) {
                //print_r($result)."<br/>";
                $user_data[date('n', strtotime($result['students']['date_added']))] = $result[0]['total'];
            }
        }

        foreach($user_data as $val){
            $array[] = (int)$val;
        }
        $this->set('month_admission',json_encode($array));


        //for pie chart
        $this->loadModel('Standard');
        $standards = $this->Standard->getStandards();
        foreach($standards as $standard){
            $standard_count[$standard['Standard']['id']] = array(
                'name' => $standard['Standard']['name'],
                'y' => 0
            );
        }
        //pr($standard_count);die;

        $pie_query = $this->Student->query("SELECT COUNT(*) AS total,standard_id FROM `students` WHERE school_id = '".CakeSession::read('Auth.User.school_id')."' GROUP BY standard_id");
        //pr($pie_query);die;
        if($pie_query) {
            foreach ($pie_query as $result) {
                //print_r($result)."<br/>";
                $standard_count[$result['students']['standard_id']]['y'] = (int)$result[0]['total'];
            }
        }

        foreach($standard_count as $val){
            $standard_val[] = $val;
        }

        //pr($standard_val);die;

        $this->set('standard_count',json_encode($standard_val));

        $students = $this->Student->find('all',array(
            'conditions' => array('Student.school_id' => CakeSession::read('Auth.User.school_id')),
            'order' => array('Student.id DESC')
        ));

        $this->set('students',$students);
    }

    public function getSuggestion() {

        $return = [];
        if(isset($this->request->query['filter_name'])){

            $students = $this->Student->find('all',array(
                'conditions' => array('Student.first_name LIKE' => $this->request->query['filter_name'] . '%','Student.school_id' => CakeSession::read('Auth.User.school_id'))
            ));

            //pr($students);die;
            if($students){
                foreach($students as $student){
                    $return[] = array(
                        'student_id' => $student['Student']['id'],
                        'student_name' => $student['Student']['first_name'],
                        'standard_id' => $student['Standard']['id'],
                        'standard_name' => $student['Standard']['name'],
                        'section_id' => $student['Section']['id'],
                        'section_name' => $student['Section']['name'],
                    );
                }
                //pr($return);die;
            }
        }
        echo json_encode($return);
        $this->autoRender = false;
    }

    public function upload() {

        $upload_dir = WWW_ROOT.'uploads/excel/';

        //pr($_FILES['excel_file']);die;
        if(isset($_FILES['excel_file']) && $_FILES['excel_file']){
            $file_name = $_FILES['excel_file']['name'];
            $file_detail = explode('.',$file_name);

            $upload_path = $upload_dir.$file_name;

            if(file_exists($upload_path)){
                $file_name = $file_detail[0].'_'.rand(1,10000).$file_detail[1];
                $upload_path = $upload_dir.$file_name;
            }

            move_uploaded_file($_FILES['excel_file']['tmp_name'],$upload_path);

            $objPHPExcel = IOFactory::load($upload_path);

            $this->processWordFile($objPHPExcel);
        }
    }

    public function processWordFile($excel) {

        $sheetData = $excel->getActiveSheet()->toArray(null,true,true,true,true,true,true,true,true,true,true);

        //pr($sheetData[1]);die;
        //echo $sheetData[]['A']."<br/>";$sheetData[1]['B']."<br/>";$sheetData[1]['C']."<br/>";$sheetData[1]['D']."<br/>";

        if((trim($sheetData[1]['B'])=="First name")) {

            unset($sheetData[1]);

            $userClass = ClassRegistry::init('User');

            foreach($sheetData as $rec) {

                $this->loadModel('Standard');
                $standard = $this->Standard->find('first',array(
                   'conditions' => array('Standard.name LIKE' => $rec['I'],'Standard.school_id' => CakeSession::read("Auth.User.school_id"))
                ));

                $standard_id = $section_id = 0;
                if($standard){
                    $standard_id = $standard['Standard']['id'];

                    $this->loadModel('StandardSectionMap');
                    $section = $this->StandardSectionMap->find('first',array(
                        'conditions' => array('StandardSectionMap.standard_id' => $standard_id,'Section.name LIKE' => $rec['J'])
                    ));

                    if($section){
                        $section_id = $section['Section']['id'];
                    }
                }

                $email_available = $userClass->find('first',array(
                   'conditions' => array('User.email' => $rec['D'])
                ));

                if(!$email_available) {
                    $this->Student->create();
                    $this->Student->save(array(
                        'school_id' => CakeSession::read("Auth.User.school_id"),
                        'standard_id' => $standard_id,
                        'section_id' => $section_id,
                        'admission_number' => $rec['K'],
                        'roll_number' => $rec['L'],
                        'first_name' => $rec['B'],
                        'last_name' => $rec['C'],
                        'contact_number' => $rec['E'],
                        'address' => ($rec['G']) ? $rec['G'] : NULL,
                        'gender' => ($rec['H']) ? $rec['H'] : NULL,
                        'birthdate' => $rec['F'],
                        'is_active' => 1,
                        'date_added' => date("Y-m-d H:i:s"),
                        'date_modified' => date("Y-m-d H:i:s"),
                    ));

                    $data['username'] = substr($rec['B'], 0, 3) . $this->Student->id;
                    $data['email'] = $rec['D'];
                    $data['password'] = 'demo';
                    $data['role_id'] = 4;

                    $userClass->create();
                    $userClass->save($data);

                    $user_id = $userClass->id;

                    $this->Student->saveField('user_id', $user_id);
                }
            }
        }

        $json['success'] = 'Successfully Inserted';

        echo json_encode($json);

        $this->autoRender = false;
    }

    public function profile() {

        if(isset($this->request->query['student_id'])) {

            $this->set('student_id',$this->request->query['student_id']);

            $student_detail = $this->Student->findById($this->request->query['student_id']);

            if(!isset($student_detail)){
                $this->redirect(array('controller' => 'students','action' => 'index'));
            }

            $this->set('student_detail',$student_detail);

            $this->loadModel('FeeStandardMap');
            $fees = $this->FeeStandardMap->find('all',array(
                'conditions' => array('FeeStandardMap.standard_id' => $student_detail['Standard']['id'])
            ));

            $this->loadModel('StudentFeeMap');
            //pr($fees);die;
            if($fees){
                foreach($fees as $fee){
                    $student_fee_details = $this->StudentFeeMap->find('first',array(
                        'conditions' => array('StudentFeeMap.student_id' => $this->request->query['student_id'],'StudentFeeMap.fee_id' => $fee['Fee']['id']),
                        'fields' => array('SUM(StudentFeeMap.amount) as paid_amount'),
                        'group' => array('StudentFeeMap.fee_id')
                    ));

                    $total = $fee['FeeStandardMap']['amount'];

                    if($student_fee_details){
                        $total_remaining = ($total - $student_fee_details[0]['paid_amount']);
                    }else{
                        $total_remaining = $total;
                    }

                    $fee_detail[] = array(
                        'fee_id' => $fee['Fee']['id'],
                        'fee_name' => $fee['Fee']['name'],
                        'due_date' => $fee['Fee']['due_date'],
                        'total' => $total,
                        'remaining' => $total_remaining,
                    );
                }

                $this->set('fee_detail',$fee_detail);

                $payment_history = $this->StudentFeeMap->find('all',array(
                    'conditions' => array('StudentFeeMap.student_id' => $this->request->query['student_id'])
                ));

                $this->set('payment_history',$payment_history);
            }


            //Timetable
            $this->loadModel('Timing');
            $timing = $this->Timing->find('all',array(
                'conditions' => array('Timing.standard_id' => $student_detail['Standard']['id'],'Timing.section_id' => $student_detail['Section']['id'],'Timing.is_delete' => 0)
            ));

            $this->loadModel('Day');
            $days = $this->Day->find('all',array(
                'order' => array('Day.id' => 'ASC')
            ));
            $this->set('days',$days);

            $this->loadModel('Timetable');

            if($timing){
                foreach($timing as $time_val) {
                    $assign = [];
                    foreach($days as $day) {
                        $detail = $this->Timetable->find('first',array(
                            'conditions' => array('day_id' => $day['Day']['id'],'class_timing_id' => $time_val['Timing']['id'])
                        ));

                        $subject = [];
                        $staff = [];
                        if($detail){
                            $subject = array(
                                'id' => $detail['Subject']['id'],
                                'name' => $detail['Subject']['name']
                            );
                            $staff = array(
                                'id' => $detail['Staff']['id'],
                                'name' => $detail['Staff']['first_name'].' '.$detail['Staff']['last_name']
                            );
                        }
                        $assign[$day['Day']['name']] = array(
                            'day_id' => $day['Day']['id'],
                            'subject' => $subject,
                            'staff' => $staff,
                            'time_table_id' => isset($detail['Timetable']['id']) ? $detail['Timetable']['id'] : 0
                        );
                    }

                    $timetable[] = array(
                        'timing_id' => $time_val['Timing']['id'],
                        'time' => date("h:i A", strtotime($time_val['Timing']['start_time'])) . " - " . date("h:i A", strtotime($time_val['Timing']['end_time'])),
                        'days' => $assign,
                        'name' => $time_val['Timing']['name'],
                        'is_break' => $time_val['Timing']['is_break']
                    );
                }

                $this->set('timetable',$timetable);
            }

            $this->loadModel('SubjectTeacherMap');
            $this->SubjectTeacherMap->recursive = 1;
            $staff_subject_details = $this->SubjectTeacherMap->find('all',array(
                'conditions' => array('StandardSectionMap.standard_id' => $student_detail['Standard']['id'],'StandardSectionMap.section_id' => $student_detail['Section']['id'])
            ));

            $this->set('staff_subject_details',$staff_subject_details);

            $month = date("m");
            $year = date("Y");

            $this->set('month',$month);
            $this->set('year',$year);

            //pr($staff);die;
        }
    }

    public function getMonthlyAttendance() {

        $date = $this->request->data['date'];

        $month = date("m",strtotime($date));
        $year = date("Y",strtotime($date));

        //echo $month."==".$year;die;
        $number = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $calendar = [];
        for($i=1;$i<=$number;$i++){

            $day = date("D",strtotime(($year . "-" . $month . "-" .  $i)));
            if($day == 'Sun') {
                $status = 'WO';
                $color = 'red';
            }else{
                $status = '-';
                $color = '#074979';
            }

            $calendar[date("d",strtotime(($year . "-" . $month . "-" .  $i)))] = array(
                'day' => $day,
                'status' => $status,
                'color' => $color
            );
        }

        //pr($calendar);die;

        $start_date = $year . '-'.$month.'-1';
        $end_date = $year . '-'.$month.'-'.$number;

        $this->loadModel('Attendance');
        $this->Attendance->recursive = -1;
        $attendance = $this->Attendance->find('all',array(
           'conditions' => array('Attendance.student_id' => $this->request->data['student_id'],'Attendance.attendance_date >=' => $start_date, 'Attendance.attendance_date <=' => $end_date  )
        ));

        //pr($attendance);die;

        if($attendance) {
            foreach ($attendance as $val) {
                if ($val['Attendance']['attendance_status']) {
                    $calendar[date("d", strtotime($val['Attendance']['attendance_date']))]['status'] = 'P';
                } else {
                    $calendar[date("d", strtotime($val['Attendance']['attendance_date']))]['status'] = 'A';
                }
            }
        }

        $this->set('calendar',$calendar);

        $this->view = 'attendance';
        $this->layout = 'ajax';
        //pr($calendar);die;
    }

    public function delete() {

        if(isset($this->request->data['student_id'])) {
            $this->Student->deleteAll(array('Student.id' => $this->request->data['student_id']));

            $this->loadModel('Attendance');
            $this->Attendance->deleteAll(array('Attendance.student_id' => $this->request->data['student_id']));

            $this->loadModel('Remark');
            $this->Remark->deleteAll(array('Remark.student_id' => $this->request->data['student_id']));

            $this->loadModel('Result');
            $this->Result->deleteAll(array('Result.student_id' => $this->request->data['student_id']));

            $this->loadModel('StudentFeeMap');
            $this->StudentFeeMap->deleteAll(array('StudentFeeMap.student_id' => $this->request->data['student_id']));

            $this->Session->setFlash('Student Successfully Deleted','flash');
            $this->redirect(array('controller' => 'students','action' => 'index'));
        }
    }
	
	public function services_getStudentList() {

        //echo "asda";die;
        if($this->request->is('post') && isset($this->request->data['standard_id']) && isset($this->request->data['section_id'])){

                $this->loadModel('Student');
                $this->Student->recursive = 0;
                $students = $this->Student->find('all', array(
                    'conditions' => array(
                        'Student.standard_id' => $this->request->data['standard_id'],
                        'Student.section_id' => $this->request->data['section_id'],
                    ),
                ));

                //pr($students);die;

                if($students) {

                    foreach($students as $student){
                        $details[] = array(
                           'firstname' => $student['Student']['first_name'],
                           'lastname' => $student['Student']['last_name'],
                           'schoolname' => $student['School']['name'],
                           'studentId' => $student['Student']['id'],
                           'mobilenumber' => $student['Student']['contact_number'],
                           'address' => $student['Student']['address'],
						   'attendance' => true,
                        );
                    }

                    $data = $this->Student->formatMessages('Login Successfully',true,$details);
                }else{
                    $data = $this->Student->formatMessages('Failed to login. Invalid username or password');
                }

        }else{
            $data = $this->Student->formatMessages('Parameter missing');
        }

        $this->set('data',$data);
    }
}