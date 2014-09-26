<?php
App::uses('AppModel', 'Model');
/**
 * Column Model
 * @property Matchthecolumn $Matchthecolumn
 */
class Choicesanswer extends AppModel {
    /**
     * belongsTo associations
     * @var array
     */
    public $belongsTo = array(
        'AppUser' => array(
            'className' => 'AppUser',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Choice' => array(
            'className' => 'Choice',
            'foreignKey' => 'choice_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );
} 