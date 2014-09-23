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

        $status = false;
        $message = "";

        $data = $this->request->data;
        //store in seconds for easy handling later
        if (isset($data['hrs']) && $data['mins']) {
            $data['Quiz'][0]['duration'] = ($data['hrs'] * 60 * 60) + ($data['mins'] * 60);
            unset($data['hrs']);
            unset($data['mins']);
        }
        $data['Submission']['type'] = 'quiz';
        $data['Submission']['classroom_id'] = $classroomId;

        $options['deep'] = true;
        $options['validate'] = false;
        $options['atomic'] = true;

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
        $this->log(array(
            'User' => array('email' => 'john-doe@cakephp.org'),
            'Cart' => array(
                array(
                    'payment_status_id' => 2,
                    'total_cost' => 250,
                    'CartItem' => array(
                        array(
                            'cart_product_id' => 3,
                            'quantity' => 1,
                            'cost' => 100,
                        ),
                        array(
                            'cart_product_id' => 5,
                            'quantity' => 1,
                            'cost' => 150,
                        )
                    )
                )
            )
        ));
        $this->log($data);
        $status = $this->Submission->Quiz->saveAssociated($data, $options);

        if ($status) {
            $lastSubmissionId = $this->Submission->getLastInsertId();
            $data = $this->Submission->getPaginatedSubmissions($classroomId, AuthComponent::user('id'), 1, $lastSubmissionId);
        }

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
        $this->set('data', $data);
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

        $this->Submission->UsersSubmission->getUsersSubmission(40, AuthComponent::user('id'));

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

    }

    public function getQuiz() {
        $this->request->onlyAllow('get');
        $this->response->type('json');

        $data = array();
        $status = false;
        $message = "";

        if (isset($this->params['url']['id'])) {
            $submissionId = $this->params['url']['id'];

            $options = array(
                'contain' => array(
                    'Quiz' => array(
                        'Quizquestion' => array(
                            'Choice', 'Column'
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
        }

        //output
        $this->set(compact('status', 'message', 'permissions', 'users_classroom_count'));
        $this->set('data', $data);
        $this->set('_serialize', array('data', 'permissions', 'users_classroom_count', 'status', 'message'));
    }


}