App = window.App or {}
App.common = App.common or {}

(($, window, document) ->

	$document = $(document)

	class Notifier

		constructor : ->

			toastr.options = {
				"closeButton" : true,
				"positionClass": "toast-top-full-width",
				"onclick": null,
				"showDuration": "300",
				"hideDuration": "1000",
				"timeOut": "5000",
				"extendedTimeOut": "1000"
			}

			@notifier = toastr

		
		notify : (type, message)->

			@notifier[type](message)


	App.common.notifier = new Notifier

)($, window, document)