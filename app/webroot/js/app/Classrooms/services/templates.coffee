App = window.App or {}
App.classrooms = App.classrooms or {}

(($, window, document) ->


	class Templates

		constructor : ->

			@setTemplates()

		setTemplates : ->

			@templates = {
				'classroomTile' : '<li><a href="{{ Classroom.Url }}">{{#if UsersClassroom.is_restricted}}<div class="lock-state"><p>! You do not have access to this class. Please contact the owner</p></div>{{/if}}{{#if UsersClassroom.is_teaching }}<div class="class-head">My Class</div>{{/if}}{{#if Classroom.is_private}}<img src="images/lock_icon.png" class="lock">{{/if}}<div class="doc-top"><p class="subject">{{ Classroom.title }}</p><div>by</div><div><span class="online"></span>{{ Classroom.Educator }}</div><div class="totalstudent">( {{Classroom.users_classroom_count}} Students)</div></div>{{#if Classroom.Campus.name}}<p class="doc-end"> {{Classroom.Campus.name}} </p>{{/if}}</a></li>',
				'quizTmpl' : '<div class="pop-wind clearfix">
					            <div class="pop-head clearfix">
					              <span>Classroom Created</span>
					              <a class="close-link" href="#">
					              <span class="icon-cross"></span></a>
					            </div>
					            <div class="pop-content">
					              <div class="created-contt">
					                <p class="created-heading">Your Class {{ Classroom.name }} has been successfully created.</p>
					                {{#if Classroom.is_private}}
					                <p class="created-txt">Please find below the unique group password. You can distribute the password to your friends so that they can join the group. </p>
					                <p class="created-txt">An E-mail with the password has also been sent to you for your convenience.</p>
					                <p class="created-txt">Unique acess code: <span class="code-txt">{{Classroom.access_code }}</span>
					                </p>
					                {{/if}}
					                <p class="created-txt">Now make your class more engaging with pyoopil. Kudos for setting up the class. Have a great session this semester with your students. Cheers!!</p>
					                <div class="pop-close">
					                  <a href="classroom.htm" class="sub-btn">Take me to my classrooms</a>
					                </div>
					              </div>
					            </div>
					          </div>',
				'default' : '<p>No template Available'
			}
		
		getTemplate : (template)->

			if template? and @templates.hasOwnProperty template
				@templates[template]
			else
				@templates.default

	App.classrooms.templates = new Templates()

)($, window, document)
