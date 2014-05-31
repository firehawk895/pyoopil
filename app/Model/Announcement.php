<?php

App::uses('AppModel', 'Model');
App::uses('AttachmentBehavior', 'Uploader.Model/Behavior');

/**
 * Announcement Model
 *
 * @property Classroom $Classroom
 * @property User $User
 * @property Pyoopilfile $Pyoopilfile
 * @property User $User
 */
class Announcement extends AppModel {

//    public function beforeUpload($options) {
//
//        $options['transport']['accessKey'] = getenv('S3_ACCESS_KEY');
//        $options['transport']['secretKey'] = getenv('S3_SECRET_KEY');
//        $options['transport']['bucket'] = getenv('S3_BUCKET');
//
//        return $options;
//    }

    public $actsAs = array(
        'Uploader.Attachment' => array(
            'file_path' => array(
                'overwrite' => true,
                'transport' => array(
                    'class' => AttachmentBehavior::S3,
                    'region' => Aws\Common\Enum\Region::SINGAPORE,
//                    'folder' => 'announcements/',
//                    'accessKey' => 'AKIAJSFESXV3YYXGWI4Q',
//                    'secretKey' => '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',
                    'bucket' => 'pyoopil-files',
                //Dynamically add 'accesskey','secretKey','bucket'
                ),
                'metaColumns' => array(
//                  'ext' => 'extension',
//                  'type' => 'mimeType',
                    'size' => 'filesize',
                    'name' => 'filename'
//                  'exif.model' => 'camera'
                )
            )
        ),
//        'Uploader.FileValidation' => array(
//            'file_path' => array(
////                'type' => 'image',
////                'mimeType' => array('image/gif'),
//                'filesize' => 2097152,
//                'required' => false
//            )
//        )
    );

    /**
     * belongsTo associations
     * @var array
     */
    public $belongsTo = array(
        'Classroom' => array(
            'className' => 'Classroom',
            'foreignKey' => 'classroom_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'AppUser' => array(
            'className' => 'AppUser',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
//		'Pyoopilfile' => array(
//			'className' => 'Pyoopilfile',
//			'foreignKey' => 'pyoopilfile_id',
//			'conditions' => '',
//			'fields' => '',
//			'order' => ''
//		)
    );

    /**
     * hasAndBelongsToMany associations
     * @var array
     */
//    public $hasAndBelongsToMany = array(
//        'User' => array(
//            'className' => 'User',
//            'joinTable' => 'users_announcements',
//            'foreignKey' => 'announcement_id',
//            'associationForeignKey' => 'user_id',
//            'unique' => 'keepExisting',
//            'conditions' => '',
//            'fields' => '',
//            'order' => '',
//            'limit' => '',
//            'offset' => '',
//            'finderQuery' => '',
//        )
//    );

    /**
     * Retrieve all annoucnements for a classroom
     * @param type $room_id
     * @return type
     */
    protected function getAnnouncements($classroomId) {

        $options['contain'] = array();
        $options['conditions'] = array(
            'classroom_id' => $classroomId
        );
        $data = $this->find('all', $options);
// public $actsAs = array(
//        'Uploader.Attachment' => array(
//            'file_path' => array(
//                'overwrite' => true,
//                'transport' => array(
//                    'class' => AttachmentBehavior::S3,
//                    'accessKey' => ,
//                    'secretKey' => getenv('S3_SECRET_KEY'),
//                    'bucket' => 'pyoopil-files',
//                    'region' => Aws\Common\Enum\Region::SINGAPORE,
//                    'folder' => 'announcements/'
//                ),
//            )
//        ),
//        'Uploader.FileValidation' => array(
//            'file_path' => array(
//                'type' => 'image',
//                'mimeType' => array('image/gif'),
//                'filesize' => 2097152,
//                'required' => false
//            )
//        )
//    );
//        $event = new CakeEvent('Model.Order.getAnnouncements', $this, array(
//            'data' => $data
//        ));
//        $this->getEventManager()->dispatch($event);

        return $data;
    }

    public function getAnnouncementTiles($classroomId) {
        $datadump = $this->getAnnouncements($classroomId);

        $i = 0;
        foreach ($datadump as $data) {
            $tiles[$i]['subject'] = $data['Announcement']['subject'];
            $tiles[$i]['name'] = $this->AppUser->getFullName($data['Announcement']['user_id']);
            $tiles[$i]['body'] = $data['Announcement']['body'];
            $tiles[$i]['created'] = $data['Announcement']['created'];
            $tiles[$i]['file_path'] = $data['Announcement']['file_path'];
            $tiles[$i]['filename'] = $data['Announcement']['filename'];
            $tiles[$i]['filesize'] = $data['Announcement']['filesize'];
            $i++;
        }
//        debug($tile);
//        die();
        return $tiles;
    }

    /**
     * 
     */

    /**
     * Create Announcement by user, for a particular classroom
     * @param type $userId
     * @param type $classroomId
     */
    public function createAnnouncement($userId, $classroomId, $data) {
        /**
         * $data = array(
         *      'Announcement' => array(
         *          'subject' => ...
         *          'body' => ...
         *      );
         * );
         */
        $data['Announcement']['classroom_id'] = $classroomId;
        $data['Announcement']['user_id'] = $userId;

//        debug($data);

        if ($this->save($data)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Dispatch sms for an announcement
     * TODO:
     * Defferred sms sending + testing of services
     * @param type $room_type
     * @param type $room_id
     * @param type $announcement_id
     */
    public function sendSms($room_type, $room_id, $announcement_id) {
        App::uses('CakeTime', 'Utility');
        $SMS_LIMIT = 160;

        $conditions = array(
            'id' => 10
        );
        $options = array(
            'conditions' => $conditions,
            'recursive' => -1,
        );
        $data = $this->find('first', $options);
        $room = "classroom";
        $roomName = "Phy-101";


        $friendlyTime = CakeTime::format(
                        'd-m-Y h:i A', $data['Announcement']['creation_date']
        );

        $rawString = 'Announcement in classroom Phy-101, from teacher_name about Sex on the beach sent at 14-03-2014 12:48 PM';
        $rawLength = strlen($rawString);
        $usableLength = $SMS_LIMIT - $rawLength;

        $smsString = String::insert('Announcement in :room :roomName, from :name about :subject sent at :timestamp', array(
                    'name' => 'teacher_name',
                    'room' => $room,
                    'roomName' => $roomName,
                    'subject' => $data['Announcement']['subject'],
                    'timestamp' => $friendlyTime
        ));

        debug($smsString);
        die();

        // generates: "My name is Bob and I am 65 years old."
    }

    /**
     * Deffered email sending.
     */
    public function sendEmails() {
        
    }

}
