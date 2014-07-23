<?php

App::uses('CakeEmail', 'Network/Email');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AnnouncementsController extends AppController {

    public $helpers = array('Time');

    public function index($classroomId) {

        $this->set('classroomId', $classroomId);
        $data = $this->Announcement->getPaginatedAnnouncements($classroomId, 1);
        $this->set('data', json_encode($data));
    }

    public function getAnnouncements($classroomId) {
        $this->response->type('json');
        $page = 1;
        $userId = AuthComponent::user('id');

        if (isset($this->params['url']['page'])) {
            $page = $this->params['url']['page'];
        }
        $status = true;
        $message = "";

        $data = $this->Announcement->getPaginatedAnnouncements($classroomId, $page);
        /**
         * finalize and set the response for the json view
         */
        $this->set('webroot', $this->webroot);
        $this->set(compact('status', 'message', 'webroot'));
        $this->set('data', $data);
        $this->set('_serialize', array('data', 'status', 'message', 'webroot'));
    }

    public function add($classroomId) {
        $this->request->onlyAllow('post');
        $this->response->type('json');

        $status = false;
        $message = "";
        $userId = AuthComponent::user('id');

        $data = $this->request->data;

        if ($this->Announcement->createAnnouncement($classroomId, $data, $userId)) {
            $data = $this->Announcement->getAnnouncementById($this->Announcement->getLastInsertID());
            $message = "Announcement created";
            $status = true;
            $this->tasty($classroomId, $data);
        } else {
            $message = "Could not create announcement";
            $status = false;
        }
        $this->set('webroot', $this->webroot);
        $this->set('data', $data);
        $this->set(compact('status', 'message', 'webroot'));
        $this->set('_serialize', array('status', 'message', 'webroot', 'data'));
    }

    public function tasty($classroomId, $announcement) {

        /**
         * Get all the users' emails
         */
        $options['contain'] = array(
            'Classroom' => array(
                'fields' => array('id')
            ),
            'AppUser' => array(
                'fields' => array('id', 'email')
            )
        );

        $options['conditions'] = array(
            'UsersClassroom.classroom_id' => $classroomId
        );
        $data = $this->Announcement->Classroom->UsersClassroom->find('all', $options);
        $emails = Hash::extract($data, '{n}.AppUser.email');

        /**
         * loop and send emails
         * TODO: defer emails
         */
        $Email = new CakeEmail();
        $Email->config('mailgun');
        foreach ($emails as $email) {
            $Email->from(array('announcements@pyoopil.com' => 'Pyoopil Announcements'));
            $Email->to($email);
            $Email->subject($announcement['Announcement']['subject']);
            $body = $announcement['Announcement']['body'] . PHP_EOL . PHP_EOL . Router::url('/', true) . 'Classrooms/' . $classroomId . '/Announcements';
            $Email->send($body);
        }
    }

}
