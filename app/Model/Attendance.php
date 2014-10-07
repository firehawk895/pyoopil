<?php
App::uses('AppModel', 'Model');
class Attendance extends AppModel {

    /**
     * belongsTo associations
     * @var array
     */
    public $belongsTo = array(
        'AppUser' => array(
            'className' => 'AppUser',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Classroom' => array(
            'className' => 'Classroom',
            'foreignKey' => 'classroom_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true,
        ),
        //If you had to normalize date
//        'Pyoopildate' => array(
//            'className' => 'Pyoopildate',
//            'foreignKey' => 'pyoopildate_id',
//            'conditions' => '',
//            'fields' => '',
//            'order' => ''
//        )
    );
}
