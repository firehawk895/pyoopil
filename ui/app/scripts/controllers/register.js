/**
 * Created by himanshu on 16/9/14.
 */
angular.module('uiApp')
  .controller('registerCtrl', ['$scope', function ($scope) {

    $scope.vm = {};

    $scope.vm.password = "";
    $scope.vm.confirmPassword = "";

  }]);

