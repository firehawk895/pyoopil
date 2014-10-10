<?php

App::uses('AppController', 'Controller');
/**
 * The controller is fat with validation logic
 * Class SubmissionsController
 */
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
        //TODO: add field restriction for security

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

        $data = array();
        $status = false;
        $message = "";

        //TODO: add field restriction
        $postData = $this->request->data;
        //store in seconds for easy handling later
        if (
            isset($postData['hrs']) && isset($postData['mins']) &&
            is_numeric($postData['hrs']) && is_numeric($postData['mins'])
        ) {
            $postData['Quiz'][0]['duration'] = ($postData['hrs'] * 60 * 60) + ($postData['mins'] * 60);
            unset($postData['hrs']);
            unset($postData['mins']);

            $postData['Submission']['type'] = 'quiz';
            $postData['Submission']['subjective_scoring'] = "marked";
            $this->Submission->validator()->remove('total_marks');

            /** This is how you do deep validation dynamically **/
            if ($this->Submission->saveAll(
                $postData, array('validate' => 'only', 'deep' => true)
            )
            ) {
                //Successfully validated, now safely do a saveAssociated
                if (!($status = $this->Submission->addQuiz($postData, $classroomId))) {
                    $message = "Could not save the quiz";
                }
            } else {
                $status = false;
                $message = Hash::flatten($this->Submission->validationErrors);
            }
        } else {
            $status = false;
            $message['hrs'] = "The duration hours(hrs) or mins of quiz are not correctly set";
        }

        /* _serialize */
        $this->set(compact('status', 'message'));
        $this->set('data', $data);
        $this->set('_serialize', array('data', 'status', 'message'));
    }

    private function _validateChoicesAndAnswers($quizQuestion) {
        /**
         * case:
         * "single-select": AND "multi-select":
         * at least 2 choices present
         * 1 choice is selected as answer
         * "true-false":
         * exactly 2 choices present, one is true, one is false
         * 1 choice is selected as answer
         * "match-column":
         * At least 2 pairs of columns present
         * total columns must be even number (pairs)
         */
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
            strlen($postData['UsersSubmission']['answer']) > 10
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

        $userId = AuthComponent::user('id');
        /*
        saveMany format:
        $data = array(
            'Choicesanswer' => array(
                array(
                    'choice_id' => 56
                ),
                array(
                    'choice_id' => 59
                ),
                array(
                    'choice_id' => 60
                ),
            ),
            'Columnanswer' => array(
                array(
                    'column1_id' => 21,
                    'column2_id' => 22,
                ),
                array(
                    'column1_id' => 23,
                    'column2_id' => 24,
                ),
            )
        );
        */

        $postData = $this->request->data;
        if (isset($postData['Submission']['id'])) {
            if ($this->Submission->checkStatus($postData['Submission']['id']) === "In Progress") {
                $status1 = false;
                $status2 = false;

                if (isset($postData['Choicesanswer'])) {
                    $choiceData = $postData['Choicesanswer'];
                    if (!empty($choiceData)) {
                        foreach ($choiceData as $key => &$choice) {
                            $choice['user_id'] = $userId;
                        }
                        $status1 = $this->Submission->Quiz->Quizquestion->Choice->Choicesanswer->saveMany($choiceData, array('validate' => 'false'));
                    }
                }

                if (isset($postData['Columnanswer'])) {
                    $columnData = $postData['Columnanswer'];
                    if (!empty($columnData)) {
                        //TODO: use a clever Hash::insert
                        foreach ($columnData as $key => &$choice) {
                            $choice['user_id'] = $userId;
                        }
                        $status2 = $this->Submission->Quiz->Quizquestion->Column->Columnanswer->saveMany($columnData);
                    }
                }

                $status = $status1 && $status2;
                if ($status) {
                    //Quiz answers created successfully
                    //update UsersSubmission
                    $usersSubmissionId = $this->Submission->UsersSubmission->getUsersSubmissionId($userId, $postData['Submission']['id']);
                    $usersSubmission = array(
                        'id' => $usersSubmissionId,
                        'is_submitted' => true
                    );
                    if ($this->Submission->UsersSubmission->save($usersSubmission)) {
                        $status = true;
                    } else {
                        $status = false;
                        $message = "Error in saving the quiz submission";
                    }
                }
            } else {
                $status = false;
                $message = "You can only submit answers to quizzes which are in progress";
            }
        } else {
            $status = false;
            $message = "Submission not selected";
        }

        $this->set(compact('status', 'message'));
        $this->set('data', $data);
        $this->set('_serialize', array('data', 'status', 'message'));
    }

    /**
     * API(get)
     * Get Quizquestions of a Quiz
     */
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

    /**
     * grade submuissions view of the owner(educator) for a given $submissionId
     */
    public function gradeSubmissions() {
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
            $data = $this->Submission->UsersSubmission->getSubmittedSubmissions($submissionId, $page);

            $status = true;
        }
        $this->set(compact('status', 'message', 'submission'));
        $this->set('data', $data);
        $this->set('_serialize', array('data', 'submission', 'status', 'message'));
    }

    /**
     * API(post)
     * educator assigns marks or grade to a submission submitted by student
     */
    public function assignGrade() {
        $gradeSet = array('A', 'B', 'C', 'D', 'E', 'F');

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
            (isset($postData['UsersSubmission']['grade']) != isset($postData['UsersSubmission']['marks']))
        ) {
            $this->Submission->id = $postData['Submission']['id'];
            $scoring = $this->Submission->field('subjective_scoring');
            if ($scoring === "graded" && isset($postData['UsersSubmission']['grade'])) {
                $type = "grade";
                $value = $postData['UsersSubmission']['grade'];
                if (in_array($postData['UsersSubmission']['grade'], $gradeSet)) {
                    $status = true;
                } else {
                    $status = false;
                    $message = "Invalid grade entered";
                }
            } else if ($scoring === "marked" && isset($postData['UsersSubmission']['marks']) && is_numeric($postData['UsersSubmission']['marks'])) {
                $type = "marks";
                $value = $postData['UsersSubmission']['marks'];
                $maxMarks = $this->Submission->field('total_marks');
                if ($postData['UsersSubmission']['marks'] > $maxMarks) {
                    $status = false;
                    $message = "Marks assigned cannot be greater than maximum marks";
                } else {
                    $status = true;
                }
            } else {
                $status = false;
                $message = "Grade/Marks not set or invalid";
            }
        }

        if ($status) {
            $usersSubmissionId = $this->Submission->UsersSubmission->getUsersSubmissionId($postData['AppUser']['id'], $postData['Submission']['id']);
            $usersSubmission = array(
                'id' => $usersSubmissionId,
                'is_graded' => true,
                $type => $value
            );
            if ($this->Submission->UsersSubmission->save($usersSubmission)) {
                $status = true;
                $message = "The Grade/Marks have been applied";
            } else {
                $status = false;
                $message = "Error in grading the Submission";
            }
        }

        //output
        $this->set(compact('status', 'message'));
        $this->set('data', $data);
        $this->set('_serialize', array('data', 'status', 'message'));
    }

    /**
     * API(POST)
     * educator assigns a comment on the submission of a student
     */
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
            isset($postData['AppUser']['id'])
        ) {
            if (
                isset($postData['UsersSubmission']['grade_comment']) &&
                strlen($postData['UsersSubmission']['grade_comment']) > 10
            ) {
                $usersSubmissionId = $this->Submission->UsersSubmission->getUsersSubmissionId($postData['AppUser']['id'], $postData['Submission']['id']);
                $usersSubmission = array(
                    'id' => $usersSubmissionId,
                    'grade_comment' => $postData['UsersSubmission']['grade_comment']
                );
                if ($this->Submission->UsersSubmission->save($usersSubmission)) {
                    $status = true;
                    $message = "the comment has been saved";
                } else {
                    $status = false;
                    $message = "Error in adding the comment";
                }
            } else {
                $status = false;
                $message = "Comment on a submission must be atleast 10 characters";
            }
        } else {
            $status = false;
            $message = "Submission and student not selected";
        }

        //output
        $this->set(compact('status', 'message'));
        $this->set('data', $data);
        $this->set('_serialize', array('data', 'status', 'message'));
    }

    /**
     * API(post)
     */
    public function publish() {
        $this->request->onlyAllow('post');
        $this->response->type('json');

        $data = array();
        $postData = $this->request->data;
        if (isset($postData['Submission']['id'])) {
            $submissionStatus = $this->Submission->checkStatus($postData['Submission']['id']);
            if ($submissionStatus === "Pending Grading") {
                if ($this->Submission->UsersSubmission->areAllGraded($postData['Submission']['id'])) {

                } else {
                    $status = false;
                    $message = "You cannot publish without grading/marking all submissions";
                }
            } else {
                $status = false;
                $message = "Only a 'Pending Grading' submission can be published";
            }
        } else {
            $status = false;
            $message = "Submission id not selected";
        }

        //output
        $this->set(compact('status', 'message'));
        $this->set('data', $data);
        $this->set('_serialize', array('data', 'status', 'message'));
    }
}