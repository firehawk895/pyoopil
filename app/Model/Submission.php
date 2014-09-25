<?php
App::uses('AppModel', 'Model');
App::uses('CakeTime', 'Utility');
/**
 * Submission Model
 *
 * @property Classroom $Classroom
 * @property Pyoopilfile $Pyoopilfile
 * @property Quiz $Quiz
 * @property Subjective $Subjective
 * @property AppUser $User
 */
class Submission extends AppModel {

    /**
     * pagination limit count for "People" of a Classroom
     */
    const PAGINATION_LIMIT = 10;

    /**
     * Validation rules
     *
     * @var array
     */
//	public $validate = array(
//		'classroom_id' => array(
//			'numeric' => array(
//				'rule' => array('numeric'),
//				//'message' => 'Your custom message here',
//				//'allowEmpty' => false,
//				//'required' => false,
//				//'last' => false, // Stop validation after this rule
//				//'on' => 'create', // Limit validation to 'create' or 'update' operations
//			),
//		),
//		'total_submitted' => array(
//			'numeric' => array(
//				'rule' => array('numeric'),
//				//'message' => 'Your custom message here',
//				//'allowEmpty' => false,
//				//'required' => false,
//				//'last' => false, // Stop validation after this rule
//				//'on' => 'create', // Limit validation to 'create' or 'update' operations
//			),
//		),
//		'is_saved' => array(
//			'boolean' => array(
//				'rule' => array('boolean'),
//				//'message' => 'Your custom message here',
//				//'allowEmpty' => false,
//				//'required' => false,
//				//'last' => false, // Stop validation after this rule
//				//'on' => 'create', // Limit validation to 'create' or 'update' operations
//			),
//		),
//		'is_published' => array(
//			'boolean' => array(
//				'rule' => array('boolean'),
//				//'message' => 'Your custom message here',
//				//'allowEmpty' => false,
//				//'required' => false,
//				//'last' => false, // Stop validation after this rule
//				//'on' => 'create', // Limit validation to 'create' or 'update' operations
//			),
//		),
//        'topic' => array(
//            'alphaNumeric' => array(
//                'rule' => array('minLength', 8),
//                'message' => 'f off'
//            )
//        )
//	);

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Classroom' => array(
            'className' => 'Classroom',
            'foreignKey' => 'classroom_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
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
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Quiz' => array(
            'className' => 'Quiz',
            'foreignKey' => 'submission_id',
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
        'Subjective' => array(
            'className' => 'Subjective',
            'foreignKey' => 'submission_id',
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
        'UsersSubmission' => array(
            'className' => 'UsersSubmission',
            'foreignKey' => 'submission_id',
        )
    );


    /**
     * hasAndBelongsToMany associations
     * Convert to join model (hasMany)
     * @var array
     */
//    public $hasAndBelongsToMany = array(
//        'AppUser' => array(
//            'className' => 'AppUser',
//            'joinTable' => 'users_submissions',
//            'foreignKey' => 'submission_id',
//            'associationForeignKey' => 'user_id',
//            'unique' => 'keepExisting',
//            'conditions' => '',
//            'fields' => '',
//            'order' => '',
//            'limit' => '',
//            'offset' => '',
//            'finderQuery' => '',
//        )
//    );

    /**
     * Given post data from controller API, save the subjective submission
     * @param $postData
     * @param $classroomId
     * @return mixed
     */
    public function addSubjective($postData, $classroomId) {
        $postData['Submission']['classroom_id'] = $classroomId;
        $postData['Submission']['type'] = 'subjective';
//        $this->log($postData);

        $options['deep'] = true;
        $options['validate'] = false;

        $this->log($postData);

        return @$this->saveAssociated($postData, $options);
//        if ($this->Subjective->saveAssociated($postData, $options)) {
//            $status = true;
//        } else {
//            $status = false;
//        }
//
//        return $status;
    }

