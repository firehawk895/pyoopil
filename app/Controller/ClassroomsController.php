<?php

/**
 * (c) Pyoopil EduTech 2014
 */
App::uses('AppController', 'Controller');
App::uses('DateConvertor', 'Lib/Custom');

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

    public $components = array('Paginator');

    public function index() {
        $this->set('data', json_encode($this->Classroom->getPaginatedClassrooms(AuthComponent::user('id'), '1')));
        /**
         * TODO: 
         * move to model and return campuses, depts, and degrees
         * that are associated to the user creating the classroom
         */
        $campuses = $this->Classroom->Campus->find('list');
        $departments = $this->Classroom->Department->find('list');
        $degrees = $this->Classroom->Degree->find('list');

        $this->set(compact('campuses', 'departments', 'degrees'));
    }

    /**
     * Render a view for a particular classroom
     * @param type $classroomId
     */
    public function view($classroomId) {
        /**
         * Redirect to classrooms/discussions at route level
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
//        $this->autoRender = false;
        $this->request->onlyAllow('post');
        $data = array();

        $this->request->data['Classroom']['duration_start_date'] = DateConvertor::convert($this->request->data['Classroom']['duration_start_date']);
        $this->request->data['Classroom']['duration_end_date'] = DateConvertor::convert($this->request->data['Classroom']['duration_end_date']);

        if ($this->Classroom->add(AuthComponent::user('id'), $this->request->data)) {
            $status = true;
            $message = "Successfully created classroom";
//            $the_great_id = $this->Classroom->getLastInsertId();
            $this->log('getting latest tile');
            $data = $this->Classroom->getLatestTile(AuthComponent::user('id'));
        } else {
            $status = true;
            $message = "Successfully created classroom";
        }
        $webroot = $this->webroot;
        $this->set(compact('status', 'message', 'webroot'));
        $this->set('data', $data);
        $this->set('_serialize', array('data', 'status', 'message', 'webroot'));
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

    /**
     * Join a classroom provided access code
     */
    public function join() {

        $this->request->onlyAllow('post'); // No direct access via browser URL - Note for Cake2.5: allowMethod()
        $this->response->type('json');

        /**
         * initialization : make sure json response is atleast empty
         */
        $status = false;
        $message = "";
        $data = array();

        $classroomId = $this->Classroom->getClassroomIdWithCode($this->request->data[$this->modelClass]['access_code']);
        if (!isset($classroomId)) {
            $status = false;
            $message = 'Invalid Access Code';
        } else {
            $returned = $this->Classroom->UsersClassroom->joinClassroom(AuthComponent::user('id'), $classroomId, false);
            $status = $returned['status'];
            $message = $returned['message'];

            if ($status === true) {
                $data = $this->Classroom->getLatestTile(AuthComponent::user('id'));
            }
        }

        /**
         * finalize and set the response for the json view
         */
        $webroot = $this->webroot;
        $this->set(compact('status', 'message', 'webroot'));
        $this->set('data', $data);
        $this->set('_serialize', array('data', 'status', 'message', 'webroot'));
    }

    public function getclassrooms() {
        $this->response->type('json');
        $page = 1;

        if (isset($this->params['url']['page'])) {
            $page = $this->params['url']['page'];
        }
        $status = true;
        $message = "";

        $webroot = $this->webroot;
        $this->set(compact('status', 'message', 'webroot'));
        $this->set('data', $this->Classroom->getPaginatedClassrooms(AuthComponent::user('id'), $page));
        $this->set('_serialize', array('data', 'status', 'message', 'webroot'));
    }

    public function isAuthorized($user) {
        if($user){
            return true;
        }
        else{
            return false;
        }
    }

}
