<?php

/*
 * (c) Pyoopil Education Technologies
 * TODO : Add detailed licence headers
 */
App::uses('AppController', 'Controller');

class DiscussionsController extends AppController {

    /**
     * get 1st paginated discussions to inject into view
     * Display Discussions of a classroom
     * @param type $classroomId
     */
    public function index($classroomId) {
        $data = $this->Discussion->getPaginatedDiscussions($classroomId, AuthComponent::user('id'), 1);
        $data = $this->Discussion->processData($data, AuthComponent::user('id'));

        /**
         * express gamification keys
         */
        $gamificationKeys = array(
            'en' => 'Engagement',
            'in' => 'Intelligence',
            'cu' => 'Curious',
            'co' => 'Contribution',
            'ed' => 'Endorsement',
        );
        $this->set('Classroom.id', $classroomId);
        $this->set(compact('classroomId', 'gamificationKeys'));
        $this->set('data', json_encode($data));
    }

    /**
     * API: get paginated discussions
     * @param int $classroomId classroom id(pk)
     */
    public function getdiscussions($classroomId) {
        $this->response->type('json');
        $page = 1;

        if (isset($this->params['url']['page'])) {
            $page = $this->params['url']['page'];
        }
        $status = true;
        $message = "";

        $data = $this->Discussion->getPaginatedDiscussions($classroomId, AuthComponent::user('id'), $page);
        $data = $this->Discussion->processData($data, AuthComponent::user('id'));

        $this->set(compact('status', 'message'));
        $this->set('data', $data);
        $this->set('_serialize', array('data', 'status', 'message'));
    }

    /**
     * API: get paginated replies
     * @param type $classroomId
     */
    public function getreplies() {
        $this->response->type('json');
        $page = 1;

        if (isset($this->params['url']['page'])) {
            $page = $this->params['url']['page'];
        }
        $status = true;
        $message = "";

        $data = $this->Discussion->getPaginatedDiscussions($classroomId, AuthComponent::user('id'), $page);
        $data = $this->Discussion->processData($data, AuthComponent::user('id'));

        $this->set(compact('status', 'message'));
        $this->set('data', $data);
        $this->set('_serialize', array('data', 'status', 'message'));
    }

    /**
     * API: delete.json
     * Deleting a Discussion/Reply
     */
    public function delete() {
        $this->request->onlyAllow('post');
        $this->response->type('json');

        $status = false;
        $message = "";
        $userId = AuthComponent::user('id');

        if (isset($this->request->data)) {
            $type = $this->request->data['type'];
            $id = $this->request->data['id'];
        }

        if ($type == 'Discussion') {
            $status = $this->Discussion->deleteDiscussion($id, $userId);
        } elseif ($type == 'Reply') {
            $status = $this->Discussion->Reply->deleteReply($id, $userId);
        }

        if ($status) {
            $message = "{$type} deleted successfully";
        } else {
            $message = "Could not delete or find the discussion";
        }
        $this->set(compact('status', 'message'));
        $this->set('_serialize', array('status', 'message'));
    }

    /**
     * API: fold.json
     * Toggle fold/unfold of a discussion of logged in user
     */
    public function togglefold() {
        $this->request->onlyAllow('post');
        $this->response->type('json');

        $status = false;
        $message = "The discussion may have been deleted, or cannot be folded right now";
        $userId = AuthComponent::user('id');

        if (isset($this->request->data['id'])) {
            $discussionId = $this->request->data['id'];
            $status = $this->Discussion->toggleFold($discussionId, $userId);
            if ($status) {
                $message = "";
            }
        }

        $this->set(compact('status', 'message'));
        $this->set('_serialize', array('status', 'message'));
    }

    public function test() {
        debug($this->webroot);
        debug(Router::fullBaseUrl());
        debug(Router::url('/', true));
        debug($this->base);
        die();
    }

    /**
     * API: add.json
     * Posting discussion (question/poll/note)
     */
    public function add() {

        $this->request->onlyAllow('post');
        $this->response->type('json');

        $savedData = $this->request->data;

        $savedData['AppUser'] = array(
            'id' => AuthComponent::user('id')
        );
        $this->log($savedData);

        if ($this->Discussion->saveAssociated($savedData)) {
            $status = true;
            $message = "";

            /**
             * no check on $savedData['Classroom']['id'],
             * the code is expecting a valid classroom Id, not tampered in front end
             * because of the securityComponent
             */
            $data = $this->Discussion->getPaginatedDiscussions($savedData['Classroom']['id'], AuthComponent::user('id'), 1, true);
            $this->log($data);
            $data = $this->Discussion->processData($data, AuthComponent::user('id'));
            $this->log($data);
//            $returnedData = $savedData;
        } else {
            $status = false;
            $message = "The Discussion could not be posted";
            $data = array(); //required for json consistency
        }
        /**
         * finalize and set the response for the json view
         */
        $this->set(compact('status', 'message'));
        $this->set('data', $data);
        $this->set('_serialize', array('data', 'status', 'message'));
    }

    /**
     * API: set gamification vote on Discussion/Reply
     */
    public function setGamificationVote() {
        $this->request->onlyAllow('post');
        $this->response->type('json');

        $status = false;
        $data = array();
        $message = "";
        $userId = AuthComponent::user('id');

        if (isset($this->request->data)) {
            $id = $this->request->data['id'];
            $type = $this->request->data['type'];
            $vote = $this->request->data['vote'];
            $status = $this->Discussion->setGamificationVote($type, $id, $vote, $userId);
            if ($status) {
                $data = $this->Discussion->getGamificationInfo($type, $id);
            }
        }

        $this->set(compact('status', 'message', 'data'));
        $this->set('_serialize', array('status', 'message', 'data'));
    }

}