    /**
     * @param $classroomId
     * @param $userId
     * @param int $page
     * @param bool $submissionId
     * @return array
     */
    public function getPaginatedSubmissions($classroomId, $userId, $page = 1, $submissionId = false) {
        //sanity check
        if ($page < 1) {
            $page = 1;
        }

        $options['conditions'] = array(
            'Submission.classroom_id' => $classroomId,
//            'UsersSubmission.user_id' => AuthComponent::user('id')
        );
//        $options['recursive'] = -1;
        $options['contain'] = array(
            'Pyoopilfile' => array(
                'fields' => array(
                    'id', 'file_path', 'filename', 'filesize', 'mime_type', 'created'
                )
            )
        );
        $options['fields'] = array(
            'id', 'topic', 'description', 'grading_policy', 'users_submission_count',
            'due_date', 'is_published', 'type', 'subjective_scoring'
        );
        $options['limit'] = self::PAGINATION_LIMIT;
        $offset = self::PAGINATION_LIMIT * ($page - 1);
        $options['offset'] = $offset;
        $options['order'] = array(
            'Submission.created' => 'desc'
        );

        if (!empty($submissionId)) {
            $options['limit'] = 1;
            unset($options['offset']);
            $options['conditions'] = array(
                'Submission.id' => $submissionId,
            );
        }

        $data = $this->find('all', $options);

        foreach ($data as &$sub) {

            $usersSubmission = $this->UsersSubmission->getUsersSubmission($sub['Submission']['id'], $userId);

            if (empty($usersSubmission)) {
                $sub['Submission']['is_submitted'] = false;
            } else {
                $sub['Submission']['is_submitted'] = true;
                $sub['UsersSubmission'] = $usersSubmission;
            }

            if ($sub['Submission']['is_published'] === true) {
                $sub['Submission']['status'] = "Graded";
            } else {
                if (CakeTime::isPast($sub['Submission']['due_date'])) {
                    $sub['Submission']['status'] = "Pending Grading";
                } else {
                    $sub['Submission']['status'] = "In Progress";
                }
            }
        }
        unset($sub);
        return $data;
    }

    public function getSubmissionById($submissionId) {
        $options['conditions'] = array(
            'Submission.id' => $submissionId,
        );

        $options['contain'] = array(
            'Pyoopilfile' => array(
                'fields' => array(
                    'id', 'file_path', 'filename', 'filesize', 'mime_type', 'created'
                )
            )
        );
        return $this->find('first', $options);
    }

    public function getPermissions($userId, $classroomId) {

        if ($this->Classroom->isOwner($userId, $classroomId)) {
            $role = "Owner";
            $allowCreate = true;
        } else {
            $role = "Student";
            $allowCreate = false;
        }
        $permissions = array(
            'role' => $role,
            'allowCreate' => $allowCreate
        );
        return $permissions;
    }

    /**
     * Calculate the scores of a quiz attempted by a student
     */
    public function scoreTheQuiz() {

    }

    public function getQuiz($submissionId) {
        //return error if invalid submissionId or submission is not a quiz
        $options = array(
            'conditions' => array(
                'Submission.id' => $submissionId
            ),
            'contains' => array(
                'Quiz' => array(
                    'Quizquestion' => array(
                        'Choice'
                    )
                )
            )
        );

        $data = $this->find('first', $options);
        $this->log($data);
    }

    public function getGradeSubmissionTile($userId, $submissionId) {
        $appUser = $this->UsersSubmission->AppUser->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'AppUser.id' => $userId
            ),
            'fields' => array(
                'id', 'fname', 'lname', 'profile_img'
            )
        ));

        $usersSubmission = $this->UsersSubmission->getUsersSubmission($submissionId, $userId);

        if (empty($usersSubmission)) {
            $sub['Submission']['is_submitted'] = false;
        } else {
            $sub['Submission']['is_submitted'] = true;
        }
        $sub['UsersSubmission'] = $usersSubmission;
        $data = array_merge($appUser, $sub);

        return $data;
    }
}
