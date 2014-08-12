angular.module 'Pyoopil.Directives'
  .directive 'tiles', [ 'classroomService', '$timeout',(classroomService, $timeout)->

    restrict : 'E',
    templateUrl : '/pyoopil/js/app/partials/Classrooms/classroom-tile.html',
    link : (scope, elem, attrs)->

      $timeout(()->
        scope.classrooms = scope.data
        if not scope.$$phase
          scope.$digest()
      ,100)



  ]