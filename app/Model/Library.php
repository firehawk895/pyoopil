<?php

App::uses('AppModel', 'Model');

/**
 * Library Model
 *
 * @property Classroom $Classroom
 * @property Topic $Topic
 */
class Library extends AppModel {
    
    /**
     * Notes:
     * On addition of files, getSize() and add to fileSize db field.
     * allow/dissallow file upload if Library->fileSize is not exceeded
     */

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
            'order' => ''
        )
    );

    /**
     * hasMany associations
     * @var array
     */
    public $hasMany = array(
        'Topic' => array(
            'className' => 'Topic',
            'foreignKey' => 'library_id',
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
     * Create a Library for a Classroom
     * @param type $classroomId Classroom(pk)
     * @return boolean success/failure of save()
     */
    public function add($classroomId) {
        $data = array(
            'Classroom' => array(
                'id' => $classroomId
            ),
            'Library' => array(
                'filesize' => '0'
            )
        );
        $this->create();
        if ($this->saveAssociated($data)) {
            return true;
        } else {
            return false;
        }
    }
    
    
    /**
     * 
     * @param int $classroomId
     * @return mixed topics all assorted library data
     */
    public function index($classroomId) {
        
    }
    
    /** 
     * Update the topic
     * @param int $libraryId
     * @param int $topicId
     * @param String $topicText
     */
    public function editTopic($libraryId , $topicId , $topicText) {
        
    }
}
