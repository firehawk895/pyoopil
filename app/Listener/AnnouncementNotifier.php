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

        $announcement = $this->Announcement->getAnnouncementById($event->data['announcementId']);
        $classroomTitle = $this->UsersClassroom->Classroom->getClassroomTitle($event->data['classroomId']);

        $notification = "Announcement in classroom: {$classroomTitle}"." {$announcement['Announcement']['subject']}";

    }

} 