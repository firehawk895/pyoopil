(($, window, document) ->

	class DiscussionServices

		constructor : ->

			@isInitial = true
			path = window.location.pathname.split('/')
			if _.last(path) is 'foldeddiscussions'
				path[path.length - 1] = 'Discussions'
				@baseUrl = path.join('/')
			else
				@baseUrl = window.location.pathname

		getDiscussions : ->

			defer = $.Deferred()

			if @isInitial is true

				defer.resolve(App.classrooms.discussions.data)

			return defer.promise()

		getData : (url)->

			ajax = $.ajax({
				url : @baseUrl + "/" + url,
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

			formData = $(data).serialize()

			url = 'add.json'

			@postData(url, formData)

		deleteDiscussion : (id) ->

			url = 'delete.json'

			@postData(url, { "id" : id , "type" : "Discussion"} )

		setGamification : (data)->

			url = 'setGamificationVote.json'

			@postData(url, data)

		addReply : (data)->

			formData = data.serialize()

			url = 'addReply.json'

			@postData(url, formData)

		getReplies : (data)->

			url = 'getreplies.json?page=' + data.page + "&discussion_id=" + data.discussion_id

			@getData(url)

		toggleFold : (id) ->

			url = 'togglefold.json'

			@postData(url, {"id" : id})

		setPoll : (id) ->

			url = 'setPollVote.json'

			@postData(url, {"pollchoice_id" : id})

		isValid : (data) ->
			return data? and data.length > 0

	App.classrooms.discussionServices = new DiscussionServices()

)($, window, document)
