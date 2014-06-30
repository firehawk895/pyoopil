App = window.App or {}
App.LeftNavScroll = App.LeftNavScroll or {}

(($, window, document) ->

	class Services

		constructor : ->

			@isInitial = true

		getClassrooms : ->

			defer = $.Deferred()

			if @isInitial is true

				defer.resolve(App.leftNavData)

			return defer.promise()

		isValid : (data) ->

			return data? and data.length > 0
	

	App.LeftNavScroll.services = new Services()

)($, window, document)
