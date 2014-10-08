<?php
App::uses('AppModel', 'Model');
/**
 * UsersSubmission Model
 *
 * @property User $User
 * @property Submission $Submission
 * @property Pyoopilfile $Pyoopilfile
 */
class UsersSubmission extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
//	public $validate = array(
//		'user_id' => array(
//			'numeric' => array(
//				'rule' => array('numeric'),
//				//'message' => 'Your custom message here',
//				//'allowEmpty' => false,
//				//'required' => false,
//				//'last' => false, // Stop validation after this rule
//				//'on' => 'create', // Limit validation to 'create' or 'update' operations
//			),
//		),
//		'submission_id' => array(
//			'numeric' => array(
//				'rule' => array('numeric'),
//				//'message' => 'Your custom message here',
//				//'allowEmpty' => false,
//				//'required' => false,
//				//'last' => false, // Stop validation after this rule
//				//'on' => 'create', // Limit validation to 'create' or 'update' operations
//			),
//		),
//	);

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
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
        'Submission' => array(
            'className' => 'Submission',
            'foreignKey' => 'submission_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true,
        ),
        'Pyoopilfile' => array(
            'className' => 'Pyoopilfile',
            'foreignKey' => 'pyoopilfile_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    /**
     * Student submits an answer to a subjective assignment
     * @param $userId
     * @param $postData
     * @return bool
     */
    public function answerSubjective($userId, $postData) {
        //submission_id is already in the post data
        $postData['AppUser']['id'] = $userId;
        $postData['UsersSubmission']['is_submitted'] = true;

        $options = array(
            'validate' => false,
            'deep' => true,
            'fieldList' => array(
                'AppUser' => array('id'),
                'Submission' => array('id'),
                'UsersSubmission' => array('answer', 'is_submitted'),
                'Pyoopilfile' => array(
                    'file_path', 'filename', 'filesize', 'mime_type', 'thumbnail_path'
                )
            )
        );

        if (@$this->saveAssociated($postData, $options)) {
            return true;
        } else {
            return false;
        }
    }

    public function getUsersSubmission($submissionId, $userId) {
        $options['contain'] = array(
            'Pyoopilfile'
        );

        $options['conditions'] = array(
            'UsersSubmission.submission_id' => $submissionId,
            'UsersSubmission.user_id' => $userId
        );

        return $this->find('first', $options);
    }

    /**
     * get all user's submitted submissions for a given submission
     * that is used by GradeSubmissions API
     * @param $submissionId
     * @return array
     */
    public function getSubmittedSubmissions($submissionId) {
        $options['contain'] = array(
            'AppUser' => array(
                'id', 'fname', 'lname', 'profile_img'
            ),
            'Pyoopilfile' => array(
                'id', 'file_path', 'filename', 'filesize', 'mime_type', 'thumbnail_path'
            )
        );

        $options['fields'] = array(
            'grade', 'marks', 'answer', 'pyoopilfile_id', 'is_submitted', 'created'
        );

        $options['conditions'] = array(
            'submission_id' => $submissionId
        );

        return $this->find('all', $options);
    }

    /**
     * Student side academic report
     * @param $userId
     * @param $classroomId
     * @return array
     */
    public function getUsersSubmissionList($userId, $classroomId) {
        $options = array(
            'contain' => array(
                'Submission' => array(
                    'id', 'topic', 'total_marks', 'subjective_scoring', 'average_marks'
                )
            ),
            'fields' => array(
                'grade', 'marks', 'percentile', 'grade_frequency', 'grade_comment', 'is_graded'
            ),
            'conditions' => array(
                'UsersSubmission.user_id' => $userId,
                'Submission.classroom_id' => $classroomId,
            )
        );

        return $this->find('all', $options);
    }

    /**
     * creating entries for student submissions for easy tracking and maintainence
     * This must exclude the owner/educator
     * @param $submissionId
     * @return bool
     */
    public function createDummyUsersSubmissions($submissionId) {
        $this->Submission->id = $submissionId;
        $classroomId = $this->Submission->field('classroom_id');

        //ensure the users_submission entry is not created for the owner(educator)
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
        $returnData = array();

        foreach ($data as $value) {
            array_push($returnData, array(
                'UsersSubmission' => array(
                    'submission_id' => $submissionId,
                    'user_id' => $value['UsersClassroom']['id'],
                )));
        }
        $this->saveMany($returnData, array(
            'validate' => false
        ));
    }

    /**
     *
     * @param $classroomId
     */
    private function _getFilteredPeople($classroomId) {
//        $usersSubmission = new UsersSubmission();
//
//        $options = array(
//            'contains' => array(
//                'AppUser' => array(
//                    'id'
//                )
//            ),
//            'conditions' => array(
//                'classroom_id' => $classroomId,
//            ),
//            'fields' => array(
//                'id'
//            )
//        );
    }

}
