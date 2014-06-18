<?php
$this->start('pagesubnav');
echo $this->element('classrooms/inside-classroom-subnav', array(
    'classroomId' => $classroom_id,
    'active' => 'Announcements'
));
$this->end();
?>
<div class="content-wrapper">
    <!--content top-->
    <div class="top-div announcement">
        <span class="txt-count">(
            <span id="rem_count">200</span>/200 characters left)</span> 
<!--        <input class="add-topic" type="text" placeholder="Subject" maxlength="200" />-->
        <?php
        echo $this->Form->create('Announcement', array(
            'url' => array('controller' => 'announcements', 'action' => 'add'),
            'type' => 'file'
        ));
        ?>
        <?php
        echo $this->Form->hidden('classroom_id', array('value' => $classroom_id));
        echo $this->Form->input('subject', array(
            'class' => 'add-topic',
            'type' => 'text',
            'placeholder' => 'Subject',
            'label' => false,
            'id' => 'create-announce'
        ));
        ?>
        <div class="ques-box">
            <?php
            echo $this->Form->input('body', array(
                'class' => 'txt-area',
                'placeholder' => 'Type announcement text here…',
                'label' => false
            ));
            ?>
            <!--<textarea class="txt-area" placeholder="Type announcement text here…"></textarea>-->
            <div class="att-box clearfix">
                <div class="disc-room f-left">
                    <div class="attachmentbox">
                        <span class="btn btn-success fileinput-button changepicsbtn attach-mail">
                            <span class="att-txt">Add files 
                                <span class="att-size">(Max 100 mb)</span></span> 
                            <?php
                            echo $this->Form->input('file_path', array(
                                'type' => 'file',
                                'class' => 'i_file',
                                'id' => 'fileupload',
                                'label' => false,
                                'div' => false
                            ));
                            ?>
                            <!--<input id="fileupload" type="file" name="files[]" class="i_file" />-->
                        </span>
                        <div id="files" class="files"></div>
                    </div>
                </div>
                <div class="f-right">
                    <!--                                        <a href="javascript:void(0)" class="follow">Cancel</a> 
                    --><a href="#" class="sub-btn" id="theButton">Create</a>
                    <?php // echo $this->Form->submit(); ?>
                </div>
                <?php
                echo $this->Form->end();

                $route = $this->Html->url(array('controller' => 'announcements', 'action' => 'add'));

$script = <<<JS

    function progressHandlingFunction(e){
        if(e.lengthComputable){
            console.log(e);
            $('progress').attr({value:e.loaded,max:e.total});
        }
    }

    $("#AnnouncementIndexForm").submit(function(e){
        e.preventDefault();
         var formData = new FormData(this);
         var formUrl = '$route';

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
            success: function(){
                $("#create-announce").val('');
                $("#AnnouncementBody").val('');
                $('progress').attr({value:0});
            }
        });
    });

    $("#theButton").click(function() {
        $("#AnnouncementIndexForm").submit();
    });

JS;



                $this->Js->buffer($script);
                ?>
                <progress value="0" max="100"></progress>
            </div>
        </div></div>
    <!--content list-->
    <div class="announcement-outer">
        <div class="middivouter">
            <?php foreach ($tiles as $tile) : ?>
                <div class="listbox">
                    <!-- unread announcement with attachment example -->
                    <div class="imgbox">
                        <a href="javascript:void(0)">
                            <img src="images/follow1.jpg" /><!-- user profile photo who posts announcement --> 
                        </a>
                    </div>
                    <div class="userinfo">
                        <h4><?php echo $tile['Announcement']['subject'] ?> 
                            <span>
                                <a href="profile-view.htm">by <?php echo $tile['AppUser']['fname'] . " " . $tile['AppUser']['lname'] ?></a>
                            </span></h4>
                        <div class="datetime clearfix"><!-- if there is an attachment --><span class="attach-icon"></span><?php
                            echo $this->Time->format(
                                    'F jS, Y h:i A', $tile['Announcement']['created'], null
                            );
                            ?></div>
                    </div>
                    <p><?php echo $tile['Announcement']['body'] ?></p>
                    <p class="cl">
                        <a class="dlfile" href="javascript:void(0)"><?php echo $tile['Announcement']['filename'] ?><?php echo CakeNumber::toReadableSize($tile['Announcement']['filesize']) ?></a> 
                        <a class="down-icon" href="<?php echo $tile['Announcement']['file_path'] ?>"></a></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php /*echo debug($this->Paginator->params()); */?>
    <?php echo $this->Paginator->prev('« Previous', null, null, array('class' => 'disabled')); ?>
    <?php echo $this->Paginator->numbers(); ?>    
    <?php echo $this->Paginator->counter(); ?>
    <?php echo $this->Paginator->next('Next »', null, null, array('class' => 'disabled')); ?> 
</div>
