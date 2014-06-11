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

        $params['recursive'] = -1;

        $data = $this->Library->find('first',$params);
        $topics = $this->Library->getTopics($data['Library']['id']);
        $this->set('topics',$topics);
    }

}