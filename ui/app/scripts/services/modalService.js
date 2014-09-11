'use strict';

angular.module('uiApp')
  .factory('modalService', [ 'ngDialog', '$sce',
    function (ngDialog, $sce) {
      var self = {};

      self.openModeratorDialog = function (scope) {
        ngDialog.open({
          template: 'views/app/rooms/moderatorDialog.html',
          scope: scope
        });
      };
      self.openDocViewerDialog = function (scope, path) {
        scope.docPath = $sce.trustAsResourceUrl("http://docs.google.com/viewer?url=" + encodeURIComponent(path) + "&embedded=true");
        ngDialog.open({
          template: 'views/app/dialog-open-doc.html',
          scope: scope
        });
      };

      return self;
    }]);