angular.module('uiApp')
  .controller('reportCtrl', ['$scope', '$stateParams' , 'roomService',
    function ($scope, $stateParams, roomService) {
      $scope.roomId = $stateParams.roomId;
      roomService.getReports($scope.roomId).then(function (result) {
        if (result.status)
          $scope.haveAccess = result.permissions.allowCreate;
      });
    }]);