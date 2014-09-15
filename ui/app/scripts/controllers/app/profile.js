angular.module('uiApp')
  .controller('profileCtrl', ['$scope', '$stateParams' , 'roomService', 'notificationService', 'modalService', 'ngDialog',
    function ($scope, $stateParams, roomService, notificationService, modalService, ngDialog) {
      $scope.vm = {};
      $scope.vm.editProfile = false;
      roomService.getProfile().then(function (result) {
        if (result.status) {
          $scope.profile = result.data.AppUser;
        }
      });
      $scope.openLeftEditDialog = function () {
        $scope.vm = jQuery.extend({}, $scope.profile);
        modalService.openLeftEditDialog($scope);
      };

      $scope.saveMinProfile = function () {
        roomService.saveMinProfile($scope.vm.fname, $scope.vm.lname, $scope.vm.gender, $scope.vm.dob, $scope.vm.location).then(function (result) {
          if (result.status) {
            $scope.profile = result.data.AppUser;
            ngDialog.close();
          }

        });
      };
    }])
  .filter('NA', function () {
    return function (val, date) {
      if (date)
        return val || '03/17/1989';
      else
        return val || 'No Information Available';
    }
  });
