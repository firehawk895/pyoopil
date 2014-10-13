<?php

class NotificationFactory {

    public static function getNotifiableObject() {
        return new FirebaseWrapper();
    }
}