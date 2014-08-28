/**
 * Created by himanshu on 26/8/14.
 */
angular.module('uiApp')
  .controller('leftNavCtrl', ['$scope', 'userService', 'notificationService', '$http', 'localStorageService', 'globalService', '$location', 'roomService', '$stateParams',
    function ($scope, userService, notificationService, $http, localStorageService, globalService, $location, roomService, $stateParams) {

      $scope.showLogout = false;
      $scope.classrooms = [];

      $scope.page = 1;
      roomService.getRooms($scope.page).then(function (result) {
        $scope.classrooms = result.data;
      });


      $scope.logout = function () {
        userService.logout().then(function (result) {
          notificationService.show(result.status, result.message);
          $location.path('/logout/');
          $http.defaults.headers.common = {'X-AuthTokenHeader': ''};
          localStorageService.remove("token");
          globalService.setIsAuthorised(false);
        });
      };

      $scope.updatePage = function () {
        roomService.getRooms(++$scope.page).then(function (result) {
          $scope.classrooms = $scope.classrooms.concat(result.data);
        });
      };

    }]);