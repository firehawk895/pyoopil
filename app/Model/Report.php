<?php
App::uses('AppModel', 'Model');
App::uses('Classroom', 'Model');

class Report extends AppModel {
    public $useTable = false;

    /**
     * @param $userId
     * @param $classroomId
     * @return array
     */
    public function getPermissions($userId, $classroomId) {
        $classroom = new Classroom();
        if ($classroom->isOwner($userId, $classroomId)) {
            $role = "Owner";
            $allowCreate = true;
        } else {
            $role = "Student";
            $allowCreate = false;
        }
        $permissions = array(
            'role' => $role,
            'allowCreate' => $allowCreate
        );
        return $permissions;
    }

}