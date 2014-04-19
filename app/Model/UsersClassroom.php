<?php
App::uses('AppModel', 'Model');
/**
 * UsersClassroom Model
 *
 * @property Classroom $Classroom
 * @property User $User
 */
class UsersClassroom extends AppModel {

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
			'order' => '',
                        'counterCache' => true
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
