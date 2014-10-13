angular.module('uiApp')
  .controller('topRightHeaderCtrl', ['$scope', 'notificationService', 'globalService',
    function ($scope, notificationService, globalService) {
      $scope.vm = {};
      $scope.vm.showNotificationPanel = false;
      $scope.vm.url = globalService.getBaseUrl();
      notificationService.getUnreadNotificationsCount().then(function (result) {
        $scope.vm.unreadNotificationsCount = result;
      });

      $scope.getInitialNotifications = function () {
        $scope.vm.showNotificationPanel = true;
        notificationService.getInitialNotifications().then(function (result) {
          $scope.vm.InitialNotifications = result;
        });

      };
    }]);