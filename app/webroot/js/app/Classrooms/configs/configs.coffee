App = window.App or {}
App.classrooms = App.classrooms or {}

(($, window, document) ->


	class Configs

		getBaseUrl : ->

			return 'js/app/'

		getResourcePath : =>

			resource = @getBaseUrl() + "resources/"

			resource
	

	App.classrooms.configs = new Configs()

)($, window, document)
