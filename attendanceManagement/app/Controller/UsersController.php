<?php
/**
 * Created by PhpStorm.
 * User: deep.gandhi
 * Date: 28-07-2015
 * Time: 18:26
 */

App::uses('AppController', 'Controller');


class UsersController extends AppController {

    private $error = array();

    public function login() {
        if($this->request->is('post')){
            //pr($this->request->data);die;
            if($this->Auth->login()){
                $this->redirect($this->Auth->loginRedirect);
                //redirect to dashboard
            }else{
                $this->set('error_msg','No match for Username and/or Password.');
            }
        }else if($this->Auth->login()) {
            $this->redirect($this->Auth->loginRedirect);
        }
    }

    public function logout() {
        if($this->Auth->login()){
            $this->Auth->logout();
            $this->redirect($this->Auth->logoutRedirect);
        }
    }

    public function index() {
        $this->getList();
    }

    public function add() {

        if($this->request->is('post') && $this->validateForm()){
            if($this->User->addUser($this->request->data)) {
                $this->Session->setFlash('User Added Successfully','flash');
                $this->redirect(array('controller' => 'users', 'action' => 'index'));
            }
        }

        $this->getForm();

        $this->view = 'form';
    }

    public function edit() {

        if($this->request->is('post') && $this->validateForm()){
            if($this->User->updateUser($this->request->data,$this->request->data['user_id'])) {
                $this->Session->setFlash('User Updated Successfully','flash');
                $this->redirect(array('controller' => 'users', 'action' => 'index'));
            }
        }

        $this->getForm();

        $this->view = 'form';
    }

    public function services_login() {

        //echo "asda";die;
        if($this->request->is('post') && isset($this->request->data['username']) && isset($this->request->data['password'])){

				$hash_password = AuthComponent::password($this->request->data['password']);

                $this->loadModel('Staff');
                $this->Staff->recursive = 0;
                $staffList = $this->Staff->find('all', array(
                    'conditions' => array(
                        'User.username' => $this->request->data['username'],
                        'User.password' => $hash_password
                    ),
                ));

                //pr($students);die;

                if($staffList) {

                    foreach($staffList as $staff){
                        $details[] = array(
                           'firstname' => $staff['Staff']['first_name'],
                           'lastname' => $staff['Staff']['last_name'],
                           'schoolname' => $staff['School']['name'],
                           'staffId' => $staff['Staff']['id'],
                           'mobilenumber' => $staff['Staff']['contact_number'],
                           'address' => $staff['Staff']['address'],
						   'profilePic' => $staff['Staff']['profile_pic'],
                           'standard' => '',

                        );
                    }
					/* $details[] = array(
                           'firstname' => 'Avanit',
                           'lastname' => 'Kaushal',
                           'schoolname' => 'Shaishav',
                           'staffId' => '123',
                           'mobilenumber' => '7878155823',
                           'address' => 'dsasdsadasd',
                           'standard' => '',

                        ); */

                    $data = $this->User->formatMessages('Login Successfully',true,$details);
                }else{
                    $data = $this->User->formatMessages('Failed to login. Invalid username or password');
                }

        }else{
            $data = $this->User->formatMessages('Parameter missing');
        }

        $this->set('data',$data);
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
                    $data = $this->User->formatMessages('Assignment details',true,$standard_detail);
                }else{
                    $data = $this->User->formatMessages('No standard available',true);
                }

        }else{
            $data = $this->User->formatMessages('Parameters missing');
        }

        $this->set('data',$data);
    
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
						   'profilePic' => $student['Student']['profile_pic'],
						   'attendance' => true,
                        );
                    } 

					 /* $details[] = array(
                           'firstname' => 'Avanit',
                           'lastname' => 'Kaushal',
                           'schoolname' => 'Shaishav',
                           'studentId' => '123',
                           'mobilenumber' => '7878155823',
                           'address' => 'dsasdsadasd',
                           'standard' => '',
						   'attendance' => true,
                        ); */
						
                    $data = $this->User->formatMessages('Login Successfully',true,$details);
                } else{
                    $data = $this->User->formatMessages('Failed to login. Invalid username or password');
                } 

       } else{
            $data = $this->User->formatMessages('Parameter missing');
        }

        $this->set('data',$data);
    }
	
}