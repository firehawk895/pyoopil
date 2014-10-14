<?php
App::uses('CakeEventListener', 'Event');
App::uses('CakeLog', 'Utility');
App::uses('NotificationFactory', 'Lib/Custom');


class AnnouncementNotifier implements CakeEventListener {

    public function implementedEvents() {
        return array(
            'Announcement.created' => 'createNotification'
        );
    }

    public function createNotification(CakeEvent $event) {

        $this->UsersClassroom = ClassRegistry::init('UsersClassroom');
        $this->Announcement = ClassRegistry::init('Announcement');

        $studentList = $this->UsersClassroom->getStudentList($event->data['classroomId']);

        $userIdList = Hash::extract($studentList, '{n}.AppUser.id');

        $announcement = $this->Announcement->getAnnouncementById($event->data['announcementId']);
        $classroomTitle = $this->UsersClassroom->Classroom->getClassroomTitle($event->data['classroomId']);

        $notification = array(
            'title' => "Announcement in classroom: {$classroomTitle}" . " {$announcement['Announcement']['subject']}",
            'is_read' => false,
            'link' => "Classroom/{$event->data['classroomId']}/announcements",
            'is_clicked' => false,
            'type' => 'Announcement',
            'id' => $event->data['announcementId'],
            'created' => $announcement['Announcement']['created']
        );

        /**
         * you will probably put this in a seperate php file
         * and exec this
         * exec("doTask.php $arg1 $arg2 $arg3 >/dev/null 2>&1 &");
         * The new php script must accept command line arguments for accepting
         * $notification, $userIdList
         * yes async php isn't attractive
         */
        $notifier = NotificationFactory::getNotifiableObject();
        $notifier->push($notification, $userIdList);
        //---two lines of exec code ends
    }

} 