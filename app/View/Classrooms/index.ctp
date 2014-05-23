<?php
$this->start('pagesubnav');
echo $this->element('classrooms/classroom-subnav');
$this->end();
?>
<div class="library-wrapper">
    <ul class="tile-lst" id="class-tile-list">
        <li class="code-class">
            <div class="newjoinbox">
                <a class="newjoin">Join New Classroom</a>
                <div class="accessclass">
                    <?php
//                echo $this->Form->create('Classroom', array(
//                        'action' => 'joinWithCode',
//                        'id' => 'join-with-code'
//                ));
                    echo $this->Form->create(null, array(
                        'url' => array(
                            'controller' => 'classrooms',
                            'action' => 'joinWithCode'
                        ),
                        'id' => 'join-with-code'
                    ));
                    echo $this->Form->input('access_code', array(
                        'div' => false,
                        'label' => false,
                        'type' => 'text',
                        'class' => 'access',
//                    'name' => 'search',
                        'placeholder' => 'Enter Access Code',
//                    'label' => 'false'
                    ));
//                echo $this->Form->submit('Join Classroom', array(
//                    'div' => false,
//                    'class' => 'sub-btn',
//                    'value' => 'Join Classroom',
//                ));
                    echo $this->Form->end();
                    $script = <<<JS
alert("working2");
var options_classroom_join = { 
//        target:        '#classroom-created-success',   // target element(s) to be updated with server response 
        beforeSubmit:  showRequest,  // pre-submit callback 
        success:       showResponse,  // post-submit callback
        error: showError
 
        // other available options: 
        //url:       url         // override for form's 'action' attribute 
        //type:      type        // 'get' or 'post', override for form's 'method' attribute 
        //dataType:  null        // 'xml', 'script', or 'json' (expected server response type) 
        //clearForm: true        // clear all form fields after successful submit 
        //resetForm: true        // reset the form after successful submit 
 
        // $.ajax options can be used here too, for example: 
        //timeout:   3000 
    }; 

    $('#join-with-code').ajaxForm(options_classroom_join);
    $('#join-with-code-submit').click( function() {
         $('#join-with-code').submit(); 
    });
JS;
                    ?>
                    <!--<input type="text" class="access" name="search" placeholder="Enter Access Code" id="join-with-code-submit">-->
                    <a href="#" class="sub-btn" id="join-with-code-submit">Join Classroom</a>
                </div>
            </div>
        </li>
        <?php foreach ($tileData as $tile) : ?>
            <li>
                <a href="<?php
                echo Router::url(array(
                    'controller' => 'Announcements',
                    'action' => 'index',
                    'id' => $tile['id']
                ));
                ?>">
                       <?php if ($tile['is_restricted'] === true) : ?>
                        <div class="lock-state">
                            <p>! You do not have access to this class. Please contact the owner</p>
                        </div>
                    <?php endif; ?>
                    <?php if ($tile['is_teaching'] === true) : ?>
                        <div class="class-head">My Class</div>
                    <?php endif; ?>
                    <?php if ($tile['is_private'] === true) : ?>
                        <?php echo $this->Html->image('/images/lock_icon.png', array('class' => 'lock')); ?>
                        <!--<img src="images/lock_icon.png" class="lock">-->
                    <?php endif; ?>
                    <div class="doc-top">
                        <p class="subject"><?php echo $tile['title'] ?></p>
                        <div>by</div>
                        <div><span class="online"></span><?php echo $tile['educatorName'] ?></div>
                        <div class="totalstudent">(<?php echo $tile['users_classroom_count'] ?> Students)</div>
                    </div>
                    <?php if ($tile['campusName'] != null) : ?>
                        <p class="doc-end"><?php echo $tile['campusName'] ?></p>
                    <?php endif; ?>
                </a>
            </li>
        <?php endforeach; ?>
        <?php
        $this->Js->buffer($script);
        ?>
    </ul>
</div>