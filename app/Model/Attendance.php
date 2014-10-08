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

    public function getAttendanceDates($classroomId){
        $options = array(
            'conditions' => array(
                'classroom_id' => $classroomId
            ),
            'fields' => array(
                'DISTINCT (Attendance.date) AS dates'
            )
        );

        $data = $this->find('all',$options);

        $data = Hash::extract($data,'{n}.Attendance.dates');

        return $data;
    }

    public function recordAttendance($classroomId, $userIds, $date){
        //mark all present
        //update the absentees
        $options = array(
            'conditions' => array(
                'UsersClassroom.classroom_id' => $classroomId,
                'UsersClassroom.is_teaching' => false
            ),
            'fields' => array(
                'id'
            )
        );

        $data = $this->AppUser->UsersClassroom->find('all', $options);
        $ids = Hash::extract($data, '{n}.UsersClassroom.id');

        $saveData = array();
        $this->log($userIds);

        foreach($ids as $id){
            array_push($saveData,array(
                'user_id' => $id,
                'classroom_id' => $classroomId,
                'date' => $date,
                'is_present' => true
                )
            );
        }

        if($this->saveMany($saveData)){
            return $this->updateAll(
                array('is_present' => false),
                array('user_id' => $userIds)
            );
        }
    }

    public function getAttendanceByDate($classroomId, $date){

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

        return $this->find('all',$options);
    }
}
