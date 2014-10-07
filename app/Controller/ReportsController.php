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

    /**
     * API: Reports/index.json
     * determines owner(educator) or student view
     * @param $classroomId
     */
    public function index($classroomId) {
        $this->request->onlyAllow('get');
        $this->response->type('json');
        $this->RequestHandler->renderAs($this, 'json');

        $permissions = $this->Report->getPermissions(AuthComponent::user('id'), $classroomId);
        $status = true;
        $message = "";

        /**
         * _serialize
         */
        $this->set(compact('permissions', 'status', 'message'));
        $this->set('_serialize', array('permissions', 'status', 'message'));
    }

    /**
     * API: Reports/engagement.json
     * engagement report for owner(educator) or student
     * @param $classroomId
     */
    public function engagement($classroomId) {

        $this->request->onlyAllow('get');
        $this->RequestHandler->renderAs($this, 'json');
        $this->response->type('json');

        $data = array();
        $status = false;

        $userId = AuthComponent::user('id');

        //determine permissions
        //determine whether educator(owner) or student view
        $permissions = $this->Report->getPermissions($userId, $classroomId);

        $UsersClassroom = new UsersClassroom();
        //need users_classroom_count for educator view also
        //hence always being populated
        $data = $UsersClassroom->getUsersGamification($userId, $classroomId);

        //exclude educator from count
        if (isset($data['Classroom']['users_classroom_count'])) {
            $data['Classroom']['users_classroom_count'] = $data['Classroom']['users_classroom_count'] - 1;
        }

        $gold = $UsersClassroom->getEngagersByPodium($classroomId, 'gold');
        $silver = $UsersClassroom->getEngagersByPodium($classroomId, 'silver');
        $bronze = $UsersClassroom->getEngagersByPodium($classroomId, 'bronze');

        $this->set(compact('data', 'gold', 'silver', 'bronze', 'status', 'message', 'permissions'));
        $this->set('_serialize', array('data', 'gold', 'silver', 'bronze', 'status', 'message', 'permissions'));
    }

    public function academic($classroomId) {
        $this->request->onlyAllow('get');
        $this->RequestHandler->renderAs($this, 'json');
        $this->response->type('json');

        //determine permissions
        //determine whether educator(owner) or student view
        $permissions = $this->Report->getPermissions(AuthComponent::user('id'), $classroomId);
        $status = true;
        $message = "";

        $this->loadModel("UsersSubmission");
        $data = array(
            array(
                'UsersSubmission' => array(
                    'grade' => null,
                    'marks' => 24,
                    'percentile' => "53.348",
                    'grade_frequency' => null,
                    'grade_comment' => "some comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teacher",
                    'is_graded' => true
                ),
                'Submission' => array(
                    'id' => 74,
                    'topic' => 'new topic',
                    'total_marks' => '100',
                    'subjective_scoring' => 'marked',
                    'average_marks' => null
                ),
            ),
            array(
                'UsersSubmission' => array(
                    'grade' => 'A',
                    'marks' => null,
                    'percentile' => null,
                    'grade_frequency' => 3,
                    'grade_comment' => "some comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teacher",
                    'is_graded' => true
                ),
                'Submission' => array(
                    'id' => 75,
                    'topic' => 'new topic',
                    'total_marks' => '100',
                    'subjective_scoring' => 'graded',
                    'average_marks' => null
                ),
            ),
            array(
                'UsersSubmission' => array(
                    'grade' => null,
                    'marks' => 24,
                    'percentile' => "53.348",
                    'grade_frequency' => null,
                    'grade_comment' => "some comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teacher",
                    'is_graded' => true
                ),
                'Submission' => array(
                    'id' => 76,
                    'topic' => 'new topic',
                    'total_marks' => '100',
                    'subjective_scoring' => 'marked',
                    'average_marks' => null
                ),
            ),
            array(
                'UsersSubmission' => array(
                    'grade' => 'A',
                    'marks' => null,
                    'percentile' => null,
                    'grade_frequency' => 3,
                    'grade_comment' => "some comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teacher",
                    'is_graded' => true
                ),
                'Submission' => array(
                    'id' => 77,
                    'topic' => 'new topic',
                    'total_marks' => '100',
                    'subjective_scoring' => 'graded',
                    'average_marks' => null
                ),
            ),
            array(
                'UsersSubmission' => array(
                    'grade' => null,
                    'marks' => 24,
                    'percentile' => "53.348",
                    'grade_frequency' => null,
                    'grade_comment' => "some comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teacher",
                    'is_graded' => true
                ),
                'Submission' => array(
                    'id' => 78,
                    'topic' => 'new topic',
                    'total_marks' => '100',
                    'subjective_scoring' => 'marked',
                    'average_marks' => null
                ),
            ),
            array(
                'UsersSubmission' => array(
                    'grade' => 'A',
                    'marks' => null,
                    'percentile' => null,
                    'grade_frequency' => 3,
                    'grade_comment' => "some comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teacher",
                    'is_graded' => true
                ),
                'Submission' => array(
                    'id' => 79,
                    'topic' => 'new topic',
                    'total_marks' => '100',
                    'subjective_scoring' => 'graded',
                    'average_marks' => null
                ),
            ),
            array(
                'UsersSubmission' => array(
                    'grade' => null,
                    'marks' => 80,
                    'percentile' => "53.348",
                    'grade_frequency' => null,
                    'grade_comment' => "some comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teacher",
                    'is_graded' => true
                ),
                'Submission' => array(
                    'id' => 74,
                    'topic' => 'new topic',
                    'total_marks' => '100',
                    'subjective_scoring' => 'marked',
                    'average_marks' => null
                ),
            ),
            array(
                'UsersSubmission' => array(
                    'grade' => 'A',
                    'marks' => null,
                    'percentile' => null,
                    'grade_frequency' => 3,
                    'grade_comment' => "some comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teacher",
                    'is_graded' => true
                ),
                'Submission' => array(
                    'id' => 81,
                    'topic' => 'new topic',
                    'total_marks' => '100',
                    'subjective_scoring' => 'graded',
                    'average_marks' => null
                ),
            ),
            array(
                'UsersSubmission' => array(
                    'grade' => null,
                    'marks' => 24,
                    'percentile' => "53.348",
                    'grade_frequency' => null,
                    'grade_comment' => "some comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teacher",
                    'is_graded' => true
                ),
                'Submission' => array(
                    'id' => 82,
                    'topic' => 'new topic',
                    'total_marks' => '100',
                    'subjective_scoring' => 'marked',
                    'average_marks' => null
                ),
            ),
            array(
                'UsersSubmission' => array(
                    'grade' => 'A',
                    'marks' => null,
                    'percentile' => null,
                    'grade_frequency' => 3,
                    'grade_comment' => "some comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teachersome comment by the teacher",
                    'is_graded' => true
                ),
                'Submission' => array(
                    'id' => 83,
                    'topic' => 'new topic',
                    'total_marks' => '100',
                    'subjective_scoring' => 'graded',
                    'average_marks' => null
                ),
            ),
        );

//        $data = $this->UsersSubmission->getUsersSubmissionList(AuthComponent::user('id'), $classroomId);
        /** _serialize */
        $this->set(compact('data', 'status', 'message', 'permissions'));
        $this->set('_serialize', array('data', 'status', 'message', 'permissions'));
    }

    public function attendance($classroomId) {
        $this->request->onlyAllow('get');
        $this->RequestHandler->renderAs($this, 'json');
        $this->response->type('json');

        $userId = AuthComponent::user('id');
        //determine permissions
        //determine whether educator(owner) or student view
        $permissions = $this->Report->getPermissions($userId, $classroomId);

        //get Attendance data for student
        $this->loadModel("UsersClassroom");
        $data = $this->UsersClassroom->getAttendance($userId, $classroomId);
        $status = true;
        $message = "";

        //get frequency attendance data
        $graph = $this->UsersClassroom->getAttendanceFrequency($userId, $classroomId);

        /** _serialize */
        $this->set(compact('data', 'graph', 'status', 'message', 'permissions'));
        $this->set('_serialize', array('data', 'graph', 'status', 'message', 'permissions'));
    }

    public function academicStudentGraph() {
        $this->request->onlyAllow('get');
        $this->RequestHandler->renderAs($this, 'json');
        $this->response->type('json');

        $status = false;
        $message = "";

        if (isset($this->params['url']['submission_id'])) {
            $submissionId = $this->params['url']['submission_id'];

            $status = true;

            if ($submissionId % 2 == 0) {
                $graph = array(
                    'points' => array(
                        array('x' => 0.0, 'y' => 5),
                        array('x' => 20.0, 'y' => 25),
                        array('x' => 38.0, 'y' => 35),
                        array('x' => 45.0, 'y' => 55),
                        array('x' => 0.0, 'y' => 75),
                        array('x' => 92.0, 'y' => 82),
                        array('x' => 100.0, 'y' => 95),
                    ),
                    'marked' => array(
                        'x' => 20.0,
                        'y' => 25
                    )
                );
            } else {
                $graph = array(
                    'frequency' => array(
                        "A" => 5,
                        "B" => 15,
                        "C" => 5,
                        "D" => 2,
                        "E" => 1
                    ),
                    'marked' => 'B'
                );
            }
        }


        /** _serialize */
        $this->set(compact('graph', 'status', 'message', 'permissions'));
        $this->set('_serialize', array('graph', 'status', 'message', 'permissions'));
    }


} 