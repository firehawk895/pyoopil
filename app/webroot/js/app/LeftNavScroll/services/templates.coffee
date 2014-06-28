App = window.App or {}
App.LeftNavScroll = App.LeftNavScroll or {}

(($, window, document) ->

	class Templates 

		constructor : ->

			@setTemplates()

		setTemplates : ->

			@templates = {
				'classroomTile' : '<div class="scroll-content-item">
						            <a href="{{ Classroom.Campus.Url }}">
						                <div class="classouter">
						                    <div class="doc-list">
						                        <div class="doc-top">
						                            <p class="subject">{{ Classroom.title }}
						                                <span>by</span>
						                                <span>{{ Classroom.Educator }}</span>
						                                <span class="totalstudent">( {{Classroom.users_classroom_count}} Students)</span>
						                        </div>
						                    </div>
						                </div>
						            </a>
						        </div>',
				'default' : '<p>No template Available'
			}
		
		getTemplate : (template)->

			if template? and @templates.hasOwnProperty template
				@templates[template]
			else
				@templates.default

	App.LeftNavScroll.templates = new Templates('.sub')

)($, window, document)
