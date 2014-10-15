angular.module('uiApp')
  .controller('accountSettingsCtrl', ['$scope', '$stateParams' , 'roomService', 'toastService', 'modalService',
    function ($scope, $stateParams, roomService, toastService, modalService) {
      $scope.vm = {};
      $scope.vm.editEmail = false;
      $scope.vm.editPassword = false;
      $scope.vm.currentPassword = "";
      $scope.vm.password = "";
      $scope.vm.confirmPassword = "";
      roomService.getAccount().then(function (result) {
        if (result.status)
          $scope.vm.email = result.data.AppUser.email;
        $scope.vm.newEmail = $scope.vm.email;
      });
      $scope.updateEmail = function () {
        roomService.updateEmail($scope.vm.newEmail).then(function (result) {
          if (result.status) {
            $scope.vm.editEmail = false;
            toastService.show(result.status, result.message);
            $scope.vm.email = $scope.vm.newEmail;
            modalService.openDialog($scope, 'views/app/profile/emailChanged.html');
          }
          else {
            var errorKey = Object.keys(result.message)[0];
            toastService.show(result.status, result.message[errorKey][0]);
          }
        });
      };
      $scope.updatePassword = function () {
        roomService.updatePassword($scope.vm.currentPassword, $scope.vm.password, $scope.vm.confirmPassword).then(function (result) {
          if (result.status) {
            $scope.vm.editPassword = false;
            $scope.vm.currentPassword = "";
            $scope.vm.password = "";
            $scope.vm.confirmPassword = "";
            toastService.show(result.status, result.message);
            modalService.openDialog($scope, 'views/app/profile/passwordChanged.html');
          }
          else {
            var errorKey = Object.keys(result.message)[0];
            toastService.show(result.status, result.message[errorKey][0]);
          }
        });
      };
      $scope.cancelPasswordChange = function () {
        $scope.vm.editPassword = false;
        $scope.vm.currentPassword = "";
        $scope.vm.password = "";
        $scope.vm.confirmPassword = "";
      };
    }]);