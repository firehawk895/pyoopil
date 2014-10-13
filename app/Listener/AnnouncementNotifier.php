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

        //firebase stuff
        //get object
        //push
        //set

    }

    private function testNotification() {
        $firebase = new Firebase('https://vivid-torch-3610.firebaseio.com/', 'p0TcCv6cmjUKhbBBJb0tyCjJCVxAzKuakDJLxjGy');
        $announcement = $this->Announcement->getAnnouncementById($this->Announcement->getLastInsertID());
        $notification = array(
            'title' => " new announcement has been posted by <strong>Aaron Bmoit</strong> in <strong>Debating</strong>",
            'is_read' => false,
            'link' => "Classroom/36/announcements",
            'is_clicked' => false,
            'created' => $announcement['Announcement']['created']
        );
        $path = AuthComponent::user('id') . '/nof/';
        $firebase->push($path, $notification);

        $path = AuthComponent::user('id') . '/unread';
        $firebase->set($path, '3');
    }

} 