App = window.App or {}
App.classrooms = App.classrooms or {}

(($, window, document) ->

	class AnnouncementViews

		constructor : (elem) ->

			@$elem = elem
			
			@init()

		init : =>

			@announcementTemplate = Handlebars.compile App.classrooms.templates.getTemplate('announcementTmpl')
			''

		renderAnnouncements : (e, announcements) =>

			announcementsHtml = if announcements?
				@renderAnnouncement announcement for announcement in announcements

			@$elem.append announcementsHtml
			@$elem.trigger 'Announcements.RENDER', true

		renderAnnouncement : (announcement) ->

			if announcement.hasOwnProperty 'data'
				announcementHtml = @announcementTemplate announcement.data
			else
				announcementHtml = @announcementTemplate announcement
			
			announcementHtml

		newAnnouncement : (e, announcement)=>

			@$createForm.dialog("close");
			quizDialog = @quizDialogTemplate classroom.data
			@$quizDialog.html(quizDialog)
			$('.ui-widget-overlay').addClass('custom-overlay')
			@$quizDialog.dialog("open")

			@$elem.prepend @renderClassroom classroom
			@$elem.trigger 'Classrooms.RENDER', false
	

	App.classrooms.announcementViews = AnnouncementViews

)($, window, document)
