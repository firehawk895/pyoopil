App = window.App or {}
App.classrooms = App.classrooms or {}

(($, window, document) ->

	class LibraryServices

		constructor : ->

			@isInitial = true
			@baseUrl = window.location.pathname

		getLibraries : ->

			defer = $.Deferred()

			if @isInitial is true

				defer.resolve(App.classrooms.libraries.data)

			return defer.promise()

		getData : (url)->

			ajax = $.ajax({
				url : url,
				method : 'GET'
			})

			ajax


		postData : (url, data)->

			ajax = $.ajax({
				type : 'POST',
				url : url,
				data : data
			})

			ajax


		newClassroom : (data) ->

			@postData @baseUrl + '/add.json' , data		

		
		getAnnouncementsByPage : (page)->

			@getData @baseUrl + '/getannouncements.json?page=' + page


		isValid : (data) ->

			return data? and data.length > 0

		getCurrentPage : ->

			url = window.location.href.split("/")

			_.last url

	App.classrooms.libraryServices = new LibraryServices()

)($, window, document)