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

        $this->Classroom->getLatestTile(AuthComponent::user('id'));

        App::uses('CakeNumber', 'Utility');
        $userId = AuthComponent::user('id');

        $this->Paginator->settings = array(
            'contain' => array(
                'UsersClassroom' => array(
                    'conditions' => array(
                        'user_id' => $userId
                    ),
                    'order' => array(
                        'UsersClassroom.created' => 'desc'
                    )
                ),
                'Campus' => array(
                    'fields' => array(
                        'id','name'
                    )
                )
            ),
            'limit' => 5,
            'fields' => array(
                'id', 'campus_id', 'is_private', 'title', 'users_classroom_count'
            )
        );

        $data = $this->Paginator->paginate('Classroom');

        foreach($data as $d){
            $teacher = $this->Classroom->getEducatorName($d['Classroom']['id']);
            $data = Hash::insert($data,'{n}.Classroom.teacher',$teacher);
        }

        $jsonData = json_encode($data);
        return $jsonData;
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
//    public function add() {
//        //shit don't work
////        $this->request->allowMethod('ajax','post');
////        $this->autoRender(false);
////        $this->layout = 'myajax';
//        
//        if ($this->request->is('post')) {
//            $this->request->data['Classroom']['duration_start_date'] = DateConvertor::convert($this->request->data['Classroom']['duration_start_date']);
//            $this->request->data['Classroom']['duration_end_date'] = DateConvertor::convert($this->request->data['Classroom']['duration_end_date']);
////            $this->request->data['Classroom']['is_private'] = true;
//
//            if ($this->Classroom->add(AuthComponent::user('id'), $this->request->data)) {
//                $this->Session->setFlash('Classroom sucessfully created');
//                
//                $this->Classroom->id = $this->Classroom->getLastInsertID();
//                
//                $classroomName = $this->Classroom->field('title');
//                $passCode = $this->Classroom->field('access_code');
////                debug($classroomName);
////                debug($passCode);
////                die();
//                
//                $this->set($classroomName);
//                $this->set($passCode);
//                
//            } else {
//                $this->Session->setFlash('One or more processes failed');
//                echo "badbad";
//            }
//
//            //populate hidden div with succeful creation
//            //redirect to classroom successfully created popup
//            //whatever
//        }
//    }
    public function add() {
        $this->layout = 'ajax';
//        $this->request->allowMethod('post');
//        $this->autoRender = false;

        if ($this->request->is('post')) {
//            debug($this->request->data);
//            die();
            $this->request->data['Classroom']['duration_start_date'] = DateConvertor::convert($this->request->data['Classroom']['duration_start_date']);
            $this->request->data['Classroom']['duration_end_date'] = DateConvertor::convert($this->request->data['Classroom']['duration_end_date']);
//
            if ($this->Classroom->add(AuthComponent::user('id'), $this->request->data)) {
                $this->Session->setFlash('Totally Successful');
                $this->Classroom->id = $this->Classroom->getLastInsertID();
////                
                $this->set('title', $this->Classroom->field('title'));
                $this->set('passCode', $this->Classroom->field('access_code'));
                $this->set('isPrivate', $this->Classroom->field('is_private'));
            }
        } else {
            
        }
    }

//    public function add() {
//        $this->autoRender = false;
//
//        $test = array(
//            'classroomName' => 'test',
//            'classroomCode' => 'test2'
//        );
//        echo json_encode($test);
//    }

    /**
     * Route : /classrooms/:id-:slug/create
     */
    public function invite() {
        if ($this->request->is('post')) {


//redirect to index or requests?
        }
//show invite form
    }

    public function test() {
        $this->layout = 'ajax';
        /**
         * WORKING:
         * debug($this->Classroom->displayTiles('1'));
         * debug($this->Classroom->getTiles('1')); //protected
         * debug($this->Classroom->getEducatorName('2'));
         */
    }

    /**
     * Join a classroom provided access code
     */
    public function joinWithCode() {
        $this->layout = "ajax";
//        $this->render('joinWithCode');
//        $this->autoRender = false;
//        echo "Sasdas";
//        echo $this->modelClass;
//                $this->render('elements/ajaxerror');
        if ($this->request->is('post')) {
////            echo $this->request->data['Classroom']['access_code'];
            $classroomId = $this->Classroom->getClassroomIdWithCode($this->request->data[$this->modelClass]['access_code']);
////            echo json_encode($classroomId);
////            echo debug(isset($classroomId));
////            
//////            return json_encode($classroomId);
            if (!isset($classroomId)) {
                $message = array(
                    'error' => 'Invalid Access Code'
                );
                $this->response->statusCode(400);
                $this->response->body(json_encode($message));
                return $this->response;
            } else {
                $response = $this->Classroom->UsersClassroom->joinClassroom(AuthComponent::user('id'), $classroomId, false);
//                echo $response['message'];
//                $response['status'] = true;
                if ($response['status']) {
                    $tilex = $this->Classroom->displayLatestTile(AuthComponent::user('id'));
                    $this->set('tile', $tilex);
                    /**
                     * dont "return" otherwise dispatcher flow is messed up.
                     */
                } else {
                    $message = array(
                        'error' => 'You are already part of this classroom'
                    );
                    $this->response->statusCode(400);
                    $this->response->body(json_encode($message));
                    return $this->response;
                }
            }
        }
    }

    public function testmenow() {
//        $test = $this->Classroom->getClassroomIdWithCode('uEcr90s');
//        debug($test);
//        debug(isset($test));
//        $this->Classroom->UsersClassroom->joinClassroom(AuthComponent::user('id') , '3' , false);
//        $test = null;
//        debug(isset($test));
//        echo AuthComponent::user('id');
//        die();
//        debug($this->Classroom->getTile(AuthComponent::user('id')));
        debug($this->Classroom->displayLatestTile(AuthComponent::user('id')));
        die();
    }
}
