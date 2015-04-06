<?php
App::uses('FirebasePushWrapper', 'Lib/FirebasePushWrapper');

class NotificationFactory {

    public static function getNotifiableObject() {
        return new FirebasePushWrapper();
    }
}