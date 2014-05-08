$(document).ready(function() {
	
	//My classroom newjoin
	$(".code-class").click(function(e) {
        $(".newjoin").remove();
		$(".accessclass").show();
    });
	//dropdown
	$(".arr-dd").hide();
	$(".dd-click").click(function () {
		var $div = $(this).next('.arr-dd');
		$(".arr-dd").not($div).hide();
		$div.toggle();
	 });
	 
	 // Select Topic
	 $(".sel-topic").click(function () {
		 var $div = $(this).next('.seltop-dd');
		$(".seltop-dd").not($div).hide();
		$div.toggle();
	 });
	 
	 //search interaction
	 $(".nav-search").click(function () {
		 $(".search-input").toggle();
		 $(this).toggleClass('active');
	});
	
	//Universal search interaction
	 $(".search-bx").click(function () {
		 $(".uni-searchinput").toggle();
		 $('.uni-search').toggleClass('active');
	});
	
	//redirect on search 
	 $('.uni-searchinput').on('keypress', function (e) {
		var code = (e.keyCode ? e.keyCode : e.which);
		if(e.which == 13) {
				$(location).attr('href','universal-searchresult.htm');
			}
		});
		
		
	 //new topic
	 $(".new-topic").click(function () {
		$(".seltop-dd").toggle();
		$(".pop-input").show();
	 });
	 
	 //Logout div
	 $(".logout").click(function () {
		$(".logout-lst").toggle();
		$(this).toggleClass('active');
	 });
	 
	 
	$(".seltop-dd li a").click(function () {
		var sel_topic = $(this).text();
		$(".sel-topic").text(sel_topic);
		$(".seltop-dd").toggle();
	});

	 //close dropdown
	$(document).click(function (e) {
		var q = $(e.target).closest('.dd-block').length
		var r = $(e.target).closest('.prs-sp').length
		var s = $(e.target).closest('.logout').length
		var t = $(e.target).closest('.assign-txtbx').length
		if (!q) {
			$(".arr-dd").css("display", "none");
		}
		if (!r) {
			$(".clk-tt").css("display", "none");
		}
		if (!s) {
			$(".logout-lst").css("display", "none");
			$(".logout").removeClass('active');
		}	
		if (!t) {
			$(".assign-txtbx").addAttr("readonly");
		}
		
	});
	 //My classroom acordian	
		$(".contentblock").hide();	
		$(".click-lib").click(function () {
		var $div = $(this).parents().next(".contentblock");
		$(".contentblock").not($div).hide();
		$(".contentblock").not($div).removeClass('active');
		$div.slideToggle(300);
		
		$(this).toggleClass("active");
		
    });
	//Top right sliders
	$("#sharediv").hide();
	$(".share").click(function(){
	  $("#sharediv").show("slide", {direction: "up" }, "slow");
	});
	$(".close-share").click(function(){
	  $("#sharediv").hide("slide", {direction: "up" }, "slow");
	});
	 
	
	
	//Right Side Layout
	$(".notification_details").hide();
	$(".dock-bk").hide();
	$(".toprightsection a").click(function () {
		$(".notification_details").show();
		$(".dock-bk").show('slow');
		$(".toprightsection").addClass("ractive");
	});
	$(".dock-bk").click(function () {
		$(".notification_details").hide();
		$(".dock-bk").hide('slow');
		$(".toprightsection").removeClass("ractive");
	});
	
	//Dialog
	$("#dialog, #view-dialog, #clone-dialog,#upload-dialog,#assign-dialog,#rest-dialog,.doc-popup,#quizdialog,#msg-dialog,#rec-dialog").dialog({
		autoOpen: false,
		modal: true
	});
	// Link to Close the dialog
	$(".close-link").click(function (event) {
		$("#dialog,#signup-popup,#view-dialog,#clone-dialog,#upload-dialog,#assign-dialog,#rest-dialog,.doc-popup,#quizdialog,#msg-dialog,#rec-dialog").dialog("close");
	});
	//message dialog
	$(".msg-link").click(function (event) {
		$("#msg-dialog").dialog("open");
		$('.ui-widget-overlay').addClass('custom-overlay');
	});
	
	//recommend dialog
	$(".rec-link").click(function (event) {
		$("#rec-dialog").dialog("open");
		$('.ui-widget-overlay').addClass('custom-overlay');
	});
	
	
	//quiz dialog
	$("#quiz-link").click(function (event) {
		$("#create-assign").dialog("close");
		$("#quizdialog").dialog("open");
		$('.ui-widget-overlay').addClass('custom-overlay');
	});
	
	 
	//multiple dialog
	// Link to open the dialog
	
	$(".dialogbox").click(function (event) {
		var title_dialog=$(this).attr('title');
		var var1="#"+title_dialog;
		$(var1).dialog("open");
		$('.ui-widget-overlay').addClass('custom-overlay');
	});
	
	// Link to open the dialog
	$("#dialog-link").click(function (event) {
		$("#dialog").dialog("open");
		$('.ui-widget-overlay').addClass('custom-overlay');
	});
	// Assign moderators Dialod
	$("#assign-link").click(function (event) {
		$("#assign-dialog").dialog("open");
		$('.ui-widget-overlay').addClass('custom-overlay');
	});
	// Restrict Access Dialod
	$("#rest-link").click(function (event) {
		$("#rest-dialog").dialog("open");
		$('.ui-widget-overlay').addClass('custom-overlay');
	});
	
	//View info Dialog
	$("#view-dlink").click(function (event) {
		$("#view-dialog").dialog("open");
		$('.ui-widget-overlay').addClass('custom-overlay');
	});
	//Clone Dialog
	$("#clone-dlink").click(function (event) {
		$("#clone-dialog").dialog("open");
		$('.ui-widget-overlay').addClass('custom-overlay');
	});
	//upload Dialog
	$("#upload-dlink").click(function (event) {
		$("#upload-dialog").dialog("open");
		$('.ui-widget-overlay').addClass('custom-overlay');
	});
	
	
	// onload popup
	$("#signup-popup").dialog({
		autoOpen: true,
		modal: true
	});
	$('.ui-widget-overlay').addClass('custom-overlay');
	
	
	//sub menu
	$('.hassub').hover(
		function() {
			$(".container").addClass("show-sub");
			$(this).addClass("hover");
			
		},
		function() {
			$(".container").removeClass("show-sub");
			$(this).removeClass("hover");
		});
		//bxslider
	$('.contact-slider').bxSlider({
		 slideWidth:160,
		 minSlides: 4,
		 maxSlides: 4,
		 moveSlides: 1,
		 slideMargin: 5,
		 infiniteLoop: false,
		 mode: 'vertical',
 	});
	
	//Pretty Photo Gallery in contact images & videos
	$("a[rel^='prettyPhoto']").prettyPhoto();
	
	// Link to open the dialog
	$(".ques").click(function (event) {
		$(".ques-box").css("display", "block");
		$(".poll-box, .note-box").css("display", "none");
		$(".ques").addClass("active");
		$(".poll,.note-icon").removeClass("active");
		
	});
	$(".poll").click(function (event) {
		$(".ques-box,.note-box").css("display", "none");
		$(".poll-box").css("display", "block");
		$(".poll").addClass("active");
		$(".ques,.note-icon").removeClass("active");
	});
	$(".note-icon").click(function (event) {
		$(".ques-box, .poll-box").css("display", "none");
		$(".note-box").css("display", "block");
		$(".note-icon").addClass("active");
		$(".ques,.poll").removeClass("active");
	});
	$(".cnl-btn").click(function (event) {
		$(".ques-box, .poll-box, .note-box").css("display", "none");
		$(".ques-icon").removeClass("active");
	});

	// Annoucement Toggle  
	$(".middivouter .listbox .more").click(function(e) {
	  $(this).prev(".fulldetails").slideToggle();
	 if ($(this).hasClass("open")){
	   $(this).addClass('close')
	   $(this).removeClass('open')
	   
	  }
	 else{
	  $(this).addClass('open')
	  $(this).removeClass('close')
	  }
	  $(this).text(function(i,v) {
           return v === 'More' ? 'Less' : 'More';
     	});
	});
	
	//search dd
	$('#demo-htmlselect').ddslick({
		onSelected: function(selectedData){
			//callback function: do something with selectedData;
		}   
	});
	$('#top-cntry').ddslick({
		onSelected: function(selectedData){
			//callback function: do something with selectedData;
		}   
	});
	
	//fold interaction
	$('a.fold-icon').click(function() {
            $(this).toggleClass('folded-icon')
     });
	 
	 $('a.folded-icon').click(function() {
            $(this).addClass('fold-icon');
			$(this).attr('title','Fold Discussion')
			$(this).removeClass('folded-icon')
			$('a.fold-icon').click(function() {
            $(this).toggleClass('folded-icon')
     });
     });
	
	//praise tooltip
	$(".clk-tt").hide();
	$(".icon-title").click(function () {
		var $div = $(this).next('.clk-tt');
		$(".clk-tt").not($div).hide();
		$div.toggle();
	 });
	 
	 //submission topic
	$(".assign-hide").hide();
	$(".assign-head").click(function () {
		var $div = $(this).next('.assign-hide');
		$(".assign-hide").not($div).hide();
		$div.slideToggle('slow');
		$('.open-dd').toggleClass('active');
	 });
	 
	 
	 //comment accordion
	$(".comm-hide").hide();
	$(".comm-link").click(function () {
		var $div = $(this).parents().next('.comm-hide');
		$(".comm-hide").not($div).hide();
		$div.toggle();
	 });
	 
	 // Engagement accordion
	$(".enga-hide").hide();
	$(".enga-link").click(function () {
		var $div = $(this).parents().next('.enga-hide');
		$(".enga-hide").not($div).hide();
		$div.slideToggle('slow');
		$('.enga-link').toggleClass('active');
		$('.enga-link p').text(function(i,v) {
           return v === 'View All' ? 'Back' : 'View All';
     	});
	 });
	 
	
	 
	 
	 //editable txtbx
	 $(".assign-txtbx").dblclick(function(){
		$(this).removeAttr("readonly");
	});
	 
	// Tooltip
	$('.tooltip').tooltipster();
	
	//Discussion tooltip
	$(".point-icon").hover(function () {
		var $div = $(this).next('.enga-tooltip');
		$(".enga-tooltip").not($div).hide();
		$div.show();
	 },function(){
    	$(".enga-tooltip").hide();
  });
	 

	//Top right section
	$('.tabpages').each(function(){
		var $active, $content, $links = $(this).find('li a.tab');
		$active = $links.first();
		$content = $($active.attr('href'));
		$links.not(':first').each(function () {
		$($(this).attr('href')).hide();
	});
	$(this).on('click', 'li a.tab', function(e){
		$active.removeClass('active');
		$content.hide();
		$active = $(this);
		$content = $($(this).attr('href'));
		$active.addClass('active');
		$content.show();
		e.preventDefault();
		});
	});
	
	//upload Wizard
	$('#form2,#form3').hide();
	$('.goto2').click(function() {
		$('#form1').hide();	
		$('#form2').show();	
		$('.wizard-steps li:nth-child(1)').removeClass( "active" );
		$('.wizard-steps li:nth-child(2)').addClass( "active" );
	});
	$('.backto1').click(function() {
		$('#form2').hide();	
		$('#form1').show();	
		$('.wizard-steps li:nth-child(2)').removeClass( "active" );
		$('.wizard-steps li:nth-child(1)').addClass( "active" );
	});
	
	//editable span
	$(".add-choice input").click(function(){
		$(this).removeAttr("readonly");
	});
	
	//announcement edit topic
	$(".doc-input").dblclick(function(){
		$(this).removeAttr("readonly");
	});
	
	//$('.add-here').bind('click','.add-choice input',function(){
//        $(this).attr('contentEditable', true);
//    }).blur(
//    function() {
//    	$(this).attr('contentEditable', false);
//    });
	
	//custom upload
	$('.custom-upload input[type=file]').change(function(){
    	$(this).next().find('input').val($(this).val());
	});
	
	//add new div
	var count = 0;
	$(".add-div").click(function(){
		var count = $('.add-choice').length;
		if(count < 7) {
			$(".add-here").append("<div class='add-choice'><input type='text' class='ans-txtbx' placeholder='Type your answer here...'><a href='javascript:void(0)' class='close-btn'></a></div>");
	        count++;
    	}
	});
	
	//upload more
	var count = 0;
	$(".add-more").click(function(){
		var count = $('.custom-upload').length;
		if(count < 8) {
			$(".add-upload").append('<div class="custom-upload" id="test'+count+'"><input type="file" name="files[]"><div class="file-upload"><span class="file-txt">Select file</span><input disabled="disabled" value="No File Chosen"></div><div class="size-txt">(Max. 00 mb)</div></div>');
			$('.custom-upload input[type=file]').change(function(){
    	$(this).next().find('input').val($(this).val());
	});
	        count++;
    	}
	});
	
	
	//Add Questions
	var count = 0;
	$(".add-ques").click(function(){
		var count = $('.ques-num').length;
		if(count < 500) {
			$(".addques-here").append('<div class="ques-num"><div class="quest-title clearfix"><p class="left-title">Question '+ (count+1) +'</p><div class="ryt-title">Max. Marks <input class="pop-dura" type="text" value=""></div></div><div class="quest-lst-box"><label>Question type</label><div class="quest-select"><select class="chosen-select select_option"><option>Multiple choice single select</option><option>Multiple choice multi select</option><option>True /False</option><option selected>Match the following</option></select></div></div></div>');
			$(".chosen-select").chosen({allow_single_deselect:true});$('select.chosen-select').customSelect();
			count++;
    	}
	});
	
	//Add answer :: Single
	var count = 0;
	$(".add-single-link").click(function(){
		var count = $('.ans-lst').length;
		if(count < 5) {
			$(".add-ans-single").append('<div class="ans-lst clearfix"><input type="text" class="pop-input" placeholder="Answer choice '+ (count+1) +'"><div class="ans-radio"><input id="ans'+ (count+1) +'" type="radio" name="answer" value="ans'+ (count+1) +'"><label for="ans'+ (count+1) +'" class="radio-lbl"></label></div></div>');
			count++;
    	}
	});
	
	//Add answer :: Multiple
	var count = 0;
	$(".add-multiple-link").click(function(){
		var count = $('.ans-mlst').length;
		if(count < 5) {
			$(".add-ans-multiple").append('<div class="ans-mlst clearfix"><input type="text" class="pop-input" placeholder="Answer choice '+ (count+1) +'"><div class="ans-radio"><input id="mul'+ (count+1) +'" type="checkbox" name="mulple" value="mul'+ (count+1) +'"><label for="mul'+ (count+1) +'" class="check-lbl"></label></div></div>');
			count++;
    	}
	});
	
	//Add answer :: Match following
	var count = 0;
	$(".add-match").click(function(){
		var count = $('.m-opt1').length;
		if(count < 20) {
			$(".match-opt").append('<div class="m-opt1  clearfix"><input class="pop-input" type="text" placeholder="Question"><input class="pop-match" type="text" placeholder=""><input class="pop-match" type="text" placeholder=""><input class="pop-input" type="text" placeholder="Answer choice"></div>');
			count++;
    	}
	});
	
	//upload more links
	var count = 0;
	$(".add-link").click(function(){
		var count = $('.add-links').length;
		if(count < 8) {
			$(".upload-links").append('<div class="add-links"><input type="text" class="pop-input" placeholder="Upload links"></div>');
	        count++;
    	}
	});
	
	// remove div on close
	$('.add-here').on('click','a.close-btn',function(){
		$(this).closest('.add-choice').remove();
	});
	
	$(".as1tabdec,.as2tabdec,.as3tabdec").hide();

	//Accordion 1 Lavel
	$(".as1tab").click(function(e) {
		$(this).next(".as1tabdec").slideToggle(200).siblings(".as1tabdec:visible").slideUp(200);
		$(this).toggleClass("active");
	  	$(this).siblings(".as1tab").removeClass("active");
    });
	
	
	//Accordion 2 Lavel
	$(".as2tab").click(function(e) {
		$(this).next(".as2tabdec").slideToggle(200).siblings(".as2tabdec:visible").slideUp(200);
		$(this).toggleClass("active");
	  	$(this).siblings(".as1tab").removeClass("active");
		
    });
	
	//Accordion 3 Lavel
	$(".as3tab").click(function(e) {
		$(this).next(".as3tabdec").slideToggle(200).siblings(".as3tabdec:visible").slideUp(200);
    });	
	
	//password strength
	$('.tooltip-pass').passStrengthify({
      minimum: 5,
      });
	  
	  //password tooltip
	$(".tooltip-pass").focus(function(){
		$(".pass-tooltip").show();
    });
	$(".tooltip-pass").blur(function(){
		$(".pass-tooltip").hide();
    });
	  
	// words limit 
	$( ".add-topic" ).keyup(function() {
		var len = this.value.length;
           if (len >= 200) {
              this.value = this.value.substring(0, 200);
           }
          $('#rem_count').text(200 - len);
	});	

	//slim scroll
	$(".cus-scroll").slimScroll({height: '145px'});	
	$(".noti-scroll").slimScroll({height: '500px',color: '#575757'});
	$(".msg-scroll").slimScroll({color: '#575757'});		
		
	//recurring check
	$('.recurr-chk input[type="checkbox"]').change(function(){
        if(this.checked)
            $('.reoccurencepattern').slideDown('slow');
        else
            $('.reoccurencepattern').slideUp('slow');

    });
   $('.recurr-radio input[type="radio"]').click(function(){
        if($(this).attr("value")=="Daily")
          {
				$('.recurr-daily').show();
				$('.recurr-weekly,.recurr-monthly,.recurr-yearly').hide();
		  }
		  if($(this).attr("value")=="Weekly")
          {
				$('.recurr-weekly').show();
				$('.recurr-daily,.recurr-monthly,.recurr-yearly').hide();
		  }
		  if($(this).attr("value")=="Monthly")
          {
				$('.recurr-monthly').show();
				$('.recurr-weekly,.recurr-daily,.recurr-yearly').hide();
		  }
		  if($(this).attr("value")=="Yearly")
          {
				$('.recurr-yearly').show();
				$('.recurr-weekly,.recurr-monthly,.recurr-daily').hide();
		  }

    });
	
	
});

	// draggable  invite 
    $( "#catalog div" ).draggable({
      appendTo: "body",
	  containment: 'DOM',
      helper: "clone"
    });
    $( "#cart ol" ).droppable({
      activeClass: "ui-state-default",
      hoverClass: "ui-state-hover",
      accept: ":not(.ui-sortable-helper)",
      drop: function( event, ui ) {
        $( this ).find( ".placeholder" ).remove();
		var test= ui.draggable.text();
        $( "<li></li>" ).text( test ).append('<a href="#" class="remove-li"></a>').appendTo( this );
		
		$(".remove-li").click(function(e) {
		$(this).parent().remove();
		
    });
      }
    }).sortable({
      items: "li:not(.placeholder)",
      sort: function() {
        // gets added unintentionally by droppable interacting with sortable
        // using connectWithSortable fixes this, but doesn't allow you to customize active/hoverClass options
        $( this ).removeClass( "ui-state-default" );
      }
    });

