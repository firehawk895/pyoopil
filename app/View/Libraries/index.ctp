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
            <p class="classlibraryhd">Documents </p>
            <ul class="doc-list">
                <?php foreach($topic['Pyoopilfile'] as $file) : ?>
                    <?php if($file['file_type'] == 'document') : ?>
                        <li>
                            <a href="javascript:void(0)" class="del-lib"></a>
                            <a href="http://docs.google.com/viewer?url=https%3A%2F%2Ftrello-attachments.s3.amazonaws.com%2F53511011b047829e0d3fcccc%2F53511127392e0ca05e6b1d73%2F1d1e2f919ffa598c15336e8ac3ac2c1f%2FPYOOPIL_HTML_Schedule.xlsx&embedded=true?iframe=true&width=100%&height=100%" rel="prettyPhoto[iframes]">
                                <div class="doc-top">

                                    <p><?php echo $file['filename']?></p>

                                </div> </a>
                            <div class="doc-end clearfix">
                                <a href="javascript:void(0)" title="dialogbox1" class="dialogbox"><img src="<?php echo $file['thumbnail_path']; ?>" class="m3-0"></a>
                                <p class="f-right">Posted <br><?php $this->Time->format('F jS, Y h:i A', $file['created'], null);?></p>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            <p class="classlibraryhd">Pictures </p>
            <ul class="doc-list imglist">
                <?php foreach($topic['Pyoopilfile'] as $file) : ?>
                    <?php if($file['file_type'] == 'image') : ?>
                        <li>
                            <div class="img-wrapper">
                                <a href="javascript:void(0)" class="del-lib"></a>
                                <a href="images/classroom/big.png" rel="prettyPhoto[pp_gal]">
                                    <img src="https://s3-ap-southeast-1.amazonaws.com/pyoopil-files/libraries/Cinderella-Ball-Gown-Lace-Wrapped-Dress-with-Long-Sleeve-WM-0015-01.jpg">
                                    <div class="piccaption clearfix">Posted <br><?php $this->Time->format('F jS, Y h:i A', $file['created'], null);?></div>
                                </a>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            <p class="classlibraryhd">Presentations</p>
            <ul class="doc-list">
                <?php foreach($topic['Pyoopilfile'] as $file) : ?>
                    <?php if($file['file_type'] == 'presentation') : ?>
                        <li>
                            <a href="javascript:void(0)" class="del-lib"></a>
                            <div class="doc-top">
                                <p><?php echo $file['filename']?></p>
                            </div>
                            <div class="doc-end clearfix">
                                <img src="images/ppt_icon.png" class="m3-0">
                                <p class="f-right">Posted <br><?php $this->Time->format('F jS, Y h:i A', $file['created'], null);?></p>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            <p class="classlibraryhd">Links</p>
            <ul class="doc-list link-lst">
                <?php foreach($topic['Link'] as $Link) : ?>
                    <li>
                        <a href="javascript:void(0)" class="del-lib"></a>
                        <div class="doc-top">
                            <p><?php echo $Link['linktext']?></p>
                        </div>
                        <div class="doc-end clearfix">
                            <img src="images/link-icon.png" class="m3-0">
                            <p class="f-right">Posted <br><?php $this->Time->format('F jS, Y h:i A', $Link['created'], null);?></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
            <p class="classlibraryhd">Video</p>
            <ul class="doc-list imglist">
                <?php foreach($topic['Pyoopilfile'] as $file) : ?>
                    <li>
                        <div class="img-wrapper">
                            <a href="javascript:void(0)" class="del-lib"></a>
                            <a href="http://www.youtube.com/watch?v=hKC-sWjgdPA" rel="prettyPhoto[pp_gal]">
                                <img src="images/classroom/library-video1.jpg">
                                <div class="piccaption clearfix">Posted <br><?php $this->Time->format('F jS, Y h:i A', $file['created'], null);?></div>
                            </a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endforeach; ?>
</div>