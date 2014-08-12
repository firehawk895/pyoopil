// Generated by CoffeeScript 1.7.1
angular.module('Pyoopil.Directives').directive('tiles', [
  'classroomService', '$timeout', function(classroomService, $timeout) {
    return {
      restrict: 'E',
      templateUrl: '/pyoopil/js/app/partials/Classrooms/classroom-tile.html',
      link: function(scope, elem, attrs) {
        return $timeout(function() {
          scope.classrooms = scope.data;
          if (!scope.$$phase) {
            return scope.$digest();
          }
        }, 100);
      }
    };
  }
]);
