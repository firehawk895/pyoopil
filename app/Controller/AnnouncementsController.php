<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AnnouncementsController extends AppController {

    /**
     * Announcements of a classroom
     * @param type $classroomId
     */
    public function index($classroomId) {
        /**
         * throw not found exception if classroom does not exist
         */
        $this->set('classroomId', $classroomId);
    }

}
