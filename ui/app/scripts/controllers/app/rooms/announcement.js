'use strict';

/**
 * @ngdoc function
 * @name uiApp.controller:AnnouncementCtrl
 * @description
 * # AnnouncementCtrl
 * Controller of the uiApp
 */
angular.module('uiApp')
    .controller('announcementCtrl', ['$scope', '$stateParams' , 'roomService', 'notificationService', function ($scope, $stateParams, roomService, notificationService) {

        $scope.announcement = {};
        //todo : check if room id has access
        $scope.page = 1;

        $scope.roomId = $stateParams.roomId;

        roomService.getAnnouncements($stateParams.roomId, $scope.page).then(function (result) {
            $scope.announcements = result.data;
            $scope.canPost = result.permissions.allowCreate;
        });

        $scope.createAnnouncement = function () {

            roomService.createAnnouncement($stateParams.roomId, $scope.announcement).then(function (added) {
                notificationService.show(added.status, added.message);
                $scope.announcements.unshift(added.data);
                $scope.announcement = {};
            });
        };

        $scope.updatePage = function () {
            roomService.getAnnouncements($stateParams.roomId, ++$scope.page).then(function (result) {
                $scope.announcements = $scope.announcements.concat(result.data);
            });
        };

        $scope.cancelAnnouncement = function () {
            $scope.announcement = {};
        }

    }]);
