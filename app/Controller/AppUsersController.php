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
    }

    protected function _setupAuth() {
        parent::_setupAuth();
//        $this->Auth->loginRedirect = array(
//            'plugin' => null,
//            'admin' => false,
//            'controller' => 'app_users',
//            'action' => 'login'
//        );
        $this->Auth->authorize = array(
            'Actions' => array('actionPath' => 'controllers')
        );
    }

}
