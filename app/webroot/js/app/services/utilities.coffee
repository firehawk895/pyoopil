angular.module 'Pyoopil.Services'
  .factory 'Utilities', ['$document', ($document)->

    class Utilities

      constructor : ->

        @modalPath = '/pyoopil/js/app/partials/modules/'
        @currentModal = false
        @_body = angular.element $document[0].body


      init : (scope)->
        @scope = scope


      openModal : (template) ->

        self = @

        @scope.template.url = @modalPath + template
        @scope.showModal = true

        if not @scope.$$phase
          @scope.$digest()

        @_body.on 'click', '.close-link', (e) -> e.preventDefault(); self.closeModal e

        @scope.$broadcast 'openModal'

      closeModal : (e) ->

        @scope.template.url = null
        @scope.$broadcast 'closeModal'

        if not @scope.$$phase
          @scope.$digest()


    new Utilities()


]