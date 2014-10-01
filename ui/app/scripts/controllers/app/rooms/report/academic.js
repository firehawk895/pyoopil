angular.module('uiApp')
  .controller('academicCtrl', ['$scope', '$stateParams' , 'roomService', 'notificationService', 'modalService', 'ngDialog', 'localStorageService', '$state',
    function ($scope, $stateParams, roomService, notificationService, modalService, ngDialog, localStorageService, $state) {
      $scope.roomId = $stateParams.roomId;
      $scope.lastExpandedItemIndex = -1;
      roomService.getAcademicReport($scope.roomId).then(function (result) {
//        if (result.status) {
        $scope.academicReport = result.data;
        angular.forEach($scope.academicReport, function (value, key) {
          value.showContent = false;
          value.showGraph = false;

        });
//        }
      });
      $scope.displayContent = function (index) {
        if ($scope.lastExpandedItemIndex == -1) {
          $scope.lastExpandedItemIndex = index;
          $scope.academicReport[index].showContent = true;
        }
        else if ($scope.lastExpandedItemIndex == index) {
          $scope.lastExpandedItemIndex = -1;
          $scope.academicReport[index].showContent = false;
        }
        else {
          $scope.academicReport[$scope.lastExpandedItemIndex].showContent = false;
          $scope.academicReport[index].showContent = true;
          $scope.lastExpandedItemIndex = index;
        }
      };

      $scope.lineChartData = [
        {x: 10, y: 15},
        {x: 15, y: 20},
        {x: 12, y: 30}
      ];

      $scope.lineChartConfig = {
        options: {
          chart: {
            type: 'line'
          }
        },
        series: [
          {
            data: $scope.lineChartData
          }
        ],
        title: {
          text: 'Hello'
        },
        loading: false
      };


    }]);