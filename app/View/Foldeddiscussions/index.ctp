<?php
$this->start('pagesubnav');
echo $this->element('classrooms/inside-classroom-subnav', array(
    'classroomId' => $classroomId,
    'active' => 'Discussions'
));
$this->end();
?>
<?php
/**
 * r4m use $data here
 */
?>
<section class="pagecontent clearfix">
    <div class="content-wrapper">
        <div class="topbuttons">
            <a href="<?php echo Router::url(array('controller' => 'discussions', 'action' => 'index', 'id' => $classroomId)); ?>" class="follow ">All</a>
            <a href="<?php echo Router::url(array('controller' => 'foldeddiscussions', 'action' => 'index', 'id' => $classroomId)); ?>" class="follow active">Folded</a>
        </div>
        <div id="discussions">
        	
        </div>
    </div>
</section>
<script type="text/javascript">

    var App = window.App || {};
    App.classrooms = App.classrooms || {};
    App.classrooms.discussions = App.classrooms.discussions || {};
    App.classrooms.discussions.data = <?php echo $data ?>;

</script> 