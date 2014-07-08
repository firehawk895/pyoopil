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
     * pagination limit for discussions and replies
     */
    const PAGINATION_LIMIT = 15;

    /**
     * max no. of replies to retrieve per discussion
     */
    const MAX_REPLIES = 5;

    /**
     * TODO : room wise, and filters
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
     * Get single discussion by id
     * @param int $discussion_id
     * @return array
     */
    public function getDiscussionById($discussion_id) {

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
                ),
                'limit' => self::MAX_REPLIES,
                'order' => array(
                    'created' => 'desc'
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
            'Foldeddiscussion'
        );

        $discussion = $this->find('all', array(
            'conditions' => array('Discussion.id' => $discussion_id),
            'contain' => $contain
        ));
        return $discussion;
    }

    /**
     * show gamification vote info only to owners or people who have voted.
     * show poll vote info only to owners or people who have voted.
     * mark folded Discussions of $userId
     * Keep FoldedDiscussion key when not null
     * @param $data (all discussions)
     * @param $userId (loggedIn user's id)
     * @return mixed
     */
    public function processData($data, $userId) {
//        $this->log($data);

        for ($i = 0; $i < count($data); $i++) {
            /* Removing Gamification information if required */
            $hasVoted = ($this->Gamificationvote->hasVoted('Discussion', $data[$i]['Discussion']['id'], $userId));

//            $this->log($hasVoted);
//            $this->log($data[$i]['Discussion']['id']);

            $isOwner = ($data[$i]['Discussion']['user_id'] == $userId);
            if ($hasVoted || $isOwner) {
                $data[$i]['Discussion']['showGamification'] = true;
            } else {
                unset($data[$i]['Discussion']['real_praise']);
//            unset($data[$i]['Discussion']['display_praise']);
                unset($data[$i]['Discussion']['cu']);
                unset($data[$i]['Discussion']['in']);
                unset($data[$i]['Discussion']['co']);
                unset($data[$i]['Discussion']['en']);
                unset($data[$i]['Discussion']['ed']);
                $data[$i]['Discussion']['showGamification'] = false;
            }

            /* Converting Gamification information to friendly form */
            $data[$i]['Gamificationvote'] = $this->convertGamificationVoteArray($data[$i]['Gamificationvote']);

            /* Decide to show votes of a poll */
            if ($data[$i]['Discussion']['type'] == 'poll') {
                $this->log($data[$i]);
                $data[$i]['Pollchoice']['showPollVote'] = false;
                if ($isOwner) {
                    $data[$i]['Pollchoice']['showPollVote'] = true;
                } else {
                    for ($k = 0; $k < count($data[$i]['Pollchoice']) - 1; $k++) {
                        if ($this->Pollchoice->Pollvote->hasVoted($data[$i]['Pollchoice'][$k]['id'], $userId)) {
                            $data[$i]['Pollchoice']['showPollVote'] = true;
                            break;
                        }
                    }
                }
            }
            /* Remove Key if not folded by current user */
            if ($data[$i]['Foldeddiscussion'] == NULL) {
                $data[$i]['Discussion']['isFolded'] = false;
            } else {
                $data[$i]['Discussion']['isFolded'] = true;
            }
            unset($data[$i]['Foldeddiscussion']);

            /* Removing Gamification information for Reply */
            for ($j = 0; $j < count($data[$i]['Reply']); $j++) {
                $hasVoted = ($this->Gamificationvote->hasVoted('Reply', $data[$i]['Reply'][$j]['id'], $userId));
                $isOwner = ($data[$i]['Reply'][$j]['user_id'] == $userId);

                if ($isOwner || $hasVoted) {
                    $data[$i]['Reply'][$j]['showGamification'] = true;
                } else {
                    unset($data[$i]['Reply'][$j]['real_praise']);
//                unset($data[$i]['Reply'][$j]['display_praise']);
                    unset($data[$i]['Reply'][$j]['cu']);
                    unset($data[$i]['Reply'][$j]['in']);
                    unset($data[$i]['Reply'][$j]['co']);
                    unset($data[$i]['Reply'][$j]['en']);
                    unset($data[$i]['Reply'][$j]['ed']);
                    $data[$i]['Reply'][$j]['showGamification'] = false;
                }
                /* Converting Gamification information to friendly form */
                $data[$i]['Reply'][$j]['Gamificationvote'] = $this->convertGamificationVoteArray($data[$i]['Reply'][$j]['Gamificationvote']);
            }

            $data[$i]['moreReplies'] = $this->Reply->setMoreRepliesFlag(1,$data[$i]['Discussion']['id']);
        }
        return $data;
    }

    /**
     * Given the $data['GamificationVote'] array, converts it to a grouped form
     * for the front end
     * @param array $gamificationVote $data['GamificationVote']
     * @return array assign to $data['GamificationVote']
     */
    public function convertGamificationVoteArray($gamificationVote = array()) {

        $data['en'] = array();
        $data['in'] = array();
        $data['cu'] = array();
        $data['co'] = array();
        $data['ed'] = array();

        for ($k = 0; $k < count($gamificationVote); $k++) {
            $vote = $gamificationVote[$k]['vote'];
            $name = $gamificationVote[$k]['AppUser']['fname'] . ' ' . $gamificationVote[$k]['AppUser']['lname'];

            switch ($vote) {
                case 'en': array_push($data['en'], $name);
                    break;
                case 'in': array_push($data['in'], $name);
                    break;
                case 'cu': array_push($data['cu'], $name);
                    break;
                case 'co': array_push($data['co'], $name);
                    break;
                case 'ed': array_push($data['ed'], $name);
                    break;
            }
        }
        return $data;
    }

    /**
     * Return Discussions of a room, paginated
     * @param int $roomId - room id(pk)
     * @param int $userId - user id for context information (discussion folded or not)
     * @param int $page - page number to retrieve
     * @param bool $onlylatest - if true, then returns only latest discussion
     * @return array
     */
    public function getPaginatedDiscussions($roomId, $userId, $page, $onlylatest = false) {

        $offset = self::PAGINATION_LIMIT * ($page - 1);

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
                ),
                'limit' => self::MAX_REPLIES,
                'order' => array(
                    'created' => 'desc'
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

        $options = array(
            'contain' => $contain,
            'conditions' => array(
                'classroom_id' => $roomId
            ),
            'order' => array(
                'created' => 'desc'
            ),
            'limit' => self::PAGINATION_LIMIT,
            'offset' => $offset
        );

        if ($onlylatest) {
            $options['limit'] = 1;
            unset($options['offset']);
        }

        $data = $this->find('all', $options);
        return $data;
    }

    /**
     * Delete discussion by id by owner
     * @param $discussionId
     * @param $userId
     * @return bool
     */
    public function deleteDiscussion($discussionId, $userId) {
        //Ensure ON DELETE CASCADE in Discussion table
        $discussion = $this->findById($discussionId);
        if (($discussion != null ) && $discussion['Discussion']['user_id'] == $userId) {
            return $this->delete($discussionId);
        } else {
            return false;
        }
    }

    /**
     * Retrieve Gamification information and engagers for a Discussion or Reply
     * @param $type (Discussion/Reply)
     * @param int $id
     * @param int $page
     * @return array
     */
    public function getGamificationInfo($type, $id, $page = 1) {
        $offset = $this->PAGINATION_LIMIT * ($page - 1 );

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

        if ($type == 'Discussion') {
            $data = $this->find('first', $params);
        } elseif ($type == 'Reply') {
            $data = $this->Reply->find('first', $params);
        }
        $data['Gamificationvote'] = $this->convertGamificationVoteArray($data['Gamificationvote']);

        return $data;
    }

    /**
     * Toggle fold on discussion
     * @param $discussionId
     * @param $userId
     * @param bool $fold
     * @return bool|mixed
     */
    public function toggleFold($discussionId, $userId) {

        if (!$this->findById($discussionId)) {
            return false;
        }

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

        if ($this->Foldeddiscussion->hasAny($conditions)) {
            $Foldeddiscussion = $this->Foldeddiscussion->find('first', array(
                'conditions' => $conditions,
                'recursive' => -1
            ));

            $id = $Foldeddiscussion['Foldeddiscussion']['id'];

            return $this->Foldeddiscussion->delete($id);
        } else {
            $this->Foldeddiscussion->create();
            return $this->Foldeddiscussion->saveAssociated($data);
        }
    }

    /**
     * User votes on a pollChoice for a poll type Discussion
     * @param type $userId Voter's user ID
     * @param type $discussionid discussion_id (pk) of the poll type discussion
     * @param type $pollChoiceId pollchoice_id of the choice on poll voted for
     */
    public function setPollVote($userId, $pollChoiceId) {

        $conditions = array(
            'user_id' => $userId,
            'pollchoice_id' => $pollChoiceId
        );

        //check if its a valid poll choice
        if (!$this->Pollchoice->findById($pollChoiceId)) {
            return false;
        }

        //does not check if already voted
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

    public function getPaginatedFoldedDiscussions($roomId, $userId, $page = 1) {

        /**
         * SELECT *
         * FROM discussions AS d
         * INNER JOIN foldeddiscussions AS f ON d.id = f.discussion_id
         * WHERE f.user_id =1
         * AND d.classroom_id =1
         */
        $offset = self::PAGINATION_LIMIT * ($page - 1);

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

        $options['offset'] = $offset;
        $options['limit'] = self::PAGINATION_LIMIT;

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
                ),
                'limit' => self::MAX_REPLIES,
                'order' => array(
                    'created' => 'desc'
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

        $options['contain'] = $contain;

        $data = $this->find('all', $options);
        return $data;
    }

}
