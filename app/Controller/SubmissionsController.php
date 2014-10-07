<?php

App::uses('AppController', 'Controller');

class SubmissionsController extends AppController {

    /**
     * Controller authorize framework
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
     * API (POST):
     * Add a new Subjective type assignment
     * @param $classroomId
     */
    public function addSubjective($classroomId) {
        //TODO: add field restriction
        $this->request->onlyAllow('post');
        $data = array();
        $postData = $this->request->data;

        //disable total marks validation when scoring is graded
        if (isset($postData['Submission']['subjective_scoring'])) {
            if ($postData['Submission']['subjective_scoring'] === "graded") {
                $this->Submission->validator()->remove('total_marks');
            }
        }

        //validate post data
        $this->Submission->set($postData);
        if ($this->Submission->validates()) {
            if ($this->Submission->addSubjective($postData, $classroomId)) {
                $status = true;
                $message = "Successfully created Subjective Assignment";
                $lastSubmissionId = $this->Submission->getLastInsertId();
                $data = $this->Submission->getSubmissionById(AuthComponent::user('id'), $lastSubmissionId);
            } else {
                $message = "Failed to create Subjective Assignment";
            }
        } else {
            $status = false;
            $message = $this->Submission->validationErrors;
        }

        /* _serialize */
        $this->set(compact('status', 'message'));
        $this->set('data', $data);
        $this->set('_serialize', array('data', 'status', 'message'));
    }

    /**
     * API (POST):
     * Add a new quiz
     * @param $classroomId
     */
    public function addQuiz($classroomId) {
        $this->request->onlyAllow('post');

        //TODO: add field restriction
        //TODO: add model validation
        //TODO: add Pyoopilfile support

//        $status = false;
//        $message = "";

        $data = $this->request->data;
        //store in seconds for easy handling later
        if (isset($data['hrs']) && $data['mins']) {
            $data['Quiz'][0]['duration'] = ($data['hrs'] * 60 * 60) + ($data['mins'] * 60);
            unset($data['hrs']);
            unset($data['mins']);
        }
        $data['Submission']['type'] = 'quiz';
        $data['Submission']['classroom_id'] = $classroomId;
        $status = $this->Submission->saveAssociated($data, array(
            'deep' => true,
            'atomic' => true
        ));

        /* _serialize */
        $this->set(compact('status', 'message'));
//        $this->set('data', $data);
        $this->set('_serialize', array('data', 'status', 'message'));
    }

    /**
     * API (GET)
     * Get submissions of a owner of classroom or a student
     * @param $classroomId
     */
    public function getSubmissions($classroomId) {
        $this->request->onlyAllow('get');
        $this->response->type('json');

        $this->Submission->updateSubmissionsStatus($classroomId);
        
        $page = 1;
        if (isset($this->params['url']['page'])) {
            $page = $this->params['url']['page'];
        }

        $data = $this->Submission->getPaginatedSubmissions($classroomId, AuthComponent::user('id'), $page);
        $status = true;
        $message = "";

        $permissions = $this->Submission->getPermissions(AuthComponent::user('id'), $classroomId);
        $this->Submission->Classroom->id = $classroomId;
        $users_classroom_count = $this->Submission->Classroom->field('users_classroom_count') - 1;

        //output
        $this->set(compact('status', 'message', 'permissions', 'users_classroom_count'));
        $this->set('data', $data);
        $this->set('_serialize', array('data', 'permissions', 'users_classroom_count', 'status', 'message'));
    }

    /**
     * API (POST)
     * A student answers a subjective assignment
     */
    public function answerSubjective() {
        $this->request->onlyAllow('post');
        $this->response->type('json');

        $data = array();
        $message = "";
        $postData = $this->request->data;

        /**
         * Validation and error checking
         */

        if (
            isset($postData['Submission']['id']) &&
            isset($postData['UsersSubmission']['answer']) &&
            strlen($postData['UsersSubmission']['answer']) > 20
        ) {
            //Check submission:
            //Only if submission.status = "In Progress", you can submit an answer
            if ($this->Submission->checkStatus($postData['Submission']['id']) === "In Progress") {
                //add condition : /Only if you have not submitted a
                //submission before you can submit an answer
                $status = $this->Submission->UsersSubmission->answerSubjective(AuthComponent::user('id'), $postData);
                if (!$status) {
                    $message = "There was an error saving the answer";
                }
            } else {
                $status = false;
                $message = "You can only submit answers to submissions which are in progress";
            }
        } else {
            $status = false;
            $message = "Answer is too short to be submitted, or submission not selected";
        }

        if ($status) {
            $data = $this->Submission->getSubmissionById(AuthComponent::user('id'), $postData['Submission']['id']);
        }

        //output
        $this->set(compact('status', 'message', 'permissions', 'users_classroom_count'));
        $this->set('data', $data);
        $this->set('_serialize', array('data', 'permissions', 'users_classroom_count', 'status', 'message'));
    }

