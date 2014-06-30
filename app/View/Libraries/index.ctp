<?php
$this->start('pagesubnav');
echo $this->element('classrooms/inside-classroom-subnav', array(
    'classroomId' => $classroomId,
    'active' => 'Libraries'
));
$this->end();
?>

<div class="library-wrapper library" id="libraries">
    <div class="topbuttons">
        <a href="javascript:void(0)" class="follow" id="upload-dlink">Upload</a>
        <!--popup-->
        <div id="upload-dialog" class="create-popup">
            <div class="pop-wind clearfix">
                <div class="pop-head clearfix">
                    <span>Upload</span>
                    <a class="close-link" href="#">
                        <span class="icon-cross"></span></a>
                </div>
                <div class="pop-content clearfix">
                    <!--<form class="form-data">-->
                    <?php
                    echo $this->Form->create('Topic', array(
                        'type' => 'file',
//                        'url' => array(
//                            'controller' => 'libraries',
//                            'action' => 'index',
//                            'id' => $classroomId
//                        )
                    ));
                    ?>
                    <div class="upload-form clearfix">
                        <!-- form 1 -->
                        <div id="form1">
                            <p class="up-heading"> Step 1 of 2: Select a topic</p>
                            <div class="select-topic">
                                <!-- <a href="javascript:void(0)" class="sel-topic">Select Topic</a>
                                 <div class="seltop-dd">
                                   <a href="javascript:void(0)" class="new-topic">Create New Topic</a>
                                   <ul>
                                     <li><a href="javascript:void(0)">Topic 1</a>
                                     </li>
                                     <li><a href="javascript:void(0)">Topic 2</a>
                                     </li>
                                     <li><a href="javascript:void(0)">Topic 3</a>
                                     </li>
                                     <li><a href="javascript:void(0)">Topic 4</a>
                                     </li>
                                   </ul>
                                 </div> -->
                                <?php
//                                echo $this->Form->input('topic_id', array(
////                                    'type' => 'select',
////                                    'options' => $topics,
//                                    'empty' => 'Create new topic',
//                                    'class' => 'chosen-select select_option',
//                                    'id' => 'topic-dd',
//                                    'hidden'
//                                ));
                                ?>
                                <?php
                                echo $this->Form->input('id', array(
                                    'type' => 'select',
                                    'options' => $topics,
                                    'empty' => 'Create new topic',
                                    'class' => 'chosen-select select_option',
                                    'id' => 'topic-dd',
                                    'div' => false,
                                    'label' => false
                                ));
                                ?>
<!--                                <select class="chosen-select select_option" id="topic-dd">
                                    <option class="new-topic">Create New Topic</option>
                                    <option>Topic 2</option>
                                    <option>Topic 3</option>
                                    <option>Topic 4</option>
                                </select>-->
                                <input type="text" class="pop-input" id="enter-topic" placeholder="Enter Topic Name" name="data[Topic][name]"/>
                                <div class="nav-btn">
                                    <input type="button" class="follow active goto2" value="Next">
                                </div>
                            </div>
                        </div>
                        <!-- form 2 -->
                        <div id="form2">
                            <p class="up-heading">Step 2 of 2</p>
                            <div class="select-topic">
                                <p class="sub-sel">Topic Name:<span> Topic 1</span></p>
                                <div class="tabpages">
                                    <ul class="upload-tab">
                                        <li><a href="#file1" class="tab active">Upload file</a>
                                        </li>
                                        <li><a href="#link1" class="tab">Upload link</a>
                                        </li>
                                    </ul>
                                    <div id="file1" class="tab-contt">
                                        <p>Select file to upload</p>
                                        <div class="upload-files">
                                            <div class="add-upload clearfix">
                                                <div class="custom-upload" id="test0">
                                                    <input type="file" name="data[Pyoopilfile][0][file_path]">
                                                    <div class="file-upload">
                                                        <span class="file-txt">Select file</span>
                                                        <input disabled="disabled" value="No File Chosen">
                                                    </div>
                                                    <div class="size-txt">(Max. 2 mb)</div>
                                                </div>
                                            </div>
                                            <span class="add-more tooltip" title="Add File"></span>
                                        </div>
                                    </div>
                                    <div id="link1" class="tab-contt">
                                        <p>Paste link here</p>
                                        <div class="upload-links">
                                            <div class="add-links">
                                                <input type="text" class="pop-input" placeholder="Upload links" name="data[Link][0][linktext]">
                                            </div>
                                        </div>
                                        <span class="add-link tooltip" title="Add Link"></span>
                                    </div>
                                </div>
                                <div class="nav-btn">
                                    <input type="button" class="follow backto1" value="Oops !">
                                    <input type="button" class="follow active" value="Save" id="upload">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--</form>-->
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>

    </div>
    <div class="clear"></div>
    <div id="library">
        <!-- fill topics here -->
    </div>
</div>
<script type="text/javascript">

    var App = window.App || {};
    App.classrooms = App.classrooms || {};
    App.classrooms.libraries = App.classrooms.libraries || {};
    App.classrooms.libraries.data = <?php echo $data ?>;

</script> 