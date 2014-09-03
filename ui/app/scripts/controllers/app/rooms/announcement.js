'use strict';

/**
 * @ngdoc function
 * @name uiApp.controller:AnnouncementCtrl
 * @description
 * # AnnouncementCtrl
 * Controller of the uiApp
 */
angular.module('uiApp')
  .controller('announcementCtrl', ['$scope', '$stateParams' , 'roomService', 'notificationService',
    function ($scope, $stateParams, roomService, notificationService) {
    //todo : check if room id has access
    $scope.page = 1;
    $scope.vm = {};
    $scope.vm.subject = "";
    $scope.vm.body = "";
    $scope.vm.file = null;
    $scope.roomId = $stateParams.roomId;

    roomService.getAnnouncements($stateParams.roomId, $scope.page).then(function (result) {
      $scope.announcements = result.data;
      $scope.canPost = result.permissions.allowCreate;
    });

    $scope.createAnnouncement = function () {

      $scope.vm.file = document.getElementById("fileupload").files[0];
      roomService.createAnnouncement($stateParams.roomId, $scope.vm.subject, $scope.vm.body, $scope.vm.file)
        .then(function (added) {
          notificationService.show(added.status, added.message);
          if (added.status) {
            $scope.announcements.unshift(added.data);
           $scope.vm={};
          }
        });
    };

    $scope.updatePage = function () {
      roomService.getAnnouncements($stateParams.roomId, ++$scope.page).then(function (result) {
        $scope.announcements = $scope.announcements.concat(result.data);
      });
    };

    $scope.cancelAnnouncement = function () {
      $scope.vm= {};



    };


  }]);
