<?php
App::uses('AppController', 'Controller');

/**
 * Class FoldeddiscussionsController
 */
class FoldeddiscussionsController extends AppController {

    /**
    * get 1st paginated folded discussions to inject into view
    * Display Folded Discussions of a classroom
    * @param type $classroomId
    */
    public function index($classroomId){
        $data = $this->Foldeddiscussion->getPaginatedFoldedDiscussions($classroomId, AuthComponent::user('id'), 1);
        $data = $this->Foldeddiscussion->Discussion->processData($data, AuthComponent::user('id'));

        /**
         * express gamification keys
         */
        $gamificationKeys = array(
            'en' => 'Engagement',
            'in' => 'Intelligence',
            'cu' => 'Curious',
            'co' => 'Contribution',
            'ed' => 'Endorsement',
        );

        $this->set('Classroom.id', $classroomId);
        $this->set(compact('classroomId', 'gamificationKeys'));
        $this->set('data', json_encode($data));
    }

}