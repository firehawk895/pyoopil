angular.module('uiApp')
    .controller('publicCtrl', ['$scope', '$location', 'userService', 'ngDialog', 'notificationService', function ($scope, $location, userService, ngDialog, notificationService) {

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
                    //redirect to rooms on successful login
                    $location.path('/app/rooms/');
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
