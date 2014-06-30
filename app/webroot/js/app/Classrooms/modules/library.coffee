App = window.App or {}
App.classrooms = App.classrooms or {}
(($, window, document) ->

	$document = $(document)

	class Library

		init : (elem)->

			@$elem = $(elem)

			@services = App.classrooms.libraryServices
			@views = new App.classrooms.libraryViews(@$elem)
			
			@notifier = App.common.notifier

			@setEventListeners()
			@getLibraries()

		getLibraries : ->

			promise = @services.getLibraries()

			promise.then((data)=>

				if @services.isValid(data) is true
					$document.trigger('Libraries.UPDATE', [data])
				else
					@notifier.notify 'error', 'No Libraries found'

			)

		setEventListeners : ->

			$document.on('Libraries.UPDATE', @views.renderLibraries)
			$document.on('Libraries.CREATE', @views.newAnnouncement)

			$document.on('click', '#upload', ()->

				$('#TopicIndexForm').submit()

			)

		newAnnouncement : (e) ->

			e.preventDefault()

			ajax = App.classrooms.services.newClassroom $(@).serialize()

			ajax.done((data)->

				if data.status is false
					App.common.notifier.notify 'error', data.message
					return

				if App.classrooms.services.isValid([data]) is true
					$document.trigger('Libraries.CREATE', [data])
				else
					App.common.notifier.notify 'error', 'New Classroom Creation failed'
			)

		announcementsRendered : (e, isInitial) =>

			if isInitial is true
				@$tinyscrollbar.update('relative')
			else
				@$tinyscrollbar.update()
				
	
	App.classrooms.library = new Library()

)($, window, document)