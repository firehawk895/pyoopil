App = window.App or {}
App.LeftNavScroll = App.LeftNavScroll or {}

(($, window, document) ->

	class Views

		constructor : (elem) ->

			@$elem = $(elem)
			@$classroomsContainer = $('div.scroll-pane')
			@classrooms = []

			bh = $(window).height();
			al = bh-260;
			@$classroomsContainer.css({'height':+al+'px'});

			@template = Handlebars.compile App.LeftNavScroll.templates.getTemplate('classroomTile')

			$('.hassub').hover(
				()->
					$(".container").addClass("show-sub");
					$(this).addClass("hover");

				,
				()->
					$(".container").removeClass("show-sub");
					$(this).removeClass("hover");

			)



		renderClassrooms : (e, classrooms) =>

			if classrooms?
				@classrooms = _.union @classrooms, classrooms
				@$classroomsContainer.empty()
				@renderClassroom classroom for classroom in @classrooms
			else
				return 'No Classroom Data'

			@$classroomsContainer
				.each(()->
					setSlider($(@));
				)
				

		renderClassroom : (classroom) ->

			if classroom.hasOwnProperty 'data'
				classroomHtml = @template classroom.data
			else
				classroomHtml = @template classroom
			@$classroomsContainer.prepend classroomHtml
	

	App.LeftNavScroll.views = new Views('.sub')

)($, window, document)
