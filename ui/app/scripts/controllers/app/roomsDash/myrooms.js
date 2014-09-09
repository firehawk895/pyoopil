/**
 * Created by greenapple on 19/8/14.
 */
angular.module('uiApp')
  .controller('myRoomCtrl', ['$scope' , 'roomService', 'notificationService', 'ngDialog', 'userService', 'localStorageService', '$state', 'globalService', '$stateParams',
    function ($scope, roomService, notificationService, ngDialog, userService, localStorageService, $state, globalService, $stateParams) {
      $scope.showJoin = true;
      $scope.accessCode = "";
      $scope.classroom = {};
      $scope.page = 1;
      $scope.pageEnd = false;
      roomService.getRooms($scope.page).then(function (result) {
        $scope.classrooms = result.data;
        $scope.canCreate = result.permissions.allowCreate;

      });

      $scope.updatePage = function () {
        if (!$scope.pageEnd) {
          roomService.getRooms(++$scope.page).then(function (result) {
            if (!result.data.length)
              $scope.pageEnd = true;
            else
              $scope.classrooms = $scope.classrooms.concat(result.data);

          });
        }
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
      $scope.createClassroom = function () {
        $scope.classroom.Classroom.minimum_attendance /= 100;
        roomService.createClassroom($scope.classroom).then(function (result) {
          notificationService.show(result.status, result.message);
          if (result.status) {
            $scope.classrooms.unshift(result.data);
            console.log($scope.classrooms);
            ngDialog.close();
            $scope.classroom = {};
            ngDialog.open({
              template: 'views/app/roomsDash/classcreated.html',
              scope: $scope
            });

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

      $scope.goToClass = function (id, restricted) {
        if (restricted)
          notificationService.show(false, "Cannot Enter Classroom");
        else
          $state.go('app.rooms.discussions', { roomId: id });
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
