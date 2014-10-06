<?php
App::uses('CakeEventListener', 'Event');
App::uses('ClassRegistry', 'Utility');
App::uses('CakeLog', 'Utility');

class GamificationTally implements CakeEventListener {

    public function implementedEvents() {
        return array(
            'Gamificationvote.setGamificationVote' => 'updateTally'
        );
    }

    public function updateTally(CakeEvent $event) {
        //TODO: @Nakul
        //1. You need to update the gamfication vote tally in users_classrooms table

        $this->AppUser = ClassRegistry::init('AppUser');

        if($event->data['type'] == 'Reply'){
            $this->Reply = ClassRegistry::init('Reply');
            $userId = $this->Reply->getReplyOwner($event->data['id']);

        }else if($event->data['type'] == 'Discussion'){
            $this->Discussion = ClassRegistry::init('Discussion');
            $discussion = $this->Discussion->getDiscussionById($event->data['id']);
            $userId = $discussion[0]['Discussion']['user_id'];

        }

        $this->AppUser->updateGamification($userId,$event->data['vote']);


    }
}