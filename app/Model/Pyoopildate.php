<?php
App::uses('AppModel', 'Model');

class Pyoopildate extends AppModel {
    /**
     * hasMany associations
     * @var array
     */
    public $hasMany = array(
        'Attendance' => array(
            'className' => 'Attendance',
            'foreignKey' => 'pyoopildate_id',
        )
    );
}
