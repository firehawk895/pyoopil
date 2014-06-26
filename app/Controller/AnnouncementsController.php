<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AnnouncementsController extends AppController {

    public $helpers = array('Time');

    public function index($classroomId){

        $this->set('classroomId',$classroomId);
        $data = $this->Announcement->getPaginatedAnnouncements($classroomId,1);
        $this->set('data',json_encode($data));

    }

    public function getAnnouncements($classroomId){
        $this->response->type('json');
        $status = false;
        $message = "";
        if(isset($this->params['url']['page'])){
            $page = $this->params['url']['page'];
            $data = $this->Announcement->getPaginatedAnnouncements($classroomId,$page);
        }

        if($data!=NULL){
            $status = true;
        }

        $this->set(compact('status', 'message', 'data'));
        $this->set('_serialize', array('status', 'message', 'data'));
    }

    public function add($classroomId) {
        $this->request->onlyAllow('post');
        $this->response->type('json');

        $status = false;
        $message = "";
        $userId =  AuthComponent::user('id');

        unset($this->request->data['Announcement']['classroom_id']);
        $data = $this->request->data;

        if($this->Announcement->createAnnouncement($classroomId,$data,$userId)){
            $data = $this->Announcement->getAnnouncementById($this->Announcement->getLastInsertID());
            $message = "Announcement created";
            $status = true;
            $this->set(compact('status', 'message', 'data'));
            $this->set('_serialize', array('status', 'message', 'data'));
        }else{
            $message = "Could not create announcement";
            $status = false;
            $this->set(compact('status', 'message'));
            $this->set('_serialize', array('status', 'message'));
        }
    }

}
