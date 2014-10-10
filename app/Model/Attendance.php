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

    /**
     * get dates for a classroom for which attendance has been taken
     * @param $classroomId
     * @return array
     */
    public function getAttendanceDates($classroomId) {
        $options = array(
            'conditions' => array(
                'classroom_id' => $classroomId
            ),
            'fields' => array(
                'DISTINCT (Attendance.date) AS dates'
            )
        );

        $data = $this->find('all', $options);
        $data = Hash::extract($data, '{n}.Attendance.dates');

        return $data;
    }

    /**
     * Saving the attendance of a classroom on a date
     * @param $classroomId classroom for which attendance taken
     * @param $userIdList userIds to be marked absent
     * @param $date date for which attendance is taken
     * @return bool
     */
    public function recordAttendance($classroomId, $userIdList, $date) {
        //TODO : use transactions for integrity
        /**
         * if attendance taken before
         *      updateAll to present
         * else
         *      createAll
         * endif
         * updateAll in usersIdList to absent
         */

        $conditions = array(
            'classroom_id' => $classroomId,
            'date' => $date
        );
        $attendanceTaken = $this->hasAny($conditions);

        if ($attendanceTaken) {
            $status = $this->updateAll(
                array('is_present' => true),
                array(
                    'classroom_id' => $classroomId,
                    'date' => $date
                )
            );
        } else {
            $options = array(
                'conditions' => array(
                    'UsersClassroom.classroom_id' => $classroomId,
                    'UsersClassroom.is_teaching' => false
                ),
                'fields' => array(
                    'id', 'user_id', 'classroom_id'
                ),
                'recursive' => -1
            );

            $data = $this->AppUser->UsersClassroom->find('all', $options);
            $ids = Hash::extract($data, '{n}.UsersClassroom.user_id');
            $saveData = array();

            foreach ($ids as $id) {
                array_push($saveData, array(
                        'user_id' => $id,
                        'classroom_id' => $classroomId,
                        'date' => $date,
                        'is_present' => true
                    )
                );
            }
            $status = !empty($this->saveMany($saveData));
        }

        if ($status) {
            $status = $this->updateAll(
                array('is_present' => false),
                array(
                    'user_id' => $userIdList,
                    'classroom_id' => $classroomId,
                    'date' => $date
                )
            );
        }
        $this->log($this->getDataSource()->getLog(false, false));
        return $status;
    }

    /**
     * view the attendance for a classroom on a particular date
     * @param $classroomId
     * @param $date
     * @return array
     */
    public
    function getAttendanceByDate($classroomId, $date) {
        $options = array(
            'conditions' => array(
                'classroom_id' => $classroomId,
                'date' => $date
            ),
            'fields' => array(
                'is_present'
            ),
            'contain' => array(
                'AppUser' => array(
                    'fields' => array(
                        'id', 'fname', 'lname', 'profile_img'
                    )
                )
            )
        );
        return $this->find('all', $options);
    }
}
