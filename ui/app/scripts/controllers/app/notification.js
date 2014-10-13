angular.module('uiApp')
  .controller('notificationCtrl', ['$scope', 'notificationService', 'globalService',
    function ($scope, notificationService, globalService) {
      $scope.vm = {};
      $scope.vm.url = globalService.getBaseUrl();
      notificationService.getNotifications().then(function (result) {
        $scope.vm.notifications = result;
      });

    }]);