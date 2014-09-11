/**
 * Created by himanshu on 3/9/14.
 */
angular.module('uiApp')
  .controller('discussionCtrl', ['$scope', '$stateParams' , 'roomService', 'notificationService', 'modalService',
    function ($scope, $stateParams, roomService, notificationService, modalService) {
      $scope.roomId = $stateParams.roomId;
      $scope.vm = {};
      $scope.vm.subject = "";
      $scope.vm.body = "";
      $scope.vm.file = null;
      $scope.vm.discussionType = "";
      $scope.choices = [];
      $scope.chartConfig = {};
      $scope.pageEnd = false;
      $scope.vm.answerChoices = [
        {
          choice: "",
          isVisible: true
        },
        {
          choice: "",
          isVisible: true
        }

      ];
    }])
  .
  filter('unsafe', function ($sce) {
    return function (val) {
      return $sce.trustAsHtml(val);
    };

  });
