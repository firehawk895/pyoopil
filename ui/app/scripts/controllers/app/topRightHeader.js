angular.module('uiApp')
  .controller('topRightHeaderCtrl', ['$scope', 'notificationService', 'globalService', '$location',
    function ($scope, notificationService, globalService, $location) {
      $scope.vm = {};
      $scope.vm.showNotificationPanel = false;
      $scope.vm.url = globalService.getBaseUrl();
      notificationService.getUnreadNotificationsCount().then(function (result) {
        result.$bindTo($scope, 'vm.unreadNotificationsCount'); //3 way binding
      });
      $scope.getInitialNotifications = function () {
        $scope.vm.showNotificationPanel = true;
        notificationService.getInitialNotifications().then(function (result) {
          $scope.vm.initialNotifications = result;
        });
      };

      $scope.openNotification = function (index) {
        $location.path('/' + $scope.vm.initialNotifications[index].link + '/');
        $scope.vm.initialNotifications[index].is_clicked = true;
        notificationService.setClickedInitial(index);
      };

    }]);