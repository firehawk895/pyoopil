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
//        print_r($topic);
        $this->getTopics(1);
//        die();
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

        /*foreach($topics as $topic){
            echo $topic['Topic']['name']."<br>";
            foreach($topic['Link'] as $Link){
                echo $Link['linktext']."<br>";
            }
            foreach($topic['Pyoopilfile'] as $file){
                debug($file);
            }

        }*/

        //debug($topics);
    }
}
