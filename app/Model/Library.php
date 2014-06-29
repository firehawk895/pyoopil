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

    const PAGINATION_LIMIT = 15;

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
     * @param $topicId
     * @param $topicText
     * @return bool
     */
    public function editTopic($topicId, $topicText) {

        $data = array(
            'name' => $topicText
        );

        $conditions = array(
            'Topic.id' => $topicId
        );

        return $this->Topic->updateAll($data, $conditions);
    }

    public function getLibraryId($classroomId) {

        $params['conditions'] = array(
            'classroom_id' => $classroomId
        );

        $params['recursive'] = -1;

        $data = $this->find('first', $params);

        return $data['Library']['id'];
    }

    public function deleteTopic($topicId) {
        return $this->Topic->delete($topicId);
    }

    public function createTopic($libraryId, $topicText) {
        $data = array(
            'Library' => array(
                'id' => $libraryId
            ),
            'Topic' => array(
                'name' => $topicText
            )
        );
    }

    public function getPaginatedTopics($libraryId, $page = 1) {

        $offset = self::PAGINATION_LIMIT * ($page - 1);

        $params['conditions'] = array(
            'library_id' => $libraryId,
        );

        $params['contain'] = array(
            'Link',
            'Pyoopilfile' => array(
                'order' => array(
                    'Pyoopilfile.file_type ASC'
                )
            )
        );

        $params['limit'] = self::PAGINATION_LIMIT;
        $params['offset'] = $offset;

        return $topics = $this->Topic->find('all', $params);
    }

    public function deleteItem($type, $id) {

        if ($type == 'File') {
            return $this->Topic->Pyoopilfile->delete($id);
        } elseif ($type == 'Link') {
            return $this->Topic->Link->delete($id);
        }
    }

    public function parseVideoLinks($data) {
        $pattern = '/^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/';
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['Video'] = array();
            for ($j = 0; $j < count($data[$i]['Link']); $j++) {
                $linkText = $data[$i]['Link'][$j]['linktext'];
                if (preg_match($pattern, $linkText)) {
                    $youtubeLink = array(
                        'id' => $data[$i]['Link'][$j]['id'],
                        'topic_id' => $data[$i]['Link'][$j]['topic_id'],
                        'linktext' => $data[$i]['Link'][$j]['linktext'],
                        'created' => $data[$i]['Link'][$j]['created']
                    );
                    array_push($data[$i]['Video'], $youtubeLink);
                    unset($data[$i]['Link'][$j]);
                }
            }
            $data[$i]['Link'] = array_values($data[$i]['Link']);
            $data[$i]['Video'] = array_values($data[$i]['Video']);
        }
        return $data;
    }

    public function parsePyoopilfiles($data) {
        $this->log($data);
        for ($i = 0; $i < count($data); $i++) {
            $this->log($data[$i]);
        }
    }

}
