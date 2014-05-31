<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AnnouncementsController extends AppController {

    public $components = array('Paginator');
    public $helpers = array('Time');

    public function index($classroom_id) {
        App::uses('CakeNumber', 'Utility');

        $this->Paginator->settings = array(
            'contain' => array(
                'AppUser' => array(
                    'fields' => array('fname', 'lname')
                )),
            'limit' => 5,
            'order' => array(
                'Announcement.created' => 'desc'
            ),
            'conditions' => array(
                'classroom_id' => $classroom_id
            )
        );

        $tiles = $this->Paginator->paginate('Announcement');
        $this->set('tiles', $tiles);
        $this->set('classroom_id', $classroom_id);
    }

//    public function paginationtest() {
//        $this->layout = 'ajax';
//        $classroom_id = 14;
//        
//        $this->Paginator->settings = array(
//            'contain' => array(
//                'AppUser' => array(
//                    'fields' => array('fname','lname')
//            )),
//            'limit' => 5,
//            'order' => array(
//                'Announcement.created' => 'desc'
//            ),
//            'conditions' => array(
//                'classroom_id' => $classroom_id
//            )
//        );
//
//        // similar to findAll(), but fetches paged results
//        $data = $this->Paginator->paginate('Announcement');
////        debug($data);
////        die();
//        $this->set('data', $data);
//    }
//    /**
//     * Announcements of a classroom
//     * @param type $classroomId
//     */
//    public function index($classroomId) {
//        App::uses('CakeNumber', 'Utility');
////        debug(getenv('S3_ACCESS_KEY'));
////        debug(getenv('S3_SECRET_KEY'));
////        debug(getenv('S3_BUCKET'));
////        echo APP;
////        echo " ";
////        echo DS;
////        die();
//        $this->set('classroomId', $classroomId);
//
//        $tilesx = $this->Announcement->getAnnouncementTiles($classroomId);
//        $this->set('tiles', $tilesx);
//        /**
//         * throw not found exception if classroom does not exist
//         */
//    }

    public function add() {
        $this->layout = 'ajax';
        if ($this->request->is('post')) {
            /**
             * $this->request->data contract:
             * array(
             *      'Announcement' => array(
             *          'classroom_id' => ..,
             *          'subject' => ..,
             *          'body' => ..
             * ));
             */
            /**
             * API consistentency.
             * Is this good or not?
             * Debate the design decision.
             */
            $classroomId = $this->request->data['Announcement']['classroom_id'];
            unset($this->request->data['Announcement']['classroom_id']);

            if ($this->Announcement->createAnnouncement(AuthComponent::user('id'), $classroomId, $this->request->data)) {
                //success
                $message = array(
                    'shit' => 'works'
                );
                $this->response->statusCode(200);
                $this->response->body(json_encode($message));
                return $this->response;
            } else {
                //failure
                $message = array(
                    'shit' => 'doesntwork'
                );
                $this->response->statusCode(200);
                $this->response->body(json_encode($message));
                return $this->response;
            }
        }
    }

}
