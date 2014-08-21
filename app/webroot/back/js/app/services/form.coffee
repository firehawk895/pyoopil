angular.module 'Pyoopil.Services'
.factory 'Form', ['$document', ($document)->

  class Form

    constructor : ->

      @path = '/pyoopil/js/app/partials/modules/'


    init : (scope)->
      @scope = scope


    openModal : (template) ->

      @scope.template.url = @modalPath + template
      @scope.showModal = true
      if not @scope.$$phase
        @scope.$digest()

      @scope.$broadcast 'openModal'


  new Utilities()


]¡