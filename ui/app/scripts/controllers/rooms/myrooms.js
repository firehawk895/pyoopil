/**
 * Created by greenapple on 19/8/14.
 */

angular.module('uiApp')
    .controller('myRoomCtrl', ['$scope' , 'roomService', 'notificationService','ngDialog',
        function ($scope, roomService, notificationService,ngDialog) {
            $scope.showJoin = true;
            $scope.accessCode = null;
            $scope.classroom = {};
            $scope.page = 1;

            roomService.getRooms($scope.page).then(function (result) {
                $scope.classrooms = result.data;

            });
            $scope.joinClassroom = function () {
                roomService.joinClassroom($scope.accessCode).then(function (result) {
                    notificationService.show(result.status, result.message);

                });
            };

           $scope.open=function() {
               ngDialog.open({
                   template: 'views/rooms/createclassroom.html',
                   scope: $scope,
                   className: 'ngdialog-theme-default random-class'
               });
           };
        }]);