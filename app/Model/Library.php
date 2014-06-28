<?php

App::uses('AppModel', 'Model');
App::uses('AttachmentBehavior', 'Uploader.Model/Behavior');

/**
 * Library Model
 *
 * @property Classroom $Classroom
 * @property Topic $Topic
 */
class Library extends AppModel {

    protected $PAGINATION_LIMIT = 15;

    /**
     * Notes:
     * On addition of files, getSize() and add to fileSize db field.
     * allow/dissallow file upload if Library->fileSize is not exceeded
     */
    public $actsAs = array(
        'Uploader.Attachment' => array(
            'file_path' => array(
                'overwrite' => true,
                'transport' => array(
                    'class' => AttachmentBehavior::S3,
                    'region' => Aws\Common\Enum\Region::SINGAPORE,
                    'folder' => 'libraries/',
                    'accessKey' => 'AKIAJSFESXV3YYXGWI4Q',
                    'secretKey' => '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',
                    'bucket' => 'pyoopil-files',
                //Dynamically add 'accesskey','secretKey','bucket'
                ),
                'metaColumns' => array(
//                  'ext' => 'extension',
//                  'type' => 'mimeType',
                    'size' => 'filesize',
                    'name' => 'filename'
//                  'exif.model' => 'camera'
                )
            )
        ),
//        'Uploader.FileValidation' => array(
//            'file_path' => array(
////                'type' => 'image',
////                'mimeType' => array('image/gif'),
//                'filesize' => 2097152,
//                'required' => false
//            )
//        )
    );

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
     * Update the topic
     * @param int $libraryId
     * @param int $topicId
     * @param String $topicText
     */
    public function editTopic($libraryId, $topicId, $topicText) {
        
    }

    public function deleteTopic($topicId){
        $this->Topic->delete($topicId);
    }

    public function createTopic($libraryId,$topicText){
        $data = array(
            'Library' => array(
                'id' => $libraryId
            ),
            'Topic' => array(
                'name' => $topicText
            )
        );

        return $this->Topic->saveAssociated($data);
    }

    /**
     * Returns library id for a classroom
     * @param $classroomId
     * @return mixed
     */
    public function getLibraryId($classroomId){
        $params['conditions'] = array(
            'classroom_id' => $classroomId
        );

        $params['recursive'] = -1;

        $data = $this->find('first',$params);
        return $data['Library']['id'];
    }

    /**
     * Retrieves topics in the library
     * @param $libraryId
     * @param int $page
     * @return array
     */
    function getPaginatedTopics($libraryId,$page=1){

        $offset = $this->PAGINATION_LIMIT*($page-1);

        $params = array(
            'conditions' => array(
                'library_id' => $libraryId,
            ),
            'contain' => array(
                'Link',
                'Pyoopilfile' => array(
                    'order' => array(
                        'Pyoopilfile.file_type ASC'
                    )
                )
            ),
            'limit' => $this->PAGINATION_LIMIT,
            'offset' => $offset
        );

        return $topics = $this->Topic->find('all',$params);
    }

}
