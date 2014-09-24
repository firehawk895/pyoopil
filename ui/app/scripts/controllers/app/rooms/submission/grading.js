angular.module('uiApp')
  .controller('gradingCtrl', ['$scope', '$stateParams' , 'roomService', 'notificationService', 'modalService', 'ngDialog', 'localStorageService', '$state',
    function ($scope, $stateParams, roomService, notificationService, modalService, ngDialog, localStorageService, $state) {
      roomService.getGradeSubmissions($stateParams.roomId, $stateParams.assignmentId, $scope.page).then(function (result) {
        $scope.gradeSubmissions = result.data;

      });
      $scope.updatePage = function () {
        if (!$scope.pageEnd) {
          roomService.getGradeSubmissions($stateParams.roomId, $stateParams.assignmentId, ++$scope.page).then(function (result) {
            if (!result.data.length)
              $scope.pageEnd = true;
            else
              $scope.gradeSubmissions = $scope.gradeSubmissions.concat(result.data);
          });
        }
      };

    }]);