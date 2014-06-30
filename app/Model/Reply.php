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

    const MAX_REPLIES = 5;

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

        return $this->saveAssociated($data);
    }

    public function deleteReply($replyId, $userId) {
        $reply = $this->findById($replyId);

        if ($reply) {
            if ($reply['Reply']['user_id'] == $userId) {
                return $this->delete($replyId);
            }
        } else {
            return false;
        }
    }

    public function processReplies($data, $userId) {
        for ($i = 0; $i < count($data); $i++) {
            $hasVoted = $this->Discussion->hasVoted('Reply', $data[$i]['Reply']['id'], $userId);
            $isOwner = ($data[$i]['Reply']['user_id'] == $userId);

            if ($hasVoted || $isOwner) {
                $data[$i]['Reply']['showGamification'] = true;
            } else {
                unset($data[$i]['Reply']['real_praise']);
                unset($data[$i]['Reply']['cu']);
                unset($data[$i]['Reply']['in']);
                unset($data[$i]['Reply']['co']);
                unset($data[$i]['Reply']['en']);
                unset($data[$i]['Reply']['ed']);
                $data[$i]['Reply']['showGamification'] = false;
            }
            
            if($hasVoted) {
                $data[$i]['allowGamificationvote'] = true;
            } else {
                $data[$i]['allowGamificationvote'] = false;
            }
            $data[$i]['Gamificationvote'] = $this->Discussion->convertGamificationVoteArray($data[$i]['Gamificationvote']);
        }

        return $data;
    }

    public function setMoreRepliesFlag($replies = array(), $page, $discussionId){

        $params = array(
            'conditions' => array(
                'discussion_id' => $discussionId
            )
        );

        $count = count($this->find('all',$params));
        $left = $count - ($page * 5);

        if($left>0){
            array_push($replies, array('moreReplies' => true));
        }else{
            array_push($replies, array('moreReplies' => false));
        }

        return $replies;
    }


}
