(($, window, document) ->

	class DiscussionServices

		constructor : ->

			@isInitial = true
			@baseUrl = window.location.pathname

		getDiscussions : ->

			defer = $.Deferred()

			if @isInitial is true

				defer.resolve(App.classrooms.discussions.data)

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
				url : @baseUrl + "/" + url,
				data : data
			})

			ajax


		newDiscussion : (data) ->

			console.log data

			formData = $(data).serialize()

			url = 'add.json'

			@postData(url, formData)


		setGamification : (data)->

			url = 'setGamificationVote.json'

			@postData(url, data)

		addReply : (data)->

			formData = data.serialize()

			url = 'addReply.json'

			@postData(url, formData)


		isValid : (data) ->

			return data? and data.length > 0

	App.classrooms.discussionServices = new DiscussionServices()

)($, window, document)
