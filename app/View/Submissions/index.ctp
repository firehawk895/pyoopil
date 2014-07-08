<?php
    $this->start('pagesubnav');
    echo $this->element('classrooms/inside-classroom-subnav', array(
        'classroomId' => $classroomId,
        'active' => 'Submissions'
    ));
    $this->end();
?>
<section class="pagecontent">
    <div class="library-wrapper submission">
        <div class="topbuttons">
            <a href="classroom-submission.htm" class="follow active">View Submissions</a>
            <a href="classroom-view-submission.htm" class="follow">Create Assignments </a>
        </div>
    </div>
</section>