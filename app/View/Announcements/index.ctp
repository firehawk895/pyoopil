<?php
$this->start('pagesubnav');
echo $this->element('classrooms/inside-classroom-subnav', array(
    'classroomId' => $classroomId,
    'active' => 'Announcements'
));
$this->end();
?>
<div class="content-wrapper" id="announcements">
    <!--content top-->
    <div class="top-div announcement">
        <span class="txt-count">(
            <span id="rem_count">200</span>/200 characters left)</span>
        <?php
        echo $this->Form->create('Announcement', array(
            'url' => array('controller' => 'announcements', 'action' => 'add'),
            'type' => 'file'
        ));
        ?>
        <?php
//        echo $this->Form->hidden('classroom_id', array('value' => $classroomId));
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
            <div class="att-box clearfix">
                <div class="disc-room f-left">
                    <div class="attachmentbox">
                        <span class="btn btn-success fileinput-button changepicsbtn attach-mail">
                            <span class="att-txt">Add files 
                                <span class="att-size">(Max 2 mb)</span></span> 
                            <?php
                            echo $this->Form->input('file_path', array(
                                'type' => 'file',
                                'class' => 'i_file',
                                'id' => 'fileupload',
                                'label' => false,
                                'div' => false
                            ));
                            ?>
                        </span>
                        <div id="files" class="files"></div>
                    </div>
                </div>
                <div class="f-right">
                    <a href="#" class="sub-btn" id="theButton">Create</a>
                </div>
                <?php
                echo $this->Form->end();

//                $test = Router::url(array(
//                    'controller' => 'Announcements',
//                    'action' => 'add',
//                    'pass' 
//                ));
                $url = '/Classrooms/' . $classroomId . '/Announcements/add.json';
                $route = Router::url($url);
//                $route = $_SERVER['REQUEST_URI'] . '/add';
//                echo $route;
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
            success: function(data){
                $("#create-announce").val('');
                $("#AnnouncementBody").val('');
                $('progress').attr({value:0});
                App.common.notifier.notify('success', 'New Announcement Created')
                $(document).trigger('Announcements.CREATE', data)
            }
        });
    });

    $("#theButton").click(function() {
        $("#AnnouncementIndexForm").submit();
    });

JS;
                $this->Js->buffer($script);
                ?>
            </div>
        </div>
    </div>
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
