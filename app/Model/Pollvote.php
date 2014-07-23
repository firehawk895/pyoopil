<?php

App::uses('AppModel', 'Model');

/**
 * Pollvote Model
 * @property User $User
 * @property Pollchoice $Pollchoice
 */
class Pollvote extends AppModel {

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
        'Pollchoice' => array(
            'className' => 'Pollchoice',
            'foreignKey' => 'pollchoice_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    public function hasVoted($pollChoiceId, $userId) {
        $conditions = array(
            'user_id' => $userId,
            'pollchoice_id' => $pollChoiceId
        );
        return $this->hasAny($conditions);
    }

    /**
     * User votes on a pollChoice for a poll type Discussion
     * @param  $userId Voter's user ID
     * @param  $pollChoiceId pollchoice_id of the choice on poll voted for
     * @return bool
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
        if (!$this->Pollvote->hasAny($conditions)) {
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
            $this->Pollvote->create();
            if ($this->Pollvote->saveAssociated($data)) {
                return true;
            }
        }
        return false;
    }

}
