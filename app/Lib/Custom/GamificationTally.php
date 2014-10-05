<?php
App::uses('CakeEventListener', 'Event');

class GamificationTally implements CakeEventsListener {

    public function implementedEvents() {
        return array(
            'Gamificationvote.setGamificationVote' => 'updateTally',
        );
    }

    public function updateTally() {
        //TODO: @Nakul
        //1. You need to update the gamfication vote tally in users_classrooms table
        //2. You need to update the gamification vote tally in the users tables
        //You will probably write appropriate methods in the models UsersClassroom and AppUser
    }
}