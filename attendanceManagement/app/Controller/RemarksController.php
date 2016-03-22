<?php
/**
 * Created by PhpStorm.
 * User: Deep Gandhi
 * Date: 07-09-2015
 * Time: 11:04 AM
 */

App::uses('AppController', 'Controller');

class RemarksController extends AppController {

    private $error = array();

    public $paginate = array(
        'limit' => 15,
        'order' => array(
            'Student.id' => 'DESC'
        )
    );

    public function index() {

        if(isset($this->request->query['student_id'])){
            $this->loadModel('Student');
            if($this->Student->findById($this->request->query['student_id'])){
                $this->view();
            }
        }

        $this->loadModel('SubjectTeacherMap');
        $this->set('standards',$this->SubjectTeacherMap->getStandards());
    }

    public function getStudentList() {

        if(isset($this->request->data['standard_id']) && $this->request->data['section_id']) {

            $this->set('standard_id',$this->request->data['standard_id']);
            $this->set('section_id',$this->request->data['section_id']);

            $this->loadModel('Student');

            $filter = array('Student.is_delete' => 0,'Student.standard_id' => $this->request->data['standard_id'],'Student.section_id' => $this->request->data['section_id']);

            $this->Paginator->settings = $this->paginate;
            $data = $this->Paginator->paginate('Student',$filter);

            $this->set('students',$data);
            $this->view = 'student_list';
            $this->layout = 'ajax';
        }
    }

    public function add() {

        //pr($this->request->data);die;
        //echo "SDasd";die;
        $return = array();

        if($this->request->is('post') && $this->validateForm()){
            if($this->Remark->add($this->request->data)) {
                $return['success'] = 'Successfully added';
            }
        }else{
            $return['error'] = $this->error['remark'];
        }

        echo json_encode($return);
        $this->autoRender = false;
    }

    public function view() {

        $UserClass = ClassRegistry::init('User');
        $staff = $UserClass->getLoggedUserDetails();

        $remarks = $this->Remark->find('all',array(
           'conditions' => array('Remark.student_id' => $this->request->data['student_id'],'Remark.staff_id' => $staff['Staff']['id'])
        ));

        //pr($remarks);die;
        $this->set('remarks',$remarks);

        $this->view = 'view';
        $this->layout = 'ajax';
    }

    public function getList() {

        $is_filter = false;

        $filter = array('Student.is_delete' => 0,'Student.school_id' => CakeSession::read('Auth.User.school_id'));
        if(isset($this->request->query['filter_name']) && $this->request->query['filter_name']){
            $is_filter = true;
            $filter['CONCAT (Staff.first_name," ",Staff.last_name) LIKE'] = '%'.$this->request->query['filter_name'] .'%';
        }

        if(isset($this->request->query['filter_roll_number']) && $this->request->query['filter_roll_number']){
            $is_filter = true;
            $filter['Student.roll_number'] = $this->request->query['filter_roll_number'];
        }

        if(isset($this->request->query['filter_standard']) && $this->request->query['filter_standard'] != ''){
            $is_filter = true;
            $filter['Student.standard_id'] = $this->request->query['filter_standard'];
        }

        if(isset($this->request->query['filter_section']) && $this->request->query['filter_section']){
            $is_filter = true;
            $filter['Student.section_id'] = $this->request->query['filter_section'];
        }

        $this->loadModel('Student');

        $this->Paginator->settings = $this->paginate;
        $data = $this->Paginator->paginate('Student',$filter);
        //pr($data);die;
        $this->loadModel('Standard');
        $this->set('standards',$this->Standard->getStandards());

        //pr($data);die;
        $this->set('students',$data);
        $this->set('is_filter',$is_filter);
    }

    public function validateForm() {

        if (strlen($this->request->data['remarks']) < 3) {
            $this->error['remark'] = 'Remarks length must be greater than 3 character';
        }

        return !$this->error;
    }


    public function services_getRemarks() {

        $this->loadModel('Assignment');

        if(isset($this->request->data['student_id'])){
            $this->loadModel('Student');

            $student_id = $this->request->data['student_id'];
            //$standard_detail = $this->Student->getStandardAndSection($this->request->data['student_id']);

            if($student_id){
                $this->Remark->recursive = -1;

                $dates = $this->Remark->find('all',array(
                    'conditions' => array('Remark.student_id' => $student_id),
                    'fields' => array('Remark.date_added'),
                    'group' => 'DATE(Remark.date_added)'
                ));

                //echo $this->Remark->getLastQuery();die;

                //pr($dates);die;
                if($dates){
                    foreach($dates as $date){
                        $remark_detail[] = array(
                            'isSection' => true,
                            'weekday' => date('l', strtotime($date['Remark']['date_added'])),
                            'date' => date("d",strtotime($date['Remark']['date_added'])),
                            'month' => date('F', strtotime($date['Remark']['date_added'])),
                            'year' => date('Y', strtotime($date['Remark']['date_added'])),
                            'title' => false,
                            'subTitle' => false,
                            'iconURI' => false,
                            'description' => false
                        );

                        $this->Remark->recursive = -2;


                        $remarks = $this->Remark->find('all',array(
                            'conditions' => array('Remark.student_id' => $student_id,'DATE(Remark.date_added)' => date("Y-m-d",strtotime($date['Remark']['date_added']))),
                            //'group' => array('Assignment.end_date')
                        ));

                        //echo $this->Remark->getLastQuery();die;
                        //pr($remarks);die;

                        foreach($remarks as $remark){
                            $remark_detail[] = array(
                                'isSection' => false,
                                'weekday' => date('l', strtotime($remark['Remark']['date_added'])),
                                'date' => date("d",strtotime($remark['Remark']['date_added'])),
                                'month' => date('F', strtotime($remark['Remark']['date_added'])),
                                'year' => date('Y', strtotime($remark['Remark']['date_added'])),
                                'title' => $remark['Remark']['title'],
                                'subTitle' => $remark['Staff']['first_name'].' '.$remark['Staff']['last_name'],
                                'iconURI' => false,
                                'description' => $remark['Remark']['remarks']
                            );
                        }

                        //pr($assignment_detail);die;
                    }

                    $data = $this->Remark->formatMessages('Remark details',true,$remark_detail);
                }else{
                    $data = $this->Remark->formatMessages('No Remarks available',true);
                }

            }else{
                $data = $this->Remark->formatMessages('Invalid Student id');
            }
        }else{
            $data = $this->Remark->formatMessages('Parameters missing');
        }

        $this->set('data',$data);
    }
}