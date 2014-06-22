<?php
$this->start('pagesubnav');
echo $this->element('classrooms/inside-classroom-subnav', array(
    'classroomId' => $classroomId,
    'active' => 'discussions'
));
$this->end();
?>

<section class="pagecontent clearfix">
    <div class="content-wrapper">
        <div class="topbuttons">
            <a href="classroom-discussion.htm" class="follow active">All</a>
            <a href="classroom-discussion-fold.htm" class="follow">Folded</a>
        </div>
        <div class="clear"></div>
        <div class="top-div">
            <!--<form>-->
            <?php
            echo $this->Form->create('Discussion', array(
                'action' => 'add'
            ));
            echo $this->Form->input('Classroom.id', array(
                'hidden' => 'Y',
                'value' => $classroomId
            ));
            echo $this->Form->input('type', array(
                'hidden' => 'Y',
                'value' => 'question',
                'label' => false,
                'div' => false
            ));
            ?>
            <div class="main-box ques-box">
                <span class="txt-count">(<span id="rem_count">200</span>/200 characters left)</span>
                <?php
                echo $this->Form->input('topic', array(
                    'class' => 'add-topic',
                    'maxlength' => '200',
                    'placeholder' => 'Topic of the discussion',
                    'label' => false,
                    'div' => false
                ));
                ?>
                <!--<input class="add-topic" type="text" placeholder="Topic of  the discussion…"  maxlength="200">-->
                <?php
                echo $this->Form->input('body', array(
                    'class' => 'txt-area h235',
                    'placeholder' => 'What do you want to ask the class?',
                    'label' => false,
                    'div' => false
                ));
                ?>
                    <!--<textarea class="txt-area h235" placeholder="Type you question here…" ></textarea>-->
                <div class="att-box clearfix">
                    <div class="disc-room f-left">
                        <div class="attachmentbox">
                            <span class="btn btn-success fileinput-button changepicsbtn attach-mail">
                                <span class="att-txt">Add files <span class="att-size">(Max 100 mb)</span></span>
                                <input id="fileupload" type="file" name="files[]">
                            </span>
                            <div id="files" class="files"></div>
                        </div>
                    </div>
                    <div class="f-right">

                        <a href="javascript:void(0)" class="sub-btn cnl-btn">Cancel</a>
                        <a href="javascript:void(0)" class="sub-btn disc-submit-btn">Submit</a>
                    </div>
                </div>
            </div>
            <?php
