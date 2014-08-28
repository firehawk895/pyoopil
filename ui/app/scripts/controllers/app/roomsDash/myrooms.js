/**
 * Created by greenapple on 19/8/14.
 */
angular.module('uiApp')
  .controller('myRoomCtrl', ['$scope' , 'roomService', 'notificationService', 'ngDialog', 'userService', 'localStorageService', 'globalService', '$stateParams',
    function ($scope, roomService, notificationService, ngDialog, userService, localStorageService, globalService, $stateParams) {
      $scope.showJoin = true;
      $scope.accessCode = null;
      $scope.classroom = {};
      $scope.page = 1;

      roomService.getRooms($scope.page).then(function (result) {
        $scope.classrooms = result.data;
        $scope.canCreate = result.permissions.allowCreate;

      });

      $scope.updatePage = function () {
        roomService.getRooms(++$scope.page).then(function (result) {
          $scope.classrooms = $scope.classrooms.concat(result.data);
        });
      };

      $scope.joinClassroom = function () {
        roomService.joinClassroom($scope.accessCode).then(function (result) {
          notificationService.show(result.status, result.message);
          if (result.status) {
            $scope.showJoin = true;
            $scope.classrooms.unshift(result.data);
            $scope.accessCode = null;
          }

        });
      };
      $scope.open = function () {
        $scope.classroom = {};

        ngDialog.open({
          template: 'views/app/roomsDash/createclassroom.html',
          scope: $scope
        });
      };
      $scope.createClassroom = function () {
        $scope.classroom.Classroom.minimum_attendance /= 100;
        roomService.createClassroom($scope.classroom).then(function (result) {
          notificationService.show(result.status, result.message);
          if (result.status) {
            ngDialog.close();
            $scope.classroom = result.data;
            ngDialog.open({
              template: 'views/app/roomsDash/classcreated.html',
              scope: $scope
            });
            $scope.classrooms.unshift(result.data)
          }
        });
      };

      roomService.getCampuses().then(function (result) {
        $scope.campuses = result.data;
      });
      roomService.getDepartments().then(function (result) {
        $scope.departments = result.data;
      });
      roomService.getDegrees().then(function (result) {
        $scope.degrees = result.data;
      });
    }]);
