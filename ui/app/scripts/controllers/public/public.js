angular.module('uiApp')
    .controller('publicCtrl', ['$scope', '$location', 'userService', 'ngDialog', 'notificationService', 'localStorageService', '$http','authService',
        function ($scope, $location, userService, ngDialog, notificationService, localStorageService, $http,authService) {
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
                        $http.defaults.headers.common = {'X-AuthTokenHeader': result.data.auth_token};
                        localStorageService.add("token", result.data.auth_token);
                        authService.loginConfirmed(result.data.auth_token);
                        //redirect to rooms on successful login
                        $location.path('/app/roomsDash/');
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
