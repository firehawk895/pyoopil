App = window.App or {}
App.LeftNavScroll = App.LeftNavScroll or {}

(($, window, document) ->

	$document = $(document)

	class LeftNav

		constructor : ->

			@init()
			@setEventHandlers()
			@getClassroomsData()

		init : ->

			@services = App.LeftNavScroll.services

		getClassroomsData : ->

			promise = @services.getClassrooms()

			promise.then((data)=>

				if @services.isValid(data.data) is true
					$document.trigger('LeftNavScroll.UPDATE', [data.data])

			)


		setEventHandlers : ->
			
			$document.on('LeftNavScroll.UPDATE', App.LeftNavScroll.views.renderClassrooms)
			# $document.on('Classrooms.UPDATE', App.LeftNavScroll.views.renderClassrooms)


	App.LeftNavScroll.leftNav = new LeftNav()

)($, window, document)
