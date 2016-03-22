<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 07-09-2015
 * Time: 11:04 AM
 */

App::uses('AppController', 'Controller');

class StaffsController extends AppController {

    private $error = array();

    public $paginate = array(
        'limit' => 15,
        'order' => array(
            'Staff.id' => 'DESC'
        )
    );

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

            if($this->Staff->add($this->request->data)) {
                $this->Session->setFlash('Staff Added Successfully','flash');
                $this->redirect(array('controller' => 'staffs', 'action' => 'index'));
            }
        }

        $this->getForm();

        $this->view = 'form';
    }

    public function edit() {

        //pr($this->request->data);die;
        if($this->request->is('post') && $this->validateForm()){

            if(!isset($this->request->data['active'])){
                $this->request->data['is_active'] = 0;
            }else{
                $this->request->data['is_active'] = 1;
            }

            if($this->Staff->update($this->request->data,$this->request->data['staff_id'])) {
                $this->Session->setFlash('Staff Updated Successfully','flash');
                $this->redirect(array('controller' => 'staffs', 'action' => 'index'));
            }
        }

        $this->getForm();

        $this->view = 'form';
    }

    public function getList() {

        //$this->School->query("SET CHARACTER SET utf8;");

        $is_filter = false;

        $filter = array('Staff.is_delete' => 0,'Staff.school_id' => CakeSession::read('Auth.User.school_id'),'User.role_id' => 3);
        if(isset($this->request->query['filter_name']) && $this->request->query['filter_name']){
            $is_filter = true;
            $filter['CONCAT (Staff.first_name," ",Staff.last_name) LIKE'] = '%'.$this->request->query['filter_name'] .'%';
        }

        if(isset($this->request->query['filter_emp_id']) && $this->request->query['filter_emp_id']){
            $is_filter = true;
            $filter['Staff.emp_id'] = $this->request->query['filter_emp_id'];
        }

        $this->Paginator->settings = $this->paginate;
        $data = $this->Paginator->paginate('Staff',$filter);

        //pr($data);die;
        $this->set('staffs',$data);
        $this->set('is_filter',$is_filter);

    }

    public function getForm() {

        if(isset($this->request->data['staff_id'])){
            $this->set('staff_id',$this->request->data['staff_id']);
            $this->set('user_id',$this->request->data['user_id']);
        } else if(isset($this->request->query['staff_id']) && $this->request->query['staff_id']) {

            //$this->School->query("SET CHARACTER SET utf8;");
            $details = $this->Staff->find('first',array(
                'conditions' => array('Staff.id' => $this->request->query['staff_id'])
            ));
            $this->set('staff_id',$this->request->query['staff_id']);

            //for username & password
            $this->loadModel('User');
            $this->User->recursive = -2;
            $user_details = $this->User->find('first',array(
                'conditions' => array('User.id' => $details['Staff']['user_id'])
            ));
            //pr($user_details);die;
            $this->set('user_id',$user_details['User']['id']);

        }else{
            $this->set('staff_id','');
            $this->set('user_id','');
        }

        if(isset($this->request->data['first_name'])){
            $this->set('first_name',$this->request->data['first_name']);
        }else if(isset($details['Staff']['first_name'])){
            $this->set('first_name',$details['Staff']['first_name']);
        }else{
            $this->set('first_name','');
        }

        if(isset($this->request->data['last_name'])){
            $this->set('last_name',$this->request->data['last_name']);
        }else if(isset($details['Staff']['last_name'])){
            $this->set('last_name',$details['Staff']['last_name']);
        }else{
            $this->set('last_name','');
        }

        if(isset($this->request->data['address'])){
            $this->set('address',$this->request->data['address']);
        }else if(isset($details['Staff']['address'])){
            $this->set('address',$details['Staff']['address']);
        }else{
            $this->set('address','');
        }

        if(isset($this->request->data['contact_number'])){
            $this->set('contact_number',$this->request->data['contact_number']);
        }else if(isset($details['Staff']['contact_number'])){
            $this->set('contact_number',$details['Staff']['contact_number']);
        }else{
            $this->set('contact_number','');
        }

        if(isset($this->request->data['qualification'])){
            $this->set('qualification',$this->request->data['qualification']);
        }else if(isset($details['Staff']['qualification'])){
            $this->set('qualification',$details['Staff']['qualification']);
        }else{
            $this->set('qualification','');
        }

        if(isset($this->request->data['type'])){
            $this->set('type',$this->request->data['type']);
        }else if(isset($details['Staff']['type'])){
            $this->set('type',$details['Staff']['type']);
        }else{
            $this->set('type','');
        }

        if(isset($this->request->data['role_id'])){
            $this->set('role_id',$this->request->data['role_id']);
        }else if(isset($user_details['Role']['id'])){
            $this->set('role_id',$user_details['Role']['id']);
        }else{
            $this->set('role_id','');
        }

        $this->loadModel('Role');
        $roles = $this->Role->find('all',array(
            'conditions' => array('Role.id != 1','Role.id != 4')
        ));
        $this->set('roles',$roles);
        //pr($roles);die;

        if(isset($this->request->data['profile_pic'])){
            $this->set('profile_pic',$this->request->data['profile_pic']);
        }else if(isset($details['Staff']['profile_pic'])){
            $this->set('profile_pic',$details['Staff']['profile_pic']);
        }else{
            $this->set('profile_pic','');
        }

        if(isset($this->request->data['gender'])){
            $this->set('gender',$this->request->data['gender']);
        }else if(isset($details['Staff']['gender'])){
            $this->set('gender',$details['Staff']['gender']);
        }else{
            $this->set('gender','');
        }

        if(isset($this->request->data['birthdate'])){
            $this->set('birthdate',$this->request->data['birthdate']);
        }else if(isset($details['Staff']['birthdate'])){
            $this->set('birthdate',$details['Staff']['birthdate']);
        }else{
            $this->set('birthdate','');
        }

        if(isset($this->request->data['emp_id'])){
            $this->set('emp_id',$this->request->data['emp_id']);
        }else if(isset($details['Staff']['emp_id'])){
            $this->set('emp_id',$details['Staff']['emp_id']);
        }else{
            $this->set('emp_id','');
        }

        if(isset($this->request->data['joining_date'])){
            $this->set('joining_date',$this->request->data['joining_date']);
        }else if(isset($details['Staff']['joining_date'])){
            $this->set('joining_date',$details['Staff']['joining_date']);
        }else{
            $this->set('joining_date','');
        }

        if(isset($this->request->data['basic_salary'])){
            $this->set('basic_salary',$this->request->data['basic_salary']);
        }else if(isset($details['Staff']['basic_salary'])){
            $this->set('basic_salary',$details['Staff']['basic_salary']);
        }else{
            $this->set('basic_salary','');
        }

        if(isset($this->request->data['experience'])){
            $this->set('experience',$this->request->data['experience']);
        }else if(isset($details['Staff']['experience'])){
            $this->set('experience',$details['Staff']['experience']);
        }else{
            $this->set('experience','');
        }

        if(isset($this->request->data['active'])){
            $this->set('active',$this->request->data['active']);
        }else if(isset($details['Staff']['is_active'])){
            $this->set('active',$details['Staff']['is_active']);
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

        //get all standards
        $this->loadModel('Standard');
        $this->set('standards',$this->Standard->getStandards());

        //get all subjects
        $this->loadModel('Subject');
		$this->set('subjects',$this->Subject->getAllSubjects());
        //$this->set('subjects',$this->Subject->find('all',array('conditions' => CakeSession::read('Auth.User.school_id'))));

        //subjects
        if(isset($this->request->data['staff_subjects'])) {
            $this->set('staff_subjects',$this->request->data['staff_subjects']);
        }else if(isset($this->request->query['staff_id'])){
            $this->loadModel('StaffSubjectMap');

            $staff_subjects_map = $this->StaffSubjectMap->find('all', array(
                'conditions' => array('StaffSubjectMap.staff_id' => $this->request->query['staff_id'])
            ));

            $staff_subjects = [];
            if($staff_subjects_map){
                foreach($staff_subjects_map as $map){
                    $staff_subjects[] = $map['StaffSubjectMap']['subject_id'];
                }
            }

            //pr($staff_subjects);die;
            $this->set('staff_subjects',$staff_subjects);
        }else{
            $this->set('staff_subjects',array());
        }

        //errors
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

        if (isset($this->error['emp_id'])) {
            $this->set('error_emp_id',$this->error['emp_id']);
        } else {
            $this->set('error_emp_id','');
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
    }

    public function validateForm() {

        if (strlen($this->request->data['first_name']) < 3) {
            $this->error['first_name'] = 'First name must be greater than 2 characters';
        }

        if (strlen($this->request->data['last_name']) < 3) {
            $this->error['last_name'] = 'Last name must be greater than 2 characters';
        }

        if (strlen($this->request->data['contact_number']) < 3 || !is_numeric($this->request->data['contact_number'])) {
            $this->error['contact_number'] = 'Contact number must be greater than 3 characters & In Numeric format';
        }

        if (!$this->request->data['emp_id']) {
            $this->error['emp_id'] = 'Invalid Employee Id';
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
                $this->error['email'] = 'Email already exists! Please try another email';
            }
        }

        /*if (strlen($this->request->data['username']) < 3 || strlen($this->request->data['username']) > 10) {
            $this->error['username'] = 'Invalid username';
        }else{
            $this->loadModel('User');

            $condition = array('User.username LIKE' => $this->request->data['username']);

            if(isset($this->request->data['user_id'])){
                $condition['User.id'] = '<> '.$this->request->data['user_id'];
            }

            $udetails = $this->User->find('first',array(
                'conditions' => $condition
            ));

            if($udetails){
                $this->error['username'] = 'Username already exists! Please try another username';
            }
        }*/

        /*if(!isset($this->request->data['staff_id'])){
            if (strlen($this->request->data['password']) < 3 || strlen($this->request->data['password']) > 10) {
                $this->error['password'] = 'Password must be between 4 to 10 character long';
            }
        }else if($this->request->data['staff_id'] && $this->request->data['password']){
            if (strlen($this->request->data['password']) < 3 || strlen($this->request->data['password']) > 10) {
                $this->error['password'] = 'Password must be between 4 to 10 character long';
            }
        }*/

        if($this->error){
            $this->error['warning'] = 'Please Check Below Errors';
        }

        return !$this->error;
    }


    public function profile() {

        if(isset($this->request->query['staff_id'])) {

            $this->set('staff_id',$this->request->query['staff_id']);

            $staff_detail = $this->Staff->findById($this->request->query['staff_id']);

            if(!isset($staff_detail)){
                $this->redirect(array('controller' => 'staff','action' => 'index'));
            }

            //pr($staff_detail);die;
            $this->set('staff_detail',$staff_detail);

            $this->loadModel('Timing');
            $timing = $this->Timing->find('all',array(
                //'conditions' => array('Timing.standard_id' => $student_detail['Standard']['id'],'Timing.section_id' => $student_detail['Section']['id'],'Timing.is_delete' => 0)
            ));

            $this->loadModel('Day');
            $days = $this->Day->find('all',array(
                'order' => array('Day.id' => 'ASC')
            ));

            //pr($days);die;
            $this->set('days',$days);

            $assign = [];
            $this->loadModel('Timetable');
            foreach($days as $day) {
                $this->Timetable->recursive = 2;
                $detail = $this->Timetable->find('all', array(
                    'conditions' => array('day_id' => $day['Day']['id'], 'staff_id' => $this->request->query['staff_id'])
                ));
                //pr($detail);die;

                if($detail) {
                    foreach($detail as $val) {
                        $assign[$day['Day']['name']][] = array(
                            'day_id' => $day['Day']['id'],
                            'start_time' => date("h:i A", strtotime($val['Timing']['start_time'])),
                            'end_time' => date("h:i A", strtotime($val['Timing']['end_time'])),
                            'subject' => $val['Subject']['name'],
                            'standard' => isset($val['Timing']['Standard']['name']) ? $val['Timing']['Standard']['name'] : '-',
                            'section' => isset($val['Timing']['Section']['name']) ? $val['Timing']['Section']['name'] : '-',
                            'time_table_id' => isset($val['Timetable']['id']) ? $val['Timetable']['id'] : 0
                        );
                    }
                }
            }

            $this->set('timetable',$assign);
            //pr($assign);die;
        }
	}
	
	public function services_getCluster() {

        if(isset($this->request->data['staff_id'])){
			
            $this->loadModel('SubjectTeacherMap');
			$standard_detail = $this->SubjectTeacherMap->getStandardsByStaffId($this->request->data['staff_id']);

			/* if(isset($this->request->query['standard_id'])){
				$this->set('standard_id',$this->request->query['standard_id']);
			}else{
				$this->set('standard_id','');
			} */

            if($standard_detail){
                    $data = $this->Assignment->formatMessages('Assignment details',true,$standard_detail);
                }else{
                    $data = $this->Assignment->formatMessages('No standard available',true);
                }

        }else{
            $data = $this->Assignment->formatMessages('Parameters missing');
        }

        $this->set('data',$data);
    
    }
}