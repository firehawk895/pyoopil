<?php

class FirebaseWrapper implements NotifyableInterface {

    /**
     *
     * @param $message - the notification object to be pushed
     * @param $usersList - the list of users to be pushed to
     */
    public function push($message, $usersList) {
        //run a transaction
        //for loop over objects and do a push
        //or perhaps there should have been a bulk push
        //or make your own parallizable implementation
    }

}