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
        $this->request->onlyAllow('post');
        $this->RequestHandler->renderAs($this, 'json');
        $this->response->type('json');

        $userIdsList = explode(",", $this->request->data['ids']);
        $date = $this->request->data['date'];

        $status = $this->Attendance->recordAttendance($classroomId,$userIdsList,$date);

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

        $date = $this->params['url']['date'];

        $data = $this->Attendance->getAttendanceByDate($classroomId, $date);

        if($data){
            $status = true;
        }else{
            $status = false;
        }

        $this->set(compact('data', 'status', 'message'));
        $this->set('_serialize', array('data', 'status', 'message'));
    }
}