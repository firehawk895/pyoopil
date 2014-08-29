'use strict';

angular.module('uiApp')
  .factory('modalService', [ 'ngDialog',
    function (ngDialog) {
      var self = {};

      self.openModeratorDialog = function (scope) {
        ngDialog.open({
          template: 'views/app/rooms/moderatorDialog.html',
          scope: scope
        });
      };


      return self;
    }]);