angular.module('uiApp')
  .controller('publicCtrl', ['$scope', '$location', 'userService', 'ngDialog', 'toastService', 'localStorageService', '$http', 'authService', 'globalService', '$auth', '$state',
    function ($scope, $location, userService, ngDialog, toastService, localStorageService, $http, authService, globalService, $auth, $state) {

//      if (globalService.getIsAuthorised())
//        $location.path('/app/room/my/');

      $scope.authenticate = function (provider) {

        $auth.authenticate(provider)
          .then(function () {
            alert("Logged in ");
          })
          .catch(function (response) {
            console.log(response.data);

          });
      };

      $scope.url = globalService.getBaseUrl();
      $scope.openLogin = function () {
        ngDialog.open({
          template: 'views/public/login.html',
          scope: $scope
        });
      };
      $scope.vm = {};
      $scope.vm.email = "";
      $scope.vm.password = "";
      $scope.doLogin = function () {
        userService.login($scope.vm.email, $scope.vm.password).then(function (result) {
          toastService.show(result.status, result.message);
          if (result.status) {
            ngDialog.close();
            localStorageService.add("token", result.data.auth_token);
            localStorageService.add("name", result.data.fullname);
            localStorageService.add("image", result.data.profile_img);
            localStorageService.add("id", result.data.id);
            userService.validateSession();
            authService.loginConfirmed(result.data.auth_token);
            console.log(result.data.auth_token);
            //redirect to rooms on successful login
//            $location.path('/Classroom/my/');
            $state.go('app.roomsDash.myroom');
          }
        }, function (error) {
          //todo: log error
        });
      };
      $scope.openSignUp = function () {
        ngDialog.open({
          template: 'views/public/signup.html',
          scope: $scope
        });
      };
      $scope.goToHome = function (path) {
//        console.log($scope.url+"/#"+path);
        $location.path($scope.url + "/#" + path);
      };

    }]);
