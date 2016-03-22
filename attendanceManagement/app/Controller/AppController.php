<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 */
class AppController extends Controller {

    public $components = array(
        'Auth' => array(

        ),
        'Paginator',
        'Session'
    );

    protected $actions = array(
        'add' => 1,
        'edit' => 2,
        'delete' => 3,
        'index' => 4 // view
    );

    /**
     * 1 = Superadmin
     * 2 = School Admin
     * 3 = School Staff
     * 4 = Students
     */
    protected  $roles = array(1,2,3,4);

    public function beforeFilter() {

        if (Router::getParam('prefix', true) == 'services') {
            //echo "Aa";die;
            $this->Auth->allow();
            $this->setAjaxLayout();
        }else{
            $this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
            $this->Auth->loginRedirect = array(
                'controller' => 'dashboard',
                'action' => 'index'
            );
            $this->Auth->logoutRedirect = array(
                'controller' => 'users',
                'action' => 'login',
            );
            //echo $this->params['action'];die;


            if(CakeSession::read("Auth.User.id")) {
                /*$this->loadModel('Role');
                //pr($this->User->getPermission());die;
                $valid = $this->Role->checkPermission($this->params['controller']);
                $this->set('valid',$valid);

                $modules = $this->Role->getModules();*/
                //pr($modules);die;

                $this->loadModel('Role');
                $modules = $this->Role->getModules();

                $this->set('modules',$modules);
            }

            $this->set('valid',true);

            $this->layout = 'admin';
        }
    }


    public function setAjaxLayout() {
        $this->layout = 'ajax';
        $this->view = '../Elements/ajax';
    }

    public function beforeRender() {

        $layout = array(
            'controller'	=> $this->params['controller'],
            'action'		=> $this->params['action'],
            'loggedIn'		=> $this->Auth->login(),
            //'me'			=> ($this->Auth->login() ? $this->Auth->Admin() : null),
            'webroot'		=> $this->webroot,
        );

        $this->_jsvariables = array(
            'base_url' => Router::url('/')
        );

        //passing controller and action to layout and other layout variables
        $this->set('layout', $layout);
        $this->set('jsVars', $this->_jsvariables);


        $this->loadModel('User');

        //Set user's last login time
        if ($this->Auth->login()) {
            $this->User->id = CakeSession::read("Auth.User.id");
            $this->User->saveField('last_access', date('Y-m-d H:i:s'));
        }
    }
}