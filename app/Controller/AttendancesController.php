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
        $dates = $this->Attendance->getAttendanceDates($classroomId);
        $data = $this->UsersClassroom->getStudentList($classroomId);
        $status = true;
        $message = "";

        $this->set(compact('data', 'dates', 'status', 'message'));
        $this->set('_serialize', array('data', 'dates', 'status', 'message'));
    }

    /**
     * (POST)
     * API: /Classrooms/id/Attendances/add.json
     * take attendance for a particular date
     */
    public function add($classroomId) {
        $this->request->onlyAllow('post');
        $this->RequestHandler->renderAs($this, 'json');
        $this->response->type('json');

        $postData = $this->request->data;
        $data = array();
        $message = "";

        if (isset($postData['ids']) && isset($postData['date'])) {
            if (Validation::date($postData['date'], 'ymd') && CakeTime::isPast($postData['date'])) {
                $userIdsList = explode(",", $postData['ids']);
                if ($status = empty($this->Attendance->recordAttendance($classroomId, $userIdsList, $postData['date']))) {
                    $message = "There was a problem saving the attendance";
                } else {
                    $message = "Attendance was saved for " . $postData['date'];
                }
            } else {
                $status = false;
                $message = $postData['date'] . " must be a valid past date";
            }
        } else {
            $status = false;
            $message = "Students and/or date missing";
        }

        $this->set(compact('data', 'status', 'message'));
        $this->set('_serialize', array('data', 'status', 'message'));
    }

    /**
     * (GET)
     * API: /Classrooms/id/Attendances/view.json?date=2015-06-18
     * view the attendance for a particular date
     */
    public function view($classroomId) {
        //show attendance data for
        $this->request->onlyAllow('get');
        $this->RequestHandler->renderAs($this, 'json');
        $this->response->type('json');

        if (isset($this->params['url']['date']) && Validation::date($this->params['date'], 'ymd')) {
            $date = $this->params['url']['date'];
            $status = !empty($data = $this->Attendance->getAttendanceByDate($classroomId, $date));
        } else {
            $status = false;
            $message = "Date not selected or invalid";
        }

        $this->set(compact('data', 'status', 'message'));
        $this->set('_serialize', array('data', 'status', 'message'));
    }
}