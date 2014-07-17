<?php

/**
 * (c) Pyoopil EduTech 2014
 */
App::uses('UsersController', 'Users.Controller');

class AppUsersController extends UsersController {

    public $name = 'AppUsers';

    public function beforeFilter() {
        parent::beforeFilter();
        $this->User = ClassRegistry::init('AppUser');
        $this->set('model', 'AppUser');
        $this->layout = 'ajax';
        $this->Auth->allow('login');
        
    }

    protected function _setupAuth() {
        parent::_setupAuth();
        $this->Auth->loginAction = array(
            'plugin' => null,
            'admin' => false,
            'controller' => 'app_users',
            'action' => 'login'
        );
        $this->Auth->loginRedirect = array(
            'plugin' => null,
            'admin' => false,
            'controller' => 'classrooms',
            'action' => 'index'
        );
        $this->Auth->logoutRedirect = array(
            'plugin' => null,
            'admin' => false,
            'controller' => 'pages',
            'action' => array('display', 'feedback')
        );

        $this->Auth->authorize = array(
            'Actions' => array('actionPath' => 'controllers')
        );
    }
    
    public function login() {
        parent::login();
        //$this->response->type('json');

        $status = $this->Auth->loggedIn();

        if($status){
            $message = "Login successful";
        }else{
            $message = "Login unsuccessful";
        }

        $data = array();
        $this->set(compact('status', 'message'));
        $this->set('data', $data);
        $this->set('_serialize', array('data', 'status', 'message'));
    }

    public function logout(){
        $this->response->type('json');

        $this->Session->destroy();
        $this->RememberMe->destroyCookie();

        $this->Auth->logout();

        $status = !$this->Auth->loggedIn();

        if($status){
            $message = "Logout successful";
        }else{
            $message = "Logout unsuccessful";
        }

        $data = array();
        $this->set(compact('status', 'message'));
        $this->set('data', $data);
        $this->set('_serialize', array('data', 'status', 'message'));
    }
}
