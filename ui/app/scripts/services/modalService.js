'use strict';

angular.module('uiApp')
  .factory('modalService', [ 'ngDialog', '$sce',
    function (ngDialog, $sce) {
      var self = {};

      self.openDialog = function (scope, path) {
        ngDialog.open({
          template: path,
          scope: scope
        });
      };
      self.closeDialog = function () {
        ngDialog.close();
      };
      self.openDocViewerDialog = function (scope, path) {
        scope.docPath = $sce.trustAsResourceUrl("http://docs.google.com/viewer?url=" + encodeURIComponent(path) + "&embedded=true");
        ngDialog.open({
          template: 'views/app/dialog-open-doc.html',
          scope: scope,
          showClose: true,
          className: 'ngdialog-theme-plain'
        });
      };
      self.openLeftEditDialog = function (scope) {
        ngDialog.open({
          template: 'views/app/profile/leftEditDialog.html',
          scope: scope
        });
      };
      return self;
    }])
;