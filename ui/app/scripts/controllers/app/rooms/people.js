/**
 * Created by himanshu on 21/8/14.
 */
angular.module('uiApp')
  .controller('peopleCtrl', ['$scope', '$stateParams' , 'roomService', 'modalService',
    function ($scope, $stateParams, roomService, modalService) {

      $scope.people = {};
      $scope.page = 1;
      $scope.dataTagMod = [];
      $scope.dataTagRestrict = [];
      $scope.roomId = $stateParams.roomId;
      $scope.canModerate = false;
      $scope.canRestrict = false;
      $scope.pageEnd = false;

      $scope.ids = "";

      roomService.getPeoples($stateParams.roomId, $scope.page).then(function (result) {
        $scope.peoples = result.data;
        $scope.canModerate = result.permissions.CUDmoderator;
        $scope.canRestrict = result.permissions.CUDrestricted;

        angular.forEach(result.data, function (peopleData) {
          if (!peopleData.UsersClassroom.is_moderator)
            $scope.dataTagMod.push(peopleData);
          if (!peopleData.UsersClassroom.is_restricted)
            $scope.dataTagRestrict.push(peopleData);
        });
      });

      $scope.updatePage = function () {
        if (!$scope.pageEnd) {
          roomService.getPeoples($stateParams.roomId, ++$scope.page).then(function (result) {
            if (!result.data.length)
              $scope.pageEnd = true;
            else {
              $scope.peoples = $scope.peoples.concat(result.data);
              angular.forEach(result.data, function (peopleData) {
                if (!peopleData.UsersClassroom.is_moderator)
                  $scope.dataTagMod.push(peopleData);
                if (!peopleData.UsersClassroom.is_restricted)
                  $scope.dataTagRestrict.push(peopleData);
              });
            }
          });
        }
      };

      $scope.removeModerator = function (index) {
        var removeId = $scope.peoples[index].AppUser.id + ",";
        roomService.removeModerator($stateParams.roomId, removeId).then(function (result) {
          if (result.status)
            $scope.peoples[index].UsersClassroom.is_moderator = false;
        });
      };

      $scope.unRestrict = function (index) {
        var removeId = $scope.peoples[index].AppUser.id + ",";
        roomService.unRestrict($stateParams.roomId, removeId).then(function (result) {
          if (result.status)
            $scope.peoples[index].UsersClassroom.is_restricted = false;
        });
      };

      $scope.openModerateDialog = function () {
        modalService.openDialog($scope, 'views/app/rooms/moderatorDialog.html');
      };

      $scope.openRestrictDialog = function () {
        modalService.openDialog($scope, 'views/app/rooms/restrictDialog.html');
      };

      $scope.setModerator = function () {
        var setModIds = $("#ddlModeratorIds").val(); //("val");
        roomService.setModerator($stateParams.roomId, setModIds).then(function (result) {
          if (result.status) {
            angular.forEach($scope.peoples, function (people) {
              if (setModIds.indexOf(people.AppUser.id) != -1) {
                people.UsersClassroom.is_moderator = true;
              }
            });
//            ngDialog.close();
            modalService.closeDialog();
          }

        });
      };

      $scope.setRestricted = function () {
        var setRestrictIds = $("#ddlRestrictedIds").val(); //.select2("val");
        roomService.setRestricted($stateParams.roomId, setRestrictIds).then(function (result) {
          if (result.status) {
            angular.forEach($scope.peoples, function (people) {
              if (setRestrictIds.indexOf(people.AppUser.id) != -1) {
                people.UsersClassroom.is_restricted = true;
              }
            });
            modalService.closeDialog();
//            ngDialog.close();
          }

        });
      };

    }]);