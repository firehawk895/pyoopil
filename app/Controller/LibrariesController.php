<?php

/*
 * (c) Pyoopil Education Technologies
 */

App::uses('AppController', 'Controller');

class LibrariesController extends AppController {

    public function index($classroomId) {
//        $options['conditions'] = array('classroom_id' => $classroomId);
//        $options['contain'] = array('Topic');
//        $topicDump = $this->Library->find('all', $options);
//        $topics = hash::extract($topicDump, '{n}.Topic.{n}.name');

        $libraryId = $this->Library->getLibraryId($classroomId);
        $topics = $this->Library->Topic->find('list', array(
            'library_id' => $libraryId
        ));

        $this->set('topics', $topics);
//        $this->set(compact('topics'));
//        $this->log($topics);
//        $data = $this->Library->getPaginatedTopics($this->Library->getLibraryId($classroomId));
//        $this->set('data', json_encode($topics));
    }

    public function getTopics($classroomId) {
        $this->response->type('json');

        $page = 1;
        $status = false;
        $message = "";

        if (!isset($this->params['url']['page'])) {
            $page = $this->params['url']['page'];
        }
        $libraryId = $this->Library->getLibraryId($classroomId);
        $data = $this->Library->getPaginatedTopics($libraryId, $page);
        $data = $this->Library->parseVideoLinks($data);
//            $data = $this->Library->parsePyoopilfiles($data);
        $status = true;

        $this->set(compact('status', 'message', 'data'));
        $this->set('_serialize', array('data', 'status', 'message'));
    }

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

    public function editTopic() {
        $this->request->onlyAllow('post');
        $this->response->type('json');

        $status = false;
        $message = "";

        if (isset($this->request->data)) {
            $topicId = $this->request->data['Topic']['id'];
            $topicName = $this->request->data['Topic']['name'];
            $status = $this->Library->editTopic($topicId, $topicName);
        }

        if ($status) {
            $message = "Topic renamed successfully.";
        } else {
            $message = "Rename unsuccessful";
        }

        $this->set(compact('status', 'message', 'data'));
        $this->set('_serialize', array('data', 'status', 'message'));
    }

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
            $message = "Deletion successfully.";
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
//        $this->log($savedData);
//        $this->log("save associated");
        if (@$this->Library->Topic->saveAssociated($savedData)) {
            $status = true;
            $message = "";
            //return latest topic or whatever ram needs
            $data = array();
        } else {
            $status = false;
            $message = "Saving links/files for the topic faield";
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
