<?php
    $this->start('pagesubnav');
    echo $this->element('classrooms/inside-classroom-subnav', array(
        'classroomId' => $classroomId,
        'active' => 'discussions'
    ));
    $this->end();

    $map = array('en','in','cu','co','ed');

    $engagers = array(
        'en' => array(),
        'in' => array(),
        'cu' => array(),
        'co' => array(),
        'ed' => array()
    );
?>

<section class="pagecontent clearfix">
<div class="content-wrapper">
<div class="topbuttons">
    <a href="classroom-discussion.htm" class="follow active">All</a>
    <a href="classroom-discussion-fold.htm" class="follow">Folded</a>
</div>
<div class="clear"></div>
<div class="top-div">
    <form>
        <span class="txt-count">(<span id="rem_count">200</span>/200 characters left)</span>
        <input class="add-topic" type="text" placeholder="Topic of  the discussion…"  maxlength="200">
        <div class="main-box ques-box">
            <textarea class="txt-area h235" placeholder="Type you question here…" ></textarea>
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
                    <a href="javascript:void(0)" class="sub-btn">Submit</a>
                </div>
            </div>
        </div>
        <div class="main-box poll-box">
            <textarea class="txt-area" placeholder="Type you question here…."></textarea>
            <div class="add-here">
                <div class="add-choice"><input type="text" class="ans-txtbx" placeholder="Type your answer here..." readonly>
                    <a href="javascript:void(0)" class="close-btn"></a>
                </div>
                <div class="add-choice"><input type="text" class="ans-txtbx" placeholder="Type your answer here..." readonly><a href="javascript:void(0)" class="close-btn"></a>
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
                    <a href="javascript:void(0)" class="sub-btn">Submit</a>
                </div>
            </div>
        </div>
        <div class="main-box note-box">
            <textarea class="ckeditor" cols="80" id="editor1" name="editor1" rows="10"></textarea>
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
                    <a href="javascript:void(0)" class="sub-btn">Submit</a>
                </div>
            </div>
        </div>
        <a href="javascript:void(0)" class="ques-icon ques"></a>
        <a href="javascript:void(0)" class="ques-icon poll"></a>
        <a href="javascript:void(0)" class="ques-icon note-icon"></a>
    </form>
</div>

