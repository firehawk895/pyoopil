<?php

App::uses('AppModel', 'Model');

/**
 * Pyoopilfile Model
 *
 * @property Topic $Topic
 * @property Announcement $Announcement
 * @property Submission $Submission
 * @property UsersSubmission $UsersSubmission
 */
class Pyoopilfile extends AppModel {

    /**
     * belongsTo associations
     * @var array
     */
    public $belongsTo = array(
        'Topic' => array(
            'className' => 'Topic',
            'foreignKey' => 'topic_id',
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
//		'Announcement' => array(
//			'className' => 'Announcement',
//			'foreignKey' => 'pyoopilfile_id',
//			'dependent' => false,
//			'conditions' => '',
//			'fields' => '',
//			'order' => '',
//			'limit' => '',
//			'offset' => '',
//			'exclusive' => '',
//			'finderQuery' => '',
//			'counterQuery' => ''
//		),
//		'Submission' => array(
//			'className' => 'Submission',
//			'foreignKey' => 'pyoopilfile_id',
//			'dependent' => false,
//			'conditions' => '',
//			'fields' => '',
//			'order' => '',
//			'limit' => '',
//			'offset' => '',
//			'exclusive' => '',
//			'finderQuery' => '',
//			'counterQuery' => ''
//		),
//		'UsersSubmission' => array(
//			'className' => 'UsersSubmission',
//			'foreignKey' => 'pyoopilfile_id',
//			'dependent' => false,
//			'conditions' => '',
//			'fields' => '',
//			'order' => '',
//			'limit' => '',
//			'offset' => '',
//			'exclusive' => '',
//			'finderQuery' => '',
//			'counterQuery' => ''
//		)
    );
    //    public function beforeUpload($options) {
//
//        $options['transport']['accessKey'] = getenv('S3_ACCESS_KEY');
//        $options['transport']['secretKey'] = getenv('S3_SECRET_KEY');
//        $options['transport']['bucket'] = getenv('S3_BUCKET');
//
//        return $options;
//    }

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
                    'type' => 'mime_type',
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

}
