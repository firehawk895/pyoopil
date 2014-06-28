App = window.App or {}
App.LeftNavScroll = App.LeftNavScroll or {}

(($, window, document) ->

	$document = $(document)

	class LeftNav

		constructor : ->

			@setEventHandlers()


		setEventHandlers : ->
			
			$document.on('Classrooms.UPDATE', App.LeftNavScroll.views.renderClassrooms)


	App.LeftNavScroll.leftNav = new LeftNav()

)($, window, document)
