<?php
/**
 * API Pattern : /Classrooms/:id/:controller/:action
 * Class AttendancesController
 */
class AttendancesController extends AppController {
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

    /**
     * (GET)
     * API: /Classrooms/id/Attendances/index.json
     * show all the dates the attendance has been marked for
     * and show the list of all users to take attendance for
     * @param $classroomId
     */
    public function index($classroomId) {
        //TODO: paginate this, if we reach that many users per classroom :O
        $this->request->onlyAllow('get');
        $this->RequestHandler->renderAs($this, 'json');
        $this->response->type('json');

        $this->loadModel("UsersClassroom");

        $data['dates'] = $this->Attendance->getAttendanceDates($classroomId);
        $data ['students'] = $this->UsersClassroom->getStudentList($classroomId);

        $this->set(compact('data', 'status', 'message'));
        $this->set('_serialize', array('data', 'status', 'message'));
    }

    /**
     * (POST)
     * API: /Classrooms/id/Attendances/add.json
     * take attendance for a particular date
     */
    public function add($classroomId) {
        //input:
        //classroom_id and date and userList

        //remember that

        //only comma seperated user ids of those users who are absent
        //make entries for all users,
        //only the users mentioned in the comma seperated values
        //do an updateAll() and change is_present to false
    }

    /**
     * (GET)
     * API: /Classrooms/id/Attendances/view.json?date=2015-06-18
     * view the attendance for a particular date
     */
    public function view($classroomId) {
        //show attendance data for
    }
}