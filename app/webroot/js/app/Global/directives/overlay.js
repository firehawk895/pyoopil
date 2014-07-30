// Generated by CoffeeScript 1.7.1
(function() {
  angular.module('Global.Directives').directive('overlay', [
    '$document', function($document) {
      return {
        restrict: 'E',
        templateUrl: '/pyoopil/js/app/partials/overlay.html',
        link: function(scope, elem, attrs) {
          var $overlay;
          $overlay = elem.find('#overlayScreen');
          elem.on('click', function() {});
          scope.$on('openModal', function(e) {
            return $overlay.fadeIn('slow');
          });
          return scope.$on('closeModal', function(e) {
            return $overlay.fadeOut('fast');
          });
        }
      };
    }
  ]);

}).call(this);

//# sourceMappingURL=overlay.map
