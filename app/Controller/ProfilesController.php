<?php

/**
 * Class ProfilesController
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
        $message = "";

        $this->AppUser->id = AuthComponent::user('id');
        if (empty($this->AppUser->save($request, false, array('fname', 'lname', 'dob', 'location')))) {
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
        $message = "";

        $this->AppUser->id = AuthComponent::user('id');
        if (empty($this->AppUser->save($request, false, array(
            'mobile', 'university_assoc', 'location_full', 'linkedin_link', 'twitter_link', 'facebook_link'
        )))
        ) {
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
     * API : upload a profile pic
     */
    public function addProfilePic() {
        $this->request->onlyAllow('post');
        $this->response->type('json');

//        $data = array();
        $status = false;
        $message = "";

        $this->loadModel("AppUser");
        $this->AppUser->id = AuthComponent::user('id');
        $data = $this->AppUser->save($this->request->data, false, array('profile_img'));

        $this->set('data', $data);
        $this->set(compact('status', 'message'));
        $this->set('_serialize', array('status', 'message', 'data'));
    }
}