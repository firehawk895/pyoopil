App = window.App or {}
App.classrooms = App.classrooms or {}

(($, window, document) ->

	class LibraryViews

		constructor : (elem) ->

			@$elem = elem.find('#library')
			
			@init()

		init : =>

			@libraryTemplate = Handlebars.compile App.classrooms.templates.getTemplate('libraryTmpl')
			''

		renderLibraries : (e, libraries) =>

			librariesHtml = if libraries?
				@renderLibrary library for library in libraries

			
			@$elem.append librariesHtml
			$("a[rel^='prettyPhoto']").prettyPhoto({
	            deeplinking: false
	        });

		renderLibrary : (library) ->

			if library.hasOwnProperty 'data'
				libraryHtml = @libraryTemplate library.data
			else
				libraryHtml = @libraryTemplate library
			
			libraryHtml

		newLibrary : (e, library)=>

			library = JSON.parse(library)

			@$elem.prepend(@renderLibrary(library))
	

	App.classrooms.libraryViews = LibraryViews

)($, window, document)
