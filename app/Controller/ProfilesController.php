<?php
/**
 * Created by PhpStorm.
 * User: ankan
 * Date: 11/9/14
 * Time: 6:27 PM
 */

class ProfilesController extends AppController {

    public function isAuthorized($user) {
        if (parent::isAuthorized($user)) {
            //do role processing here
            return true;
        } else {
            return false;
        }
    }

    /**
     * API: get profile details of a user
     */
    public function getProfile() {
        $this->request->onlyAllow('get');
        $this->response->type('json');

        $status = true;
        $message = "";
        $userId = AuthComponent::user('id');

        $this->loadModel("AppUser");
        $data = $this->AppUser->getProfile($userId);

        $this->set('data', $data);
        $this->set(compact('status', 'message'));
        $this->set('_serialize', array('data', 'status', 'message'));
    }

    /**
     * Form for posting the lesser profile data
     */
    public function addMinProfile() {
        $this->request->onlyAllow('post');
        $this->response->type('json');

        $this->loadModel("AppUser");
        $request = $this->request->data;
        $data = array();
        $status = false;
        $message = "";


        /**
         * Data Filtering, make sure only expected fields are modified
         * Need a more concrete security strategy
         * Don't like this approach
         */
        if (isset($request['AppUser']['fname'])) {
            $filteredData['AppUser']['fname'] = $request['AppUser']['fname'];
        }

        if (isset($request['AppUser']['lname'])) {
            $filteredData['AppUser']['lname'] = $request['AppUser']['lname'];
        }

        if (isset($request['AppUser']['dob'])) {
            $filteredData['AppUser']['dob'] = $request['AppUser']['dob'];
        }

        if (isset($request['AppUser']['location'])) {
            $filteredData['AppUser']['location'] = $request['AppUser']['location'];
        }

        $this->log($filteredData);

        $this->AppUser->id = AuthComponent::user('id');
        if (empty($this->AppUser->save($filteredData, false))) {
            $status = false;
        } else {
            $status = true;
        }

        $this->loadModel("AppUser");
        $data = $this->AppUser->getProfile($this->AppUser->id);

        $this->set('data', $data);
        $this->set(compact('status', 'message'));
        $this->set('_serialize', array('status', 'message', 'data'));
    }

    /**
     * Form for posting the larger profile data
     */
    public function addFullProfile() {
        $this->request->onlyAllow('post');
        $this->response->type('json');

        $this->loadModel("AppUser");
        $request = $this->request->data;
        $data = array();
        $status = false;
        $message = "";

        /**
         * Data Filtering, make sure only expected fields are modified
         * Need a more concrete security strategy
         * Don't like this approach
         */
        if (isset($request['AppUser']['mobile'])) {
            $filteredData['AppUser']['mobile'] = $request['AppUser']['mobile'];
        }

        if (isset($request['AppUser']['university_assoc'])) {
            $filteredData['AppUser']['university_assoc'] = $request['AppUser']['university_assoc'];
        }

        if (isset($request['AppUser']['location_full'])) {
            $filteredData['AppUser']['location_full'] = $request['AppUser']['location_full'];
        }

        if (isset($request['AppUser']['linkedin_link'])) {
            $filteredData['AppUser']['linkedin_link'] = $request['AppUser']['linkedin_link'];
        }

        if (isset($request['AppUser']['twitter_link'])) {
            $filteredData['AppUser']['twitter_link'] = $request['AppUser']['twitter_link'];
        }

        if (isset($request['AppUser']['facebook_link'])) {
            $filteredData['AppUser']['facebook_link'] = $request['AppUser']['facebook_link'];
        }

        $this->AppUser->id = AuthComponent::user('id');
        if (empty($this->AppUser->save($filteredData, false))) {
            $status = false;
        } else {
            $status = true;
        }

        $this->loadModel("AppUser");
        $data = $this->AppUser->getProfile($this->AppUser->id);

        $this->set('data', $data);
        $this->set(compact('status', 'message'));
        $this->set('_serialize', array('status', 'message', 'data'));

    }

    public function deleteProfileItem() {

    }
}