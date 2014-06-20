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
        //do not render view
        if(isset($this->params['url']['page'])){
            $data = $this->Announcement->getPaginatedAnnouncements($classroomId,1);
        }

    }

    public function add($classroomId) {
        $this->autoRender = false;
        if ($this->request->is('post')){
            $userId = AuthComponent::user('id');

            unset($this->request->data['Announcement']['classroom_id']);
            $data = $this->request->data;

            if($this->Announcement->createAnnouncement($classroomId,$data,$userId)){
                $announcement = $this->Announcement->getAnnouncementById($this->Announcement->getLastInsertID());
                $message = "Announcement created";
                $status = true;
                $this->response->body(json_encode($announcement + compact('message','status')));
                return $this->response;
            }else{
                $message = "Could not create announcement";
                $status = false;
                $this->response->body(json_encode(compact('message','status')));
                return $this->response;
            }
        }
    }

}
