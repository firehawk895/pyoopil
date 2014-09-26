<?php
/**
 * Created by PhpStorm.
 * User: nakul
 * Date: 7/4/14
 * Time: 12:36 PM
 */

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
        //TODO: add model validation
        //TODO: add Pyoopilfile support

        $this->request->onlyAllow('post');
        $data = array();

        if ($this->Submission->addSubjective($this->request->data, $classroomId)) {
            $status = true;
            $message = "Successfully created Subjective Assignment";
            $lastSubmissionId = $this->Submission->getLastInsertId();
            $data = $this->Submission->getPaginatedSubmissions($classroomId, AuthComponent::user('id'), 1, $lastSubmissionId);
        } else {
            $status = false;
            $message = "Failed to create Subjective Assignment";
        }

        //output
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
//
//        $options['deep'] = true;
//        $options['validate'] = false;
//        $options['atomic'] = true;

        /*
         * Use this for security
        $options['fieldList'] = array(
            'Submission' => array(
                'topic', 'description', 'grading_policy'
            ),
            'Quizquestion' => array(
                'marks', 'question', 'type',
            )
        );
        */
//        $this->log(array(
//            'User' => array('email' => 'john-doe@cakephp.org'),
//            'Cart' => array(
//                array(
//                    'payment_status_id' => 2,
//                    'total_cost' => 250,
//                    'CartItem' => array(
//                        array(
//                            'cart_product_id' => 3,
//                            'quantity' => 1,
//                            'cost' => 100,
//                        ),
//                        array(
//                            'cart_product_id' => 5,
//                            'quantity' => 1,
//                            'cost' => 150,
//                        )
//                    )
//                )
//            )
//        ));
//        $this->log($data);
//        $status = $this->Submission->Quiz->saveAssociated($data, $options);
//        $status = $this->Submission->Quiz->saveAll($data, $options);
//        $this->log($this->Submission->getShi());
//        $status = $this->Submission->saveAssociated($this->Submission->getShit(), array(
//            'deep' => true
//        ));
        $status = $this->Submission->saveAssociated($data, array(
            'deep' => true,
            'atomic' => true
        ));

//        if ($status) {
//            $lastSubmissionId = $this->Submission->getLastInsertId();
//            $data = $this->Submission->getPaginatedSubmissions($classroomId, AuthComponent::user('id'), 1, $lastSubmissionId);
//        }

        /*
        //Calculate
//        $data['Submission']['total_marks'] = 0;

        $flattenData = Hash::flatten($data);
        //loop

        for ($i = 0; Hash::check($data, 'Quiz.0.Quizquestion.{$i}'); $i++) {
            switch (Hash::get($data, 'Quiz.0.Quizquestion.{$i}.type')) {
                case "single-select":
                    $index = Hash::get($data, 'Quiz.0.Quizquestion.{$i}.Choice.answer_option');
                    $data['Quiz'][0]['Quizquestion'][$i]['Choice'][$index]['is_answer'] = true;
                    break;
                case "true-false":
                    $data['Quiz'][0]['Quizquestion'][$i]['Choice'][0]['description'] = 'true';
                    $data['Quiz'][0]['Quizquestion'][$i]['Choice'][1]['description'] = 'false';
                    $answer = Hash::get($data, 'Quiz.0.Quizquestion.{$i}.Choice.answer_option');
                    if ($answer == 'true') {
                        $data['Quiz'][0]['Quizquestion'][$i]['Choice'][0]['is_answer'] = true;
                    } else if ($answer == 'false') {
                        $data['Quiz'][0]['Quizquestion'][$i]['Choice'][1]['is_answer'] = true;
                    }
                    break;
                case "match-columns":
                    //no manipulations required as of now
//                        for ($j = 0; Hash::check($data, 'Quiz.0.Quizquestion.{$i}.Matchthecolumn.0.Column.{$j}') && Hash::check($data, 'Quiz.0
                    //                        }
            }
        }
        */
        //output

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
        //
        $this->request->onlyAllow('get');
        $this->response->type('json');

//        $this->Submission->UsersSubmission->getUsersSubmission(40, AuthComponent::user('id'));

        $page = 1;
        if (isset($this->params['url']['page'])) {
            $page = $this->params['url']['page'];
        }

        $data = $this->Submission->getPaginatedSubmissions($classroomId, AuthComponent::user('id'), $page);
        $status = true;
        $message = "";

        $permissions = $this->Submission->getPermissions(AuthComponent::user('id'), $classroomId);
        $this->Submission->Classroom->id = $classroomId;
        $users_classroom_count = $this->Submission->Classroom->field('users_classroom_count');

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
        $postData = $this->request->data;
        $status = $this->Submission->UsersSubmission->answerSubjective(AuthComponent::user('id'), $postData);

        if ($status) {
            $data = $this->Submission->getPaginatedSubmissions(null, AuthComponent::user('id'), 1, $postData['Submission']['id']);
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
        //The great saveMany format
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
        $this->request->onlyAllow('get');
        $this->response->type('json');

        $status = false;
        $message = "";

        if (isset($this->params['url']['id'])) {
            $submissionId = $this->params['url']['id'];

            $submission = $this->Submission->getSubmissionById($submissionId);

            $page = 1;
            if (isset($this->params['url']['page'])) {
                $page = $this->params['url']['page'];
            }

            $data = $this->Submission->Classroom->UsersClassroom->getPaginatedPeople($classroomId, $page);
//            $this->log($data);

            foreach ($data as &$sub) {
                unset($sub['UsersClassroom']);
                unset($sub['Classroom']);

                $usersSubmission = $this->Submission->UsersSubmission->getUsersSubmission($submissionId, $sub['AppUser']['id']);
                $this->log($usersSubmission);

                if (empty($usersSubmission)) {
                    $sub['Submission']['is_submitted'] = false;
                } else {
                    $sub['Submission']['is_submitted'] = true;
                    $sub['UsersSubmission'] = $usersSubmission;
                }

//                if ($sub['Submission']['is_published'] === true) {
//                    $sub['Submission']['status'] = "Graded";
//                } else {
//                    if (CakeTime::isPast($sub['Submission']['due_date'])) {
//                        $sub['Submission']['status'] = "Pending Grading";
//                    } else {
//                        $sub['Submission']['status'] = "In Progress";
//                    }
//                }
            }

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