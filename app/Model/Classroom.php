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
     * $userId creates a classroom and joins it as an educator.
     * @param int $userId
     * @param mixed $data $request->data 
     */
    public function add($userId, $data) {
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
            if (!$this->UsersClassroom->joinClassroom($userId, $this->id, true)) {
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
     * @param int $userId 
     */
    protected function getTiles($userId) {

        /**
         * cakePhp ORM has issues:
         * Campus fields will be ignored if specific
         * fields are selected from UsersClassroom
         * Analyze generated query and you'll know what I mean
         * Can't use:
         * $options['fields'] = array(
         *   'is_teaching', 'is_restricted'
         * );
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
            'user_id' => $userId,
        );
        
        $options['order'] = 'UsersClassroom.created DESC';

        $dump = $this->UsersClassroom->find('all', $options);
        return $dump;
    }

    /**
     * Formatted data for classroom tiles
     * @param int $userId 
     */
    public function displayTiles($userId) {
        /**
         * Data contract:
         * is_teaching
         * is_private
         * is_restricted
         * title
         * educatorName
         * campusName
         * users_classroom_count
         */
        $dumps = $this->getTiles($userId);
        $i = 0;
        $tileData = array();
        foreach ($dumps as $dump) {
            $tileData[$i]['id'] = Hash::get($dump, 'Classroom.id');
            $tileData[$i]['is_teaching'] = Hash::get($dump, 'UsersClassroom.is_teaching');
            $tileData[$i]['is_private'] = Hash::get($dump, 'Classroom.is_private');
            $tileData[$i]['is_restricted'] = Hash::get($dump, 'UsersClassroom.is_restricted');
            $tileData[$i]['title'] = Hash::get($dump, 'Classroom.title');
            $tileData[$i]['educatorName'] = $this->getEducatorName(Hash::get($dump, 'Classroom.id'));
            $tileData[$i]['campusName'] = Hash::get($dump, 'Classroom.Campus.name');
            $tileData[$i]['users_classroom_count'] = Hash::get($dump, 'Classroom.users_classroom_count');
            $i++;
        }
        return $tileData;
    }

    /**
     * TODO: Cache the query for use in both side Nav and main tiles
     * get raw db data for all classrooms attended/taught by $userId
     * @param int $userId 
     */
    protected function getLatestTile($userId) {

        /**
         * cakePhp ORM has issues:
         * Campus fields will be ignored if specific
         * fields are selected from UsersClassroom
         * Analyze generated query and you'll know what I mean
         * Can't use:
         * $options['fields'] = array(
         *   'is_teaching', 'is_restricted'
         * );
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
            'user_id' => $userId,
        );

        $options['order'] = 'UsersClassroom.created DESC';

        $dump = $this->UsersClassroom->find('first', $options);
        return $dump;
    }

    /**
     * Formatted data for classroom tiles
     * @param int $userId 
     */
    public function displayLatestTile($userId) {
        /**
         * Data contract:
         * is_teaching
         * is_private
         * is_restricted
         * title
         * educatorName
         * campusName
         * users_classroom_count
         */
        $dump = $this->getLatestTile($userId);
//        $i = 0;
        $tileData = array();
//        foreach ($dumps as $dump) {
        $tileData['is_teaching'] = Hash::get($dump, 'UsersClassroom.is_teaching');
        $tileData['is_private'] = Hash::get($dump, 'Classroom.is_private');
        $tileData['is_restricted'] = Hash::get($dump, 'UsersClassroom.is_restricted');
        $tileData['title'] = Hash::get($dump, 'Classroom.title');
        $tileData['educatorName'] = $this->getEducatorName(Hash::get($dump, 'Classroom.id'));
        $tileData['campusName'] = Hash::get($dump, 'Classroom.Campus.name');
        $tileData['users_classroom_count'] = Hash::get($dump, 'Classroom.users_classroom_count');
//            $i++;
//        }
        return $tileData;
    }

    /**
     * @param int $classroomId
     * @param mixed $data
     */
    public function edit($classroomId, $data) {
        //if archived return false
    }

    /**
     * Archive a classroom
     * TODO : auth framework should prevent any modification of archived classrooms
     * otherwise hack all edit methods if(!is_archived)
     * @param type $classroomId
     */
    public function archiveIt($classroomId) {
        $this->id = $classroomId;
        $this->saveField('is_archived', true);
    }

    /**
     * Clone a classroom
     * @param type $classroomId
     */
    public function cloneIt($classroomId) {
        /**
         * All amazons3 links need to be preserved for cloning library
         * Clone:
         * Library, Submissions, 
         */
    }

    /**
     * generates and assigns access code to classroom, preventing duplicates
     * with CODE_RETRY times retries.
     * @param int $classroomId Classroom(pk)
     */
    private function generateCode($classroomId) {

        $this->id = $classroomId;

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
     * @param type $classroomId Classroom(pk)
     * @return boolean success/failure
     */
    public function resetCode($classroomId) {
        $this->id = $classroomId;
        if ($this->field('is_private')) {
            return $this->generateCode($classroomId);
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
    protected function getEducatorName($classroomId) {

        $options['conditions'] = array(
            'classroom_id' => $classroomId,
            'is_teaching' => true
        );

        $options['contain'] = array(
            'User' => array(
                'fields' => array('fname', 'lname')
            )
        );

        $data = $this->UsersClassroom->find('first', $options);

        if (Hash::check($data, 'User')) {
            $educatorName = Hash::get($data, 'User.fname') . " " . Hash::get($data, 'User.lname');
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

}
