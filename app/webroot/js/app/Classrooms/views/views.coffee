App = window.App or {}
App.classrooms = App.classrooms or {}

(($, window, document) ->

	class Views

		constructor : (elem) ->

			@$elem = elem
			@$createForm = $("#create-assign")
			@$quizDialog = $('#quizdialog')
			
			@init()

		init : =>

			@classroomTemplate = Handlebars.compile App.classrooms.templates.getTemplate('classroomTile')
			@quizDialogTemplate = Handlebars.compile App.classrooms.templates.getTemplate('quizTmpl')
			''

		renderClassrooms : (e, classrooms) =>

			classroomsHtml = if classrooms?
				@renderClassroom classroom for classroom in classrooms

			@$elem.append classroomsHtml
			@$elem.trigger 'Classrooms.RENDER', true

		renderClassroom : (classroom) ->

			if classroom.hasOwnProperty 'data'
				classroomHtml = @classroomTemplate classroom.data
			else
				classroomHtml = @classroomTemplate classroom
			
			classroomHtml

		newClassroom : (e, classroom)=>

			@$createForm.dialog("close");
			quizDialog = @quizDialogTemplate classroom.data
			@$quizDialog.html(quizDialog)
			$('.ui-widget-overlay').addClass('custom-overlay')
			@$quizDialog.dialog("open")

			@$elem.prepend @renderClassroom classroom
			@$elem.trigger 'Classrooms.RENDER', false
		
		newJoin : (e, classroom)=>

			$(".newjoin").show();
			$(".accessclass").hide();

			@$elem.prepend @renderClassroom classroom
			@$elem.trigger 'Classrooms.RENDER', false
	

	App.classrooms.views = Views

)($, window, document)
