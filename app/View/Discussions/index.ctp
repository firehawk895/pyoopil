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
        <input class="add-topic" type="text" placeholder="Topic of  the discussion…" maxlength="200">
        <div class="main-box ques-box">
            <textarea class="txt-area h235" placeholder="Type you question here…" style="resize: none; overflow-y: hidden; position: absolute; top: 0px; left: -9999px; height: 235px; width: 97%; line-height: normal; text-decoration: none; letter-spacing: 0px;" tabindex="-1"></textarea><textarea class="txt-area h235" placeholder="Type you question here…" style="resize: none; overflow-y: hidden;"></textarea>
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
            <textarea class="txt-area" placeholder="Type you question here…." style="resize: none; overflow-y: hidden; position: absolute; top: 0px; left: -9999px; height: 90px; width: 97%; line-height: normal; text-decoration: none; letter-spacing: 0px;" tabindex="-1"></textarea><textarea class="txt-area" placeholder="Type you question here…." style="resize: none; overflow-y: hidden;"></textarea>
            <div class="add-here">
                <div class="add-choice"><input type="text" class="ans-txtbx" placeholder="Type your answer here..." readonly="">
                    <a href="javascript:void(0)" class="close-btn"></a>
                </div>
                <div class="add-choice"><input type="text" class="ans-txtbx" placeholder="Type your answer here..." readonly=""><a href="javascript:void(0)" class="close-btn"></a>
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
            <textarea class="ckeditor" cols="80" id="editor1" name="editor1" rows="10" style="visibility: hidden; display: none;"></textarea><div id="cke_editor1" class="cke_1 cke cke_reset cke_chrome cke_editor_editor1 cke_ltr cke_browser_webkit" dir="ltr" lang="en" role="application" aria-labelledby="cke_editor1_arialbl"><span id="cke_editor1_arialbl" class="cke_voice_label">Rich Text Editor, editor1</span><div class="cke_inner cke_reset" role="presentation"><span id="cke_1_top" class="cke_top cke_reset_all" role="presentation" style="height: auto; -webkit-user-select: none;"><span id="cke_7" class="cke_voice_label">Editor toolbars</span><span id="cke_1_toolbox" class="cke_toolbox" role="group" aria-labelledby="cke_7" onmousedown="return false;"><span id="cke_10" class="cke_toolbar" aria-labelledby="cke_10_label" role="toolbar"><span id="cke_10_label" class="cke_voice_label">Clipboard/Undo</span><span class="cke_toolbar_start"></span><span class="cke_toolgroup" role="presentation"><a id="cke_11" class="cke_button cke_button__cut cke_button_disabled " href="javascript:void('Cut')" title="Cut" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_11_label" aria-haspopup="false" aria-disabled="true" onkeydown="return CKEDITOR.tools.callFunction(2,event);" onfocus="return CKEDITOR.tools.callFunction(3,event);" onclick="CKEDITOR.tools.callFunction(4,this);return false;"><span class="cke_button_icon cke_button__cut_icon" style="background-image:url(http://localhost/www/pyoopil/js/ck/plugins/icons.png?t=E4KA);background-position:0 -264px;background-size:auto;">&nbsp;</span><span id="cke_11_label" class="cke_button_label cke_button__cut_label" aria-hidden="false">Cut</span></a><a id="cke_12" class="cke_button cke_button__copy cke_button_disabled " href="javascript:void('Copy')" title="Copy" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_12_label" aria-haspopup="false" aria-disabled="true" onkeydown="return CKEDITOR.tools.callFunction(5,event);" onfocus="return CKEDITOR.tools.callFunction(6,event);" onclick="CKEDITOR.tools.callFunction(7,this);return false;"><span class="cke_button_icon cke_button__copy_icon" style="background-image:url(http://localhost/www/pyoopil/js/ck/plugins/icons.png?t=E4KA);background-position:0 -216px;background-size:auto;">&nbsp;</span><span id="cke_12_label" class="cke_button_label cke_button__copy_label" aria-hidden="false">Copy</span></a><a id="cke_13" class="cke_button cke_button__paste  cke_button_off" href="javascript:void('Paste')" title="Paste" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_13_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(8,event);" onfocus="return CKEDITOR.tools.callFunction(9,event);" onclick="CKEDITOR.tools.callFunction(10,this);return false;"><span class="cke_button_icon cke_button__paste_icon" style="background-image:url(http://localhost/www/pyoopil/js/ck/plugins/icons.png?t=E4KA);background-position:0 -312px;background-size:auto;">&nbsp;</span><span id="cke_13_label" class="cke_button_label cke_button__paste_label" aria-hidden="false">Paste</span></a><a id="cke_14" class="cke_button cke_button__pastetext  cke_button_off" href="javascript:void('Paste as plain text')" title="Paste as plain text" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_14_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(11,event);" onfocus="return CKEDITOR.tools.callFunction(12,event);" onclick="CKEDITOR.tools.callFunction(13,this);return false;"><span class="cke_button_icon cke_button__pastetext_icon" style="background-image:url(http://localhost/www/pyoopil/js/ck/plugins/icons.png?t=E4KA);background-position:0 -720px;background-size:auto;">&nbsp;</span><span id="cke_14_label" class="cke_button_label cke_button__pastetext_label" aria-hidden="false">Paste as plain text</span></a><a id="cke_15" class="cke_button cke_button__pastefromword  cke_button_off" href="javascript:void('Paste from Word')" title="Paste from Word" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_15_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(14,event);" onfocus="return CKEDITOR.tools.callFunction(15,event);" onclick="CKEDITOR.tools.callFunction(16,this);return false;"><span class="cke_button_icon cke_button__pastefromword_icon" style="background-image:url(http://localhost/www/pyoopil/js/ck/plugins/icons.png?t=E4KA);background-position:0 -768px;background-size:auto;">&nbsp;</span><span id="cke_15_label" class="cke_button_label cke_button__pastefromword_label" aria-hidden="false">Paste from Word</span></a><span class="cke_toolbar_separator" role="separator"></span><a id="cke_16" class="cke_button cke_button__undo cke_button_disabled " href="javascript:void('Undo')" title="Undo" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_16_label" aria-haspopup="false" aria-disabled="true" onkeydown="return CKEDITOR.tools.callFunction(17,event);" onfocus="return CKEDITOR.tools.callFunction(18,event);" onclick="CKEDITOR.tools.callFunction(19,this);return false;"><span class="cke_button_icon cke_button__undo_icon" style="background-image:url(http://localhost/www/pyoopil/js/ck/plugins/icons.png?t=E4KA);background-position:0 -1008px;background-size:auto;">&nbsp;</span><span id="cke_16_label" class="cke_button_label cke_button__undo_label" aria-hidden="false">Undo</span></a><a id="cke_17" class="cke_button cke_button__redo cke_button_disabled " href="javascript:void('Redo')" title="Redo" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_17_label" aria-haspopup="false" aria-disabled="true" onkeydown="return CKEDITOR.tools.callFunction(20,event);" onfocus="return CKEDITOR.tools.callFunction(21,event);" onclick="CKEDITOR.tools.callFunction(22,this);return false;"><span class="cke_button_icon cke_button__redo_icon" style="background-image:url(http://localhost/www/pyoopil/js/ck/plugins/icons.png?t=E4KA);background-position:0 -960px;background-size:auto;">&nbsp;</span><span id="cke_17_label" class="cke_button_label cke_button__redo_label" aria-hidden="false">Redo</span></a></span><span class="cke_toolbar_end"></span></span><span id="cke_18" class="cke_toolbar" aria-labelledby="cke_18_label" role="toolbar"><span id="cke_18_label" class="cke_voice_label">Editing</span><span class="cke_toolbar_start"></span><span class="cke_toolgroup" role="presentation"><a id="cke_19" class="cke_button cke_button__scayt cke_button_off " href="javascript:void('')" title="" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_19_label" aria-haspopup="true" onkeydown="return CKEDITOR.tools.callFunction(23,event);" onfocus="return CKEDITOR.tools.callFunction(24,event);" onclick="CKEDITOR.tools.callFunction(25,this);return false;"><span class="cke_button_icon cke_button__scayt_icon" style="background-image:url(http://localhost/www/pyoopil/js/ck/plugins/icons.png?t=E4KA);background-position:0 -888px;background-size:auto;">&nbsp;</span><span id="cke_19_label" class="cke_button_label cke_button__scayt_label" aria-hidden="false"></span><span class="cke_button_arrow"></span></a></span><span class="cke_toolbar_end"></span></span><span id="cke_20" class="cke_toolbar" aria-labelledby="cke_20_label" role="toolbar"><span id="cke_20_label" class="cke_voice_label">Links</span><span class="cke_toolbar_start"></span><span class="cke_toolgroup" role="presentation"><a id="cke_21" class="cke_button cke_button__link  cke_button_off" href="javascript:void('Link')" title="Link" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_21_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(26,event);" onfocus="return CKEDITOR.tools.callFunction(27,event);" onclick="CKEDITOR.tools.callFunction(28,this);return false;"><span class="cke_button_icon cke_button__link_icon" style="background-image:url(http://localhost/www/pyoopil/js/ck/plugins/icons.png?t=E4KA);background-position:0 -528px;background-size:auto;">&nbsp;</span><span id="cke_21_label" class="cke_button_label cke_button__link_label" aria-hidden="false">Link</span></a><a id="cke_22" class="cke_button cke_button__unlink cke_button_disabled " href="javascript:void('Unlink')" title="Unlink" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_22_label" aria-haspopup="false" aria-disabled="true" onkeydown="return CKEDITOR.tools.callFunction(29,event);" onfocus="return CKEDITOR.tools.callFunction(30,event);" onclick="CKEDITOR.tools.callFunction(31,this);return false;"><span class="cke_button_icon cke_button__unlink_icon" style="background-image:url(http://localhost/www/pyoopil/js/ck/plugins/icons.png?t=E4KA);background-position:0 -552px;background-size:auto;">&nbsp;</span><span id="cke_22_label" class="cke_button_label cke_button__unlink_label" aria-hidden="false">Unlink</span></a><a id="cke_23" class="cke_button cke_button__anchor  cke_button_off" href="javascript:void('Anchor')" title="Anchor" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_23_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(32,event);" onfocus="return CKEDITOR.tools.callFunction(33,event);" onclick="CKEDITOR.tools.callFunction(34,this);return false;"><span class="cke_button_icon cke_button__anchor_icon" style="background-image:url(http://localhost/www/pyoopil/js/ck/plugins/icons.png?t=E4KA);background-position:0 -504px;background-size:auto;">&nbsp;</span><span id="cke_23_label" class="cke_button_label cke_button__anchor_label" aria-hidden="false">Anchor</span></a></span><span class="cke_toolbar_end"></span></span><span id="cke_24" class="cke_toolbar" aria-labelledby="cke_24_label" role="toolbar"><span id="cke_24_label" class="cke_voice_label">Insert</span><span class="cke_toolbar_start"></span><span class="cke_toolgroup" role="presentation"><a id="cke_25" class="cke_button cke_button__image  cke_button_off" href="javascript:void('Image')" title="Image" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_25_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(35,event);" onfocus="return CKEDITOR.tools.callFunction(36,event);" onclick="CKEDITOR.tools.callFunction(37,this);return false;"><span class="cke_button_icon cke_button__image_icon" style="background-image:url(http://localhost/www/pyoopil/js/ck/plugins/icons.png?t=E4KA);background-position:0 -360px;background-size:auto;">&nbsp;</span><span id="cke_25_label" class="cke_button_label cke_button__image_label" aria-hidden="false">Image</span></a><a id="cke_26" class="cke_button cke_button__table  cke_button_off" href="javascript:void('Table')" title="Table" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_26_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(38,event);" onfocus="return CKEDITOR.tools.callFunction(39,event);" onclick="CKEDITOR.tools.callFunction(40,this);return false;"><span class="cke_button_icon cke_button__table_icon" style="background-image:url(http://localhost/www/pyoopil/js/ck/plugins/icons.png?t=E4KA);background-position:0 -912px;background-size:auto;">&nbsp;</span><span id="cke_26_label" class="cke_button_label cke_button__table_label" aria-hidden="false">Table</span></a><a id="cke_27" class="cke_button cke_button__horizontalrule  cke_button_off" href="javascript:void('Insert Horizontal Line')" title="Insert Horizontal Line" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_27_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(41,event);" onfocus="return CKEDITOR.tools.callFunction(42,event);" onclick="CKEDITOR.tools.callFunction(43,this);return false;"><span class="cke_button_icon cke_button__horizontalrule_icon" style="background-image:url(http://localhost/www/pyoopil/js/ck/plugins/icons.png?t=E4KA);background-position:0 -336px;background-size:auto;">&nbsp;</span><span id="cke_27_label" class="cke_button_label cke_button__horizontalrule_label" aria-hidden="false">Insert Horizontal Line</span></a><a id="cke_28" class="cke_button cke_button__specialchar  cke_button_off" href="javascript:void('Insert Special Character')" title="Insert Special Character" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_28_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(44,event);" onfocus="return CKEDITOR.tools.callFunction(45,event);" onclick="CKEDITOR.tools.callFunction(46,this);return false;"><span class="cke_button_icon cke_button__specialchar_icon" style="background-image:url(http://localhost/www/pyoopil/js/ck/plugins/icons.png?t=E4KA);background-position:0 -864px;background-size:auto;">&nbsp;</span><span id="cke_28_label" class="cke_button_label cke_button__specialchar_label" aria-hidden="false">Insert Special Character</span></a></span><span class="cke_toolbar_end"></span></span><span id="cke_29" class="cke_toolbar" aria-labelledby="cke_29_label" role="toolbar"><span id="cke_29_label" class="cke_voice_label">Tools</span><span class="cke_toolbar_start"></span><span class="cke_toolgroup" role="presentation"><a id="cke_30" class="cke_button cke_button__maximize  cke_button_off" href="javascript:void('Maximize')" title="Maximize" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_30_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(47,event);" onfocus="return CKEDITOR.tools.callFunction(48,event);" onclick="CKEDITOR.tools.callFunction(49,this);return false;"><span class="cke_button_icon cke_button__maximize_icon" style="background-image:url(http://localhost/www/pyoopil/js/ck/plugins/icons.png?t=E4KA);background-position:0 -672px;background-size:auto;">&nbsp;</span><span id="cke_30_label" class="cke_button_label cke_button__maximize_label" aria-hidden="false">Maximize</span></a></span><span class="cke_toolbar_end"></span></span><span id="cke_31" class="cke_toolbar" aria-labelledby="cke_31_label" role="toolbar"><span id="cke_31_label" class="cke_voice_label">Document</span><span class="cke_toolbar_start"></span><span class="cke_toolgroup" role="presentation"><a id="cke_32" class="cke_button cke_button__source  cke_button_off" href="javascript:void('Source')" title="Source" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_32_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(50,event);" onfocus="return CKEDITOR.tools.callFunction(51,event);" onclick="CKEDITOR.tools.callFunction(52,this);return false;"><span class="cke_button_icon cke_button__source_icon" style="background-image:url(http://localhost/www/pyoopil/js/ck/plugins/icons.png?t=E4KA);background-position:0 -840px;background-size:auto;">&nbsp;</span><span id="cke_32_label" class="cke_button_label cke_button__source_label" aria-hidden="false">Source</span></a></span><span class="cke_toolbar_end"></span></span><span class="cke_toolbar_break"></span><span id="cke_33" class="cke_toolbar" aria-labelledby="cke_33_label" role="toolbar"><span id="cke_33_label" class="cke_voice_label">Basic Styles</span><span class="cke_toolbar_start"></span><span class="cke_toolgroup" role="presentation"><a id="cke_34" class="cke_button cke_button__bold  cke_button_off" href="javascript:void('Bold')" title="Bold" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_34_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(53,event);" onfocus="return CKEDITOR.tools.callFunction(54,event);" onclick="CKEDITOR.tools.callFunction(55,this);return false;"><span class="cke_button_icon cke_button__bold_icon" style="background-image:url(http://localhost/www/pyoopil/js/ck/plugins/icons.png?t=E4KA);background-position:0 -24px;background-size:auto;">&nbsp;</span><span id="cke_34_label" class="cke_button_label cke_button__bold_label" aria-hidden="false">Bold</span></a><a id="cke_35" class="cke_button cke_button__italic  cke_button_off" href="javascript:void('Italic')" title="Italic" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_35_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(56,event);" onfocus="return CKEDITOR.tools.callFunction(57,event);" onclick="CKEDITOR.tools.callFunction(58,this);return false;"><span class="cke_button_icon cke_button__italic_icon" style="background-image:url(http://localhost/www/pyoopil/js/ck/plugins/icons.png?t=E4KA);background-position:0 -48px;background-size:auto;">&nbsp;</span><span id="cke_35_label" class="cke_button_label cke_button__italic_label" aria-hidden="false">Italic</span></a><a id="cke_36" class="cke_button cke_button__strike  cke_button_off" href="javascript:void('Strike Through')" title="Strike Through" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_36_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(59,event);" onfocus="return CKEDITOR.tools.callFunction(60,event);" onclick="CKEDITOR.tools.callFunction(61,this);return false;"><span class="cke_button_icon cke_button__strike_icon" style="background-image:url(http://localhost/www/pyoopil/js/ck/plugins/icons.png?t=E4KA);background-position:0 -72px;background-size:auto;">&nbsp;</span><span id="cke_36_label" class="cke_button_label cke_button__strike_label" aria-hidden="false">Strike Through</span></a><span class="cke_toolbar_separator" role="separator"></span><a id="cke_37" class="cke_button cke_button__removeformat  cke_button_off" href="javascript:void('Remove Format')" title="Remove Format" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_37_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(62,event);" onfocus="return CKEDITOR.tools.callFunction(63,event);" onclick="CKEDITOR.tools.callFunction(64,this);return false;"><span class="cke_button_icon cke_button__removeformat_icon" style="background-image:url(http://localhost/www/pyoopil/js/ck/plugins/icons.png?t=E4KA);background-position:0 -792px;background-size:auto;">&nbsp;</span><span id="cke_37_label" class="cke_button_label cke_button__removeformat_label" aria-hidden="false">Remove Format</span></a></span><span class="cke_toolbar_end"></span></span><span id="cke_38" class="cke_toolbar" aria-labelledby="cke_38_label" role="toolbar"><span id="cke_38_label" class="cke_voice_label">Paragraph</span><span class="cke_toolbar_start"></span><span class="cke_toolgroup" role="presentation"><a id="cke_39" class="cke_button cke_button__numberedlist  cke_button_off" href="javascript:void('Insert/Remove Numbered List')" title="Insert/Remove Numbered List" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_39_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(65,event);" onfocus="return CKEDITOR.tools.callFunction(66,event);" onclick="CKEDITOR.tools.callFunction(67,this);return false;"><span class="cke_button_icon cke_button__numberedlist_icon" style="background-image:url(http://localhost/www/pyoopil/js/ck/plugins/icons.png?t=E4KA);background-position:0 -648px;background-size:auto;">&nbsp;</span><span id="cke_39_label" class="cke_button_label cke_button__numberedlist_label" aria-hidden="false">Insert/Remove Numbered List</span></a><a id="cke_40" class="cke_button cke_button__bulletedlist  cke_button_off" href="javascript:void('Insert/Remove Bulleted List')" title="Insert/Remove Bulleted List" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_40_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(68,event);" onfocus="return CKEDITOR.tools.callFunction(69,event);" onclick="CKEDITOR.tools.callFunction(70,this);return false;"><span class="cke_button_icon cke_button__bulletedlist_icon" style="background-image:url(http://localhost/www/pyoopil/js/ck/plugins/icons.png?t=E4KA);background-position:0 -600px;background-size:auto;">&nbsp;</span><span id="cke_40_label" class="cke_button_label cke_button__bulletedlist_label" aria-hidden="false">Insert/Remove Bulleted List</span></a><span class="cke_toolbar_separator" role="separator"></span><a id="cke_41" class="cke_button cke_button__outdent cke_button_disabled " href="javascript:void('Decrease Indent')" title="Decrease Indent" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_41_label" aria-haspopup="false" aria-disabled="true" onkeydown="return CKEDITOR.tools.callFunction(71,event);" onfocus="return CKEDITOR.tools.callFunction(72,event);" onclick="CKEDITOR.tools.callFunction(73,this);return false;"><span class="cke_button_icon cke_button__outdent_icon" style="background-image:url(http://localhost/www/pyoopil/js/ck/plugins/icons.png?t=E4KA);background-position:0 -456px;background-size:auto;">&nbsp;</span><span id="cke_41_label" class="cke_button_label cke_button__outdent_label" aria-hidden="false">Decrease Indent</span></a><a id="cke_42" class="cke_button cke_button__indent  cke_button_off" href="javascript:void('Increase Indent')" title="Increase Indent" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_42_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(74,event);" onfocus="return CKEDITOR.tools.callFunction(75,event);" onclick="CKEDITOR.tools.callFunction(76,this);return false;"><span class="cke_button_icon cke_button__indent_icon" style="background-image:url(http://localhost/www/pyoopil/js/ck/plugins/icons.png?t=E4KA);background-position:0 -408px;background-size:auto;">&nbsp;</span><span id="cke_42_label" class="cke_button_label cke_button__indent_label" aria-hidden="false">Increase Indent</span></a><span class="cke_toolbar_separator" role="separator"></span><a id="cke_43" class="cke_button cke_button__blockquote  cke_button_off" href="javascript:void('Block Quote')" title="Block Quote" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_43_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(77,event);" onfocus="return CKEDITOR.tools.callFunction(78,event);" onclick="CKEDITOR.tools.callFunction(79,this);return false;"><span class="cke_button_icon cke_button__blockquote_icon" style="background-image:url(http://localhost/www/pyoopil/js/ck/plugins/icons.png?t=E4KA);background-position:0 -168px;background-size:auto;">&nbsp;</span><span id="cke_43_label" class="cke_button_label cke_button__blockquote_label" aria-hidden="false">Block Quote</span></a></span><span class="cke_toolbar_end"></span></span><span id="cke_44" class="cke_toolbar" aria-labelledby="cke_44_label" role="toolbar"><span id="cke_44_label" class="cke_voice_label">Styles</span><span class="cke_toolbar_start"></span><span id="cke_8" class="cke_combo cke_combo__styles  cke_combo_off" role="presentation"><span id="cke_8_label" class="cke_combo_label">Styles</span><a class="cke_combo_button" hidefocus="true" title="Formatting Styles" tabindex="-1" "="" href="javascript:void('Formatting Styles')" role="button" aria-labelledby="cke_8_label" aria-haspopup="true" onkeydown="return CKEDITOR.tools.callFunction(81,event,this);" onfocus="return CKEDITOR.tools.callFunction(82,event);" onclick="CKEDITOR.tools.callFunction(80,this);return false;"><span id="cke_8_text" class="cke_combo_text cke_combo_inlinelabel">Styles</span><span class="cke_combo_open"><span class="cke_combo_arrow"></span></span></a></span><span id="cke_9" class="cke_combo cke_combo__format  cke_combo_off" role="presentation"><span id="cke_9_label" class="cke_combo_label">Format</span><a class="cke_combo_button" hidefocus="true" title="Paragraph Format" tabindex="-1" "="" href="javascript:void('Paragraph Format')" role="button" aria-labelledby="cke_9_label" aria-haspopup="true" onkeydown="return CKEDITOR.tools.callFunction(84,event,this);" onfocus="return CKEDITOR.tools.callFunction(85,event);" onclick="CKEDITOR.tools.callFunction(83,this);return false;"><span id="cke_9_text" class="cke_combo_text cke_combo_inlinelabel">Format</span><span class="cke_combo_open"><span class="cke_combo_arrow"></span></span></a></span><span class="cke_toolbar_end"></span></span><span id="cke_45" class="cke_toolbar" aria-labelledby="cke_45_label" role="toolbar"><span id="cke_45_label" class="cke_voice_label">about</span><span class="cke_toolbar_start"></span><span class="cke_toolgroup" role="presentation"><a id="cke_46" class="cke_button cke_button__about  cke_button_off" href="javascript:void('About CKEditor')" title="About CKEditor" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_46_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(86,event);" onfocus="return CKEDITOR.tools.callFunction(87,event);" onclick="CKEDITOR.tools.callFunction(88,this);return false;"><span class="cke_button_icon cke_button__about_icon" style="background-image:url(http://localhost/www/pyoopil/js/ck/plugins/icons.png?t=E4KA);background-position:0 0px;background-size:auto;">&nbsp;</span><span id="cke_46_label" class="cke_button_label cke_button__about_label" aria-hidden="false">About CKEditor</span></a></span><span class="cke_toolbar_end"></span></span></span></span><div id="cke_1_contents" class="cke_contents cke_reset" role="presentation" style="height: 200px;"><span id="cke_51" class="cke_voice_label">Press ALT 0 for help</span><iframe src="" frameborder="0" class="cke_wysiwyg_frame cke_reset" title="Rich Text Editor, editor1" aria-describedby="cke_51" tabindex="0" allowtransparency="true" style="width: 0px; height: 100%;"></iframe></div><span id="cke_1_bottom" class="cke_bottom cke_reset_all" role="presentation" style="-webkit-user-select: none;"><span id="cke_1_resizer" class="cke_resizer cke_resizer_vertical cke_resizer_ltr" title="Resize" onmousedown="CKEDITOR.tools.callFunction(0, event)">◢</span><span id="cke_1_path_label" class="cke_voice_label">Elements path</span><span id="cke_1_path" class="cke_path" role="group" aria-labelledby="cke_1_path_label"><span class="cke_path_empty">&nbsp;</span></span></span></div></div>
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