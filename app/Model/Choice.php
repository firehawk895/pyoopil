<?php
App::uses('AppModel', 'Model');
/**
 * Column Model
 * @property Matchthecolumn $Matchthecolumn
 */
class Choice extends AppModel {

    /**
     * Validation rules
     * @var array
     */
//	public $validate = array(
//		'matchthecolumn_id' => array(
//			'numeric' => array(
//				'rule' => array('numeric'),
//				//'message' => 'Your custom message here',
//				//'allowEmpty' => false,
//				//'required' => false,
//				//'last' => false, // Stop validation after this rule
//				//'on' => 'create', // Limit validation to 'create' or 'update' operations
//			),
//		),
//		'text' => array(
//			'notEmpty' => array(
//				'rule' => array('notEmpty'),
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
     * @var array
     */
    public $belongsTo = array(
        'Quizquestion' => array(
            'className' => 'Quizquestion',
            'foreignKey' => 'quizquestion_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    public $hasMany = array(
        'Choicesanswer' => array(
            'className' => 'Choicesanswer',
            'foreignKey' => 'choice_id',
            'dependent' => false,
        ),
    );
}
