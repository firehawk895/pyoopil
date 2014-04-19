<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * Killer Notes, TODO:
 * use View::set() to set menu buttons to active
 * http://book.cakephp.org/2.0/en/views.html#view-api
 */
/*
 * Description of ClassroomsController
 *
 * @author useruser
 */
class ClassroomsController extends AppController {
    //put your code here

    /**
     * Route : /classrooms
     * display all classroom tiles
     */
    public function index() {
        /**
         * call $this->Classroom->displayTiles()
         */
    }

    /**
     * Route : /classrooms/:id-:slug -> redirect to classroom's discussions
     * decide if this method is needed
     * @param type $classroomId
     */
    public function display($classroomId) {
        //Check Authorized for classroomId
        //of logged in user with $classroomId
        //redirect to Classroom's Discussions
    }

    /**
     * Route : /classrooms/:id-:slug/create
     */
    public function add() {
        if ($this->request->is('post')) {


            //populate hidden div with succeful creation
            //redirect to index
            //whatever
        }
        //show create form 
    }

    /**
     * Route : /classrooms/:id-:slug/create
     */
    public function invite() {
        if ($this->request->is('post')) {


            //redirect to index or requests?
        }
        //show invite form
    }

    public function testcases() {
        /**
         * WORKING:
         * debug($this->Classroom->displayTiles('1'));
         * debug($this->Classroom->getTiles('1')); //protected
         * debug($this->Classroom->getEducatorName('2'));
         */
    }

}
