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
            <a href="<?php echo Router::url(array('controller' => 'discussions', 'action' => 'index', 'id' => $classroomId)); ?>" class="follow active">All</a>
            <a href="<?php echo Router::url(array('controller' => 'foldeddiscussions', 'action' => 'index', 'id' => $classroomId)); ?>" class="follow">Folded</a>
        </div>
    </div>
</section>