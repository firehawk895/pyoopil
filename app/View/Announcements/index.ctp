<?php
$this->start('pagesubnav');
echo $this->element('classrooms/inside-classroom-subnav', array(
    'classroomId' => $classroomId,
    'active' => 'Announcements'
));
$this->end();
?>
<div class="content-wrapper">
    <!--content top-->
    <div class="top-div announcement">
        <span class="txt-count">(
            <span id="rem_count">200</span>/200 characters left)</span> 
        <input class="add-topic" type="text" placeholder="Subject" maxlength="200" />
        <div class="ques-box">
            <textarea class="txt-area" placeholder="Type announcement text here…"></textarea>
            <div class="att-box clearfix">
                <div class="disc-room f-left">
                    <div class="attachmentbox">
                        <span class="btn btn-success fileinput-button changepicsbtn attach-mail">
                            <span class="att-txt">Add files 
                                <span class="att-size">(Max 100 mb)</span></span> 
                            <input id="fileupload" type="file" name="files[]" class="i_file" /></span>
                        <div id="files" class="files"></div>
                    </div>
                </div>
                <div class="f-right">
                    <a href="javascript:void(0)" class="follow">Cancel</a> 
                    <a href="javascript:void(0)" class="sub-btn chk-file">Create</a></div>
            </div>
        </div></div>
    <div class="loader">
        <!--<img src="images/loading/ajax-loader.gif" alt="loading" />-->
        <?php $this->Html->image('/images/loading/ajax-loader.gif'); ?>
    </div>
    <!--content list .loader-announcement { bottom: -5px; margin-left: 330px; postiion: relative; display:none; padding: 10px;} css for loader-->
    <div class="loader-announcement">
        <!--<img src="images/loading/ajax-loader.gif" alt="loading" />-->
        <?php $this->Html->image('/images/loading/ajax-loader.gif'); ?>
    </div>
    <div class="announcement-outer">
        <div class="middivouter">
            <div class="listbox">
                <div class="imgbox">
                    <a href="javascript:void(0)">
                        <!--<img src="images/follow1.jpg" />-->
                        <?php $this->Html->image('/images/follow1.jpg'); ?>
                    </a>
                </div>
                <div class="userinfo">
                    <h4>Announcement subject line 
                        <span>
                            <a href="profile-view.htm">by Abhimanyu Singh</a>
                        </span></h4>
                    <div class="datetime clearfix">Oct 1, 2013 at 7:45am</div>
                </div>
                <p>Lorem ipsum dolor sit amet, viris inimicus instructior ad eos, quem legere vulputate ut vis, viris inimicus
                    instructior ad eos, quem legere vulputate ut vis Lorem Ipsum is simply dummy text.</p>Lorem Ipsum is simply dummy
                text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since
                the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has
                survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It
                was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently
                with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                <p class="cl">
                    <a class="dlfile" href="javascript:void(0)">bill1.pptx.42kb</a> 
                    <a class="down-icon" href="javascript:void(0)"></a></p>
                <a href="javascript:void(0)" class="more">More</a></div>
            <div class="listbox">
                <div class="imgbox">
                    <a href="javascript:void(0)">
                        <img src="images/follow2.jpg" />
                    </a>
                </div>
                <div class="userinfo">
                    <h4>Announcement subject line 
                        <span>
                            <a href="profile-view.htm">by Abhimanyu Singh</a>
                        </span></h4>
                    <div class="datetime clearfix">Oct 1, 2013 at 7:45am</div>
                </div>
                <p>Lorem ipsum dolor sit amet, viris inimicus instructior ad eos, quem legere vulputate ut vis, viris inimicus
                    instructior ad eos, quem legere vulputate ut vis Lorem Ipsum is simply dummy text.</p>Lorem Ipsum is simply dummy
                text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since
                the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has
                survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It
                was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently
                with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                <p class="cl">
                    <a class="dlfile" href="javascript:void(0)">bill1.pptx.42kb</a> 
                    <a class="down-icon" href="javascript:void(0)"></a></p>
                <a href="javascript:void(0)" class="more">More</a></div>
            <div class="listbox">
                <div class="imgbox">
                    <a href="javascript:void(0)">
                        <img src="images/follow3.jpg" />
                    </a>
                </div>
                <div class="userinfo">
                    <h4>Announcement subject line 
                        <span>
                            <a href="profile-view.htm">by Abhimanyu Singh</a>
                        </span></h4>
                    <div class="datetime clearfix">Oct 1, 2013 at 7:45am</div>
                </div>
                <p>Lorem ipsum dolor sit amet, viris inimicus instructior ad eos, quem legere vulputate ut vis, viris inimicus
                    instructior ad eos, quem legere vulputate ut vis Lorem Ipsum is simply dummy text.</p>Lorem Ipsum is simply dummy
                text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since
                the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has
                survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It
                was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently
                with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                <p class="cl">
                    <a class="dlfile" href="javascript:void(0)">bill1.pptx.42kb</a> 
                    <a class="down-icon" href="javascript:void(0)"></a></p>
                <a href="javascript:void(0)" class="more">More</a></div>
            <div class="listbox">
                <div class="imgbox">
                    <a href="javascript:void(0)">
                        <img src="images/follow4.jpg" />
                    </a>
                </div>
                <div class="userinfo">
                    <h4>Announcement subject line 
                        <span>
                            <a href="profile-view.htm">by Abhimanyu Singh</a>
                        </span></h4>
                    <div class="datetime clearfix">Oct 1, 2013 at 7:45am</div>
                </div>
                <p>Lorem ipsum dolor sit amet, viris inimicus instructior ad eos, quem legere vulputate ut vis, viris inimicus
                    instructior ad eos, quem legere vulputate ut vis Lorem Ipsum is simply dummy text.</p>Lorem Ipsum is simply dummy
                text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since
                the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has
                survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It
                was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently
                with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                <p class="cl">
                    <a class="dlfile" href="javascript:void(0)">bill1.pptx.42kb</a> 
                    <a class="down-icon" href="javascript:void(0)"></a></p>
                <a href="javascript:void(0)" class="more">More</a></div>
            <div class="listbox restrict">
                <div class="imgbox">
                    <a href="javascript:void(0)">
                        <img src="images/follow5.jpg" />
                    </a>
                </div>
                <div class="userinfo">
                    <h4>Announcement subject line 
                        <span>
                            <a href="profile-view.htm">by Abhimanyu Singh</a>
                        </span></h4>
                    <div class="datetime clearfix">Oct 1, 2013 at 7:45am</div>
                </div>
                <p>Lorem ipsum dolor sit amet, viris inimicus instructior ad eos, quem legere vulputate ut vis, viris inimicus
                    instructior ad eos, quem legere vulputate ut vis Lorem Ipsum is simply dummy text.</p>Lorem Ipsum is simply dummy
                text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since
                the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has
                survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It
                was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently
                with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                <p class="cl">
                    <a class="dlfile" href="javascript:void(0)">bill1.pptx.42kb</a> 
                    <a class="down-icon" href="javascript:void(0)"></a></p>
                <a href="javascript:void(0)" class="more">More</a></div>
            <div class="listbox">
                <div class="imgbox">
                    <a href="javascript:void(0)">
                        <img src="images/follow2.jpg" />
                    </a>
                </div>
                <div class="userinfo">
                    <h4>Announcement subject line 
                        <span>
                            <a href="profile-view.htm">by Abhimanyu Singh</a>
                        </span></h4>
                    <div class="datetime clearfix">Oct 1, 2013 at 7:45am</div>
                </div>
                <p>Lorem ipsum dolor sit amet, viris inimicus instructior ad eos, quem legere vulputate ut vis, viris inimicus
                    instructior ad eos, quem legere vulputate ut vis Lorem Ipsum is simply dummy text.</p>Lorem Ipsum is simply dummy
                text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since
                the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has
                survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It
                was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently
                with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                <p class="cl">
                    <a class="dlfile" href="javascript:void(0)">bill1.pptx.42kb</a> 
                    <a class="down-icon" href="javascript:void(0)"></a></p>
                <a href="javascript:void(0)" class="more">More</a></div>
        </div>
    </div>
</div>


<script src="js/jquery-1.8.2.min.js"></script> 
<script src="js/jquery-ui-1.10.3.custom.js"></script> 
<script src="js/plugin.js"></script> 
<script src="js/core.js"></script></body>
