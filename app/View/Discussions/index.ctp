<?php
$this->start('pagesubnav');
echo $this->element('classrooms/inside-classroom-subnav', array(
    'classroomId' => $classroomId,
    'active' => 'discussions'
));
$this->end();
?>
Welcome to discussions homie of classroom <?php echo $classroomId ?>