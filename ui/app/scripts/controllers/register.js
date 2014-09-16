/**
 * Created by himanshu on 16/9/14.
 */
angular.module('uiApp')
  .controller('registerCtrl', ['$scope', '$stateParams' , 'roomService', 'notificationService', 'modalService',
    function ($scope, $stateParams, roomService, notificationService, modalService) {

      $scope.vm = {};

      $scope.vm.password = "";
      $scope.vm.confirmPassword = "";

    }]);

