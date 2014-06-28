<?php

App::uses('AppModel', 'Model');

/**
 * Pollchoice Model
 *
 * @property Discussion $Discussion
 * @property Pollvote $Pollvote
 */
class Pollchoice extends AppModel {

    /**
     * belongsTo associations
     * @var array
     */
    public $belongsTo = array(
        'Discussion' => array(
            'className' => 'Discussion',
            'foreignKey' => 'discussion_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    /**
     * hasMany associations
     * @var array
     */
    public $hasMany = array(
        'Pollvote' => array(
            'className' => 'Pollvote',
            'foreignKey' => 'pollchoice_id',
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

}
