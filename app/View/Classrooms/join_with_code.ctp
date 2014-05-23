<li>
    <a href="">
        <?php if ($tile['is_restricted'] === true) : ?>
            <div class="lock-state">
                <p>! You do not have access to this class. Please contact the owner</p>
            </div>
        <?php endif; ?>
        <?php if ($tile['is_teaching'] === true) : ?>
            <div class="class-head">My Class</div>
        <?php endif; ?>
        <?php if ($tile['is_private'] === true) : ?>
            <img src="images/lock_icon.png" class="lock">
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