//            echo $this->Form->submit();
            echo $this->Form->end();
            ?>
            <!--</form>-->
            <!--<form>-->
            <?php
            echo $this->Form->create('Discussion', array(
                'action' => 'add',
                'id' => 'DiscussionAddFormPoll'
            ));
            echo $this->Form->input('Classroom.id', array(
                'hidden' => 'Y',
                'value' => $classroomId
            ));
            echo $this->Form->input('type', array(
                'hidden' => 'Y',
                'value' => 'poll',
                'label' => false,
                'div' => false
            ));
            ?>
            <div class="main-box poll-box"><span class="txt-count">(<span id="rem_count">200</span>/200 characters left)</span>
                <?php
                echo $this->Form->input('topic', array(
                    'class' => 'add-topic',
                    'maxlength' => '200',
                    'placeholder' => 'Topic of the discussion',
                    'label' => false,
                    'div' => false
                ));
                ?>
            <!--<input class="add-topic" type="text" placeholder="Topic of  the discussion…"  maxlength="200">-->
                <?php
                echo $this->Form->input('body', array(
                    'class' => 'txt-area',
                    'placeholder' => 'Describe your poll',
                    'label' => false,
                    'div' => false
                ));
                ?>
                <!--<textarea class="txt-area" placeholder="Type you question here…."></textarea>-->
                <div class="add-here">
                    <div class="add-choice">
                        <?php
                        echo $this->Form->input('Pollchoice.0.choice', array(
                            'placeholder' => 'add a choice for your poll',
                            'class' => 'ans-txtbx',
                            'label' => false,
                            'div' => false
                        ));
                        ?>
                        <!--<input type="text" class="ans-txtbx" placeholder="Type your answer here..." readonly>-->
                        <a href="javascript:void(0)" class="close-btn"></a>
                    </div>
                    <div class="add-choice">
                        <?php
                        echo $this->Form->input('Pollchoice.1.choice', array(
                            'class' => 'ans-txtbx',
                            'placeholder' => 'add a choice for your poll',
                            'label' => false,
                            'div' => false
                        ));
                        ?>
                        <!--<input type="text" class="ans-txtbx" placeholder="Type your answer here..." readonly>-->
                        <a href="javascript:void(0)" class="close-btn"></a>
                    </div>
                    <div class="add-choice">
                        <?php
                        echo $this->Form->input('Pollchoice.2.choice', array(
                            'class' => 'ans-txtbx',
                            'placeholder' => 'add a choice for your poll',
                            'label' => false,
                            'div' => false
                        ));
                        ?>
                        <!--<input type="text" class="ans-txtbx" placeholder="Type your answer here..." readonly>-->
                        <a href="javascript:void(0)" class="close-btn"></a>
                    </div>
                    <div class="add-choice">
                        <?php
                        echo $this->Form->input('Pollchoice.3.choice', array(
                            'class' => 'ans-txtbx',
                            'placeholder' => 'add a choice for your poll',
                            'label' => false,
                            'div' => false
                        ));
                        ?>
                        <!--<input type="text" class="ans-txtbx" placeholder="Type your answer here..." readonly>-->
                        <a href="javascript:void(0)" class="close-btn"></a>
                    </div>
                    <div class="add-choice">
                        <?php
                        echo $this->Form->input('Pollchoice.4.choice', array(
                            'class' => 'ans-txtbx',
                            'placeholder' => 'add a choice for your poll',
                            'label' => false,
                            'div' => false
                        ));
                        ?>
                        <!--<input type="text" class="ans-txtbx" placeholder="Type your answer here..." readonly>-->
                        <a href="javascript:void(0)" class="close-btn"></a>
                    </div>
                    <div class="add-choice">
                        <?php
                        echo $this->Form->input('Pollchoice.5.choice', array(
                            'class' => 'ans-txtbx',
                            'placeholder' => 'add a choice for your poll',
                            'label' => false,
                            'div' => false
                        ));
                        ?>
                        <!--<input type="text" class="ans-txtbx" placeholder="Type your answer here..." readonly>-->
                        <a href="javascript:void(0)" class="close-btn"></a>
                    </div>
                </div>
                <div class="add-choice"><a href="javascript:void(0)" class="add-div"> + Add answer choice</a>
                </div>
                <div class="att-box clearfix">
                    <div class="disc-room f-left">
                        <div class="attachmentbox">
                            <span class="btn btn-success fileinput-button changepicsbtn attach-mail">
                                <span class="att-txt">Add files <span class="att-size">(Max 100 mb)</span></span>
                                <input id="fileupload" type="file" name="files[]">
                            </span>
                            <div id="files" class="files"></div>
                        </div>
                    </div>
                    <div class="f-right">

                        <a href="javascript:void(0)" class="sub-btn cnl-btn">Cancel</a>
                        <a href="javascript:void(0)" class="sub-btn disc-submit-btn-poll">Submit</a>
                    </div>
                </div>
            </div>
            <?php
