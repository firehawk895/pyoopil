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
     * @var array
     */
    public $validate = array(
        'topic' => array(
            'alphaNumeric' => array(
                'rule' => array('minLength', 8),
                'message' => 'Topic should be minimum 8 characters',
                'allowEmpty' => false,
                'required' => true,
            ),
        ),
        'description' => array(
            'alphaNumeric' => array(
                'rule' => array('minLength', 8),
                'message' => 'Description should be minimum 8 characters'
            ),
        ),
        'subjective_scoring' => array(
            'allowedChoice' => array(
                'rule' => array('inList', array('marked', 'graded')),
                'allowEmpty' => false,
                'required' => true,
                'message' => 'Should be either marked or graded'
            )
        ),
        'total_marks' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'allowEmpty' => false,
                'required' => true,
                'message' => 'Marks must be a number',
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'due_date' => array(
            'isPast' => array(
                'rule' => 'isPast',
                'message' => 'Date must be valid and in the future',
                'allowEmpty' => false,
                'required' => true,
            )
        )
    );

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
        'UsersSubmission' => array(
            'className' => 'UsersSubmission',
            'foreignKey' => 'submission_id',
        )
    );


    /**
     * Custom validation rule for model
     * due_date of an assignment should be in the future
     * @param $check
     * @return bool
     */
    public function isPast($check) {
        return !CakeTime::isPast($check['due_date']);
    }

    /**
     * Given post data from controller API, save the subjective submission
     * @param $postData
     * @param $classroomId
     * @return mixed
     */
    public function addSubjective($postData, $classroomId) {
        $postData['Submission']['classroom_id'] = $classroomId;
        $postData['Submission']['type'] = 'subjective';

        $options['deep'] = true;
        $options['validate'] = false;

        $status = @$this->saveAssociated($postData, $options);

        if ($status) {
            //Create UsersSubmission entries
            //TODO: concurrency scaling bug
            $submissionId = $this->getLastInsertId();
            $this->UsersSubmission->createDummyUsersSubmissions($submissionId);
            return true;
        }
        return false;
    }

    /**
     * Given post data from controller API, save the subjective submission
     * @param $postData
     * @param $classroomId
     * @return bool
     */
    public function addQuiz($postData, $classroomId) {
        $postData['Submission']['classroom_id'] = $classroomId;
//        $postData['Submission']['type'] = 'quiz';
//        $postData['Submission']['subjective_scoring'] = "marked";

        //calculate total marks
        //sweet sweet code
        $allMarks = Hash::extract($postData, 'Quiz.0.Quizquestion.{n}.marks');
        $postData['Submission']['total_marks'] = array_sum($allMarks);

        $options = array(
            'deep' => true,
            'validate' => false,
            'atomic' => true
        );
        $status = @$this->saveAssociated($postData, $options);
        if ($status) {
            //TODO: Scalability issue
            $submissionId = $this->getLastInsertID();
            $this->UsersSubmission->createDummyUsersSubmissions($submissionId);
            return true;
        }
        return false;
    }

    /**
     * get paginated submissions of $classroomId, requested by $userId, specified by $page
     * Note that this view handles both owner(educator) and student view
     * @param $classroomId
     * @param $userId
     * @param int $page
     * @return array
     */
    public function getPaginatedSubmissions($classroomId, $userId, $page = 1) {
        /**
         * TODO: Design consideration
         * seperate the methods for student and educator view,
         * possibly "simpler" that way.
         */

        /**
         * TODO: Probable optimization
         * retrieve all usersSubmission for student view instead of queries inside loop
         */

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
            'due_date', 'is_published', 'status', 'type', 'subjective_scoring'
        );

        $options['limit'] = self::PAGINATION_LIMIT;
        $offset = self::PAGINATION_LIMIT * ($page - 1);
        $options['offset'] = $offset;
        $options['order'] = array(
            'Submission.created' => 'desc'
        );

        $data = $this->find('all', $options);

        /**
         * For student view:
         * is_submitted field injected into 'Submission' key
         * to determine if the student has submitted a submission
         * UsersSubmission also has the same field with the same purpose
         */
        if (!$this->Classroom->isOwner($userId, $classroomId)) {
            foreach ($data as &$sub) {
                //Only applicable for students
                $usersSubmission = $this->UsersSubmission->getUsersSubmission($sub['Submission']['id'], $userId);
                if ($usersSubmission['UsersSubmission']['is_submitted']) {
                    $sub['Submission']['is_submitted'] = true;
                    if (!$sub['Submission']['is_published']) {
                        unset($usersSubmission['UsersSubmission']['grade']);
                        unset($usersSubmission['UsersSubmission']['marks']);
                        unset($usersSubmission['UsersSubmission']['percentile']);
                        unset($usersSubmission['UsersSubmission']['grade_comment']);
                        unset($usersSubmission['UsersSubmission']['is_graded']);
                    }
                    $sub['UsersSubmission'] = $usersSubmission;
                } else {
                    $sub['Submission']['is_submitted'] = false;
                }
            }
        }
        //php convention
        unset($sub);
        return $data;
    }

    /**
     * update the 'status' field of all submissions
     * from "In Progress" to "Pending Grading"
     * ideally this should be time triggered
     * @param $classroomId
     */
    public function updateSubmissionsStatus($classroomId) {
        $db = $this->getDataSource();

        //must unbind all associations
        //otherwise updateAll will create joins
        //refer cakePhp documentation

        $this->unbindModel(array(
            'belongsTo' => array(
                'Classroom',
                'Pyoopilfile'
            )
        ));
        $this->unbindModel(array(
            'hasMany' => array(
                'Quiz',
                'UsersSubmission'
            )
        ));

        //mySql server time required for consistency
        //Unfortunately NOW() cannot be directly used
        //using $db->expression('NOW()') doesn't help because
        //it inserts a '=' before NOW()

        $dbTime = $db->fetchRow('SELECT NOW();');
        //$this->log($frustratedQuery);
        $this->updateAll(
            array('Submission.status' => "'Pending Grading'"),
            array(
                'AND' => array(
                    'Submission.classroom_id' => $classroomId,
                    'Submission.status' => "In Progress",
//                    'Submission.due_date' => $db->expression('NOW()') (doesn't help) see query
                    'Submission.due_date <= ' => $dbTime[0]['NOW()']
                )
            ));
        //analyse query log
        //$this->log($this->getDataSource()->getLog(false, false));
    }

    /**
     * @param $userId
     * @param $submissionId
     * @return array
     */
    public function getSubmissionById($userId, $submissionId) {
        $options['conditions'] = array(
            'Submission.id' => $submissionId,
        );

        $options['fields'] = array(
            'id', 'topic', 'description', 'grading_policy', 'users_submission_count',
            'due_date', 'is_published', 'status', 'type', 'subjective_scoring', 'total_marks', 'status'
        );

        $options['contain'] = array(
            'Pyoopilfile' => array(
                'fields' => array(
                    'id', 'file_path', 'filename', 'filesize', 'mime_type', 'created'
                )
            )
        );

        $data = $this->find('first', $options);
        return $data;
    }

    /**
     * get role and create privilege of the user of a classroom (owner and student)
     * @param $userId
     * @param $classroomId
     * @return array
     */
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
    public function scoreQuiz() {

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
    }

    /**
     * check the status field of a submission
     * "In Progress", "Pending Grading", "Graded"
     * @param $submissionId
     * @return string
     */
    public function checkStatus($submissionId) {
        $this->id = $submissionId;
        return $this->field('status');
    }
}
