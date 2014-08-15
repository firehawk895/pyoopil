'use strict';

/**
 * @ngdoc overview
 * @name uiApp
 * @description
 * # uiApp
 *
 * Main module of the application.
 */
angular
  .module('uiApp', [
    'ngAnimate',
    'ngCookies',
    'ngResource',
    'ui.router',
    'ngSanitize',
    'restangular',
    'LocalStorageModule',
    'ngTouch'
  ])
  .config(['$stateProvider', '$urlRouterProvider', '$locationProvider', function ($stateProvider, $urlRouterProvider, $locationProvider) {

    $locationProvider.html5Mode(true);
    $urlRouterProvider.otherwise("/rooms");
    //
    // Now set up the states
    $stateProvider
      .state('rooms', {
        url: "/rooms/",
        templateUrl: "views/rooms/index.html"
      })
      .state('login', {
        url: "/login/",
        templateUrl: "views/home/login.html",
        controller: "LoginCtrl"
      });
  }])
  .controller('MainController', ['$scope', 'globalService', function ($scope, globalService) {
    $scope.isLoggedIn = globalService.getIsAuthorised();

  }])
  //main run module for the whole application
  .run(['$http', 'globalService', 'Restangular',
    function ($http, globalService, restangular) {

      $http.defaults.useXDomain = true;

      //set base path for restangular
      restangular.setBaseUrl(globalService.getBaseUrl());
//      userService.validateSession();
//      $idle.watch();
    }])
;
