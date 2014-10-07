<?php

/**
 * (c) Pyoopil EduTech 2014
 */
App::uses('UsersController', 'Users.Controller');
App::uses('CodeGenerator', 'Lib/Custom');

class AppUsersController extends UsersController {

    public $name = 'AppUsers';

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->authorize = array('Controller');
        $this->Security->unlockedActions = array('login', 'logout', 'add');
        $this->User = ClassRegistry::init('AppUser');
        $this->set('model', 'AppUser');
        $this->Auth->allow('login', 'add', 'reset_password');

        $this->response->header('Access-Control-Allow-Origin', '*');
        $this->response->header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
        $this->response->header('Access-Control-Allow-Headers', 'X-AuthTokenHeader,X-Auth-Token,Authorization,Content-Type,Accept,Origin,User-Agent,DNT,Cache-Control,X-Mx-ReqToken,Keep-Alive,X-Requested-With,If-Modified-Since');

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

        if ($this->request->is('post')) {
            $user = $this->AppUser->authenticate($this->request->data);
            if ($user) {
                $token = $this->AppUser->generateAuthToken();
                $this->AppUser->id = $user['AppUser']['id'];
                $saveData['AppUser']['auth_token'] = $token;
                $saveData['AppUser']['auth_token_expires'] = $this->AppUser->authTokenExpirationTime();

                if ($this->AppUser->save($saveData, false)) {
                    $this->AppUser->updateLastActivity($user['AppUser']['id']);
                    $status = true;
                    $theQuery = $this->AppUser->find('first', array(
                        'conditions' => array(
                            'AppUser.id' => $this->AppUser->id
                        ),
                        'fields' => array(
                            'profile_img'
                        )
                    ));
                    $data['profile_img'] = $theQuery['AppUser']['profile_img'];
                    $data['auth_token'] = $token;
                    $data['fullname'] = $this->AppUser->getFullName($user['AppUser']['id']);
                    $data['id'] = $user['AppUser']['id'];
                    $message = "Login successful";
                }
            } else {
                $message = "Login unsuccessful";
            }
        }

        $this->set(compact('status', 'message'));
        $this->set('data', $data);
        $this->set('_serialize', array('data', 'status', 'message'));
    }

    public function logout() {
        $this->RequestHandler->renderAs($this, 'json');
        $this->response->type('json');

        $data = array();
        $status = false;

        if ($this->request->is('post')) {
            $status = $this->AppUser->deleteAuthToken(AuthComponent::User());
            $this->Session->destroy();

            if ($status) {
                $message = "Logout successful.";
            } else {
                $message = "Logout unsuccessful.";
            }
        }

        $this->set(compact('status', 'message'));
        $this->set('data', $data);
        $this->set('_serialize', array('data', 'status', 'message'));
    }

    /**
     * @param string $type
     * @param null $token
     */
    public function verify($type = 'email', $token = null) {
        if ($type == 'reset') {
            // Backward compatiblity
            $this->request_new_password($token);
        }

        try {
            $this->{$this->modelClass}->verifyEmail($token);
            $this->Session->setFlash(__d('users', 'Your e-mail has been validated!'));
            return $this->redirect('/');
        } catch (RuntimeException $e) {
            $this->Session->setFlash($e->getMessage());
            return $this->redirect('/');
        }
    }

    public function add() {
        $this->RequestHandler->renderAs($this, 'json');
        $this->response->type('json');

        $data = array();
        $status = false;
        $message = "";

        $postData = $this->request->data;
        if (!empty($postData)) {
            $postData['AppUser']['username'] = CodeGenerator::accessCode('alpha', '10');
            //The sweetest way to do this
            $this->AppUser->set($postData);
            if ($this->AppUser->validates()) {
                $postData['AppUser']['password'] = $this->AppUser->hash($postData['AppUser']['password'], 'sha1', true);
//                $this->AppUser->create();
                $this->AppUser->save($postData, false);
                $status = true;
                $message = "Your account has been created.";
            } else {
                $message = $this->AppUser->validationErrors;
            }
        }

        $this->set(compact('status', 'message'));
        $this->set('data', $data);
        $this->set('_serialize', array('data', 'status', 'message'));
    }

    public function isAuthorized($user = null) {
        if ($user) {
            return true;
        } else {
            return false;
        }
    }
}
