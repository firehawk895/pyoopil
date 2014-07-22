<?php

/**
 * (c) Pyoopil EduTech 2014
 */
App::uses('User', 'Users.Model');

class AppUser extends User {

    public $useTable = 'users';

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
              'UserDetail' => array(
              'className' => 'UserDetail',
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
              )
             * 
             */
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

        if(!empty($user)){
            return $user;
        }
        else{
            return false;
        }
    }

    public function generateAuthToken(){
        return String::uuid();
    }

}
