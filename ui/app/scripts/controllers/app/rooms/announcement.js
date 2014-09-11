'use strict';

/**
 * @ngdoc function
 * @name uiApp.controller:AnnouncementCtrl
 * @description
 * # AnnouncementCtrl
 * Controller of the uiApp
 */
angular.module('uiApp')
  .controller('announcementCtrl', ['$scope', '$stateParams' , 'roomService', 'notificationService', 'ngDialog', '$sce', 'modalService',
    function ($scope, $stateParams, roomService, notificationService, ngDialog, $sce, modalService) {
      //todo : check if room id has access
      $scope.showInfoPopup = false;
      $scope.page = 1;
      $scope.vm = {};
      $scope.vm.subject = "";
      $scope.vm.body = "";
      $scope.vm.file = null;
      $scope.roomId = $stateParams.roomId;
      $scope.pageEnd = false;

      roomService.getAnnouncements($stateParams.roomId, $scope.page).then(function (result) {
        $scope.announcements = result.data;
        $scope.canPost = result.permissions.allowCreate;
      });

      $scope.createAnnouncement = function () {
        if ($scope.vm.subject == "" || $scope.vm.body == "")
          notificationService.show(false, "Cannot Create Announcement");
        else {
          $scope.vm.file = document.getElementById("fileupload").files[0];
          if (angular.isDefined($scope.vm.file) && $scope.vm.file.size > 5242880)
            notificationService.show(false, "Cannot upload more than 5 MB");
          else {
            roomService.createAnnouncement($stateParams.roomId, $scope.vm.subject, $scope.vm.body, $scope.vm.file)
              .then(function (added) {
                notificationService.show(added.status, added.message);
                if (added.status) {
                  $scope.announcements.unshift(added.data);
                  $scope.vm = {};
                }
              });
          }
        }
      };

      $scope.updatePage = function () {
        if (!$scope.pageEnd) {
          roomService.getAnnouncements($stateParams.roomId, ++$scope.page).then(function (result) {
            if (!result.data.length)
              $scope.pageEnd = true;
            else
              $scope.announcements = $scope.announcements.concat(result.data);
          });
        }
      };

      $scope.cancelAnnouncement = function () {
        $scope.vm = {};
      };
      $scope.openDocViewerDialog = function (path) {
        modalService.openDocViewerDialog($scope, path);
      };

    }]);
