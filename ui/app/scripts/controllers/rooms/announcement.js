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
        roomService.getAnnouncements($stateParams.roomId, $scope.page).then(function (result) {
            $scope.announcements = result.data;
            $scope.canPost=result.permissions.allowCreate;
        });

        $scope.createAnnouncement = function () {

            roomService.createAnnouncement($stateParams.roomId, $scope.announcement).then(function (added) {
                notificationService.show(added.status, added.message);
                $scope.announcements.unshift(added.data);
                $scope.announcement = {};
            });
        };

        $scope.myPagingFunction = function () {
            roomService.getAnnouncements($stateParams.roomId, ++$scope.page).then(function (result) {
                $scope.announcements = $scope.announcements.concat(result.data);
            });
        };
//        $scope.subCharLeft = function () {
//            var charLeft = 200 - $scope.announcement.Announcement.subject.length;
//            if (charLeft==undefined)
//                return 0;
//
//            return charLeft;
//        };

    }]);
