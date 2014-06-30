App = window.App or {}
App.classrooms = App.classrooms or {}

(($, window, document) ->

	class AnnouncementViews

		constructor : (elem) ->

			@$elem = elem.find('.middivouter')
			
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

			announcement = JSON.parse(announcement)

			@$elem.prepend(@renderAnnouncement(announcement))
			@$elem.trigger 'Announcements.RENDER', false
	

	App.classrooms.announcementViews = AnnouncementViews

)($, window, document)
