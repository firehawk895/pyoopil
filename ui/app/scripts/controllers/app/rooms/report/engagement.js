angular.module('uiApp')
  .controller('engagementCtrl', ['$scope', '$stateParams' , 'roomService', 'notificationService', 'modalService', 'ngDialog', 'localStorageService', '$state',
    function ($scope, $stateParams, roomService, notificationService, modalService, ngDialog, localStorageService, $state) {
      $scope.vm = {};
      $scope.roomId = $stateParams.roomId;
      roomService.getEngagementReports($scope.roomId).then(function (result) {
//        if (result.status) {
        $scope.engagementReport = result.data;
        $scope.haveAccess = result.permissions.allowCreate;
        $scope.vm.gold = result.gold;
        $scope.vm.silver = result.silver;
        $scope.vm.bronze = result.bronze;
        $scope.vm.allStudents = $scope.vm.gold.concat($scope.vm.silver, $scope.vm.bronze);
        $scope.vm.gold.viewAll = false;
        $scope.vm.silver.viewAll = false;
        $scope.vm.bronze.viewAll = false;
//        }
      });

      $scope.showAll = function (type) {
        if (type == 'gold') {
          $scope.vm.gold.viewAll = !$scope.vm.gold.viewAll;
          $scope.vm.silver.viewAll = false;
          $scope.vm.bronze.viewAll = false;
        }
        else if (type == 'silver') {
          $scope.vm.silver.viewAll = !$scope.vm.silver.viewAll;
          $scope.vm.gold.viewAll = false;
          $scope.vm.bronze.viewAll = false;
        }
        else if (type == 'bronze') {
          $scope.vm.bronze.viewAll = !$scope.vm.bronze.viewAll;
          $scope.vm.silver.viewAll = false;
          $scope.vm.gold.viewAll = false;
        }
      }
    }]);