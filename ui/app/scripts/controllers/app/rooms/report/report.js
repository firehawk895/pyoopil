angular.module('uiApp')
  .controller('reportCtrl', ['$scope', '$stateParams' , 'roomService', 'notificationService', 'modalService', 'ngDialog', 'localStorageService', '$state',
    function ($scope, $stateParams, roomService, notificationService, modalService, ngDialog, localStorageService, $state) {
      $scope.roomId = $stateParams.roomId;
      roomService.getReports($scope.roomId).then(function (result) {
        if (result.status)
          $scope.haveAccess = result.permissions.allowCreate;
      });
    }]);