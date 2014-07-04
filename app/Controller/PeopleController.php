<?php
/**
 * Created by PhpStorm.
 * User: nakul
 * Date: 6/11/14
 * Time: 5:15 PM
 */

class PeopleController extends AppController {

    public function index(){

        $this->loadModel("UsersClassroom");
        $params = array(
            'contain' => array(
                'AppUser',
                'Classroom' => array(
                    'Campus'
                )
            )
        );

        $people = $this->UsersClassroom->find('all',$params);
        $this->set('people',$people);
        debug($people);
        die();
    }

} 