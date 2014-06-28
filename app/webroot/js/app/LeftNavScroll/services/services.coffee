App = window.App or {}
App.LeftNavScroll = App.LeftNavScroll or {}

(($, window, document) ->

	class Services

		constructor : ->

			@isInitial = true

		getClassrooms : ->

			defer = $.Deferred()

			if @isInitial is true

				defer.resolve(App.classrooms.data)

			return defer.promise()
	

	App.LeftNavScroll.services = new Services()

)($, window, document)
