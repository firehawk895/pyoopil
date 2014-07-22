<?php

/**
 * (c) Pyoopil EduTech 2014
 */
App::uses('UsersController', 'Users.Controller');

class AppUsersController extends UsersController {

    public $name = 'AppUsers';

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Security->unlockedActions = array('login');
        $this->User = ClassRegistry::init('AppUser');
        $this->set('model', 'AppUser');
        $this->layout = 'ajax';
        $this->Auth->allow('login');
    }

    protected function _setupAuth() {
        //parent::_setupAuth();
/*        $this->Auth->loginAction = array(
            'plugin' => null,
            'admin' => false,
            'controller' => 'app_users',
            'action' => 'login'
        );*/
/*        $this->Auth->loginRedirect = array(
            'plugin' => null,
            'admin' => false,
            'controller' => 'classrooms',
            'action' => 'index'
        );*/
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

        $this->RequestHandler->renderAs($this, 'json');
        $this->response->type('json');

        $data = array();
        $status = false;

        if($this->request->is('post')){
            $this->log($this->request);
            $user = $this->AppUser->authenticate($this->request->data);
            if($user){
                $token = $this->AppUser->generateAuthToken();
                $this->AppUser->id = $user['AppUser']['id'];

                if($this->AppUser->saveField('auth_token', $token)){
                    $status = true;
                    $data['auth_token'] = $token;
                    $message = "Login successful";
                }
            }
            else{
                $message = "Login unsuccessful";
            }
        }

        $this->set(compact('status', 'message'));
        $this->set('data', $data);
        $this->set('_serialize', array('data', 'status', 'message'));
    }

    public function logout(){
        $this->response->type('json');

        $this->Session->destroy();



        $data = array();
        $this->set(compact('status', 'message'));
        $this->set('data', $data);
        $this->set('_serialize', array('data', 'status', 'message'));
    }
}
