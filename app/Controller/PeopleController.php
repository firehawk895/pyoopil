<?php
/**
 * Created by PhpStorm.
 * User: nakul
 * Date: 6/11/14
 * Time: 5:15 PM
 */

class PeopleController extends AppController {

    public function isAuthorized($user) {
        return true;
    }

    public function index() {

        $this->loadModel("UsersClassroom");
        $params = array(
            'contain' => array(
                'AppUser',
                'Classroom' => array(
                    'Campus'
                )
            )
        );

        $people = $this->UsersClassroom->find('all', $params);
        $this->set('people', $people);
        debug($people);
        die();
    }

    /**
     * API: follow/unfollow a user POST form
     * Expecting:
     * data[Follower][id]*
     * data[Followee][id]*
     */
    public function toggleFollow() {
        $this->request->onlyAllow('post'); // No direct access via browser URL - Note for Cake2.5: allowMethod()
        $this->response->type('json');

        $status = false;
        $message = "";
        $data = array();

        $request = $this->request->data;
        if (isset($request['Follower']['id']) && isset($request['Followee']['id'])) {
            $this->loadModel("Follow");
            $response = $this->Follow->toggleFollow($request['Follower']['id'], $request['Followee']['id']);
            $status = $response['status'];
            $message = $response['message'];
        } else {
            $message = "Missing parameters";
        }

        /**
         * finalize and set the response for the json view
         */
        $this->set(compact('status', 'message'));
        $this->set('data', $data);
        $this->set('_serialize', array('data', 'status', 'message'));
    }

} 