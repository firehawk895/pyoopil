angular.module('uiApp')
  .controller('publicCtrl', ['$scope', '$location', 'userService', 'ngDialog', 'notificationService', 'localStorageService', '$http', 'authService', 'globalService',
    function ($scope, $location, userService, ngDialog, notificationService, localStorageService, $http, authService, globalService) {

      if (globalService.getIsAuthorised())
        $location.path('/app/room/my/');


      $scope.openLogin = function () {
        ngDialog.open({
          template: 'views/public/login.html',
          scope: $scope,
          className: 'ngdialog-theme-default'
        });
      };
      $scope.vm = {};
      $scope.vm.email = "";
      $scope.vm.password = "";
      $scope.doLogin = function () {
        userService.login($scope.vm.email, $scope.vm.password).then(function (result) {
          notificationService.show(result.status, result.message);
          if (result.status) {
            ngDialog.close();
            localStorageService.add("token", result.data.auth_token);
            userService.validateSession();
            authService.loginConfirmed(result.data.auth_token);
            console.log(result.data.auth_token);
            //redirect to rooms on successful login
            $location.path('/app/room/my/');
          }
        }, function (error) {
          //todo: log error
        });
      };
      $scope.openSignUp = function () {
        ngDialog.open({
          template: 'views/public/signup.html',
          scope: $scope,
          className: 'ngdialog-theme-default'
        });
      };

    }]);
