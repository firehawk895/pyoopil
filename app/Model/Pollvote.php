<?php

App::uses('AppModel', 'Model');

/**
 * Pollvote Model
 *
 * @property User $User
 * @property Pollchoice $Pollchoice
 */
class Pollvote extends AppModel {

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
        'Pollchoice' => array(
            'className' => 'Pollchoice',
            'foreignKey' => 'pollchoice_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

}
