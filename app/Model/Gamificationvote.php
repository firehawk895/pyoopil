<?php
App::uses('AppModel', 'Model');
/**
 * Gamificationvote Model
 *
 * @property User $User
 * @property Discussion $Discussion
 * @property Reply $Reply
 */
class Gamificationvote extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Discussion' => array(
			'className' => 'Discussion',
			'foreignKey' => 'discussion_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Reply' => array(
			'className' => 'Reply',
			'foreignKey' => 'reply_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
