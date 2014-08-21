'use strict';

/**
 * @ngdoc function
 * @name uiApp.controller:LoginCtrl
 * @description
 * # LoginCtrl
 * Controller of the uiApp
 */
angular.module('uiApp')
  .controller('LoginCtrl', ['$scope', '$location', 'userService', function ($scope, $location, userService) {
    $scope.doLogin = function (model) {
      userService.login(model.email, model.password).then(function (result) {

        console.log(result);

//        if (result.status) {
//
//          //redirect to rooms on successful login
//          $location.path('/rooms');
//
//        }
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
