<?php
$this->start('pagesubnav');
echo $this->element('classrooms/inside-classroom-subnav', array(
    'classroomId' => $classroomId,
    'active' => 'Announcements'
));
$this->end();
?>
<div class="content-wrapper" id="announcements" ng-app="classrooms">
    <announcement-form></announcement-form>
    <div class="announcement-outer tinyscrollbar">
        <div class="viewport">
            <div class="overview">
                <div class="middivouter">
                    
                </div>
            </div>
            <div class="scrollbar">
                <div class="track">
                    <div class="thumb">
                        <div class="end">
                            <announcements></announcements>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">

        var App = window.App || {};
            App.classrooms = App.classrooms || {};
            App.classrooms.announcements = App.classrooms.announcements || {};
            App.classrooms.announcements.data = <?php echo $data ?>;

    </script> 
</div>