    /**
     * API (POST)
     * A students answers a assignment which is a quiz
     */
    public function answerQuiz() {
        $this->request->onlyAllow('post');
        $this->response->type('json');

        $data = array();
        $status = false;
        $message = "";

        $userId = AuthComponent::user('id');
        //The great cakephp saveMany format
        //keep this comment to make life easier
//        $data = array(
//            'Choicesanswer' => array(
//                array(
//                    'choice_id' => 56
//                ),
//                array(
//                    'choice_id' => 59
//                ),
//                array(
//                    'choice_id' => 60
//                ),
//            ),
//            'Columnanswer' => array(
//                array(
//                    'column1_id' => 21,
//                    'column2_id' => 22,
//                ),
//                array(
//                    'column1_id' => 23,
//                    'column2_id' => 24,
//                ),
//            )
//        );

        $postData = $this->request->data;

        if (isset($postData['Choicesanswer'])) {
            $choiceData = $postData['Choicesanswer'];
            if (!empty($choiceData)) {
                foreach ($choiceData as $key => &$choice) {
                    $choice['user_id'] = $userId;
                }
                $status1 = $this->Submission->Quiz->Quizquestion->Choice->Choicesanswer->saveMany($choiceData, array('validate' => 'false'));
                $status = $status1;
            }
        }

        if (isset($postData['Columnanswer'])) {
            $columnData = $postData['Columnanswer'];
            if (!empty($columnData)) {
                foreach ($columnData as $key => &$choice) {
                    $choice['user_id'] = $userId;
                }
                $status2 = $this->Submission->Quiz->Quizquestion->Column->Columnanswer->saveMany($columnData);
                $status = $status && $status2;
            }
        }

        $this->set(compact('status', 'message'));
        $this->set('data', $data);
        $this->set('_serialize', array('data', 'status', 'message'));
    }

    public function getQuiz() {
        $this->request->onlyAllow('get');
        $this->response->type('json');

        $data = array();
        $status = false;
        $message = "";

        if (isset($this->params['url']['submission_id'])) {
            $submissionId = $this->params['url']['submission_id'];

            $options = array(
                'contain' => array(
                    'Quiz' => array(
                        'Quizquestion' => array(
                            'Choice' => array(
                                'fields' => array(
                                    'id', 'quizquestion_id', 'description'
                                )
                            ),
                            'Column'
                        )
                    )
                )
            );

            $options['conditions'] = array(
                'Submission.id' => array(
                    $submissionId
                )
            );

            $data = $this->Submission->find('first', $options);
            if (!empty($data)) {
                $status = true;
            } else {
                $status = false;
            }
        }

        //output
        $this->set(compact('status', 'message', 'permissions', 'users_classroom_count'));
        $this->set('data', $data);
        $this->set('_serialize', array('data', 'permissions', 'users_classroom_count', 'status', 'message'));
    }

