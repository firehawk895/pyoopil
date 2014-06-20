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

    public $PAGINATION_LIMIT = 15;

    /**     * TODO : room wise, and filters

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

    const limit = 15;

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
            'Gamificationvote' => array(
                'AppUser' => array(
                    'fields' => array(
                        'fname',
                        'lname'
                    )
                )
            ),
            'AppUser' => array(
                'fields' => array(
                    'fname',
                    'lname'
                )
            )
        ),
        'Pollchoice' => array(
            'Pollvote'
        ),
        'Gamificationvote' => array(
            'AppUser' => array(
                'fields' => array(
                    'fname',
                    'lname'
                )
            )
        ),
        'AppUser' => array(
            'fields' => array('fname', 'lname')
        )
    );

    /**
     * Retrieve Discussion by id
     * @param int $discussion_id
     * @return mixed
     */
    public function getDiscussion($discussion_id) {

        $discussion = $this->find('first', array(
            'conditions' => array('Discussion.id' => $discussion_id),
            'contain' => $this->containing
        ));
        return $discussion;
    }

    /**
     * Remove Gamification information where loggedIn user is not the owner of Discussion/Reply and he hasn't voted
     * Keep FoldedDiscussion key when not null
     * @param $data (all discussions)
     * @param $userId (loggedIn user's id)
     * @return mixed
     */
    public function processData($data, $userId){

        for($i=0;$i<count($data);$i++){
            /*Removing Gamification information*/
            $hasVoted = ($this->hasVoted('Reply',$data[$i]['Discussion']['id'],$userId));
            $isOwner = ($data[$i]['Discussion']['user_id'] == $userId);
            if((!$isOwner && !$hasVoted) || !$isOwner){
                unset($data[$i]['Discussion']['real_praise']);
                unset($data[$i]['Discussion']['display_praise']);
                unset($data[$i]['Discussion']['cu']);
                unset($data[$i]['Discussion']['in']);
                unset($data[$i]['Discussion']['co']);
                unset($data[$i]['Discussion']['en']);
                unset($data[$i]['Discussion']['ed']);
            }

            /*Remove Key if not folded by current user*/
            if($data[$i]['Foldeddiscussion'] == NULL){
                unset($data[$i]['Foldeddiscussion']);
            }
            /*Removing Gamification information for Reply*/
            for($j=0;$j<count($data[$i]['Reply']);$j++){
                $hasVoted = ($this->hasVoted('Reply',$data[$i]['Reply'][$j]['id'],$userId));
                $isOwner = ($data[$i]['Reply'][$j]['user_id'] == $userId);
                if((!$isOwner && !$hasVoted) || !$isOwner){
                    unset($data[$i]['Reply'][$j]['real_praise']);
                    unset($data[$i]['Reply'][$j]['display_praise']);
                    unset($data[$i]['Reply'][$j]['cu']);
                    unset($data[$i]['Reply'][$j]['in']);
                    unset($data[$i]['Reply'][$j]['co']);
                    unset($data[$i]['Reply'][$j]['en']);
                    unset($data[$i]['Reply'][$j]['ed']);
                }
            }
        }

        return $data;
    }

    public function getPaginatedDiscussions($roomId,$userId,$page=1){

        $offset = $this->PAGINATION_LIMIT*($page-1);

        $contain = array(
            'Reply' => array(
                'Gamificationvote' => array(
                    'AppUser' => array(
                        'fields' => array(
                            'fname',
                            'lname'
                        )
                    )
                ),
                'AppUser' => array(
                    'fields' => array(
                        'fname',
                        'lname'
                    )
                )
            ),
            'Pollchoice' => array(
                'Pollvote'
            ),
            'Gamificationvote' => array(
                'AppUser' => array(
                    'fields' => array(
                        'fname',
                        'lname'
                    )
                )
            ),
            'AppUser' => array(
                'fields' => array('fname', 'lname')
            ),
            'Foldeddiscussion' => array(
                'conditions' => array(
                    'user_id' => $userId
                )
            )
        );


        $data = $this->find('all', array(
                'contain' => $contain,
                'conditions' => array(
                    'classroom_id' => $roomId
                ),
                'order' => array(
                    'created' => 'desc'
                ),
                'limit' => $this->PAGINATION_LIMIT,
                'offset' => $offset
            )
        );
        return $data;
    }

    public function deleteDiscussion($discussionId) {
        //Ensure ON DELETE CASCADE in Discussion table
        $this->delete($discussionId);
    }

    /**
     * Checks if a user has voted on a reply or discussion
     * @param $type (Discussion,Reply)
     * @param $id
     * @param $userId
     * @return boolean
     */
    public function hasVoted($type,$id,$userId){
        $conditions= array(
                'user_id' => $userId
        );

        if($type == 'Discussion'){
            $conditions = Hash::insert($conditions,'discussion_id',$id);
        }elseif($type == 'Reply'){
            $conditions = Hash::insert($conditions,'reply_id',$id);
        }

        return $this->Gamificationvote->hasAny($conditions);
    }

    /**
     * Vote on a particular Discussion or Reply
     * @param $type
     * @param $id
     * @param $vote
     * @param $userId
     * @return boolean
     */
    public function setGamificationVote($type,$id,$vote,$userId){

        $params = array(
            'contain' => array(
                'Gamificationvote'
            ),
            'conditions' => array(
                'id' => $id
            ),
        );

        $voteTypes = Hash::combine($this->enum, 'vote.{n}');
        $validVote = array_key_exists($vote, $voteTypes);

        if($type == 'Discussion'){
            $this->id = $id;
            $data = $this->find('first',$params);
        }elseif($type == 'Reply'){
            $this->Reply->id = $id;
            $data = $this->Reply->find('first',$params);
        }

        /*Ensuring no self vote*/
        if($data[$type]['user_id'] != $userId){
            /*Ensuring no duplicate voting and valid voting*/
            if(!$this->hasVoted($type,$id,$userId) && $validVote){

                $displayPraise = $data[$type]['display_praise'] + 1;

                if($vote == $this->enumMap[self::ED]){
                    $realPraise = $data[$type]['real_praise'] + 10;
                }else{
                    $realPraise = $data[$type]['real_praise'] + 1;
                }

                $voteValue = $data[$type][$vote] + 1;

                $record = array(
                    $type => array(
                        'id' => $id,
                        'display_praise' => $displayPraise,
                        'real_praise' => $realPraise,
                        $vote => $voteValue
                    ),
                    'Gamificationvote' => array(
                        'vote' => $vote,
                        'user_id' => $userId
                    )
                );

                return $this->Gamificationvote->saveAssociated($record);
            }
            else{
                /*duplicate vote error message*/
                return false;
            }
        }else{
            /*voting on own discussion/reply*/
            return false;
        }
    }

    /**
     * Retrieve Gamification information and engagers for a Discussion or Reply
     * @param $type
     * @param $id
     * @param int $page
     * @return array
     */
    public function getGamificationInfo($type,$id,$page=1){
        $offset = $this->PAGINATION_LIMIT*($page-1);

        $params = array(
            'contain' => array(
                'Gamificationvote' => array(
                    'AppUser' => array(
                        'fields' => array(
                            'fname',
                            'lname'
                        )
                    )
                )
            ),
            'fields' => array(
                'id',
                'display_praise',
                $this->enumMap[self::CU],
                $this->enumMap[self::IN],
                $this->enumMap[self::CO],
                $this->enumMap[self::EN],
                $this->enumMap[self::ED]
            ),
            'conditions' => array(
                'id' => $id
            ),
            'offset' => $offset,
            'limit' => $this->PAGINATION_LIMIT
        );

        if($type == 'Discussion'){
            $data = $this->find('first',$params);
        }elseif($type == 'Reply'){
            $data = $this->Reply->find('first',$params);
        }

        return $data;
    }

    /**
     * Toggle fold on discussion
     * @param $discussionId
     * @param $userId
     * @param bool $fold
     * @return bool|mixed
     */
    public function toggleFold($discussionId, $userId, $fold=true){

        $conditions = array(
            'user_id' => $userId,
            'discussion_id' => $discussionId
        );

        $data = array(
            'User' => array(
                'id' => $userId
            ),
            'Discussion' => array(
                'id' => $discussionId
            )
        );

        if($fold){
            $this->Foldeddiscussion->create();
            return $this->Foldeddiscussion->saveAssociated($data);
        }else{
            $id = $this->Foldeddiscussion->find('first',array(
                'conditions' => $conditions,
                'recursive' => -1
            ));

            return $this->Foldeddiscussion->delete($id);
        }
    }

    /**
     * User votes on a poll type discussion
     * @param type $userId Voter's user ID
     * @param type $discussionid discussion_id (pk) of the poll type discussion
     * @param type $pollChoiceId pollchoice_id of the choice on poll voted for
     */
    public function setPollVote($userId, $pollChoiceId) {

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

    public function postReply($discussionId,$comment,$userId){
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

    public function addDiscussion($data){

    }

}
