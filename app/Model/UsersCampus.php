<?php

App::uses('AppModel', 'Model');

/**
 * UsersCampus Model
 *
 * @property User $User
 * @property Campus $Campus
 * @property Department $Department
 * @property Degree $Degree
 */
class UsersCampus extends AppModel {
    
    /**
     * db Notes:
     * campus -> department -> degree
     * ideally only 1 of these keys should be populated,
     * although more than 1 can be populated to take advanatage of all keys 
     * being present.
     * 
     * User (student) can belong to a degree
     * User (educator) can belong to a department and not specific degree
     * User may belong to a campus, no association with department/degree
     */

    /**
     * belongsTo associations
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
        'Campus' => array(
            'className' => 'Campus',
            'foreignKey' => 'campus_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Department' => array(
            'className' => 'Department',
            'foreignKey' => 'department_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Degree' => array(
            'className' => 'Degree',
            'foreignKey' => 'degree_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

}
