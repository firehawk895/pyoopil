<?php

/*
 * (c) Pyoopil Education Technologies
 */

App::uses('AppController', 'Controller');

class LibrariesController extends AppController {

    public function index($classroomId) {

        $libraryId = $this->Library->getLibraryId($classroomId);
        $topics = $this->Library->getPaginatedTopics($libraryId,1);
        $this->set('topics',$topics);
    }

    public function getTopics($classroomId){
        //do not render view

        if(isset($this->params['url']['page'])){
            $libraryId = $this->Library->getLibraryId($classroomId);
            $data = $this->Discussion->getPaginatedTopics($classroomId,$this->params['url']['page']);
        }
    }

}