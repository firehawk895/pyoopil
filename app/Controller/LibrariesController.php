<?php

/*
 * (c) Pyoopil Education Technologies
 */

App::uses('AppController', 'Controller');

class LibrariesController extends AppController {

    public function index($room_id) {
        
        if($this->request->is('post')) {
            if($this->Library->saveMany($this->request->data['file_path'])) {
                echo "test successful";
                die();
            } else {
                echo "Unfuck yourself, because you are, indeed, fucked.";
            }
        }
        $topics = $this->Library->Topic->find('list');
        $this->set(compact('topics'));
        
    }

}