    public function gradeSubmissions($classroomId) {

//        {
//            "data": [
//        {
//            "AppUser": {
//            "id": "23",
//                "fname": "Ankan",
//                "lname": null,
//                "profile_img": "https:\/\/s3-ap-southeast-1.amazonaws.com\/pyoopil-files\/default_profile_photo-1.png"
//            },
//            "Submission": {
//            "is_submitted": true
//            },
//            "UsersSubmission": {
//            "UsersSubmission": {
//                "id": "17",
//                    "user_id": "23",
//                    "submission_id": "22",
//                    "grade": null,
//                    "marks": null,
//                    "percentile": "0.000",
//                    "grade_frequency": null,
//                    "answer": "this is my answer",
//                    "grade_comment": null,
//                    "submitted_date": null,
//                    "is_graded": false,
//                    "pyoopilfile_id": "75",
//                    "is_submitted": false,
//                    "created": "2014-10-05 22:13:24",
//                    "modified": "2014-10-05 22:13:24"
//                },
//                "Pyoopilfile": {
//                "id": "75",
//                    "topic_id": null,
//                    "file_path": "https:\/\/s3-ap-southeast-1.amazonaws.com\/pyoopil-files\/libraries\/Screenshot-from-2014-07-11-00-07-19.png",
//                    "filename": "Screenshot-from-2014-07-11-00-07-19",
//                    "filesize": "20543",
//                    "mime_type": "image\/png",
//                    "thumbnail_path": "https:\/\/s3-ap-southeast-1.amazonaws.com\/pyoopil-files\/libraries\/Screenshot-from-2014-07-11-00-07-19-resize-200x256-5431c284b965d-1.png",
//                    "file_type": null,
//                    "created": "2014-10-05 22:13:24"
//                }
//            }
//        },
//        {
//            "AppUser": {
//            "id": "20",
//                "fname": "Harsh",
//                "lname": "Tripathi",
//                "profile_img": "https:\/\/s3-ap-southeast-1.amazonaws.com\/pyoopil-files\/default_profile_photo-1.png"
//            },
//            "Submission": {
//            "is_submitted": false
//            }
//        },
//        {
//            "AppUser": {
//            "id": "19",
//                "fname": "Aaron",
//                "lname": "Basaiawmoit",
//                "profile_img": "https:\/\/s3-ap-southeast-1.amazonaws.com\/pyoopil-files\/default_profile_photo-1.png"
//            },
//            "Submission": {
//            "is_submitted": false
//            }
//        }
//    ],
//    "submission": {
//            "Submission": {
//                "id": "22",
//            "classroom_id": "34",
//            "type": "subjective",
//            "users_submission_count": "1",
//            "topic": "asdad",
//            "description": "asdasd",
//            "grading_policy": "asdasd",
//            "pyoopilfile_id": null,
//            "due_date": "2014-10-09 01:00:00",
//            "total_marks": "100",
//            "is_saved": false,
//            "is_published": false,
//            "average_marks": null,
//            "subjective_scoring": "marked",
//            "status": "In Progress",
//            "created": "2014-10-05 19:17:23",
//            "modified": "2014-10-05 22:13:24"
//        },
//        "Pyoopilfile": {
//                "id": null,
//            "file_path": null,
//            "filename": null,
//            "filesize": null,
//            "mime_type": null,
//            "created": null
//        }
//    },
//    "status": true,
//    "message": ""
//}


        $this->request->onlyAllow('get');
        $this->response->type('json');

        $status = false;
        $message = "";
        $userId = AuthComponent::user('id');

        if (isset($this->params['url']['id'])) {
            $submissionId = $this->params['url']['id'];
            $submission = $this->Submission->getSubmissionById($userId, $submissionId);

            $page = 1;
            if (isset($this->params['url']['page'])) {
                $page = $this->params['url']['page'];
            }

            //if submission.status = "In Progress"
            $data = $this->Submission->UsersSubmission->getSubmittedSubmissions($submissionId);

//            $data = $this->Submission->Classroom->UsersClassroom->getPaginatedPeople($classroomId, $page);
//            $this->log($data);

//            foreach ($data as &$sub) {
//                unset($sub['UsersClassroom']);
//                unset($sub['Classroom']);
//
//                $usersSubmission = $this->Submission->UsersSubmission->getUsersSubmission($submissionId, $sub['AppUser']['id']);
//                $this->log($usersSubmission);
//
//                if (empty($usersSubmission)) {
//                    $sub['Submission']['is_submitted'] = false;
//                } else {
//                    $sub['Submission']['is_submitted'] = true;
//                    $sub['UsersSubmission'] = $usersSubmission;
//                }

//                if ($sub['Submission']['is_published'] === true) {
//                    $sub['Submission']['status'] = "Graded";
//                } else {
//                    if (CakeTime::isPast($sub['Submission']['due_date'])) {
//                        $sub['Submission']['status'] = "Pending Grading";
//                    } else {
//                        $sub['Submission']['status'] = "In Progress";
//                    }
//                }
//            }

            $status = true;
            //output
        }
        $this->set(compact('status', 'message', 'submission'));
        $this->set('data', $data);
        $this->set('_serialize', array('data', 'submission', 'status', 'message'));
    }

