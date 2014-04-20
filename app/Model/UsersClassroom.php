<?php

App::uses('AppModel', 'Model');

/**
 * UsersClassroom Model
 *
 * @property Classroom $Classroom
 * @property User $User
 */
class UsersClassroom extends AppModel {

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
            'order' => '',
            'counterCache' => true
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    /**
     * Make a user join a classroom.
     * @param int $userId user(pk)
     * @param int $classroomId classroom(pk)
     * @param boolean $isOwner If the user joining is the educator/owner of classroom
     */
    public function joinClassroom($userId, $classroomId, $isOwner) {
        $data = array(
            'UsersClassroom' => array(
                'user_id' => $userId,
                'classroom_id' => $classroomId,
            )
        );

        if ($isOwner) {
            $data['UsersClassroom']['is_teaching'] = true;
        }

        if ($this->saveAssociated($data)) {
            return true;
        } else {
            return false;
        }
    }

}
