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
        'AppUser' => array(
            'className' => 'AppUser',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    /**
     * instead of array returns
     * Make a user join a classroom.
     * @param int $userId user(pk)
     * @param int $classroomId classroom(pk)
     * @param boolean $isOwner If the user joining is the educator/owner of classroom
     * @return array
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

    /**
     * promote a list of users from moderator privilege for a classroom
     * @param int $classroomId
     * @param array $usersList
     * @return mixed
     */
    public function setModerator($classroomId, $usersList = array()) {
        $this->_toggleField($classroomId, $usersList, 'is_moderator', true);
    }

    /**
     * demote a list of users from moderator privilege for a classroom
     * @param int $classroomId
     * @param array $usersList
     * @return mixed
     */
    public function removeModerator($classroomId, $usersList = array()) {
        $this->_toggleField($classroomId, $usersList, 'is_moderator', false);
    }

    /**
     * @param int $classroomId
     * @param array $usersList
     */
    public function setRestricted($classroomId, $usersList = array()) {
        $this->_toggleField($classroomId, $usersList, 'is_restricted', true);
    }

    public function removeRestricted($classroomId, $usersList = array()) {
        $this->_toggleField($classroomId, $usersList, 'is_restricted', false);
    }

    /**
     * Internal abstraction for toggling fields (adding or removing) is_moderator, is_restircted
     * for many users
     * @param $classroomId int
     * @param $usersList array of userIds
     * @param $field String is_moderator, is_restricted
     * @param $action bool true for adding, false for removing
     * @return bool
     */
    private function _toggleField($classroomId, $usersList = array(), $field, $action) {
        $status = $this->updateAll(
            array('UsersClassroom.{$field}' => $action),
            array(
                'UsersClassroom.user_id IN' => $usersList,
                'AND' => array(
                    'UsersClassroom.classroom_id' => $classroomId
                )));
        /**
         * study the SQL log with the following commands,
         * and land up "sneaking" the IN clause into the ORM
         * .Genius.
         */
//        $this->log($status);
//        $this->log($this->getDataSource()->getLog(false, false));
        return $status;
    }
}