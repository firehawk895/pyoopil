<?php
/**
 * Created by PhpStorm.
 * User: nakul
 * Date: 7/4/14
 * Time: 12:36 PM
 */

App::uses('AppController', 'Controller');

class SubmissionsController extends AppController {

    public function addSubjective($classroomId) {
        $this->request->onlyAllow('post');
        $data = array();

        if ($this->Submission->addSubjective($this->request->data, $classroomId)) {
            $status = true;
            $message = "Successfully created Subjective Assignment";
            $data = $this->Submission->getPaginatedSubmissions($classroomId, 1, true);
        } else {
            $status = false;
            $message = "Failed to create Subjective Assignment";
        }

        //output
        $this->set(compact('status', 'message'));
        $this->set('data', $data);
        $this->set('_serialize', array('data', 'status', 'message'));
    }

    public function addQuiz($classroomId) {
        $this->request->onlyAllow('post');
        $this->log($this->request->data);

        $data = array();
        $status = false;
        $message = "";


        $data = $this->request->data;
        //store in seconds for easy handling later
        if (isset($data['hrs']) && $data['mins']) {
            $data['Quiz']['duration'] = ($data['hrs'] * 60 * 60) + ($data['mins'] * 60);
            unset($data['hrs']);
            unset($data['mins']);
        }
        $data['Submission']['type'] = 'quiz';
        $data['Submission']['classroom_id'] = $classroomId;

        $options['deep'] = true;
        $options['validate'] = false;
        $status = $this->Submission->Quiz->saveAssociated($data, $options);

        if ($status) {
            $data = $this->Submission->getPaginatedSubmissions($classroomId, 1, true);
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

    public function getSubmissions($classroomId) {
        $this->request->onlyAllow('get');
        $this->response->type('json');

        $page = 1;
        if (isset($this->params['url']['page'])) {
            $page = $this->params['url']['page'];
        }

        $data = $this->Submission->getPaginatedSubmissions($classroomId, $page);
        $status = true;
        $message = "";

        //output
        $this->set(compact('status', 'message'));
        $this->set('data', $data);
        $this->set('_serialize', array('data', 'status', 'message'));
    }
}