<?php
/**
 * Created by PhpStorm.
 * User: ankan
 * Date: 30/9/14
 * Time: 9:40 AM
 */

class ReportsController extends AppController {
    /**
     * Controller authorize
     * user determined from token
     * @param $user
     * @return bool
     */
    public function isAuthorized($user) {
        if (parent::isAuthorized($user)) {
            //do role processing here
            return true;
        } else {
            return false;
        }
    }

    public function engagement($classroomId) {
        $this->request->onlyAllow('get');
        $this->RequestHandler->renderAs($this, 'json');
        $this->response->type('json');

        $userId = AuthComponent::user('id');

        //determine permissions
        //determine whether educator(owner) or student view
        $permissions = $this->Report->getPermissions($userId, $classroomId);

        //get engagement points for the user
        $this->loadModel("UsersClassroom");
        $data = $this->UsersClassroom->find('first', array(
            'conditions' => array(
                'user_id' => $userId,
                'classroom_id' => $classroomId
            ),
            'recursive' => -1,
            'fields' => array('en', 'in', 'cu', 'co', 'ed')
        ));

        if (!empty($data)) {
            $status = true;
            $message = "";
        } else {
            $message = "Unable to fetch data";
            $status = false;
        }

        //get list of engagers
        $gold = $this->UsersClassroom->getEngagers($classroomId);
        $silver = $this->UsersClassroom->getEngagers($classroomId);
        $bronze = $this->UsersClassroom->getEngagers($classroomId);

        /**
         * Setting data for json view.
         * this code repeats
         * two steps, set and then _serialize
         */
        $this->set(compact('data', 'gold', 'silver', 'bronze', 'status', 'message', 'permissions'));
        $this->set('_serialize', array('data', 'gold', 'silver', 'bronze', 'status', 'message', 'permissions'));
    }


} 