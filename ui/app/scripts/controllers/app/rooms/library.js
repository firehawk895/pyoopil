/**
 * Created by himanshu on 21/8/14.
 */
angular.module('uiApp')
  .controller('libraryCtrl', ['$scope', '$stateParams' , 'roomService', 'notificationService','ngDialog',
    function ($scope, $stateParams, roomService, notificationService,ngDialog) {

      $scope.people = {};
      $scope.page = 1;

      $scope.roomId = $stateParams.roomId;

      roomService.getPeoples($stateParams.roomId, $scope.page).then(function (result) {
        $scope.peoples = result.data;
        $scope.canModerate = result.permissions.CUDModerator;
        $scope.canRestrict = result.permissions.CUDRestricted;
      });

      $scope.myPagingFunction = function () {
        roomService.getPeoples($stateParams.roomId, ++$scope.page).then(function (result) {
          $scope.peoples = $scope.peoples.concat(result.data);
        });
      };

      $scope.unRestrict = function (id) {
        roomService.unRestrict().then(function (result) {
          if (result.status) {
          }
        });
      };
      $scope.openModerateDialog=function(){
        ngDialog.open({
          template: 'views/app/rooms/moderatorDialog.html',
          scope: $scope,
          className: 'ngdialog-theme-default'
        });
      };
      $scope.openRestrictDialog=function(){
        ngDialog.open({
          template: 'views/app/rooms/restrictDialog.html',
          scope: $scope,
          className: 'ngdialog-theme-default'
        });
      };
      $scope.openMessage=function(){
        ngDialog.open({
          template: 'views/app/rooms/openmessage.html',
          scope: $scope,
          className: 'ngdialog-theme-default'
        });
      };
      $scope.openRecommend=function(){
        ngDialog.open({
          template: 'views/app/rooms/openrecommend.html',
          scope: $scope,
          className: 'ngdialog-theme-default'
        });
      };
    }]);