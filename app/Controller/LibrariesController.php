<?php

/*
 * (c) Pyoopil Education Technologies
 */

App::uses('AppController', 'Controller');

class LibrariesController extends AppController {

    public function index($room_id) {

        $params['conditions'] = array(
            'classroom_id' => $room_id
        );

        $params['contain'] = array(
            'Topic'
        );
        $topics = $this->Library->find('all',$params);
        $topic = hash::extract($topics,'{n}.Topic.{n}.name');
        $this->getTopics(1);
    }


    function getTopics($libraryId){

        $params['conditions'] = array(
            'library_id' => $libraryId,
        );

        $params['contain'] = array(
            'Link',
            'Pyoopilfile' => array(
                'order' => array(
                    'Pyoopilfile.file_type ASC'
                )
            )
        );

        $topics = $this->Library->Topic->find('all',$params);
        $this->set('topics',$topics);

        /*debug($topics);
        die();*/
    }
}
