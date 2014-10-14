<?php

class FirebasePushWrapper implements NotifyableInterface {

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

        //find a better place to put it
        $firebase = new Firebase('https://vivid-torch-3610.firebaseio.com/', 'p0TcCv6cmjUKhbBBJb0tyCjJCVxAzKuakDJLxjGy');

        foreach($usersList as $id){

            $path = $id . '/nof/';
            $firebase->push($path, $message);

            $path = $id . '/unread';
            $unread = $firebase->get($path);
            $unread += 1;

            $firebase->set($path, $unread);
        }
    }

}