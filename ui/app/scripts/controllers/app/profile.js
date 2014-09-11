angular.module('uiApp')
  .controller('profileCtrl', ['$scope', '$stateParams' , 'roomService', 'notificationService','localStorageService',
    function ($scope, $stateParams, roomService, notificationService,localStorageService) {
      $scope.fullName = localStorageService.get("name");
    }]);
