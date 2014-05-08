$(document).ready(function () {

	// Tooltip
	$('.tooltip').tooltipster();
	
	//Dialog
	$("#dialog, #quizpopup, #quizpopup2").dialog({
		autoOpen: false,
		modal: true
	});
	
	// onload popup
	$("#signup").dialog({
		autoOpen: true,
		modal: true
	})
	;$('.ui-widget-overlay').addClass('custom-overlay');
	
	// Link to open the dialog
	$("#dialog-link").click(function (event) {
		$("#dialog").dialog("open");
		$('.ui-widget-overlay').addClass('custom-overlay');
		$(".nice-scroll").slimScroll();
	});
	// Link to open the dialog
	$(".close-link").click(function (event) {
		$("#dialog,#signup").dialog("close");
	});
	
	
	$("#dialog-link2").click(function (event) {
		$("#quizpopup").dialog("open");
		$('.ui-widget-overlay').addClass('custom-overlay');
	});
	
	$("#quizstart").click(function (event) {
		$("#quizpopup2").dialog("open");
	});

	// Link to open the dialog
	$(".ques").click(function (event) {
		$(".ques-box").css("display", "block");
		$(".poll-box").css("display", "none");
		$(".note-box").css("display", "none");
	});
	$(".poll").click(function (event) {
		$(".ques-box").css("display", "none");
		$(".poll-box").css("display", "block");
		$(".note-box").css("display", "none");
	});
	$(".note-icon").click(function (event) {
		$(".ques-box").css("display", "none");
		$(".poll-box").css("display", "none");
		$(".note-box").css("display", "block");
	});
	$(".cnl-btn").click(function (event) {
		$(".ques-box").css("display", "none");
		$(".poll-box").css("display", "none");
		$(".note-box").css("display", "none");
	});
	 
	 //dropdown
	$(".arr-dd").hide();
	$(".dd-icon").click(function () {
		var $div = $(this).next('.arr-dd');
		$(".arr-dd").not($div).hide();
		$div.show();
	 });
	//close autocomplete
	$(document).click(function (e) {
		var q = $(e.target).closest('.dd-block').length
		if (!q) {
			$(".arr-dd").css("display", "none");
		}
	});
	
	
	//editable span
	$('.add-here').bind('dblclick','.add-choice span',function(){
        $(this).attr('contentEditable', true);
    }).blur(
    function() {
    	$(this).attr('contentEditable', false);
    });
	
	//add new div
	var count = 0;
	$(".add-div").click(function(){
		var count = $('.add-choice').length;
		if(count < 6) {
			$(".add-here").append("<div class='add-choice'><span>Answer choice "+ count +" </span><a href='javascript:void(0)' class='close-btn'></a></div>");
	        count++;
    	}
	});
	
	// remove div on close
	$('.add-here').on('click','a.close-btn',function(){
		$(this).closest('.add-choice').remove();
	});
	
	// Tiny Editor
	var editor = new TINY.editor.edit('editor', {
	id: 'tinyeditor',
	width: 584,
	height: 175,
	cssclass: 'tinyeditor',
	controlclass: 'tinyeditor-control',
	rowclass: 'tinyeditor-header',
	dividerclass: 'tinyeditor-divider',
	controls: ['bold', 'italic', 'underline','font', 'leftalign','centeralign', 'rightalign', 'unorderedlist' ],
	footer: true,
	fonts: ['Verdana','Arial','Georgia','Trebuchet MS'],
	xhtml: true,
	cssfile: 'custom.css',
	bodyid: 'editor',
	footerclass: 'tinyeditor-footer',
	toggle: {text: 'source', activetext: 'wysiwyg', cssclass: 'toggle'},
	resize: {cssclass: 'resize'}
});
	
});

$(function () {
	$("select").dropkick();
});

