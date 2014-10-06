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
//        'classroom_id' => array(
//            'numeric' => array(
//                'rule' => array('numeric'),
//                //'message' => 'Your custom message here',
//                //'allowEmpty' => false,
//                //'required' => false,
//                //'last' => false, // Stop validation after this rule
//                //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
//        'total_submitted' => array(
//            'numeric' => array(
//                'rule' => array('numeric'),
//                //'message' => 'Your custom message here',
//                //'allowEmpty' => false,
//                //'required' => false,
//                //'last' => false, // Stop validation after this rule
//                //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
//        'is_saved' => array(
//            'boolean' => array(
//                'rule' => array('boolean'),
//                //'message' => 'Your custom message here',
//                //'allowEmpty' => false,
//                //'required' => false,
//                //'last' => false, // Stop validation after this rule
//                //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
//        'is_published' => array(
//            'boolean' => array(
//                'rule' => array('boolean'),
//                //'message' => 'Your custom message here',
//                //'allowEmpty' => false,
//                //'required' => false,
//                //'last' => false, // Stop validation after this rule
//                //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
        'topic' => array(
            'alphaNumeric' => array(
                'rule' => array('minLength', 8),
                'message' => 'Topic should be minimum 8 characters',
                'allowEmpty' => false,
                'required' => true,
            ),
//            'notEmpty' => arraY(
//                'rule' => 'notEmpty',
//                'allowEmpty' => false,
//                'message' => 'topic cannot be empty'
//            )
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
//        'Subjective' => array(
//            'className' => 'Subjective',
//            'foreignKey' => 'submission_id',
//            'dependent' => false,
//            'conditions' => '',
//            'fields' => '',
//            'order' => '',
//            'limit' => '',
//            'offset' => '',
//            'exclusive' => '',
//            'finderQuery' => '',
//            'counterQuery' => ''
//        ),
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

        return @$this->saveAssociated($postData, $options);
    }

    /**
     * get paginated submissions of $classroomId, requested by $userId, specified by $page
     * OR
     * a specific submission specified by $submissionId
     * Note that this view handles both owner(educator) and student view
     * as student view is a subset of educator view
     * @param $classroomId
     * @param $userId - used to get data specific to a students submission
     * @param int $page
     * @param bool $submissionId - used in the case of getting only one submission
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
            'due_date', 'is_published', 'status', 'type', 'subjective_scoring'
        );
        $options['limit'] = self::PAGINATION_LIMIT;
        $offset = self::PAGINATION_LIMIT * ($page - 1);
        $options['offset'] = $offset;
        $options['order'] = array(
            'Submission.created' => 'desc'
        );

        /**
         * This is the case when this method is being used
         * for getting a single submission
         * refer public function getSubmissionById($userId, $submissionId)
         */
        if (!empty($submissionId)) {
            $options['limit'] = 1;
            unset($options['offset']);
            $options['conditions'] = array(
                'Submission.id' => $submissionId,
            );
        }

        $data = $this->find('all', $options);

        //Only applicable for students
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

    /**
     * @param $userId
     * @param $submissionId
     * @return array
     */
    public function getSubmissionById($userId, $submissionId) {
        return $this->getPaginatedSubmissions(null, $userId, 1, $submissionId);
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

    public function getShi() {
//        $data = array(
//            'User' => array('email' => 'john-doe@cakephp.org'),
//            'Cart' => array(
//                array(
//                    'payment_status_id' => 2,
//                    'total_cost' => 250,
//                    'CartItem' => array(
//                        array(
//                            'cart_product_id' => 3,
//                            'quantity' => 1,
//                            'cost' => 100,
//                        ),
//                        array(
//                            'cart_product_id' => 5,
//                            'quantity' => 1,
//                            'cost' => 150,
//                        )
//                    )
//                )
//            )
//        );

        $data = array(
            'Submission' => array(
                'topic' => 'some topic',
                'description' => 'the description',
                'grading_policy' => 'grade hard',
                'due_date' => '2015-06-18T10:34:09',
                'type' => 'quiz',
                'classroom_id' => '13'
            ),
            'Quiz' => array(
                array(
                    'duration' => 8400,
                    'Quizquestion' => array(
                        array(
                            'marks' => 2,
                            'question' => 'this is the first question',
                            'type' => 'single-select',
                            'Choice' => array(
                                array(
                                    'description' => 'this is choice 1'
                                ),
                                array(
                                    'description' => 'this is choice 2'
                                ),
                                array(
                                    'description' => 'this is choice 3'
                                ),
                            )
                        ),
                        array(
                            'marks' => 5,
                            'question' => 'this is the second question',
                            'type' => 'single-select',
                        )
                    )
                )
            ),
        );

        return $data;


//        (
//        [Submission] => Array
//        (
//            [topic] => new quiz
//                [description] => descrption
//            [grading_policy] => grade hard
//            [due_date] => 2015 - 06 - 18T10:34:09
//            [type] => quiz
//            [classroom_id] => 13
//        )
//
//    [Quiz] => Array
//        (
//            [0] => Array
//            (
//                [Quizquestion] => Array
//                (
//                    [0] => Array
//                        (
//                            [marks] => 2
//                                    [question] => This is the first question
//                                    [type] => single - select
//                                    [Choice] => Array
//        (
//            [0] => Array
//            (
//                [description] => this is choice1
//                                                )
//
//                                            [1] => Array
//        (
//            [description] => this is choice2(right answer)
//                                                )
//
//                                            [2] => Array
//        (
//            [description] => this is choice3
//                                                )
//
//                                        )
//
//                                )
//
//                        )
//
//                    [duration] => 8400
//                )
//
//        )
//
//)
    }
}
