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
            'className' => 'User',
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

    public function answerSubjective($userId, $postData) {
        //submission_id is already in the post data
        $postData['AppUser']['id'] = $userId;

        if (@$this->saveAssociated($postData, array(
            'validate' => false,
            'deep' => true
        ))
        ) {
            return true;
        } else {
            $this->log("behen");
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

}