//tagit
$(function(){
	//close
	
	var sampleTags = ['Ahmed','Ram','Mohan','Swati','Nikhil','Manish','Gaurav','Aaliyah','Apeksha','Deepti','Parul'];
	$('#singleFieldTags,#singleFieldTags2').tagit({
		availableTags: sampleTags,
		// This will make Tag-it submit a single form value, as a comma-delimited field.
		singleField: true,
		singleFieldNode: $('#mySingleField,#mySingleField2')
	});
});	
$(function () {		
	// Tiny Editor
	var editor = new TINY.editor.edit('editor', {
	id: 'tinyeditor',
	width: 584,
	height: 175,
	cssclass: 'tinyeditor',
	controlclass: 'tinyeditor-control',
	rowclass: 'tinyeditor-header',
	dividerclass: 'tinyeditor-divider',
	controls: ['bold', 'italic', 'underline', 'leftalign','centeralign', 'rightalign', 'unorderedlist' ],
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
		
	//test
	var a3 = $(window).height();
	 $(".notification_details").css({'height':+a3+'px'});
	$(window).resize(function(){
		var a4 = $(window).height();
		 $(".notification_details").css({'height':+a4+'px'});
	});	
	
	
	
	
// Right panel Calender 
	$( "#req-datepicker" ).datepicker({
		inline: true
	});
$( ".duration" ).datepicker();
$( ".date_popup" ).datepicker({
	showOn: "both",
	buttonImage: "images/classroom/pop-cal.png",
	buttonImageOnly: true
});

//left menu scroll
$('.scroll-pane').each(function(){
	setSlider($(this));
});

var bh = $(window).height();
var al = bh-260;
 $(".scroll-pane").css({'height':+al+'px'});	
 
$(window).resize(function(){
	var bh = $(window).height();
	var al = bh-260;
	$(".scroll-pane").css({'height':+al+'px'});	
});	


$('.arrow_up').mousedown(function(event) {
	if(event.preventDefault) event.preventDefault();
    intervalId = setInterval('scrollUp()', 30);
	$(this).bind('mouseup mouseleave', function() {
		clearInterval(intervalId);
	});
});
$('.arrow_down').mousedown(function(event) {
	if(event.preventDefault) event.preventDefault();
    intervalId = setInterval('scrollDown()', 30);
	$(this).bind('mouseup mouseleave', function() {
		clearInterval(intervalId);
	});
});

function scrollUp(){
	if ($(".slider-vertical").slider("value")<100){
		$(".slider-vertical").slider("value",$(".slider-vertical").slider("value")+1);
	}
}
function scrollDown(){
	if ($(".slider-vertical").slider("value")>0){
		$(".slider-vertical").slider("value",$(".slider-vertical").slider("value")-1);
	}
}


//Custom select
$(".chosen-select").chosen({allow_single_deselect:true});$('select.chosen-select').customSelect();







