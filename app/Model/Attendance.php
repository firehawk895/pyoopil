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
        $dates = array();

        foreach($data as $date){
            array_push($dates, $date['Attendance']['dates']);
        }

        return $dates;
    }
}
