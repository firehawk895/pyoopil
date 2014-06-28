App = window.App or {}
App.classrooms = App.classrooms or {}

(($, window, document) ->

	$document = $(document)

	class Classroom

		constructor : (elem)->

			@$elem = $(elem)

			@init()
			@setEventListeners()
			@getClassroomsData()

		init : ->

			@$createClassroomForm = $('#classroom-form')
			@$joinClassroom = $('#join-with-code')
			@$viewport = @$elem.closest('.tinyscrollbar').find('.viewport')
			@currentPage = 1
			@hasScrollReached = false

			@views = new App.classrooms.views(@$elem)
			@services = App.classrooms.services
			@notifier = App.common.notifier

			$tinyscrollbar = $('.tinyscrollbar')
			$tinyscrollbar.tinyscrollbar({thumbSize: 9})

			@$tinyscrollbar = $tinyscrollbar.data("plugin_tinyscrollbar")

		getClassroomsData : ->

			promise = @services.getClassrooms()

			promise.then((data)=>

				if @services.isValid(data) is true
					$document.trigger('Classrooms.UPDATE', [data])
				else
					@notifier.notify 'error', 'No classrooms found'

			)

		setEventListeners : ->

			$document.on('Classrooms.UPDATE', @views.renderClassrooms)
			$document.on('Classrooms.CREATE', @views.newClassroom)
			$document.on('Classrooms.JOIN', @views.newJoin)
			$document.on('Classrooms.RENDER', @classroomsRendered)

			@$createClassroomForm.on('submit', @newClassroomSubmit)
			@$joinClassroom.on('submit', @joinClassroomSubmit)

			@$viewport.on('endOfScroll', =>
				if @hasScrollReached is false
					@hasScrollReached = true
					@currentPage += 1

					ajax = @services.getClassroomsByPage @currentPage

					ajax.done((data) =>
						if data.data and data.data.length > 0
							$document.trigger('Classrooms.UPDATE', [[data.data]])
						else
							App.common.notifier.notify('error', 'No more Data to Display')

						@hasScrollReached = false
					)
			)

		newClassroomSubmit : (e) ->

			e.preventDefault()

			ajax = App.classrooms.services.newClassroom $(@).serialize()

			ajax.done((data)->

				if data.status is false
					App.common.notifier.notify 'error', data.message
					return

				if App.classrooms.services.isValid([data]) is true
					$document.trigger('Classrooms.CREATE', [data])
				else
					App.common.notifier.notify 'error', 'New Classroom Creation failed'
			)

		joinClassroomSubmit : (e) ->

			e.preventDefault()

			ajax = App.classrooms.services.newJoinClassroom $(@).serialize()

			ajax.done((data)->
				if data.status is false
					App.common.notifier.notify 'error', data.message
					return

				if App.classrooms.services.isValid([data]) is true
					$document.trigger('Classrooms.JOIN', [data])
					App.commonnotifier.notify 'success', 'Joining New Classroom Success !'
				else
					App.common.notifier.notify 'error', 'Joining New Classroom failed'
			)

		classroomsRendered : (e, isInitial) =>

			if isInitial is true
				@$tinyscrollbar.update('relative')
			else
				@$tinyscrollbar.update()

	App.classrooms.classroom = new Classroom('#classrooms')

)($, window, document)

