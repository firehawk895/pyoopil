App = window.App or {}
App.classrooms = App.classrooms or {}
(($, window, document) ->

	$document = $(document)

	class Announcement

		init : (elem)->

			@$elem = $(elem)

			@$createClassroomForm = $('#AnnouncementIndexForm')
			@$viewport = @$elem.find('.tinyscrollbar').find('.viewport')
			@currentPage = 1
			@hasScrollReached = false

			@services = App.classrooms.announcementServices
			@views = new App.classrooms.announcementViews(@$elem)
			
			@notifier = App.common.notifier

			$tinyscrollbar = $('.tinyscrollbar')
			$tinyscrollbar.tinyscrollbar({thumbSize: 34})

			@$tinyscrollbar = $tinyscrollbar.data("plugin_tinyscrollbar")

			@setEventListeners()
			@getAnnouncements()

		getAnnouncements : ->

			promise = @services.getAnnouncements()

			promise.then((data)=>

				if @services.isValid(data) is true
					$document.trigger('Announcements.UPDATE', [data])
				else
					@notifier.notify 'error', 'No Announcements found'

			)

		setEventListeners : ->

			$document.on('Announcements.UPDATE', @views.renderAnnouncements)
			$document.on('Announcements.CREATE', @views.newAnnouncement)
			$document.on('Announcements.RENDER', @announcementsRendered)

			@$createClassroomForm.on('submit', @newClassroomSubmit)
			$('#fileupload').on('change', @handleFileUpload)

			@$viewport.on('endOfScroll', =>

				if @hasScrollReached is false
					@hasScrollReached = true
					@currentPage += 1

					ajax = @services.getAnnouncementsByPage @currentPage

					ajax.done((data) =>

						if data.data and data.data.length > 0
							$document.trigger('Announcements.UPDATE', [[data.data]])
						else
							App.common.notifier.notify('error', 'No more Data to Display')

						@hasScrollReached = false
					)
			)

		handleFileUpload : (e) =>

			@uploadedFiles = e.target.files

			$('.files').html(@uploadedFiles[0].name)

		newAnnouncement : (e) ->

			e.preventDefault()

			ajax = App.classrooms.services.newClassroom $(@).serialize()

			ajax.done((data)->

				if data.status is false
					App.common.notifier.notify 'error', data.message
					return

				if App.classrooms.services.isValid([data]) is true
					$document.trigger('Announcements.CREATE', [data])
				else
					App.common.notifier.notify 'error', 'New Classroom Creation failed'
			)

		announcementsRendered : (e, isInitial) =>

			if isInitial is true
				@$tinyscrollbar.update('relative')
			else
				@$tinyscrollbar.update()
				
	
	App.classrooms.announcement = new Announcement()

)($, window, document)