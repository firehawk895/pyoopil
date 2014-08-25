'use strict';

/**
 * @ngdoc function
 * @name uiApp.controller:LoginCtrl
 * @description
 * # LoginCtrl
 * Controller of the uiApp
 */
angular.module('uiApp')
    .controller('LoginCtrl', ['$scope', '$location', 'userService', 'ngDialog', function ($scope, $location, userService, ngDialog) {
        $scope.name="Him";
        $scope.openLogin = function () {
            ngDialog.open({
                template: 'views/home/login.html',
                scope: $scope,
                className: 'ngdialog-theme-default'
            });
        };

        $scope.doLogin = function (model) {


            userService.login(model.email, model.password).then(function (result) {


        if (result.status) {

          //redirect to rooms on successful login
          $location.path('/app/rooms');

        }
            }, function (error) {
                //todo: log error
            });
        }
    }]);


//angular.module('uiApp')
//  .controller('LoginCtrl', ['$scope', '$location', 'userService', function ($scope, $location, userService) {
//    $scope.doLogin = function (model) {
//      userService.login(model.email, model.password).then(function (result) {
//        if (result.status) {
//
//          //redirect to rooms on successful login
//          $location.path('/rooms');
//
//        }
//      });
//    }
//  }]);
