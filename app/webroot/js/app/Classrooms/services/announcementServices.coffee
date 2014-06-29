App = window.App or {}
App.classrooms = App.classrooms or {}

(($, window, document) ->

	class AnnouncementServices

		constructor : ->

			@isInitial = true
			@baseUrl = '/PDD/pyoopil/Classrooms/'

		getAnnouncements : ->

			defer = $.Deferred()

			if @isInitial is true

				defer.resolve(App.classrooms.announcements.data)

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

			@postData @baseUrl + 'add.json' , data


		newJoinClassroom : (data) ->
			
			@postData @baseUrl + 'join.json' , data			

		
		getClassroomsByPage : (page)->

			@getData @baseUrl + 'getclassrooms.json?page=' + page


		isValid : (data) ->

			return data? and data.length > 0

		getCurrentPage : ->

			url = window.location.href.split("/")

			_.last url

	App.classrooms.announcementServices = new AnnouncementServices()

)($, window, document)
