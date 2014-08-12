// Generated by CoffeeScript 1.7.1
(function() {
  angular.module('Pyoopil.Directives').directive('createClassroom', [
    'Utilities', function(Utilities) {
      return {
        restrict: 'E',
        replace: true,
        scope: {},
        template: '<button class="sub-btn dialogbox" title="create-assign">Create New Classroom</button>',
        link: function(scope, elem, attrs) {
          return elem.on('click', function(e) {
            Utilities.openModal('create-classroom-form.html');
            return false;
          });
        }
      };
    }
  ]);

}).call(this);

//# sourceMappingURL=create-classroom.map
