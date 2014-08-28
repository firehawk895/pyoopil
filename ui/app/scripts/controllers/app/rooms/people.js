/**
 * Created by himanshu on 21/8/14.
 */
angular.module('uiApp')
  .controller('peopleCtrl', ['$scope', '$stateParams' , 'roomService', 'notificationService', 'ngDialog', 'modalService',
    function ($scope, $stateParams, roomService, notificationService, ngDialog, modalService) {

      $scope.people = {};
      $scope.page = 1;
      $scope.dataTagMod = [];
      $scope.dataTagRestrict = [];
      $scope.roomId = $stateParams.roomId;

      $scope.ids = "";

      roomService.getPeoples($stateParams.roomId, $scope.page).then(function (result) {
        $scope.peoples = result.data;
        $scope.canModerate = result.permissions.CUDModerator;
        $scope.canRestrict = result.permissions.CUDRestricted;

        angular.forEach(result.data, function (peopleData) {
          if (!peopleData.UsersClassroom.is_moderator)
            $scope.dataTagMod.push(peopleData);
          if (!peopleData.UsersClassroom.is_restricted)
            $scope.dataTagRestrict.push(peopleData);
        });
      });

      $scope.myPagingFunction = function () {
        roomService.getPeoples($stateParams.roomId, ++$scope.page).then(function (result) {
          $scope.peoples = $scope.peoples.concat(result.data);

          angular.forEach(result.data, function (peopleData) {
            if (!peopleData.UsersClassroom.is_moderator)
              $scope.dataTagMod.push(peopleData);
            if (!peopleData.UsersClassroom.is_restricted)
              $scope.dataTagRestrict.push(peopleData);
          });
        });
      };

      $scope.removeModerator = function (people) {
        var removeId = people.AppUser.id + ",";
        roomService.removeModerator($stateParams.roomId, removeId).then(function (result) {
          if (result.status)
            people.UsersClassroom.is_moderator = false;
        });
      };

      $scope.unRestrict = function (people) {
        var removeId = people.AppUser.id + ",";
        roomService.unRestrict($stateParams.roomId, removeId).then(function (result) {
          if (result.status)
            people.UsersClassroom.is_restricted = false;
        });
      };

      $scope.openModerateDialog = function () {
        modalService.openModeratorDialog($scope);
      };

      $scope.openRestrictDialog = function () {
        ngDialog.open({
          template: 'views/app/rooms/restrictDialog.html',
          scope: $scope
        });
      };

      $scope.setModerator = function () {
        var setModIds = $("#ddlModeratorIds").select2("val");
        roomService.setModerator($stateParams.roomId, setModIds).then(function (result) {
          if (result.status) {
            angular.forEach($scope.peoples, function (people) {
              if (setModIds.indexOf(people.AppUser.id) != -1) {
                people.UsersClassroom.is_moderator = true;
              }
            });
            ngDialog.close();
          }
        });
      };

      $scope.setRestricted = function () {
        var setRestrictIds = $("#ddlRestrictedIds").select2("val");
        roomService.setRestricted($stateParams.roomId, setRestrictIds).then(function (result) {
          if (result.status) {
            angular.forEach($scope.peoples, function (people) {
              if (setRestrictIds.indexOf(people.AppUser.id) != -1) {
                people.UsersClassroom.is_restricted = true;
              }
            });
            ngDialog.close();
          }

        });
      };

    }]);