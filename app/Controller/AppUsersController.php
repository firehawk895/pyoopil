<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('UsersController', 'Users.Controller');

class AppUsersController extends UsersController {

    public $name = 'AppUsers';

    public function beforeFilter() {
        parent::beforeFilter();
        $this->User = ClassRegistry::init('AppUser');
        $this->set('model', 'AppUser');
    }

}
