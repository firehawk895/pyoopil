<?php
App::uses('AppModel', 'Model');
/**
 * UsersSubmission Model
 * @property User $User
 * @property Submission $Submission
 * @property Pyoopilfile $Pyoopilfile
 */
class UsersSubmission extends AppModel {

    /**
     * gradeSubmissions pagination limit
     */
    const PAGINATION_LIMIT = 10;

    /**
     * belongsTo associations
     * @var array
     */
    public $belongsTo = array(
        'AppUser' => array(
            'className' => 'AppUser',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Submission' => array(
            'className' => 'Submission',
            'foreignKey' => 'submission_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => array(
                'users_submission_count' => array('UsersSubmission.is_submitted' => 1)
            )
        ),
        'Pyoopilfile' => array(
            'className' => 'Pyoopilfile',
            'foreignKey' => 'pyoopilfile_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    /**
     * Student submits an answer to a subjective assignment
     * @param $userId
     * @param $postData
     * @return bool
     */
    public function answerSubjective($userId, $postData) {
        //submission_id is already in the post data
        $postData['AppUser']['id'] = $userId;
        $postData['UsersSubmission']['is_submitted'] = true;

        $this->log($postData);
        $usersSubmissionId = $this->getUsersSubmissionId($postData['AppUser']['id'], $postData['Submission']['id']);
        unset($postData['AppUser']);
        unset($postData['Submission']);
        $postData['UsersSubmission']['id'] = $usersSubmissionId;

        $options = array(
            'validate' => false,
            'deep' => true,
            'fieldList' => array(
                'UsersSubmission' => array('id', 'answer', 'is_submitted'),
                'Pyoopilfile' => array(
                    'file_path', 'filename', 'filesize', 'mime_type', 'thumbnail_path'
                )
            )
        );

        if (@$this->saveAssociated($postData, $options)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * returns a UsersSubmission record, that is guaranteed to exist
     * because of createDummySubmissions()
     * @param $userId
     * @param $submissionId
     * @return mixed
     */
    public function getUsersSubmissionId($userId, $submissionId) {
        $usersSubmission = $this->find('first', array(
            'conditions' => array(
                'user_id' => $userId,
                'submission_id' => $submissionId
            ),
            'recursive' => -1,
            'fields' => array(
                'id'
            )
        ));
        return $usersSubmission['UsersSubmission']['id'];
    }

    /**
     * Used for getting the submission details of a student
     * injected in getSubmissions API
     * @param $submissionId
     * @param $userId
     * @return array
     */
    public function getUsersSubmission($submissionId, $userId) {
        $options['contain'] = array(
            'Pyoopilfile'
        );

        $options['conditions'] = array(
            'UsersSubmission.submission_id' => $submissionId,
            'UsersSubmission.user_id' => $userId
        );

        return $this->find('first', $options);
    }

    /**
     * get all user's submitted submissions for a given submission
     * that is used by GradeSubmissions API
     * @param $submissionId
     * @param $page
     * @return array
     */
    public function getSubmittedSubmissions($submissionId, $page) {
        if ($page < 1) {
            $page = 1;
        }

        $options['contain'] = array(
            'AppUser' => array(
                'id', 'fname', 'lname', 'profile_img'
            ),
            'Pyoopilfile' => array(
                'id', 'file_path', 'filename', 'filesize', 'mime_type', 'thumbnail_path'
            )
        );

        $options['fields'] = array(
            'grade', 'marks', 'answer', 'grade_comment', 'is_graded', 'pyoopilfile_id', 'is_submitted', 'created'
        );

        $options['conditions'] = array(
            'submission_id' => $submissionId
        );

        //pagination
        $options['limit'] = self::PAGINATION_LIMIT;
        $offset = self::PAGINATION_LIMIT * ($page - 1);
        $options['offset'] = $offset;

        //Only show the submissions of users who have submitted
        //until Submissin status is "Pending Grading" or "Graded"
        $this->Submission->id = $submissionId;
        $status = $this->Submission->field('status');
        if ($status === "In Progress") {
            $options['conditions']['is_submitted'] = true;
        }

        return $this->find('all', $options);
    }

    /**
     * Student side academic report
     * @param $userId
     * @param $classroomId
     * @return array
     */
    public function getUsersSubmissionList($userId, $classroomId) {
        $options = array(
            'contain' => array(
                'Submission' => array(
                    'id', 'topic', 'total_marks', 'subjective_scoring', 'average_marks'
                )
            ),
            'fields' => array(
                'grade', 'marks', 'percentile', 'grade_frequency', 'grade_comment', 'is_graded'
            ),
            'conditions' => array(
                'UsersSubmission.user_id' => $userId,
                'Submission.classroom_id' => $classroomId,
            )
        );

        return $this->find('all', $options);
    }

    /**
     * creating entries for student submissions for easy tracking and maintainence
     * This must exclude the owner/educator
     * @param $submissionId
     * @return bool
     */
    public function createDummyUsersSubmissions($submissionId) {
        $this->Submission->id = $submissionId;
        $classroomId = $this->Submission->field('classroom_id');

        //ensure the users_submission entry is not created for the owner(educator)
        $options = array(
            'conditions' => array(
                'UsersClassroom.classroom_id' => $classroomId,
                'UsersClassroom.is_teaching' => false
            ),
            'fields' => array(
                'id', 'user_id', 'is_teaching', 'classroom_id'
            )
        );

        $data = $this->AppUser->UsersClassroom->find('all', $options);
        $returnData = array();

        foreach ($data as $value) {
            array_push($returnData, array(
                'UsersSubmission' => array(
                    'submission_id' => $submissionId,
                    'user_id' => $value['UsersClassroom']['user_id'],
                )));
        }

        if ($this->saveMany($returnData, array('validate' => false))) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if all the UsersSubmissions have been graded by the educator(owner)
     * @param $submissionid
     * @return bool
     */
    public function areAllGraded($submissionid) {
        $options['conditions'] = array(
            'submission_id' => $submissionid
        );
        $options['recursive'] = -1;

        $total = $this->find('count', $options);
        $options['conditions']['is_graded'] = true;
        $graded = $this->find('count', $options);

        if ($total == $graded) {
            return true;
        } else {
            return false;
        }
    }

    public function calculatePercentile($submissionId) {

        $query = 'SELECT a.submission_id, a.id,
                  ROUND( 100.0 * ( SELECT COUNT(*) FROM users_submissions AS b WHERE b.marks <= a.marks ) / total.cnt, 1 )
                  AS percentile FROM users_submissions a CROSS JOIN (SELECT COUNT(*) AS cnt FROM users_submissions) AS total WHERE a.submission_id = ' . $submissionId . ' ORDER BY percentile DESC';

        $data = $this->query($query);

        $saveData = array();

        foreach ($data as $d) {
            array_push($saveData, array(
                'UsersSubmission' => array(
                    'id' => $d['a']['id'],
                    'percentile' => $d[0]['percentile']
                )
            ));
        }

        $this->saveMany($saveData);

    }

    public function calculateGradeFrequency($submissionId) {

        $options = array(
            'conditions' => array(
                'submission_id' => $submissionId
            ),
            'fields' => array(
                'COUNT(*) AS frequency, grade'
            ),
            'group' => array(
                'grade'
            )
        );

        $data = $this->find('all', $options);

        $result['GradeFrequency'] = Hash::combine($data, '{n}.UsersSubmission.grade', '{n}.{n}.frequency');
        return $result;
    }
}
