<?php

/*
 * (c) Pyoopil Education Technologies
 */

App::uses('AppController', 'Controller');

class LibrariesController extends AppController {

    /**
     * Controller authorize
     * user determined from token
     * @param $user
     * @return bool
     */
    public function isAuthorized($user) {
        if (parent::isAuthorized($user)) {
            //do role processing here
            return true;
        } else {
            return false;
        }
    }

    public function index($classroomId) {

        if ($this->request->is('post')) {
            $savedData = $this->request->data;
            if ($savedData['Topic']['id'] == "") {
                unset($savedData['Topic']['id']);
                $savedData['Library']['id'] = $this->Library->getLibraryId($classroomId);
            } else {
                unset($savedData['Topic']['name']);
            }

            //Handle any empty inputs


            if (@$this->Library->Topic->saveAssociated($savedData)) {
                $status = true;
            } else {
                $status = false;
            }
        }

        $libraryId = $this->Library->getLibraryId($classroomId);
        $topics = $this->Library->Topic->find('list', array(
            'conditions' => array(
                'library_id' => $libraryId
            )
        ));

        $data = $this->Library->getPaginatedTopics($libraryId, 1);
        $data = $this->Library->parseVideoLinks($data);
        $data = $this->Library->parsePyoopilfiles($data);

        $this->set('topics', $topics);
        $this->set('classroomId', $classroomId);
        $this->set('data', json_encode($data));
    }

    /**
     * API: get topics and corresponding data for library
     * of a given classroom
     * @param $classroomId
     */
    public function getTopics($classroomId) {
        $this->response->type('json');

        $page = 1;
        $status = false;
        $message = "";

        if (isset($this->params['url']['page'])) {
            $page = $this->params['url']['page'];
        }
        $libraryId = $this->Library->getLibraryId($classroomId);
        $data = $this->Library->getPaginatedTopics($libraryId, $page);
        $data = $this->Library->parseVideoLinks($data);
        $data = $this->Library->parsePyoopilfiles($data);
        $status = true;

        $permissions = array(
            'allowCUD' => $this->Library->allowCUD($classroomId, AuthComponent::user('id'))
        );

        $this->set(compact('status', 'message', 'data', 'permissions'));
        $this->set('_serialize', array('data', 'status', 'message', 'permissions'));
    }

    /**
     * API : delete an entire topic form
     */
    public function deleteTopic() {
        $this->request->onlyAllow('post');
        $this->response->type('json');

        $status = false;
        $message = "";

        if (isset($this->request->data)) {
            $topicId = $this->request->data['Topic']['id'];
            $status = $this->Library->deleteTopic($topicId);
        }

        if ($status) {
            $message = "Topic deleted successfully.";
        } else {
            $message = "Deletion unsuccessful";
        }

        $this->set(compact('status', 'message', 'data'));
        $this->set('_serialize', array('data', 'status', 'message'));
    }

    /**
     * API : change (update) the name of the topic form
     */
    public function editTopic() {
        $this->request->onlyAllow('post');
        $this->response->type('json');

        $data = array();
        $status = false;
        $message = "";

        if (isset($this->request->data)) {
            $topicId = $this->request->data['Topic']['id'];
            $topicName = $this->request->data['Topic']['name'];
            $data = $this->Library->editTopic($topicId, $topicName);
            $status = !empty($data);
        }

        if ($status) {
            $message = "Topic renamed successfully.";
        } else {
            $message = "Could not rename, Topic may have been deleted";
        }

        $this->set(compact('data', 'status', 'message'));
        $this->set('_serialize', array('data', 'status', 'message'));
    }

    /**
     * delete any item (type file or link) under a topic
     */
    public function deleteItem() {
        $this->request->onlyAllow('post');
        $this->response->type('json');

        $status = false;
        $message = "";

        if (isset($this->request->data)) {
            $id = $this->request->data['id'];
            $type = $this->request->data['type'];
            $status = $this->Library->deleteItem($type, $id);
        }

        if ($status) {
            $message = "Deletion successful";
        } else {
            $message = "Deletion unsuccessful";
        }

        $this->set(compact('status', 'message', 'data'));
        $this->set('_serialize', array('data', 'status', 'message'));
    }

    public function add() {
        $this->request->onlyAllow('post');
        $this->response->type('json');

        $savedData = $this->request->data;
        if ($savedData['Topic']['id'] == "") {
            unset($savedData['Topic']['id']);
            $savedData['Library']['id'] = 13;
        } else {
            unset($savedData['Topic']['name']);
        }

        if (@$this->Library->Topic->saveAssociated($savedData)) {
            $status = true;
            $message = "";
            //return latest topic or whatever ram needs
            $data = array();
        } else {
            $status = false;
            $message = "Saving links/files for the topic failed";
            $data = array();
        }

        /**
         * finalize and set the response for the json view
         */
        $this->set(compact('status', 'message'));
        $this->set('data', $data);
        $this->set('_serialize', array('data', 'status', 'message'));
    }
}
