<?php

/**
 * (c) Pyoopil EduTech 2014
 */
App::uses('User', 'Users.Model');
App::uses('AttachmentBehavior', 'Uploader.Model/Behavior');

class AppUser extends User {

    public $actsAs = array(
        'Utility.Enumerable',
        'Containable',
        'Uploader.Attachment' => array(
            'profile_img' => array(
                'overwrite' => true,
                'transport' => array(
                    'class' => AttachmentBehavior::S3,
                    'region' => Aws\Common\Enum\Region::SINGAPORE,
//                    'folder' => 'announcements/',
                    'accessKey' => 'AKIAJSFESXV3YYXGWI4Q',
                    'secretKey' => '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',
                    'bucket' => 'pyoopil-files',
                    //Dynamically add 'accesskey','secretKey','bucket'
                ),
                'metaColumns' => array( //                  'ext' => 'extension',
//                  'type' => 'mimeType',
//                    'size' => 'filesize',
//                    'name' => 'filename'
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

    public $useTable = 'users';

    protected $authTokenExpirationTime = 14400;

    /**
     * belongsTo associations
     * @var array
     */
    public $belongsTo = array(
        'Group' => array(
            'className' => 'Group',
            'foreignKey' => 'group_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Announcement' => array(
            'className' => 'Announcement',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Discussion' => array(
            'className' => 'Discussion',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Foldeddiscussion' => array(
            'className' => 'Foldeddiscussion',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Follow' => array(
            'className' => 'Follow',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Gamificationvote' => array(
            'className' => 'Gamificationvote',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Pollvote' => array(
            'className' => 'Pollvote',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Reply' => array(
            'className' => 'Reply',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Choicesanswer' => array(
            'className' => 'Choicesanswer',
            'foreignKey' => 'user_id',
            'dependent' => false,
        ),
        /**
         * HABTMs that are rightly hasMany:
         */
        'UsersCampus' => array(
            'className' => 'UsersCampus',
            'foreignKey' => 'user_id',
        ),
        'UsersClassroom' => array(
            'className' => 'UsersClassroom',
            'foreignKey' => 'user_id',
        ),
        'UsersAnnouncement' => array(
            'className' => 'UsersAnnouncement',
            'foreignKey' => 'user_id',
        ),
        'UsersSubmission' => array(
            'className' => 'UsersSubmission',
            'foreignKey' => 'user_id',
        ),
        /**
         * Already handled by plugin, perhaps:
         * 'UserDetail' => array(
         * 'className' => 'UserDetail',
         * 'foreignKey' => 'user_id',
         * 'dependent' => false,
         * 'conditions' => '',
         * 'fields' => '',
         * 'order' => '',
         * 'limit' => '',
         * 'offset' => '',
         * 'exclusive' => '',
         * 'finderQuery' => '',
         * 'counterQuery' => ''
         * )
         *
         */
        'Follower' => array(
            'classname' => 'Follow',
            'foreignKey' => 'user_id'
        ),
        'Followee' => array(
            'classname' => 'Follow',
            'foreignKey' => 'follows_id'
        )
    );

    public function getFullName($userId) {
        $options['contain'] = array();
        $options['fields'] = array('fname', 'lname');
        $options['conditions'] = array(
            'AppUser.id' => $userId
        );

//        $this->find('first' , $options);
        $data = $this->find('first', $options);
        $fullName = $data['AppUser']['fname'] . " " . $data['AppUser']['lname'];
        return $fullName;
    }

    public function authenticate($data) {
        $user = $this->find('first', array(
            'conditions' => array(
                'AppUser.email' => $data['AppUser']['email'],
                'AppUser.password' => $this->hash($data['AppUser']['password'], 'sha1', true)
            ),
        ));

        if (!empty($user)) {
            return $user;
        } else {
            return false;
        }
    }

    public function generateAuthToken() {
        return String::uuid();
    }

    public function deleteAuthToken($user) {
        $this->id = $user['id'];
        $data['AppUser']['auth_token'] = null;
        $data['AppUser']['auth_token_expires'] = null;
        if ($this->save($data, false)) {
            return true;
        } else {
            return false;
        }
    }

    public function authTokenExpirationTime() {
        return date('Y-m-d H:i:s', time() + $this->authTokenExpirationTime);
    }

    public function checkIdleTimeOut($user) {
        App::uses('CakeTime', 'Utility');
        if (CakeTime::wasWithinLast("4 hours", $user['last_action'])) {
            $this->updateLastActivity($user['id']);
            return false;
        } else {
            $this->deleteAuthToken($user);
            return true;
        }
    }

    /**
     * $userId1 follows/unfollows a $userId2
     */
    public function toggleFollow() {
        $this->loadModel("Follow");
        $this->Follow->toggleFollow();
//        $this->log("what");
    }

    /**
     * get a users profile
     * @param $userId
     * @return array
     */
    public function getProfile($userId) {
        App::uses('CakeTime', 'Utility');

        $options = array(
            'fields' => array(
                'fname', 'lname', 'gender', 'dob', 'location',
                'facebook_link', 'twitter_link', 'linkedin_link',
                'email', 'mobile', 'university_assoc', 'location_full', 'profile_img'
            ),
            'conditions' => array(
                'AppUser.id' => $userId
            )
        );

        $data = $this->find('first', $options);
        $data['AppUser']['age'] = null;

        $this->log($data);
        if (isset($data['AppUser']['dob'])) {
            $data['AppUser']['age'] = CakeTime::timeAgoInWords($data['AppUser']['dob']);
        }
        return $data;
    }

    public function updateGamification($userId, $vote){

        $options = array(
            'fields' => array(
                'in', 'cu', 'en', 'co', 'ed', 'display_praise', 'real_praise'
            ),
            'conditions' => array(
                'AppUser.id' => $userId
            )
        );


        if(in_array($vote,$this->Gamificationvote->votes)){
            $data = $this->find('first',$options);

            $voteValue = $date['AppUser'][$vote] + 1;
            $displayPraise = $data['AppUser']['display_praise'] + 1;

            if($vote == 'ed'){
                $realPraise = $data['AppUser']['real_praise'] + 10;
            }else{
                $realPraise = $data['AppUser']['real_praise'] + 1;
            }

            $record = array(
                    'id' => $userId,
                    $vote => $voteValue,
                    'display_praise' => $displayPraise,
                    'real_praise' => $realPraise
            );

            $this->save($record,false);
        }
        else{
            return false;
        }
    }
}
