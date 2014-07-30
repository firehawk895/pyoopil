angular.module('Global.Directives')
.directive('overlay', ['$document', ($document)->

    return {

    restrict : 'E'
    templateUrl : '/pyoopil/js/app/partials/overlay.html'
    link : (scope, elem, attrs)->

      $overlay = elem.find '#overlayScreen'

      elem.on('click', ->

#        $overlay.fadeOut('fast')

      )

      scope.$on('openModal', (e)->

        $overlay.fadeIn('slow')

      )

      scope.$on('closeModal', (e)->

        $overlay.fadeOut('fast')

      )

    }


  ])