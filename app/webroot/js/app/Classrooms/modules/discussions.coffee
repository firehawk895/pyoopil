App = window.App or {}
App.classrooms = App.classrooms or {}

(($, window, document) ->

	$document = $(document)

	class Discussion

		init : (elem) =>

			@$elem = $(elem)

			@services = App.classrooms.discussionServices
			@views = new App.classrooms.discussionViews(@$elem)
			@notifier = App.common.notifier
			
			@setEventListeners()
			@getDiscussions()


		getDiscussions : ->

			promise = @services.getDiscussions()

			promise.then((data)=>

				if @services.isValid(data) is true
					$document.trigger('Discussions.UPDATE', [data])
				else
					@notifier.notify 'error', 'No Discussions found'

			)

		setEventListeners : ->

			$document.on('Discussions.UPDATE', @views.renderDiscussions)
			$document.on('Discussions.CREATE', @views.newDiscussion)
			$document.on('Discussions.REPLY', @views.newReply)

			$('#fileupload').on('change', @handleFileUpload)
			$("#DiscussionAddForm, #DiscussionAddFormPoll, #DiscussionAddFormNote").on('submit', @newDiscussion)
			
			@$elem.on('submit', '.reply', @newReply)

			$(".disc-submit-btn").click(()->
		        $("#DiscussionAddForm").submit()
		    )

			$(".disc-submit-btn-poll").click(()->
				$("#DiscussionAddFormPoll").submit()
			)

			$(".disc-submit-btn-note").click(()->
				CKEDITOR.instances.editor1.updateElement();
				$("#DiscussionAddFormNote").submit()
			)

			@$elem.on('click', '.praise li a', (e)->

				that = @
				$that = $(@)
				$parent = $that.closest('.praise')
				id = ''

				switch $parent.data('type')
					when 'Discussion' then id = $parent.data('discussion-id')
					when 'Reply' then id = $parent.data('reply-id')

				praise = {
					type : $parent.data('type')
					id : id
					vote : $that.data('praise-type')	
				}
				
				promise = App.classrooms.discussionServices.setGamification(praise)

				promise.then((data)->

					if data.status is false
						App.common.notifier.notify 'error', data.message
						return

					if App.classrooms.services.isValid([data]) is true
						App.common.notifier.notify 'success', 'Your have successfully Voted'
					else
						App.common.notifier.notify 'error', 'Voting failed'

				,
				(error)->
					App.common.notifier.notify 'error', 'Voting not success'
				)

				false
			)

		handleFileUpload : (e) =>

			@uploadedFiles = e.target.files

			$('.files').html(@uploadedFiles[0].name)


		newDiscussion : (e) =>

			e.preventDefault()
			e.stopPropagation()

			form = e.target
			$form = $(e.target)

			if @services.isValid(@uploadedFiles)
				formData = new FormData()
				$.each(@uploadedFiles, (key, value)->
					formData.append(key, value);
				)

			ajax = App.classrooms.discussionServices.newDiscussion form

			ajax.done((data)->

				console.log data

				form.reset()
				$form.find('.cnl-btn').click()

				if data.status is false
					App.common.notifier.notify 'error', data.message
					return

				if App.classrooms.services.isValid([data]) is true
					App.common.notifier.notify 'success', 'Your have successfully Created a new Discussion'
					$document.trigger('Discussions.CREATE', data.data)
				else
					App.common.notifier.notify 'error', 'New Discussion Creation failed'
			)

		newReply : (e)->

			e.preventDefault()
			e.stopPropagation()

			form = e.target
			$form = $(e.target)
			$parent = $form.closest('.discussion')

			$parentClass = '.discussion_' + $parent.data('discussion-id')

			promise = App.classrooms.discussionServices.addReply $form

			promise.then((data)->

				if data.status is false
					App.common.notifier.notify 'error', data.message
					return

				if App.classrooms.services.isValid([data]) is true
					App.common.notifier.notify 'success', 'Your have successfully Replied to this Discussion'
					form.reset()
					$document.trigger('Discussions.REPLY', { "data" : data.data, "parentClass" : $parentClass })
				else
					App.common.notifier.notify 'error', 'Reply failed'
			)
				
	
	App.classrooms.discussion = new Discussion()

)($, window, document)