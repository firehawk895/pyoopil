<?php
App::uses('AppModel', 'Model');
/**
 * Quizquestion Model
 *
 * @property Quiz $Quiz
 * @property Matchthecolumn $Matchthecolumn
 * @property Multiplechoice $Multiplechoice
 * @property User $User
 */
class Quizquestion extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
//        'quiz_id' => array(
//            'numeric' => array(
//                'rule' => array('numeric'),
//                //'message' => 'Your custom message here',
//                //'allowEmpty' => false,
//                //'required' => false,
//                //'last' => false, // Stop validation after this rule
//                //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
        'marks' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                'message' => "Marks must be valid and present for all questions",
                'allowEmpty' => false,
                'required' => true
            ),
        ),
        'question' => array(
            'alphaNumeric' => array(
                'rule' => array('minLength', 8),
                'message' => 'all questions should be non-empty and 8 characters',
                'allowEmpty' => false,
                'required' => true,
            ),
        ),
        'type' => array(
            'allowedChoice' => array(
                'rule' => array('inList', array('single-select', 'multi-select', 'true-false', 'match-columns')),
                'allowEmpty' => false,
                'required' => true,
                'message' => 'Question type should be single-select, multi-select, true-false or match-columns'
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
        'Quiz' => array(
            'className' => 'Quiz',
            'foreignKey' => 'quiz_id',
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
        'Column' => array(
            'className' => 'Column',
            'foreignKey' => 'quizquestion_id',
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
        'Choice' => array(
            'className' => 'Choice',
            'foreignKey' => 'quizquestion_id',
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
//		'Multiplechoice' => array(
//			'className' => 'Multiplechoice',
//			'foreignKey' => 'quizquestion_id',
//			'dependent' => false,
//			'conditions' => '',
//			'fields' => '',
//			'order' => '',
//			'limit' => '',
//			'offset' => '',
//			'exclusive' => '',
//			'finderQuery' => '',
//			'counterQuery' => ''
//		)
    );


    /**
     * hasAndBelongsToMany associations
     *
     * @var array
     */
//	public $hasAndBelongsToMany = array(
//		'AppUser' => array(
//			'className' => 'User',
//			'joinTable' => 'users_quizquestionsanswers',
//			'foreignKey' => 'quizquestion_id',
//			'associationForeignKey' => 'user_id',
//			'unique' => 'keepExisting',
//			'conditions' => '',
//			'fields' => '',
//			'order' => '',
//			'limit' => '',
//			'offset' => '',
//			'finderQuery' => '',
//		)
//	);

}
