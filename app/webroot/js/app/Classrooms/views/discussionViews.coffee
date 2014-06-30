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
			@$elem.prepend @renderDiscussion discussion

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
				chartData = $elem.data('chart')

				data = google.visualization.arrayToDataTable([
				  ['Answer', 'Reply'],
				  ['Answer 1', 30],
				  ['Answer 2', 50],
				  ['Answer 3', 10],
				  ['Answer 4', 10]
				])
				options = {};
				chart = new google.visualization.BarChart(elem);
				chart.draw(data, {
				  colors: ['#ee6d05', '#f78928', '#f79f57', '#f9b785'],
				  is3D: true
				})
			)

		renderChart : (elem)->


	App.classrooms.discussionViews = DiscussionViews

)($, window, document)