    public function assignGrade() {
        $this->request->onlyAllow('post');
        $this->response->type('json');

        $data = array();
        $status = false;
        $message = "";

        $postData = $this->request->data;

        /**
         * Validation:
         */
        if (
            isset($postData['Submission']['id']) &&
            isset($postData['AppUser']['id']) &&
            (isset($postData['UsersSubmission']['grade']) || isset($postData['UsersSubmission']['marks']))
        ) {
            $data = $this->Submission->UsersSubmission->find('first', array(
                'conditions' => array(
                    'submission_id' => $postData['Submission']['id'],
                    'user_id' => $postData['AppUser']['id']
                ),
                'recursive' => -1
            ));

            if (isset($postData['UsersSubmission']['grade'])) {
                $type = "grade";
                $value = $postData['UsersSubmission']['grade'];
            } else {
                $type = "marks";
                $value = $postData['UsersSubmission']['marks'];
            }

            if (!empty($data)) {
                $this->Submission->UsersSubmission->id = $data['UsersSubmission']['id'];
                $this->Submission->UsersSubmission->set(array(
                    'is_graded' => true,
                    $type => $value
                ));
                $saveStatus = $this->Submission->UsersSubmission->save();
            } else {
                //TODO : Invalid data will break this
                //Actually MySQL will not allow this to happen. muhahahah
                $usersSubmissionData = array(
                    'UsersSubmission' => array(
                        'user_id' => $postData['AppUser']['id'],
                        'submission_id' => $postData['Submission']['id'],
                        $type => $value,
                        'is_graded' => true
                    )
                );

                $data = $this->Submission->UsersSubmission;
                $this->Submission->UsersSubmission->create();
                $saveStatus = $this->Submission->UsersSubmission->save($usersSubmissionData);
//                $this->Submission->UsersSubmission->id = $this->Submission->UsersSubmission->getLastInsertId();
            }

            if (!empty($saveStatus)) {
                $status = true;
                $message = "Marks/Grade saved successfully";
                $data = $this->Submission->getGradeSubmissionTile($postData['AppUser']['id'], $postData['Submission']['id']);
            } else {
                $status = false;
                $message = "Unable to save Marks/Grade";
                $data = array();
            }
        }

        //output
        $this->set(compact('status', 'message'));
        $this->set('data', $data);
        $this->set('_serialize', array('data', 'status', 'message'));
    }

    public function assignComment() {
        $this->request->onlyAllow('post');
        $this->response->type('json');

        $data = array();
        $status = false;
        $message = "";

        $postData = $this->request->data;

        /**
         * Validation:
         */
        if (
            isset($postData['Submission']['id']) &&
            isset($postData['AppUser']['id']) &&
            isset($postData['UsersSubmission']['grade_comment'])
        ) {
            $data = $this->Submission->UsersSubmission->find('first', array(
                'conditions' => array(
                    'submission_id' => $postData['Submission']['id'],
                    'user_id' => $postData['AppUser']['id']
                ),
                'recursive' => -1
            ));

            if (!empty($data)) {
                $this->Submission->UsersSubmission->id = $data['UsersSubmission']['id'];
                $this->Submission->UsersSubmission->set(array(
                    'grade_comment' => $postData['UsersSubmission']['grade_comment'],
                ));
                $saveStatus = $this->Submission->UsersSubmission->save();
            } else {
                //TODO : Invalid data will break this
                //Actually MySQL will not allow this to happen. muhahahah
                $usersSubmissionData = array(
                    'UsersSubmission' => array(
                        'user_id' => $postData['AppUser']['id'],
                        'submission_id' => $postData['Submission']['id'],
                        'grade_comment' => $postData['UsersSubmission']['grade_comment']
                    )
                );

                $data = $this->Submission->UsersSubmission;
                $this->Submission->UsersSubmission->create();
                $saveStatus = $this->Submission->UsersSubmission->save($usersSubmissionData);
//                $this->Submission->UsersSubmission->id = $this->Submission->UsersSubmission->getLastInsertId();
            }

            if (!empty($saveStatus)) {
                $status = true;
                $message = "Comment saved successfully";
                $data = $this->Submission->getGradeSubmissionTile($postData['AppUser']['id'], $postData['Submission']['id']);
            } else {
                $status = false;
                $message = "Unable to save Comment";
                $data = array();
            }
        }

        //output
        $this->set(compact('status', 'message'));
        $this->set('data', $data);
        $this->set('_serialize', array('data', 'status', 'message'));
    }
}