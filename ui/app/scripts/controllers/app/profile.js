angular.module('uiApp')
  .controller('profileCtrl', ['$scope', '$stateParams' , 'roomService', 'notificationService', 'modalService', 'ngDialog',
    function ($scope, $stateParams, roomService, notificationService, modalService, ngDialog) {
      $scope.vm = {};
      $scope.vm.editProfile = false;
      $scope.vm.editFullProfile = false;
      roomService.getProfile().then(function (result) {
        if (result.status) {
          $scope.profile = result.data.AppUser;
        }
      });
      $scope.openLeftEditDialog = function () {
        $scope.vm = {};
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
      $scope.editFullProfile = function () {
        $scope.vm = jQuery.extend({}, $scope.profile);
        $scope.vm.editFullProfile = true;
      };
      $scope.cancelEditProfile = function () {
        $scope.profile = jQuery.extend({}, $scope.vm);
      };
      $scope.saveFullProfile = function () {
        roomService.saveFullProfile($scope.profile.mobile, $scope.profile.university_assoc, $scope.profile.location_full,
          $scope.profile.facebook_link, $scope.profile.twitter_link, $scope.profile.linkedin_link).then(function (result) {
            if (result.status)
              $scope.profile = result.data.AppUser;
          });
      };

      $scope.vm.image = '';
      $scope.vm.croppedImage = '';
      $scope.file_changed = function (element) {
        var photofile = element.files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
          $scope.$apply(function () {
            $scope.vm.image = e.target.result;
          });
        };
        reader.readAsDataURL(photofile);
        ngDialog.open({
          template: 'views/app/profile/profilePicCropDialog.html',
          scope: $scope
        });
      };
      $scope.uploadPic = function () {

      }
    }])
  .filter('NA', function () {
    return function (val, date) {
      if (date)
        return val || '03/17/1989';
      else
        return val || 'No Information Available';
    }
  });
