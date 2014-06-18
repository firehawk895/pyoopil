<?php

/*
 * (c) Pyoopil Education Technologies
 * TODO : Add detailed licence headers
 */
App::uses('AppController', 'Controller');

class DiscussionsController extends AppController {

    /**
     * Ajax action to get favorites
     * Dummy method - remove this
     */
    public function favorites() {
        $this->autoRender = false; // We don't render a view in this example
//        $this->request->onlyAllow('ajax'); // No direct access via browser URL

        $data = array(
            'content' => array(
                'test' => 'xyz'
            ),
            'error' => null,
        );
        return json_encode($data);
    }
    
    /**
     * Display Discussions of a classroom
     * @param type $classroomId
     */
    public function index($classroomId) {

        /**
         * throw not found exception if classroom does not exist
         */

        $this->set('classroomId' , $classroomId);

        $userId = AuthComponent::user('id');

        if(isset($this->params['url']['page'])){
            $data = $this->Discussion->getPaginatedDiscussions(1,$userId,$this->params['url']['page']);
            $data = $this->Discussion->processData($data,$userId);
        }
        else{
            $data = $this->Discussion->getPaginatedDiscussions(1,$userId,1);
            $data = $this->Discussion->processData($data,$userId);
        }

        $this->set('data',json_encode($data));

    }

}
