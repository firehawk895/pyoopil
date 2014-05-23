<?php
//$script += 'var classoomName = ' . classroomName . ';';
//$script += 'var passCode = ' . passCode . ';';
//$script = <<<JS
//$('#create-class-name').html('<Classroom name>');
//$('#create-class-passcode').html('<Classroom acess code>');
//$("#create-class").dialog("close");
//$("#create-class-success").dialog("open");
//$('.ui-widget-overlay').addClass('custom-overlay');
//JS;
//
//$this->Js->buffer($script);
?>
<div class="pop-content">
    <div class="created-contt">
        <p class="created-heading">Your Class "<?php echo $title ?>" has been successfully created.</p>
        <p class="created-txt">Please find below the unique group password. You can distribute the password to your friends so that they can join the group. </p>
        <p class="created-txt">An E-mail with the password has also been sent to you for your convenience.</p>
        <?php if ($isPrivate) : ?>
            <p class="created-txt">Unique access code: <span class="code-txt"><?php echo $passCode ?></span>
            </p>
        <?php else : ?>
            <p class="created-txt">The classroom is public and accessible to everyone.</p>
        <?php endif; ?>
        <p class="created-txt">Now make your class more engaging with pyoopil. Kudos for setting up the class. Have a great session this semester with your students. Cheers</p>
        <div class="pop-close">
            <a href="#" class="sub-btn">Take me to my classrooms</a>
        </div>
    </div>
</div>