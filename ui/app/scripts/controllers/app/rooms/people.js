/**
 * Created by himanshu on 21/8/14.
 */
angular.module('uiApp')
  .controller('peopleCtrl', ['$scope', '$stateParams' , 'roomService', 'notificationService', 'ngDialog',
    function ($scope, $stateParams, roomService, notificationService, ngDialog) {

      $scope.people = {};
      $scope.page = 1;
      $scope.dataTag = [];
      $scope.roomId = $stateParams.roomId;

      $scope.list_of_string = [];

      roomService.getPeoples($stateParams.roomId, $scope.page).then(function (result) {
        $scope.peoples = result.data;
        $scope.canModerate = result.permissions.CUDModerator;
        $scope.canRestrict = result.permissions.CUDRestricted;
        angular.forEach(result.data, function (peopleData) {
          $scope.dataTag.push(peopleData.AppUser.fname);
        });
      });


      $scope.select2Options = {
        'multiple': true,
        'simple_tags': true,
        'tags': $scope.dataTag
      };


      $scope.myPagingFunction = function () {
        roomService.getPeoples($stateParams.roomId, ++$scope.page).then(function (result) {
          $scope.peoples = $scope.peoples.concat(result.data);

          angular.forEach(result.data, function (peopleData) {
            $scope.dataTag.push(peopleData.AppUser.fname);
          });
        });
      };

      $scope.unRestrict = function (id) {
        roomService.unRestrict().then(function (result) {
          if (result.status) {
          }
        });
      };
      $scope.openModerate = function () {
        ngDialog.open({
          template: 'views/app/rooms/openmoderator.html',
          scope: $scope,
          className: 'ngdialog-theme-default'
        });
      };
      $scope.openRestrict = function () {
        ngDialog.open({
          template: 'views/app/rooms/openrestrict.html',
          scope: $scope,
          className: 'ngdialog-theme-default'
        });
      };
      $scope.openMessage = function () {
        ngDialog.open({
          template: 'views/app/rooms/openmessage.html',
          scope: $scope,
          className: 'ngdialog-theme-default'
        });
      };

      $scope.openRecommend = function () {
        ngDialog.open({
          template: 'views/app/rooms/openrecommend.html',
          scope: $scope,
          className: 'ngdialog-theme-default'
        });
      };

      $scope.recommend = function () {
        console.log($scope.list_of_string);
      }

    }]);