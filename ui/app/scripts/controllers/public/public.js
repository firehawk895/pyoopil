angular.module('uiApp')
  .controller('publicCtrl', ['$scope', '$location', 'userService', 'ngDialog', 'notificationService', 'localStorageService', '$http', 'authService',
    function ($scope, $location, userService, ngDialog, notificationService, localStorageService, $http, authService) {
      $scope.openLogin = function () {
        ngDialog.open({
          template: 'views/public/login.html',
          scope: $scope,
          className: 'ngdialog-theme-default'
        });
      };
      $scope.model = {};
      $scope.doLogin = function () {
        userService.login($scope.model).then(function (result) {
          notificationService.show(result.status, result.message);
          if (result.status) {
            ngDialog.close();
            localStorageService.add("token", result.data.auth_token);
            userService.validateSession();
            authService.loginConfirmed(result.data.auth_token);
            console.log(result.data.auth_token);
            //redirect to rooms on successful login
            $location.path('/app/roomsDash/myroom/');
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
