<?php

/**
 * Class MessagesController
 */
class MessagesController extends AppController{

    public function index(){

        $params = array(
            'conditions' => array(
                'OR' => array(
                    'sender_id' => 1,
                    'recipient_id' => 1
                )
            )
        );

        $data = $this->Message->find('all',$params);
        debug($data);
        die();
    }
} 