//            echo $this->Form->submit();
            echo $this->Form->end();
            ?>
            <!--</form>-->
            <!--<form>-->
            <?php
            echo $this->Form->create('Discussion', array(
                'action' => 'add',
                'id' => 'DiscussionAddFormNote'
            ));
            echo $this->Form->input('Classroom.id', array(
                'hidden' => 'Y',
                'value' => $classroomId
            ));
            echo $this->Form->input('type', array(
                'hidden' => 'Y',
                'value' => 'note',
                'label' => false,
                'div' => false
            ));
            ?>
            <div class="main-box note-box"><span class="txt-count">(<span id="rem_count">200</span>/200 characters left)</span>
                <?php
                echo $this->Form->input('topic', array(
                    'class' => 'add-topic',
                    'maxlength' => '200',
                    'placeholder' => 'Topic of the discussion',
                    'label' => false,
                    'div' => false
                ));
                ?>
                <br />
                <br />
            <!--<input class="add-topic" type="text" placeholder="Topic of  the discussion…"  maxlength="200">-->
                <?php
                echo $this->Form->input('body', array(
                    'class' => 'ckeditor',
                    'label' => false,
                    'div' => false,
                    'cols' => '80',
                    'rows' => '10',
                    'id' => 'editor1'
                ));
                ?>
                <!--<textarea class="ckeditor" cols="80" id="editor1" name="editor1" rows="10"></textarea>-->
                <div class="att-box clearfix">
                    <div class="disc-room f-left">
                        <div class="attachmentbox">
                            <span class="btn btn-success fileinput-button changepicsbtn attach-mail">
                                <span class="att-txt">Add files <span class="att-size">(Max 100 mb)</span></span>
                                <input id="fileupload" type="file" name="files[]">
                            </span>
                            <div id="files" class="files"></div>
                        </div>
                    </div>
                    <div class="f-right">
                        <a href="javascript:void(0)" class="sub-btn cnl-btn">Cancel</a>
                        <a href="javascript:void(0)s" class="sub-btn disc-submit-btn-note">Submit</a>
                    </div>
                </div>
            </div>
            <a href="javascript:void(0)" class="ques-icon ques"></a>
            <a href="javascript:void(0)" class="ques-icon poll"></a>
            <a href="javascript:void(0)" class="ques-icon note-icon"></a>
            <?php echo $this->Form->end(); ?>
            <!--</form>-->

        </div>

        <!--populate discussions here-->
        <!--Praise people Dialog-->
    </div>
</section>
<?php
//echo $this->Form->create('Discussion', array(
//    'action' => 'add',
//    'id' => 'DiscussionAddFormNote'
//));
//echo $this->Form->input('Classroom.id', array(
//    'hidden' => 'Y',
//    'value' => $classroomId
//));
//echo $this->Form->input('body', array(
//    'class' => 'ckeditor',
//    'placeholder' => 'Type a note for the class',
//    'label' => false,
//    'div' => false,
//    'cols' => '80',
//    'rows' => '10',
//    'id' => 'editor1'
//));
//echo $this->Form->input('Pollchoice.0.choice');
//echo $this->Form->input('Pollchoice.1.choice');
//echo $this->Form->input('Pollchoice.2.choice');
//echo $this->Form->submit();
//echo $this->Form->end();
?>
<?php
//$route = $_SERVER['REQUEST_URI'].'/add';
//                echo $route;

$script = <<<JS
    
    $("#DiscussionAddForm, #DiscussionAddFormPoll, #DiscussionAddFormNote").submit(function(e){
        e.preventDefault();
         var formData = new FormData(this);
         var formUrl = '/pyoopil/pyoopil/discussions/add.json';

        console.log(formData);

        $.ajax({
            url: formUrl,
            type: 'POST',
            /*xhr: function() {  // Custom XMLHttpRequest
                var myXhr = $.ajaxSettings.xhr();
                if(myXhr.upload){ // Check if upload property exists
                    myXhr.upload.addEventListener('progress',progressHandlingFunction, true); // For handling the progress of the upload
                }
                return myXhr;
            },*/
            data: formData,
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
//            success: function(){
//                $("#create-announce").val('');
//                $("#AnnouncementBody").val('');
//                $('progress').attr({value:0});
//            }
        });
    });

    $(".disc-submit-btn").click(function() {
        $("#DiscussionAddForm").submit();
    });
    $(".disc-submit-btn-poll").click(function() {
        $("#DiscussionAddFormPoll").submit();
    });
    $(".disc-submit-btn-note").click(function() {
        CKEDITOR.instances.editor1.updateElement();
        $("#DiscussionAddFormNote").submit();
    });

JS;
$this->Js->buffer($script);
?>