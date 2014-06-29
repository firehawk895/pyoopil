(($, window, document) ->

	$document = $(document)

	class Init

		constructor : ->

			@services = App.classrooms.services
			@currentPage = @services.getCurrentPage()

			# console.log @currentPage

			switch @currentPage
				when 'Classrooms' then new App.classrooms.landing('#classrooms')
				when 'Classrooms#' then new App.classrooms.landing('#classrooms')
				when 'index' then new App.classrooms.landing('#classrooms')
				when 'Discussions' then App.classrooms.discussion.init('#discussions')
				when 'Discussions#' then App.classrooms.discussion.init('#discussions')
				when 'Announcements' then App.classrooms.announcement.init('#announcements')
				when 'Announcements#' then App.classrooms.announcement.init('#announcements')
				else
					new App.classrooms.landing('#classrooms')
		

	new Init()

)($, window, document)

