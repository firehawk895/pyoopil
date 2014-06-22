<?php

App::uses('AppModel', 'Model');

/**
 * Reply Model
 *
 * @property User $User
 * @property Discussion $Discussion
 * @property Gamificationvote $Gamificationvote
 */
class Reply extends AppModel {

    /**
     * belongsTo associations
     * @var array
     */
    public $belongsTo = array(
        'AppUser' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Discussion' => array(
            'className' => 'Discussion',
            'foreignKey' => 'discussion_id',
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
        'Gamificationvote' => array(
            'className' => 'Gamificationvote',
            'foreignKey' => 'reply_id',
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

    public function postReply($discussionId, $comment, $userId) {
        $data = array(
            'AppUser' => array(
                'id' => $userId
            ),
            'Discussion' => array(
                'id' => $discussionId
            ),
            'Reply' => array(
                'comment' => $comment
            )
        );

        return $this->Reply->saveAssociated($data);
    }

    public function deleteReply($replyId, $userId) {
        $reply = $this->findById($replyId);
        if ($reply['Reply']['user_id'] == $userId) {
            return $this->delete($replyId);
        }
    }

}
