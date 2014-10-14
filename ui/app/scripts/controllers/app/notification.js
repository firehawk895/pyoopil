angular.module('uiApp')
  .controller('notificationCtrl', ['$scope', 'notificationService', 'globalService', '$location',
    function ($scope, notificationService, globalService, $location) {
      $scope.vm = {};
      $scope.vm.url = globalService.getBaseUrl();
      notificationService.getNotifications().then(function (result) {
        $scope.vm.notifications = result;
      });

      $scope.openNotification = function (index) {
        $location.path($scope.vm.url + '/' + $scope.vm.notifications[index].link);
        $scope.vm.notifications[index].is_clicked = true;
        notificationService.setClicked(index);
      };

    }]);