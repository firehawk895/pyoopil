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
     * TODO : Investigate transient flash messages for cake 2.x perhaps,
     * instead of array returns
     * 
     * Make a user join a classroom.
     * @param int $userId user(pk)
     * @param int $classroomId classroom(pk)
     * @param boolean $isOwner If the user joining is the educator/owner of classroom
     */
    public function joinClassroom($userId, $classroomId, $isOwner) {

        $conditions = array(
            'user_id' => $userId,
            'classroom_id' => $classroomId,
        );

        $data = array(
            'UsersClassroom' => array(
                'user_id' => $userId,
                'classroom_id' => $classroomId,
            )
        );

        if ($this->hasAny($conditions)) {
            return array(
                'message' => 'You already belong to that classroom',
                'status' => false
            );
        } else {
            if ($isOwner) {
                $data['UsersClassroom']['is_teaching'] = true;
            }

            if ($this->saveAssociated($data)) {
                return array(
                    'message' => 'You have successfully joined the classroom',
                    'status' => true
                );
            } else {
                return array(
                    'message' => 'The classroom could not be joined. Please try again later',
                    'status' => false
                );
            }
        }
    }

}