<!--populate discussions here-->
    <?php foreach($discussions as $discussion) : ?>
    <ul class="disc-list">
        <li>
            <div class="disc-box clearfix">
                <div class="disc-left">
                    <a href="javascript:void(0)"><img src="images/follow1.jpg" class="disc-img"></a>
                </div>
                <div class="arrow_box">
                    <?php if($discussion['Discussion']['type'] == 'question') : ?>
                        <span class="arrowbox-icon quest-icon"></span>
                    <?php elseif($discussion['Discussion']['type'] == 'poll') : ?>
                        <span class="arrowbox-icon"></span>
                    <?php elseif($discussion['Discussion']['type'] == 'note') : ?>
                        <span class="arrowbox-icon note-icon"></span>
                    <?php endif; ?>

                    <div class="name-left">
                        <p class="tname"><?php echo $discussion['Discussion']['topic']; ?></p>

                        <p class="tby"><a href="javascript:void(0)">by <?php echo $discussion['AppUser']['fname']." ".$discussion['AppUser']['lname'] ; ?></a></p>

                        <p class="tby"><?php echo $this->Time->format('F jS, Y h:i A', $discussion['Discussion']['created'], null);?></p>
                    </div>
                    <div class="icon-right">
                        <a href="javascript:void(0)" class="vl-t tooltip"><img src="images/disc-share.png"></a>
                        <a href="javascript:void(0)" class="vl-t tooltip"><img src="images/disc-close.png"></a>
                        <a class="fold-icon tooltip" href="javascript:void(0)"></a>
                    </div>
                    <div class="clear"></div>
                    <p class="ttxt"><?php echo $discussion['Discussion']['body']; ?></p>
                    <?php if($discussion['Discussion']['type'] == 'poll') : ?>
                        <div class="clearfix">
                            <div class="poll-left">
                                <a href="javascript:void(0)" class="ans-btn">Answer 1</a>
                                <a href="javascript:void(0)" class="ans-btn">Answer 2</a>
                                <a href="javascript:void(0)" class="ans-btn">Answer 3</a>
                                <a href="javascript:void(0)" class="ans-btn">Answer 4</a>
                            </div>
                            <div class="poll-right">
                                <div id="chart_div2"></div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="arrbox-footer clearfix">
                        <div class="f-left prs-sp">
                            <a href="javascript:void(0)" class="icon-title"><span class="praise-icon nopraise"><?php echo $discussion['Discussion']['display_praise']; ?></span>Praise</a>

                            <div class="clk-tt" style="display: none;">
                                <ul>
                                    <li><a href="javascript:void(0)"><span>EH</span>Engagement</a>
                                    </li>
                                    <li><a href="javascript:void(0)"><span>IN</span>Intelligence</a>
                                    </li>
                                    <li><a href="javascript:void(0)"><span>CU</span>Curiosity</a>
                                    </li>
                                    <li><a href="javascript:void(0)"><span>CO</span>Contribution</a>
                                    </li>
                                    <li class="lastli"><a href="javascript:void(0)"><span>EN</span>Endorsement</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="f-right">
                            <?php foreach($map as $m) : ?>
                                <div class="enga">
                                    <?php if($discussion['Discussion'][$m] == 0) : ?>
                                        <a href="javascript:void(0)" class="msg-link point-icon nopoint-icon"><?php echo strtoupper($m); ?></a>
                                    <?php else : ?>
                                        <a href="javascript:void(0)" class="msg-link point-icon"><?php echo strtoupper($m); ?></a>
                                    <?php endif; ?>
                                    <!--Populate engagers here-->
                                    <?php /*if($discussion['Gamificationvote'] != NULL) : */?>
                                        <!--<div class="enga-tooltip">
                                            <div class="enga-list">
                                                <ul>
                                                    <li><p class="tt-name">Amar Verma</p></li>
                                                    <li><p class="tt-name">Akriti Singh</p></li>
                                                    <li><p class="tt-name">Deepti Singh</p></li>
                                                </ul>
                                            </div>
                                        </div>-->
                                    <?php /*endif; */?>
                                    <span class="icon-title "><?php echo $discussion['Discussion'][$m]; ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!--<div class="bor-rep">
                <a href="javascript:void(0)" class="view-more">View all 5 answers <img src="images/view-all.png"></a>
            </div>-->
        </li>
        <!--populating replies -->
        <?php foreach($discussion['Reply'] as $reply) : ?>
        <li>
            <div class="disc-box clearfix">
                <div class="disc-left">
                    <a href="javascript:void(0)"><img src="images/chat2.png" class="disc-img"></a>
                </div>
                <div class="arrow_box">
                    <div class="name-left">
                        <p class="tname"><a href="javascript:void(0)"><?php echo $reply['AppUser']['fname']." ".$reply['AppUser']['lname'] ; ?></a></p>
                        <p class="tby"><?php echo $this->Time->format('F jS, Y h:i A', $reply['created'], null);?></p>
                    </div>
                    <div class="icon-right">
                  <span class="dd-block">
                  <a href="javascript:void(0)" class="dd-icon dd-click"></a>
                  <div class="arr-dd">
                      <ul>
                          <li><a href="javascript:void(0)">Report Abuse</a>
                          </li>
                          <li class="lastli"><a href="javascript:void(0)">Delete Comment</a>
                          </li>
                      </ul>
                  </div>
                  </span>
                    </div>
                    <div class="clear"></div>
                    <p class="ttxt"><?php echo $reply['comment']; ?></p>
                    <div class="arrbox-footer clearfix">
                        <div class="f-left prs-sp">
                            <a href="javascript:void(0)" class="icon-title"><span class="praise-icon">61</span>Praise</a>
                            <div class="clk-tt">
                                <ul>
                                    <li><a href="javascript:void(0)"><span>EH</span>Engagement</a>
                                    </li>
                                    <li><a href="javascript:void(0)"><span>IN</span>Intelligence</a>
                                    </li>
                                    <li><a href="javascript:void(0)"><span>CU</span>Curiosity</a>
                                    </li>
                                    <li><a href="javascript:void(0)"><span>CO</span>Contribution</a>
                                    </li>
                                    <li class="lastli"><a href="javascript:void(0)"><span>EN</span>Endorsement</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="f-right">
                            <?php foreach($map as $m) : ?>
                                <div class="enga">
                                    <?php if($reply[$m] == 0) : ?>
                                        <a href="javascript:void(0)" class="msg-link point-icon nopoint-icon"><?php echo strtoupper($m); ?></a>
                                    <?php else : ?>
                                        <a href="javascript:void(0)" class="msg-link point-icon"><?php echo strtoupper($m); ?></a>
                                    <?php endif; ?>

                                    <!--Populate engagers here-->

                                    <?php /*if($reply['Gamificationvote'] != null) : */?>
                                        <?php /*foreach($reply['Gamificationvote'] as $vote) : */?>
                                            <!--<div class="enga-tooltip">
                                                <div class="enga-list">
                                                    <ul>
                                                        <?php /*if($vote['vote'] == $m) : */?>
                                                            <li><p class="tt-name">Amar Verma</p></li>
                                                            <li><p class="tt-name">Akriti Singh</p></li>
                                                        <?php /*endif; */?>
                                                    </ul>
                                                </div>
                                            </div>-->
                                        <?php /*endforeach; */?>
                                    <?php /*endif; */?>


                                    <span class="icon-title "><?php echo $reply[$m]; ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php endforeach; ?>

</div>
<!--Praise people Dialog-->

</section>