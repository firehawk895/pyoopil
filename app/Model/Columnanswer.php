<?php
App::uses('AppModel', 'Model');
/**
 * Column Model
 * @property Matchthecolumn $Matchthecolumn
 */
class Columnanswer extends AppModel {
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
        'Firstcolumn' => array(
            'className' => 'Firstcolumn',
            'foreignKey' => 'column1_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Secondcolumn' => array(
            'className' => 'Firstcolumn',
            'foreignKey' => 'column2_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );
} 