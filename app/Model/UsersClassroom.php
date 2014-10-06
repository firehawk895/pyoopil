<?php

App::uses('AppModel', 'Model');

/**
 * UsersClassroom Model
 * @property Classroom $Classroom
 * @property User $User
 */
class UsersClassroom extends AppModel {

    /**
     * pagination limit count for "People" of a Classroom
     */
    const PAGINATION_LIMIT = 15;

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
        return $this->_toggleField($classroomId, $usersList, 'is_moderator', true);
    }

    /**
     * demote a list of users from moderator privilege for a classroom
     * @param int $classroomId
     * @param array $usersList
     * @return mixed
     */
    public function removeModerator($classroomId, $usersList = array()) {
        return $this->_toggleField($classroomId, $usersList, 'is_moderator', false);
    }

    /**
     * @param $classroomId
     * @param array $usersList
     * @return bool
     */
    public function setRestricted($classroomId, $usersList = array()) {
        return $this->_toggleField($classroomId, $usersList, 'is_restricted', true);
    }

    /**
     * @param $classroomId
     * @param array $usersList
     * @return bool
     */
    public function removeRestricted($classroomId, $usersList = array()) {
        return $this->_toggleField($classroomId, $usersList, 'is_restricted', false);
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
        $field = "UsersClassroom." . $field;
        $status = $this->updateAll(
            array($field => $action),
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

    /**
     * get all participants of a classroom, paginated
     * @param $classroomId
     * @param int $page
     * @return array
     */
    public function getPaginatedPeople($classroomId, $page = 1) {
        /**
         * TODO: filter out not to allow teacher
         */

        //sanity check
        if ($page < 1) {
            $page = 1;
        }

        $offset = self::PAGINATION_LIMIT * ($page - 1);

        $options = array(
            'contain' => array(
                'Classroom' => array(
                    'fields' => array('id')
                ),
                'AppUser' => array(
                    'fields' => array('id', 'fname', 'lname', 'profile_img')
                )
            ),
            'fields' => array('id', 'is_moderator', 'is_restricted', 'is_teaching'),
            'conditions' => array(
                'Classroom.id' => $classroomId
            ),
            'limit' => self::PAGINATION_LIMIT,
            'offset' => $offset,
            'order' => array(
                'UsersClassroom.created' => 'desc'
            )
        );

        $data = $this->find('all', $options);
        return $data;
    }

    /**
     * get the engagement points
     * @param $userId
     * @param $classroomId
     */
    public function getUsersGamification($userId, $classroomId) {
//        "UsersClassroom": {
//            "en": "0",
//            "in": "0",
//            "cu": "0",
//            "co": "0",
//            "ed": "0"
//        },
//        "Classroom": {
//            "id": "34",
//            "users_classroom_count": "3"
//        }
    }

    /**
     * get the classroom podium
     * @param $classroomId
     */
    public function getEngagers($classroomId) {

        /**
         * after calculation of engagers,
         * done in another method mostly
         * organize data as
         * array(
         *  'gold' =>
         *  'silver' =>
         *  'bronze' =>
         *
         * format is
         * "AppUser": {
         * //            "id": "19",
         * //                "fname": "Aaron",
         * //                "lname": "Basaiawmoit",
         * //                "profile_img": "https:\/\/s3-ap-southeast-1.amazonaws.com\/pyoopil-files\/default_profile_photo-1.png"
         * //            },
         * //            "Classroom": {
         * //            "id": "34"
         * //            }
         */

//        $options = array(
//            'contain' => array(
//                'Classroom',
//                'AppUser' => array(
//                    'fields' => array('id', 'fname', 'lname', 'profile_img')
//                )
//            ),
//            'fields' => array('total_gamification'),
//            'conditions' => array(
//                'Classroom.id' => $classroomId
//            ),
//            'order' => array(
//                'UsersClassroom.created' => 'desc'
//            )
//        );
//
//        $data = $this->find('all', $options);
//        return $data;
    }

    public function getAttendance($userId, $classroomId) {
        $options = array(
            'contain' => array(
                'Classroom' => array(
                    'classes_held', 'minimum_attendance_percentage', 'users_classroom_count'
                ),
                'AppUser' => array(
                    'fields' => array('id')
                )
            ),
            'fields' => array('classes_attended'),
            'conditions' => array(
                'Classroom.id' => $classroomId,
                'AppUser.id' => $userId
            ),
            'order' => array(
                'UsersClassroom.created' => 'desc'
            )
        );

        return $this->find('first', $options);
    }

    private function _getAttendance($classroomId) {
        $options = array(
            'contain' => array(
                'Classroom',
                'AppUser' => array(
                    'fields' => array('id')
                )
            ),
            'fields' => array('classes_attended'),
            'conditions' => array(
                'Classroom.id' => $classroomId,
            ),
            'order' => array(
                'UsersClassroom.created' => 'desc'
            )
        );
    }

    public function getAttendanceFrequency($userId, $classroomId) {
        $data['frequency'] = array(
            '0-20%' => '0',
            '20-40%' => '2',
            '40-60%' => '14',
            '60-80%' => '17',
            '80-100%' => '5',
        );

        $data['marked'] = '40-60%';
        return $data;
    }

    public function updateGamification($userId, $classroomId, $vote){

        $options = array(
            'fields' => array(
                'in', 'cu', 'en', 'co', 'ed', 'display_praise', 'real_praise'
            ),
            'conditions' => array(
                'UsersClassroom.classroom_id' => $classroomId,
                'UsersClassroom.user_id' => $userId
            )
        );

        if(in_array($vote,$this->AppUser->Gamificationvote->votes)){
            $data = $this->find('first',$options);

            $voteValue = $data['UsersClassroom'][$vote] + 1;
            $displayPraise = $data['UsersClassroom']['display_praise'] + 1;

            if($vote == 'ed'){
                $realPraise = $data['UsersClassroom']['real_praise'] + 10;
            }else{
                $realPraise = $data['UsersClassroom']['real_praise'] + 1;
            }

            $record = array(
                'id' => $userId,
                $vote => $voteValue,
                'display_praise' => $displayPraise,
                'real_praise' => $realPraise
            );

            if($this->save($record,false)){
                return true;
            }
        }
        else{
            return false;
        }
    }
}