<?php
    $map = array(
        'document',
        'image',
        'presentation',
        'link',
        'video'
    );

    $type = array(
        'Pyoopilfile',
        'Link'
    );
?>

<?php foreach($topics as $topic) : ?>
    <div class="attach-doc classlibrary stud-pnl">
        <div class="doc-heading clearfix">
            <input type="text" class="doc-input" value="<?php echo $topic['Topic']['name']; ?>"  maxlength="70" readonly>
            <div class="lib-right">
                <a href="javascript:void(0)" class="lib-edit tooltip" title="Edit Topic"></a>
                <a href="javascript:void(0)" class="lib-delete tooltip" title="Delete"></a>
                <a href="javascript:void(0)" class="lib-download tooltip" title="Download"></a>
                <div class="click-lib click-icon tooltip" title="Click to slide"></div>
            </div>
        </div>

        <div class="contentblock">
            <?php foreach($map as $m) : ?>
                <p class="classlibraryhd"><?php echo Inflector::camelize(Inflector::pluralize($m)); ?> </p>
                <?php if($m == 'document' || $m == 'presentation') : ?>
                    <ul class="doc-list">
                <?php elseif($m == 'image' || $m == 'video') : ?>
                    <ul class="doc-list img-list">
                <?php elseif($m == 'link') : ?>
                    <ul class="doc-list link-list">
                <?php endif; ?>

                    <?php foreach($topic['Pyoopilfile'] as $file) : ?>
                        <?php if($file['file_type'] == $m) : ?>
                            <li>
                                <?php if($m == 'document' || $m == 'presentation' || $m == 'link') : ?>
                                    <a href="javascript:void(0)" class="del-lib"></a>
                                    <a href="http://docs.google.com/viewer?url=https%3A%2F%2Ftrello-attachments.s3.amazonaws.com%2F53511011b047829e0d3fcccc%2F53511127392e0ca05e6b1d73%2F1d1e2f919ffa598c15336e8ac3ac2c1f%2FPYOOPIL_HTML_Schedule.xlsx&embedded=true?iframe=true&width=100%&height=100%" rel="prettyPhoto[iframes]">
                                        <div class="doc-top">
                                            <?php if($m == 'link') :?>
                                                <p><?php echo $file['linktext']?></p>
                                            <?php else : ?>
                                                <p><?php echo $file['filename']?></p>
                                            <?php endif; ?>
                                        </div> </a>
                                    <div class="doc-end clearfix">
                                        <a href="javascript:void(0)" title="dialogbox1" class="dialogbox"><img src="images/word_icon.png" class="m3-0"></a>
                                        <p class="f-right">Posted<br><?php echo $this->Time->format('F jS, Y h:i A', $file['created'], null);?></p>
                                    </div>
                                <?php elseif(($m == 'image') || ($m == 'video')) : ?>
                                    <div class="img-wrapper">
                                        <a href="javascript:void(0)" class="del-lib"></a>
                                        <a href="images/classroom/big.png" rel="prettyPhoto[pp_gal]">
                                            <img src="images/classroom/big.png">
                                            <div class="piccaption clearfix">Posted <br><?php echo $this->Time->format('F jS, Y h:i A', $file['created'], null);?></div>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            <? endforeach; ?>
        </div>
    </div>
<?php endforeach; ?>
</div>