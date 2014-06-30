(($, window, document) ->

	class DiscussionViews

		constructor : (elem) ->

			@$elem = elem
			
			@init()

		init : =>

			@discussionTemplate = Handlebars.compile App.classrooms.templates.getTemplate('discussionTmpl')
			@pollTemplate = Handlebars.compile App.classrooms.templates.getTemplate('pollTmpl')
			@noteTemplate = Handlebars.compile App.classrooms.templates.getTemplate('noteTmpl')
			@replyTemplate = Handlebars.compile App.classrooms.templates.getTemplate('replyTmpl')
			@gamificationDiscussionTemplate = Handlebars.compile App.classrooms.templates.getTemplate('gamificationDiscussionTmpl')
			@gamificationReplyTemplate = Handlebars.compile App.classrooms.templates.getTemplate('gamificationReplyTmpl')
			@pollingTemplate = Handlebars.compile App.classrooms.templates.getTemplate('pollingTmpl')
			''

		renderDiscussions : (e, discussions) =>

			discussionsHtml = if discussions?
				@renderDiscussion discussion for discussion in discussions

			@$elem.append discussionsHtml
			@renderCharts()

		renderDiscussion : (discussion) ->

			switch discussion.Discussion.type
				when 'poll' then discussionHtml = @pollTemplate discussion
				when 'question' then discussionHtml = @discussionTemplate discussion
				when 'note' then discussionHtml = @noteTemplate discussion
				else
					discussionHtml = @discussionTemplate discussion

			discussionHtml

		newDiscussion : (e, discussion)=>
			discussionHtml = @renderDiscussion discussion
			@$elem.prepend discussionHtml
			@renderChart(discussion.Discussion.id)

		renderReply : (reply) ->

			replyHtml = @replyTemplate reply

			replyHtml

		newReply : (e, reply) =>

			$parent = @$elem.find($(reply.parentClass + ' .replies'))

			$parent.prepend(@renderReply(reply.data[0]))

		renderGamification : (e, gamification) =>

			switch gamification.type
				when 'Discussion' then gamificationHtml = @gamificationDiscussionTemplate gamification.data
				when 'Reply' then gamificationHtml = @gamificationReplyTemplate gamification.data

			$(gamification.container).html(gamificationHtml)

		renderReplies : (e,replies) =>

			repliesHtml = if replies.data?
				@renderReply reply for reply in replies.data

			replies.container.append repliesHtml

		renderCharts : () ->

			$chartElems = $('div.chart')

			$.each($chartElems, (i, elem)->
				$elem = $(elem)
				chartDataJson = $elem.data('chart')
				chartsData = [['Answer', 'Reply']]

				$.each(chartDataJson, (i, data)->
					if data.choice
						chart = []
						chart.push(data.choice)
						chart.push(parseInt(data.votes))

						chartsData.push chart
				)

				data = google.visualization.arrayToDataTable(chartsData)
				options = {};
				chart = new google.visualization.BarChart(elem);
				chart.draw(data, {
				  colors: ['#ee6d05', '#f78928', '#f79f57', '#f9b785'],
				  is3D: true
				})
			)

		renderChart : (id)->

			discussionId = '.discussion_' + id

			$elem = @$elem.find(discussionId).find('.chart')

			chartDataJson = $elem.data('chart')
			chartsData = [['Answer', 'Reply']]

			$.each(chartDataJson, (i, data)->
				if data.choice
					chart = []
					chart.push(data.choice)
					chart.push(parseInt(data.votes))

					chartsData.push chart
			)
			data = google.visualization.arrayToDataTable(chartsData)
			options = {};
			chart = new google.visualization.BarChart($elem[0]);
			chart.draw(data, {
			  colors: ['#ee6d05', '#f78928', '#f79f57', '#f9b785'],
			  is3D: true
			})

		renderPolling : (data) ->

			@pollingTemplate data

		renderPoll : (e, data) =>

			pollData = data.data

			data.polling.html(@renderPolling(pollData[0]))
			@renderChart(data.discussionId)


	App.classrooms.discussionViews = DiscussionViews

)($, window, document)
