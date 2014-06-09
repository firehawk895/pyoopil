<?php

App::uses('AppModel', 'Model');

/**
 * Discussion Model
 *
 * @property User $User
 * @property Foldeddiscussion $Foldeddiscussion
 * @property Pollchoice $Pollchoice
 * @property Reply $Reply
 * @property UsersPollchoice $UsersPollchoice
 */
class Discussion extends AppModel {

    /**
     * Common Authorization Framework:
     * Check if user is participant of room (classRoom | institutionRoom | staffRoom | groupRoom)
     * check if user is follower of myRoom's user 
     * ENUM('cu','in','co','en','ed')
     */
    
    /**
     * db notes:
     * ON DELETE CASCADE set for all related Discussion models except Classroom 
     */
    
    const CU = 1;
    const IN = 2;
    const CO = 3;
    const EN = 4;
    const ED = 5;

    public $enum = array(
        'vote' => array(
            self::CU => 'cu',
            self::IN => 'in',
            self::CO => 'co',
            self::EN => 'en',
            self::ED => 'ed'
        )
    );

    /**
     * Easily switch between enum string text and integer
     * easy hack to select required databaseField
     * @var type 
     */
    public $enumMap = array(
        self::CU => 'cu',
        self::IN => 'in',
        self::CO => 'co',
        self::EN => 'en',
        self::ED => 'ed',
        'cu' => self::CU,
        'in' => self::IN,
        'co' => self::CO,
        'en' => self::EN,
        'ed' => self::ED
    );
    public $actsAs = array(
        'Utility.Enumerable',
        'Containable'
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
        ),
        'AppUser' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
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
        'Foldeddiscussion' => array(
            'className' => 'Foldeddiscussion',
            'foreignKey' => 'discussion_id',
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
        'Gamificationvote' => array(
            'className' => 'Gamificationvote',
            'foreignKey' => 'discussion_id',
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
        'Pollchoice' => array(
            'className' => 'Pollchoice',
            'foreignKey' => 'discussion_id',
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
        'Reply' => array(
            'className' => 'Reply',
            'foreignKey' => 'discussion_id',
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
     * Discussions containable
     * @var type array()
     */
    private $containing = array(
        'Reply' => array(
            'Gamificationvote'
        ),
        'Pollchoice' => array(
            'Pollvote'
        ),
        'Gamificationvote',
        'AppUser' => array(
            'fields' => array('fname', 'lname')
        )
    );

    /**
     * @param int $discussion_id
     * @return mixed
     */
    public function getDiscussion($discussion_id) {
        /**
         *  Tested and working
         */
        $discussion = $this->find('first', array(
            'conditions' => array('Discussion.id' => $discussion_id),
            'contain' => $this->containing
        ));
        return $discussion;
    }

    /**
     * TODO : room wise, and filters
     * @param type $roomId
     * @return type
     */
    public function getAllDiscussions($roomId) {
        /**
         * Tested and working
         * if the discussion is a poll
         *      then if user voted OR user is owner
         *          fetch poll options and results [mark as 'show' => true]
         *      else
         *          fetch poll options
         * if user voted OR user is owner,
         *      then fetch gamification votes
         */
        $data = $this->find('all', array(
            'contain' => $this->containing,
            'conditions' => array(
                'classroom_id' => $roomId
            )
        ));

        return $data;
    }

    /*
     * Get folded discussions of a user for a particular room
     * @param int $userId user's id (PK)
     * @param int $roomId context room id (PK)
     * TODO : Incorporate for other rooms also
     */

    public function getFoldedDiscussions($userId, $roomId) {

        /**
         * SELECT * 
         * FROM discussions AS d
         * INNER JOIN foldeddiscussions AS f ON d.id = f.discussion_id
         * WHERE f.user_id =1
         * AND d.classroom_id =1
         */
        $options['joins'] = array(
            array('table' => 'foldeddiscussions',
                'alias' => 'Foldeddiscussion',
                'type' => 'inner',
                'conditions' => array(
                    'Discussion.id = Foldeddiscussion.discussion_id'
                )
            ),
        );

        $options['conditions'] = array(
            'Discussion.classroom_id' => $roomId,
            'Foldeddiscussion.user_id' => $userId
        );

        $options['contain'] = $this->containing;

        $discussions = $this->find('all', $options);
        return $discussions;
    }

    public function editDiscussionText($discussionId, $text) {
        $this->id = $discussionId;
        $this->saveField('body', $text);
    }

    public function deleteDiscussion($discussionId) {
        //Ensure ON DELETE CASCADE in Discussion table
        $this->delete($discussionId);
    }

    /**
     * User gives a gamification vote on a discussion (Q/P/N)
     * @param type $userId User who is voting
     * @param type $disscussionId discussion_id (pk) of the discussion
     * @param type $type - gamification vote type ENUM('cu','in','co','en','ed')
     */
    public function setGamificationDiscussion($userId, $disscussionId, $type) {
        /**
         * If exists (already voted), don't allow insert
         * allowing 'ed' vote to only to educator
         * insert gamification vote
         * update gamification scores for discussion
         */
        $conditions = array(
            'user_id' => $userId,
            'discussion_id' => $disscussionId
        );

        //make sure its a valid type to prevent database errors
        $voteTypes = Hash::combine($this->enum, 'vote.{n}');
        $validVote = array_key_exists($type, $voteTypes);

        //TODO : also make sure vote NOT already cast
        //        if ($type == self::ED)
        if ($validVote && !$this->Gamificationvote->hasAny($conditions)) {
            $this->id = $disscussionId;
            $displayPraise = $this->field('display_praise') + 1;

            if ($type == $this->enumMap[self::ED]) {
                $realPraise = $this->field('real_praise') + 10;
            } else {
                $realPraise = $this->field('real_praise') + 1;
            }

            $vote = $this->field($type) + 1;

            $this->Gamificationvote->create();
            $data = array(
                'User' => array(
                    'id' => $userId
                ),
                'Discussion' => array(
                    'id' => $disscussionId,
                    'display_praise' => $displayPraise,
                    'real_praise' => $realPraise,
                    $type => $vote
                ),
                'Gamificationvote' => array(
                    'vote' => $type
                )
            );
            if ($this->Gamificationvote->saveAssociated($data)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * User gives a gamification vote on a discussion's reply (answer/comment)
     * @param type $userId
     * @param type $replyId
     * @param type $type gamification vote type ENUM('cu','in','co','en','ed')
     */
    public function setGamificationReply($userId, $replyId, $type) {
        /**
         * If exists (already voted), don't allow insert
         * allowing 'ed' vote to only to educator
         * insert gamification vote
         * update gamification scores for discussion
         */
        $conditions = array(
            'user_id' => $userId,
            'reply_id' => $replyId
        );

        //make sure its a valid type to prevent database errors
        $voteTypes = Hash::combine($this->enum, 'vote.{n}');
        $validVote = array_key_exists($type, $voteTypes);

        //TODO : also make sure vote NOT already cast
        //        if ($type == self::ED)
        if ($validVote && !$this->Gamificationvote->hasAny($conditions)) {
            $this->id = $replyId;
            $displayPraise = $this->field('display_praise') + 1;

            if ($type == $this->enumMap[self::ED]) {
                $realPraise = $this->field('real_praise') + 10;
            } else {
                $realPraise = $this->field('real_praise') + 1;
            }

            $vote = $this->field($type) + 1;

            $this->Gamificationvote->create();
            $data = array(
                'User' => array(
                    'id' => $userId
                ),
                'Reply' => array(
                    'id' => $replyId,
                    'display_praise' => $displayPraise,
                    'real_praise' => $realPraise,
                    $type => $vote
                ),
                'Gamificationvote' => array(
                    'vote' => $type
                )
            );
            if ($this->Gamificationvote->saveAssociated($data)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getGamificationDiscussion($discussionId) {
        $discussion = $this->find('first', array(
            'conditions' => array('Discussion.id' => $discussionId),
            'fields' => array(
                'display_praise',
                $this->enumMap[self::CU],
                $this->enumMap[self::IN],
                $this->enumMap[self::CO],
                $this->enumMap[self::EN],
                $this->enumMap[self::ED]
            ),
            'recursive' => -1
        ));
        return $discussion;
    }

    public function getGamificationReply($replyId) {
        $reply = $this->Reply->find('first', array(
            'conditions' => array('Reply.id' => $replyId),
            'fields' => array(
                'display_praise',
                $this->enumMap[self::CU],
                $this->enumMap[self::IN],
                $this->enumMap[self::CO],
                $this->enumMap[self::EN],
                $this->enumMap[self::ED]
            ),
            'recursive' => -1
        ));
        return $reply;
    }

    /**
     * User votes on a poll type discussion
     * @param type $userId Voter's user ID
     * @param type $discussionid discussion_id (pk) of the poll type discussion
     * @param type $pollChoiceId pollchoice_id of the choice on poll voted for
     */
    public function setVoteOnPoll($userId, $pollChoiceId) {

        $conditions = array(
            'user_id' => $userId,
            'pollchoice_id' => $pollChoiceId
        );

        //TODO : check if its a valid poll choice

        if (!$this->Pollchoice->Pollvote->hasAny($conditions)) {
            $this->Pollchoice->id = $pollChoiceId;
            $newVotes = $this->Pollchoice->field('votes') + 1;
//            $this->Pollchoice->id = $pollChoiceId;
//            $this->Pollchoice->saveField('votes' , $newVotes);

            $data = array(
                'User' => array(
                    'id' => $userId
                ),
                'Pollchoice' => array(
                    'id' => $pollChoiceId,
                    'votes' => $newVotes
                )
            );
            $this->Pollchoice->Pollvote->create();
            if ($this->Pollchoice->Pollvote->saveAssociated($data)) {
                return true;
            }
        }
        return false;
    }

    public function foldDiscussion($userId, $discussionId) {
        //If already folded then ignore

        $conditions = array(
            'user_id' => $userId,
            'discussion_id' => $discussionId
        );

        $data = array(
            'User' => array('id' => $userId),
            'Discussion' => array('id' => $discussionId)
        );

        if (!$this->Foldeddiscussion->hasAny($conditions)) {
            $this->Foldeddiscussion->create();
            if ($this->Foldeddiscussion->saveAssociated($data)) {
                return true;
            }
        }
        return false;
    }

    public function unfoldDiscussion($userId, $discussionId) {

        //Sadness : User.id notation translated to joins!
        //will not work with recursive -1
        //this is a sweeter approach
        $conditions = array(
            'user_id' => $userId,
            'discussion_id' => $discussionId
        );

        $foldedDiscussion = $this->Foldeddiscussion->find('first', array(
            'conditions' => $conditions,
            'recursive' => -1
        ));

        if ($foldedDiscussion) {
            $this->Foldeddiscussion->delete($foldedDiscussion[Foldeddiscussion][id]);
            return true;
        }

        return false;
    }

}
