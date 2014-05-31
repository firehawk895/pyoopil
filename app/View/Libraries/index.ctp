<?php
//echo $this->Form->create('Library' , array('type' => 'file'));
//echo $this->Form->input('id');
//echo $this->Form->input('Topic.0.name');
////or (without list for new topic)
////echo $this->Form->input('Topic.0.name');
//echo $this->Form->input('Pyoopilfile.0.path' , array('type' => 'file'));
//echo $this->Form->input('Pyoopilfile.1.path' , array('type' => 'file'));
//echo $this->Form->input('Pyoopilfile.2.path' , array('type' => 'file'));
//echo $this->Form->input('Link.0.linktext');
//echo $this->Form->input('Link.1.linktext');
//echo $this->Form->input('Link.2.linktext');
//echo $this->Form->end('Upload');

echo "see it works";
?>
<div class="library-wrapper library">
    <div class="topbuttons">
        <a href="javascript:void()" class="follow" id="upload-dlink">Upload</a>
        <!--popup-->
        <div id="upload-dialog" class="create-popup">
            <div class="pop-wind clearfix">
                <div class="pop-head clearfix">
                    <span>Upload</span>
                    <a class="close-link" href="#">
                        <span class="icon-cross"></span></a>
                </div>
                <div class="pop-content clearfix">
                    <?php
                        echo $this->Form->create('Library' , array(
                            'class' => 'form-data',
                            'type' => 'file'
                        ));
                    ?>
                    <?php
                        //Chose existing topic
                        echo $this->Form->input('Topic', array(
                            'empty' => 'Create New Topic',
                            'label' => false,
                            'div' => false
                        )); 
                        //Enter new topic
                          echo $this->Form->input('Topic.name', array(
                            'empty' => 'Create New Topic',
                            'label' => false,
                            'div' => false
                        )); 
                        //Upload file.0
                          echo $this->Form->input('Pyoopilfile.0.path', array(
                            'label' => false,
                            'div' => false,
                            'type' => 'file'
                        )); 
                        //Upload file.1
                          echo $this->Form->input('Pyoopilfile.1.path', array(
                            'label' => false,
                            'div' => false,
                            'type' => 'file'
                        ));
                        //Upload link.1
                          echo $this->Form->input('Link.0.linktext', array(
                            'label' => false,
                            'div' => false,
                        ));
                        //Upload link.2
                          echo $this->Form->input('Link.1.linktext', array(
                            'label' => false,
                            'div' => false,
                        ));
                          
                        echo $this->Form->submit();  
                        echo $this->Form->end();
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="attach-doc classlibrary stud-pnl">
        <div class="doc-heading clearfix">
            <input type="text" class="doc-input" value="Topic 1"  maxlength="70" readonly>
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
                <li>
                    <a href="javascript:void(0)" class="del-lib"></a>
                    <a href="javascript:void(0)" title="dialogbox1" class="dialogbox">
                        <div class="doc-top">

                            <p>Document</p>
                            <p>Subject</p>

                        </div> </a>
                    <div class="doc-end clearfix">
                        <a href="javascript:void(0)" title="dialogbox1" class="dialogbox"><img src="images/word_icon.png" class="m3-0"></a>
                        <p class="f-right">Posted<br>
                            12.08.13</p>
                    </div>
                </li>
                <li>
                    <a href="javascript:void(0)" class="del-lib"></a>
                    <a href="javascript:void(0)" title="dialogbox1" class="dialogbox"><div class="doc-top">

                            <p>Document</p>
                            <p>Subject</p>

                        </div></a>
                    <div class="doc-end clearfix">
                        <a href="javascript:void(0)" title="dialogbox2" class="dialogbox"><img src="images/doc-icon.png" class="m3-0"></a>
                        <p class="f-right">Posted<br>
                            12.08.13</p>
                    </div>

                </li>
                <li>
                    <a href="javascript:void(0)" class="del-lib"></a>
                    <a href="javascript:void(0)" title="dialogbox3" class="dialogbox"><div class="doc-top">

                            <p>Document</p>
                            <p>Subject</p>

                        </div></a>
                    <div class="doc-end clearfix">
                        <a href="javascript:void(0)" title="dialogbox1" class="dialogbox"><img src="images/doc-icon.png" class="m3-0"></a>
                        <p class="f-right">Posted<br>
                            12.08.13</p>
                    </div>

                </li>
                <li>
                    <a href="javascript:void(0)" class="del-lib"></a>
                    <a href="javascript:void(0)" title="dialogbox1" class="dialogbox"><div class="doc-top">

                            <p>Document</p>
                            <p>Subject</p>

                        </div></a>
                    <div class="doc-end clearfix">
                        <a href="javascript:void(0)" title="dialogbox1" class="dialogbox"><img src="images/doc-icon.png" class="m3-0"></a>
                        <p class="f-right">Posted<br>
                            12.08.13</p>
                    </div>
                </li>
            </ul>
            <p class="classlibraryhd">Pictures</p>
            <ul class="doc-list imglist">
                <li>
                    <div class="img-wrapper">
                        <a href="javascript:void(0)" class="del-lib"></a>
                        <a href="images/classroom/big.png" rel="prettyPhoto[pp_gal]">
                            <img src="images/classroom/big.png">
                            <div class="piccaption clearfix">Posted <br>
                                08.02.13</div>
                        </a>
                    </div>
                </li>
                <li>
                    <div class="img-wrapper">
                        <a href="javascript:void(0)" class="del-lib"></a>
                        <a href="images/classroom/library-img2.jpg" rel="prettyPhoto[pp_gal]">
                            <img src="images/classroom/library-img2.jpg">
                            <div class="piccaption clearfix">Posted <br>
                                08.02.13</div>
                        </a>
                    </div>
                </li>
                <li>
                    <div class="img-wrapper">
                        <a href="javascript:void(0)" class="del-lib"></a>
                        <a href="images/classroom/library-img3.jpg" rel="prettyPhoto[pp_gal]">
                            <img src="images/classroom/library-img3.jpg">
                            <div class="piccaption clearfix">Posted <br>
                                08.02.13</div>
                        </a>
                    </div>
                </li>
                <li>
                    <a href="javascript:void(0)" class="del-lib"></a>
                    <a href="images/classroom/library-img4.jpg" rel="prettyPhoto[pp_gal]">
                        <img src="images/classroom/library-img4.jpg">
                        <div class="piccaption clearfix">Posted <br>
                            08.02.13</div>
                    </a>
                </li>
                <li>
                    <div class="img-wrapper">
                        <a href="javascript:void(0)" class="del-lib"></a>
                        <a href="images/classroom/library-img5.jpg" rel="prettyPhoto[pp_gal]">
                            <img src="images/classroom/library-img5.jpg">
                            <div class="piccaption clearfix">Posted <br>
                                08.02.13</div>
                        </a>
                    </div>
                </li>
            </ul>
            <p class="classlibraryhd">Presentations</p>
            <ul class="doc-list">
                <li>
                    <a href="javascript:void(0)" class="del-lib"></a>
                    <div class="doc-top">
                        <p>Document</p>
                        <p>Subject</p>
                    </div>
                    <div class="doc-end clearfix">
                        <img src="images/ppt_icon.png" class="m3-0">
                        <p class="f-right">Posted<br>
                            12.08.13</p>
                    </div>
                </li>
                <li>
                    <a href="javascript:void(0)" class="del-lib"></a>
                    <div class="doc-top">
                        <p>Document</p>
                        <p>Subject</p>
                    </div>
                    <div class="doc-end clearfix">
                        <img src="images/ppt_icon.png" class="m3-0">
                        <p class="f-right">Posted<br>
                            12.08.13</p>
                    </div>
                </li>
                <li>
                    <a href="javascript:void(0)" class="del-lib"></a>
                    <div class="doc-top">
                        <p>Document</p>
                        <p>Subject</p>
                    </div>
                    <div class="doc-end clearfix">
                        <img src="images/ppt_icon.png" class="m3-0">
                        <p class="f-right">Posted<br>
                            12.08.13</p>
                    </div>
                </li>
                <li>
                    <a href="javascript:void(0)" class="del-lib"></a>
                    <div class="doc-top">
                        <p>Document</p>
                        <p>Subject</p>
                    </div>
                    <div class="doc-end clearfix">
                        <img src="images/ppt_icon.png" class="m3-0">
                        <p class="f-right">Posted<br>
                            12.08.13</p>
                    </div>
                </li>
            </ul>
            <p class="classlibraryhd">Links</p>
            <ul class="doc-list link-lst">
                <li>
                    <a href="javascript:void(0)" class="del-lib"></a>
                    <div class="doc-top">
                        <p>Go To Link</p>
                    </div>
                    <div class="doc-end clearfix">
                        <img src="images/link-icon.png" class="m3-0">
                        <p class="f-right">Posted<br>
                            12.08.13</p>
                    </div>
                </li>
                <li>
                    <a href="javascript:void(0)" class="del-lib"></a>
                    <div class="doc-top">
                        <p>Go To Link</p>
                    </div>
                    <div class="doc-end clearfix">
                        <img src="images/link-icon.png" class="m3-0">
                        <p class="f-right">Posted<br>
                            12.08.13</p>
                    </div>
                </li>
                <li>
                    <a href="javascript:void(0)" class="del-lib"></a>
                    <div class="doc-top">
                        <p>Go To Link</p>
                    </div>
                    <div class="doc-end clearfix">
                        <img src="images/link-icon.png" class="m3-0">
                        <p class="f-right">Posted<br>
                            12.08.13</p>
                    </div>
                </li>
            </ul>
            <p class="classlibraryhd">Video</p>
            <ul class="doc-list imglist">
                <li>
                    <div class="img-wrapper">
                        <a href="javascript:void(0)" class="del-lib"></a>
                        <a href="http://www.youtube.com/watch?v=hKC-sWjgdPA" rel="prettyPhoto[pp_gal]">
                            <img src="images/classroom/library-video1.jpg">
                            <div class="piccaption clearfix">Posted <br>
                                08.02.13</div>
                        </a>
                    </div>
                </li>
                <li>
                    <div class="img-wrapper">
                        <a href="javascript:void(0)" class="del-lib"></a>
                        <a href="http://www.youtube.com/watch?v=hKC-sWjgdPA" rel="prettyPhoto[pp_gal]">
                            <img src="images/classroom/library-video2.jpg">
                            <div class="piccaption clearfix">Posted <br>
                                08.02.13</div>
                        </a>
                    </div>
                </li>
                <li>
                    <div class="img-wrapper">
                        <a href="javascript:void(0)" class="del-lib"></a>
                        <a href="http://www.youtube.com/watch?v=hKC-sWjgdPA" rel="prettyPhoto[pp_gal]">
                            <img src="images/classroom/library-video3.jpg">
                            <div class="piccaption clearfix">Posted <br>
                                08.02.13</div>
                        </a>
                    </div>
                </li>
                <li>
                    <div class="img-wrapper">
                        <a href="javascript:void(0)" class="del-lib"></a>
                        <a href="http://www.youtube.com/watch?v=hKC-sWjgdPA" rel="prettyPhoto[pp_gal]">
                            <img src="images/classroom/library-video4.jpg">
                            <div class="piccaption clearfix">Posted <br>
                                08.02.13</div>
                        </a>
                    </div>
                </li>
                <li>
                    <div class="img-wrapper">
                        <a href="javascript:void(0)" class="del-lib"></a>
                        <a href="http://www.youtube.com/watch?v=hKC-sWjgdPA" rel="prettyPhoto[pp_gal]">
                            <img src="images/classroom/library-video5.jpg">
                            <div class="piccaption clearfix">Posted <br>
                                08.02.13</div>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="attach-doc classlibrary stud-pnl">
        <div class="doc-heading clearfix">
            <input type="text" class="doc-input" value="Topic 2"  maxlength="70" readonly>
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
                <li>
                    <a href="javascript:void(0)" class="del-lib"></a>
                    <a href="javascript:void(0)" title="dialogbox1" class="dialogbox"><div class="doc-top">

                            <p>Document</p>
                            <p>Subject</p>

                        </div> </a>
                    <div class="doc-end clearfix">
                        <a href="javascript:void(0)" title="dialogbox1" class="dialogbox"><img src="images/word_icon.png" class="m3-0"></a>
                        <p class="f-right">Posted<br>
                            12.08.13</p>
                    </div>
                </li>
                <li>
                    <a href="javascript:void(0)" class="del-lib"></a>
                    <a href="javascript:void(0)" title="dialogbox1" class="dialogbox"><div class="doc-top">

                            <p>Document</p>
                            <p>Subject</p>

                        </div></a>
                    <div class="doc-end clearfix">
                        <a href="javascript:void(0)" title="dialogbox1" class="dialogbox"><img src="images/doc-icon.png" class="m3-0"></a>
                        <p class="f-right">Posted<br>
                            12.08.13</p>
                    </div>

                    <!--popup-->
                    <div id="dialogbox1" class="create-popup doc-popup">
                        <div class="pop-wind clearfix">
                            <div class="pop-head clearfix">
                                <span>Document</span>
                                <a href="#" class="close-link"><span class="icon-cross">
                                    </span></a>
                            </div>
                            <div class="pop-content clearfix">
                                <iframe src="http://docs.google.com/viewer?url=https%3A%2F%2Ftrello-attachments.s3.amazonaws.com%2F53511011b047829e0d3fcccc%2F53511127392e0ca05e6b1d73%2F1d1e2f919ffa598c15336e8ac3ac2c1f%2FPYOOPIL_HTML_Schedule.xlsx&embedded=true" width="100%" height="780" style="border: none;"></iframe>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>