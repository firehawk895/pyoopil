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
        'ngTouch',
        'infinite-scroll'
    ])
    .config(['$stateProvider', '$urlRouterProvider', '$locationProvider', function ($stateProvider, $urlRouterProvider, $locationProvider) {

        $locationProvider.html5Mode(true);
        $urlRouterProvider.otherwise("/rooms/");
        //
        // Now set up the states
        $stateProvider
            .state('rooms', {
                url: "/rooms/",
                templateUrl: "views/rooms/index.html",
                controller:"myRoomCtrl"
            })
            .state('login', {
                url: "/login/",
                templateUrl: "views/home/login.html",
                controller: "LoginCtrl"
            })
            .state('announcements', {
                url: "/rooms/:roomId/announcements/",
                templateUrl: "views/rooms/announcement.html",
                controller: "announcementCtrl"
            });
    }])
    .controller('MainController', ['$scope', 'globalService', function ($scope, globalService) {
        $scope.isLoggedIn = globalService.getIsAuthorised();

    }])
    //main run module for the whole application
    .run(['$http', 'globalService', 'Restangular',
        function ($http, globalService, restangular) {

            //set base path for restangular
            restangular.setBaseUrl(globalService.getBaseUrl());

            $http.defaults.headers.common = {'X-AuthTokenHeader': '53f2f038-e8d4-47d3-a681-03f90130a31c'};

//      userService.validateSession();
//      $idle.watch();
        }])
;
