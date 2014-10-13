<?php

class NotificationFactory {

    public static function getNotificayableObject() {
        return new FirebaseWrapper();
    }
}