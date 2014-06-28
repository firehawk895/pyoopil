<?php

App::uses('AppModel', 'Model');

/**
 * Foldeddiscussion Model
 *
 * @property User $User
 * @property Discussion $Discussion
 */
class Foldeddiscussion extends AppModel {

    /**
     * pagination limit for discussions and replies
     */
    const PAGINATION_LIMIT = 15;

    /**
     * max no. of replies to retrieve per discussion
     */
    const MAX_REPLIES = 5;

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
        'Discussion' => array(
            'className' => 'Discussion',
            'foreignKey' => 'discussion_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    public function getPaginatedFoldedDiscussions($roomId, $userId, $page = 1) {
        $offset = self::PAGINATION_LIMIT * ($page - 1);
        $contain = array(
            'Discussion' => array(
                'conditions' => array(
                    'classroom_id' => $roomId
                ),
                'order' => array(
                    'created' => 'desc'
                ),
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
                )
            )
        );

        $params = array(
            'contain' => $contain,
            'limit' => self::PAGINATION_LIMIT,
            'offset' => $offset
        );

        $data = $this->find('all', $params);
        return $data;
    }

    public function processData($data, $userId) {
        for ($i = 0; $i < count($data); $i++) {
            /* Removing Gamification information */
            $hasVoted = ($this->Discussion->hasVoted('Discussion', $data[$i]['Discussion']['id'], $userId));
            $isOwner = ($data[$i]['Discussion']['user_id'] == $userId);
//            if ((!$isOwner && !$hasVoted) || !$isOwner) {
//                unset($data[$i]['Discussion']['real_praise']);
//                unset($data[$i]['Discussion']['display_praise']);
//                unset($data[$i]['Discussion']['cu']);
//                unset($data[$i]['Discussion']['in']);
//                unset($data[$i]['Discussion']['co']);
//                unset($data[$i]['Discussion']['en']);
//                unset($data[$i]['Discussion']['ed']);
//                $data[$i]['Discussion']['showGamification'] = false;
//            } else {
//                $data[$i]['Discussion']['showGamification'] = true;
//            }

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

            /* Remove Key if not folded by current user */
            if ($data[$i]['Foldeddiscussion'] == NULL) {
                $data[$i]['Discussion']['isFolded'] = false;
            } else {
                $data[$i]['Discussion']['isFolded'] = true;
            }
            unset($data[$i]['Foldeddiscussion']);

            /* Removing Gamification information for Reply */
            for ($j = 0; $j < count($data[$i]['Discussion']['Reply']); $j++) {
                $hasVoted = ($this->Discussion->hasVoted('Reply', $data[$i]['Discussion']['Reply'][$j]['id'], $userId));
                $isOwner = ($data[$i]['Discussion']['Reply'][$j]['user_id'] == $userId);
                if ((!$isOwner && !$hasVoted) || !$isOwner) {
                    unset($data[$i]['Discussion']['Reply'][$j]['real_praise']);
                    unset($data[$i]['Discussion']['Reply'][$j]['display_praise']);
                    unset($data[$i]['Discussion']['Reply'][$j]['cu']);
                    unset($data[$i]['Discussion']['Reply'][$j]['in']);
                    unset($data[$i]['Discussion']['Reply'][$j]['co']);
                    unset($data[$i]['Discussion']['Reply'][$j]['en']);
                    unset($data[$i]['Discussion']['Reply'][$j]['ed']);
                    $data[$i]['Discussion']['Reply'][$j]['showGamification'] = false;
                } else {
                    $data[$i]['Discussion']['Reply'][$j]['showGamification'] = true;
                }
            }
        }

        return $data;
    }

}
