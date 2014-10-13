<?php
App::uses('CakeEventListener', 'Event');
App::uses('CakeLog', 'Utility');


class AnnouncementNotifier implements CakeEventListener{

    public function implementedEvents() {
        return array(
            'Announcement.created' => 'createNotification'
        );
    }

    public function createNotification(CakeEvent $event){

        $this->UsersClassroom = ClassRegistry::init('UsersClassroom');
        $this->Announcement = ClassRegistry::init('Announcement');

        $studentList = $this->UsersClassroom->getStudentList($event->data['classroomId']);

        $userIdList = Hash::extract($studentList,'{n}.AppUser.id');

        $announcement = $this->Announcement->getAnnouncementById($event->data['announcementId']);
        $classroomTitle = $this->UsersClassroom->Classroom->getClassroomTitle($event->data['classroomId']);

        $notification = array(
            'title' => "Announcement in classroom: {$classroomTitle}"." {$announcement['Announcement']['subject']}",
            'is_read' => false,
            'link' => "Classroom/{$event->data['classroomId']}/announcements",
            'is_clicked' => false,
            'created' => $announcement['Announcement']['created']
        );

        //exec to external script for push and set

    }

} 