<?php

App::uses('AppModel', 'Model');

/**
 * Campus Model
 *
 * @property University $University
 * @property Classroom $Classroom
 * @property Degree $Degree
 * @property Department $Department
 * @property User $User
 */
class Campus extends AppModel {
    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'University' => array(
            'className' => 'University',
            'foreignKey' => 'university_id',
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
        'Classroom' => array(
            'className' => 'Classroom',
            'foreignKey' => 'campus_id',
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
        'Degree' => array(
            'className' => 'Degree',
            'foreignKey' => 'campus_id',
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
        'Department' => array(
            'className' => 'Department',
            'foreignKey' => 'campus_id',
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
        'User' => array(
            'className' => 'User',
            'joinTable' => 'users_campuses',
            'foreignKey' => 'campus_id',
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

}
