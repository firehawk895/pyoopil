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
        )
    );


    /**
     * hasAndBelongsToMany associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
        'AppUser' => array(
            'className' => 'AppUser',
            'joinTable' => 'users_submissions',
            'foreignKey' => 'submission_id',
            'associationForeignKey' => 'user_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
        )
    );

    public function addSubjective($postData, $classroomId) {
        $postData['Submission']['classroom_id'] = $classroomId;
        $postData['Submission']['type'] = 'subjective';
//        $this->log($postData);

        $options['deep'] = true;
        $options['validate'] = false;

        return $this->Subjective->saveAssociated($postData, $options);
//        if ($this->Subjective->saveAssociated($postData, $options)) {
//            $status = true;
//        } else {
//            $status = false;
//        }
//
//        return $status;
    }

    public function getPaginatedSubmissions($classroomId, $page = 1, $onlylatest = false) {
        //sanity check
        if ($page < 1) {
            $page = 1;
        }

        $options['conditions'] = array(
            'Submission.classroom_id' => $classroomId
        );
        $options['recursive'] = -1;
        $options['fields'] = array(
            'id', 'topic', 'description', 'grading_policy', 'total_submitted',
            'due_date', 'is_published', 'type', 'subjective_scoring'
        );
        $options['limit'] = self::PAGINATION_LIMIT;
        $offset = self::PAGINATION_LIMIT * ($page - 1);
        $options['offset'] = $offset;
        $options['order'] = array(
            'Submission.created' => 'desc'
        );

        if ($onlylatest) {
            $options['limit'] = 1;
            unset($options['offset']);
        }

        $data = $this->find('all', $options);

        foreach ($data as &$sub) {
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

}
