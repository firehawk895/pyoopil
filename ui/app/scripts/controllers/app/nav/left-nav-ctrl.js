/**
 * Created by himanshu on 26/8/14.
 */
angular.module('uiApp')
  .controller('leftNavCtrl', ['$scope', 'userService', 'toastService', '$http', 'localStorageService', 'globalService', '$location', 'roomService', '$stateParams', '$state',
    function ($scope, userService, toastService, $http, localStorageService, globalService, $location, roomService, $stateParams, $state) {

      $scope.showLogout = false;
      $scope.classrooms = [];
      $scope.pageEnd = false;
      $scope.fullName = localStorageService.get("name");
      $scope.profile_img = localStorageService.get("image");
      $scope.page = 1;
      roomService.getRooms($scope.page).then(function (result) {
        $scope.classrooms = result.data;
      });
      $scope.logout = function () {
        userService.logout().then(function (result) {
          toastService.show(result.status, result.message);
          globalService.setIsAuthorised(false);
          $location.path('/logout/');
          $http.defaults.headers.common = {'X-AuthTokenHeader': ''};
          localStorageService.remove("token");
          localStorageService.remove("name");
          localStorageService.remove("image");
          localStorageService.remove("id");

        });
      };
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
      $scope.goToClass = function (id, restricted) {
        if (restricted)
          toastService.show(false, "Cannot Enter Classroom");
        else
          $state.go('app.rooms.discussions.all', { roomId: id });
      };
    }]);