<?php

/*
 * (c) Pyoopil Education Technologies
 * TODO : Add detailed licence headers
 */
App::uses('AppController', 'Controller');

class DiscussionsController extends AppController {

    public function testcases() {
        /**
         * WORKING TEST CASES:
         * debug($this->Discussion->getDiscussion(1));
         * debug($this->Discussion->getAllDiscussions());
         * debug($this->Discussion->editDiscussionText(1, 'suck my loda now, immediately')); //OK
         * debug($this->Discussion->deleteDiscussion('1'));
         *      *Cascading works on gamificationvote, other related cascades set
         * debug($this->Discussion->enum('vote'));
         * $this->Discussion->setGamificationDiscussion('5', '5', 'cu');
         *      *Gamification voting works, praise is incremented, 'cu' is updated
         *      *duplicate votes prevented
         * debug($this->Discussion->setGamificationDiscussion('5', '5', 'ed'));
         *      *endorsement effects real praise, and is tallied correctly
         *      *invalid votes are ignored
         * debug($this->Discussion->setGamificationReply('5', '1', 'ed'));
         *      *endorsement working, duplicates dissallowed, other votes working, invalid votes caught
         * debug($this->Discussion->getGamificationDiscussion(5));
         * debug($this->Discussion->getGamificationReply(1));
         * debug($this->Discussion->setVoteOnPoll('5' , '1'));
         *      TODO: handle invalid user and pollchoiceId
         * debug($this->Discussion->foldDiscussion('5','6'));
         *      *folds
         *      *prevents duplicates
         * debug($this->Discussion->unfoldDiscussion('5','6')); 
         *      *checks if exists then unfolds
         * debug($this->Discussion->getFoldedDiscussions('1', '3'));
         *      * Looks good, working in the few tested cases
         *      * contains hierarchy of discussions (pollchoices,gamification etc.) 
         *      * returned well  
         */
        
    }

    /**
     * Ajax action to get favorites
     * Dummy method - remove this
     */
    public function favorites() {
        $this->autoRender = false; // We don't render a view in this example
//        $this->request->onlyAllow('ajax'); // No direct access via browser URL

        $data = array(
            'content' => array(
                'test' => 'xyz'
            ),
            'error' => null,
        );
        return json_encode($data);
    }
    
    /**
     * Display Discussions of a classroom
     * @param type $classroomId
     */
    public function index($classroomId) {
        
        /**
         * throw not found exception if classroom does not exist
         */
        $this->set('classroomId' , $classroomId);
        $data = $this->Discussion->getAllDiscussions($classroomId);
        debug($data);
        die();
        $this->set('discussions',$data);
    }
}
