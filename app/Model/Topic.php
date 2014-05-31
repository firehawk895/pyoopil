<?php

App::uses('AppModel', 'Model');

/**
 * Topic Model
 *
 * @property Library $Library
 * @property Link $Link
 * @property Pyoopilfile $Pyoopilfile
 */
class Topic extends AppModel {

    /**
     * belongsTo associations
     * @var array
     */
    public $belongsTo = array(
        'Library' => array(
            'className' => 'Library',
            'foreignKey' => 'library_id',
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
        'Link' => array(
            'className' => 'Link',
            'foreignKey' => 'topic_id',
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
        'Pyoopilfile' => array(
            'className' => 'Pyoopilfile',
            'foreignKey' => 'topic_id',
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
