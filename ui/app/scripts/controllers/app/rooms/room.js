angular.module('uiApp')
  .controller('roomCtrl', ['$scope', '$stateParams' , 'roomService', 'notificationService', 'ngDialog', '$sce', 'modalService',
    function ($scope, $stateParams, roomService, notificationService, ngDialog, $sce, modalService) {
      $scope.vm = {};
      $scope.roomId = $stateParams.roomId;
      $scope.vm.showInfoPopup = false;

      roomService.getClassInfo($scope.roomId).then(function (result) {
        if (result.status) {
          $scope.classInfo = result.data;
        }
      });
      $scope.resetAccessCode = function () {
        roomService.resetAccessCode($scope.roomId).then(function (result) {
          notificationService.show(result.status, result.message);
          if (result.status) {
            $scope.vm.showInfoPopup = false;
            $scope.resetClass = result.data;
            ngDialog.open({
              template: 'views/app/rooms/resetDialog.html',
              scope: $scope
            });
          }
        });
      };
      $scope.showClassInfo = function () {
        ngDialog.open({
          template: 'views/app/rooms/classInfo.html',
          scope: $scope
        });
      };
    }]);