<?php

App::uses('AppModel', 'Model');
App::uses('CodeGenerator', 'Lib/Custom');

/**
 * Classroom Model
 *
 * @property User $User
 * @property Campus $Campus
 * @property Department $Department
 */
class Classroom extends AppModel {

    const PAGINATION_LIMIT = 20;

    /**
     * db Notes:
     * campus_id -> department_id -> degree_id is a hierarchy
     * only 1 needs to be populated for correct information
     * however all 3 can be populated for taking unfair advantage of this :)
     */

    /**
     * No. of times to try getting unique Access Code
     * before throwing fatal error
     */
    const CODE_RETRY = 5;

    /**
     * All Associations modelled as of April 19th
     */
    public $belongsTo = array(
        'Campus' => array(
            'className' => 'Campus',
            'foreignKey' => 'campus_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Department' => array(
            'className' => 'Department',
            'foreignKey' => 'department_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Degree' => array(
            'className' => 'Degree',
            'foreignKey' => 'degree_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    public $hasMany = array(
        'Announcement' => array(
            'className' => 'Announcement',
            'foreignKey' => 'classroom_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Discussion' => array(
            'className' => 'Discussion',
            'foreignKey' => 'classroom_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Library' => array(
            'className' => 'Library',
            'foreignKey' => 'classroom_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Submission' => array(
            'className' => 'Submission',
            'foreignKey' => 'classroom_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'UsersClassroom' => array(
            'className' => 'UsersClassroom',
            'foreignKey' => 'classroom_id'
        )
    );

    /**
     * Converted to hasMany, like it always should be
     * ----------------------------------------------
     *  public $hasAndBelongsToMany = array(
     *      'User' => array(
     *          'className' => 'User',
     *          'joinTable' => 'users_classrooms',
     *          'foreignKey' => 'classroom_id',
     *          'associationForeignKey' => 'user_id',
     *          'unique' => 'keepExisting',
     *          'conditions' => '',
     *          'fields' => '',
     *          'order' => '',
     *          'limit' => '',
     *          'offset' => '',
     *          'finderQuery' => '',
     *      )
     *  );
     * 
     */
//    public function afterSave($created, $options = array()) {
//        parent::afterSave($created, $options);
//
//        //set access code for any private classroom/staffroom
//        If (isset($created) && $created == true && $this->data['is_private'] == true) {
//            $this->generateCode();
//        }
//    }

    /**
     * create classroom popup:
     * $user_id creates a classroom and joins it as an educator.
     * @param int $user_id
     * @param mixed $data $request->data 
     */
    public function add($user_id, $data) {
        /**
         * Initialize and map Library
         * No Initialization Required for:
         * Discussions, Announcements, People, Submissions, Reports
         */
        /**
         * Possible design consideration:
         * Methods have been broken down granularly,
         * but ideally only 1 save should be called for operations:
         * create access code, join classroom, create and associate library
         * so that transactional integrity can be maintained
         */
        $this->create();
        if ($this->save($data)) {
            if ($data['Classroom']['is_private'] == '1') {
                $this->generateCode($this->id);
            }
            if (!$this->UsersClassroom->joinClassroom($user_id, $this->id, true)) {
                return false;
            }
            if (!$this->Library->add($this->id)) {
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * TODO: Cache the query for use in both side Nav and main tiles
     * get raw db data for all classrooms attended/taught by $userId
     * @param int $user_id
     * @return array $jsonData
     */
    public function getLatestTile($user_id) {

        $options['contain'] = array(
            'Classroom' => array(
                'fields' => array('id', 'campus_id', 'is_private', 'title', 'users_classroom_count', 'access_code'),
                'Campus' => array(
                    'fields' => array(
                        'id', 'name'
                    )
                )
            ),
        );

        $options['conditions'] = array('user_id' => $user_id);
        $options['order'] = array('UsersClassroom.created' => 'desc');
        /**
         * Magic:
         * Campus fields won't come if you uncomment the follwing line.
         * I'm watching you in git.
         */
//        $options['fields'] = array('is_restricted', 'is_teaching', 'created', 'modified');


        $data = $this->UsersClassroom->find('first', $options);

        $educator = $this->getEducatorName($data['Classroom']['id']);
        $data = Hash::insert($data, 'Classroom.Educator', $educator);

        return $data;
    }

    /**
     * @param int $classroom_id
     * @param mixed $data
     */
    public function edit($classroom_id, $data) {
        //if archived return false
    }

    /**
     * Archive a classroom
     * TODO : auth framework should prevent any modification of archived classrooms
     * otherwise hack all edit methods if(!is_archived)
     * @param type $classroom_id
     */
    public function archiveIt($classroom_id) {
        $this->id = $classroom_id;
        $this->saveField('is_archived', true);
    }

    /**
     * Clone a classroom
     * @param type $classroom_id
     */
    public function cloneIt($classroom_id) {
        /**
         * All amazons3 links need to be preserved for cloning library
         * Clone:
         * Library, Submissions, 
         */
    }

    /**
     * generates and assigns access code to classroom, preventing duplicates
     * with CODE_RETRY times retries.
     * @param int $classroom_id Classroom(pk)
     */
    private function generateCode($classroom_id) {

        $this->id = $classroom_id;

        $newCode = CodeGenerator::accessCode('alnum', '6');
        $conditions = array(
            'access_code' => $newCode
        );

        for ($i = 0; $i < self::CODE_RETRY; $i++) {
            if ($this->hasAny($conditions)) {
                $conditions['access_code'] = CodeGenerator::accessCode('alnum', '6');
            } else {
                return $this->saveField('access_code', $newCode);
            }
        }
        //throw fatal error
        return false;
    }

    /**
     * Reset Access code of classroom
     * @param type $classroom_id Classroom(pk)
     * @return boolean success/failure
     */
    public function resetCode($classroom_id) {
        $this->id = $classroom_id;
        if ($this->field('is_private')) {
            return $this->generateCode($classroom_id);
        }
    }

    public function displayArchivedTiles() {
        /**
         * add isArchived = false to DisplayTiles 
         */
    }

    public function joinWithCode($accessCode) {
        
    }

    public function joinPublic() {
        
    }

    public function invite($data) {
        //Controller will send invite data dump of which people/class/section etc.
        //to invite
        //Dispatch reccomend/invite to Requests module
    }

    /**
     * TODO: decide parameters to display invites
     * Use University association of user,
     * populate Ajax tree:
     *      Department 
     *          -> Degree
     *              -> Section
     */
    public function displayInviteData() {
        
    }

    /**
     * Staff Room Section
     * Inherit or put here?
     */
    public function addStaffRoom() {
        
    }

    public function displayStaffRooms() {
        
    }

    /**
     * Helper methods
     */

    /**
     * Educator's full name of a classroom
     * @param int $classroomId
     */
    public function getEducatorName($classroomId) {

        $options['conditions'] = array(
            'classroom_id' => $classroomId,
            'is_teaching' => true
        );

        $options['contain'] = array(
            'AppUser' => array(
                'fields' => array('fname', 'lname')
            )
        );

        $data = $this->UsersClassroom->find('first', $options);

        if (Hash::check($data, 'AppUser')) {
            $educatorName = Hash::get($data, 'AppUser.fname') . " " . Hash::get($data, 'AppUser.lname');
        } else {
            $educatorName = "Unknown Teacher";
        }
        return String::truncate(trim($educatorName), '40');
    }

    /**
     * db Notes:
     * access_code can't have unique index
     * because all public classrooms have 'null' as value
     */
    public function getClassroomIdWithCode($access_code) {
        $access_code = trim($access_code);

        $options['conditions'] = array(
            'access_code' => $access_code
        );
        $options['recursive'] = -1;
        $options['fields'] = array('Classroom.id');

        $data = $this->find('first', $options);

        if (isset($data['Classroom']['id'])) {
            return $data['Classroom']['id'];
        } else {
            return null;
        }
    }

    /**
     * get paginated classroom tile details
     * @param type $user_id
     * @param type $page
     */
    public function getPaginatedClassrooms($user_id, $page) {
        //sanity check
        if ($page < 1) {
            $page = 1;
        }
        $offset = self::PAGINATION_LIMIT * ($page - 1);

        /**
         * cakePhp ORM has issues:
         * Campus fields will be ignored if specific
         * fields are selected from UsersClassroom
         * Analyze generated query and you'll know what I mean
         * Can't use:
         * $options['fields'] = array(
         *   'is_teaching', 'is_restricted'
         * );
         * 
         * This code has been attempted to be refactored 2 times.
         * Increment this number, once you refactor and it failes the test cases
         * to warn the next developer
         * 
         * Changing the entry point to Classroom, solves the issue but returns
         * classrooms that the user is not part of
         */
        $options['contain'] = array(
            'Classroom' => array(
                'fields' => array('id', 'campus_id', 'is_private', 'title', 'users_classroom_count'),
                'Campus' => array(
                    'fields' => array('id', 'name')
                )
            ),
        );
        $options['conditions'] = array(
            'user_id' => $user_id,
        );
        $options['order'] = 'UsersClassroom.created DESC';
        $options['limit'] = self::PAGINATION_LIMIT;
        $options['offset'] = $offset;

        $data = $this->UsersClassroom->find('all', $options);

        for ($i = 0; $i < count($data); $i ++) {
            $educator_name = $this->getEducatorName($data[$i]['Classroom']['id']);
            $path = $i . '.Classroom.Educator';
            $data = Hash::insert($data, $path, $educator_name);

            $path2 = $i . '.Classroom.Url';
            $data = Hash::insert($data, $path2, Router ::url(array(
                                'controller' => 'Discussions',
                                'action' => 'index',
                                'id' => $data[$i]['Classroom']['id']
            )));
        }

        return $data;
    }

}
