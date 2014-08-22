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
        'infinite-scroll',
        'ngDialog'
    ])
    .config(['$stateProvider', '$urlRouterProvider', '$locationProvider','ngDialogProvider',function ($stateProvider, $urlRouterProvider, $locationProvider,ngDialogProvider) {

        $locationProvider.html5Mode(true);
        $urlRouterProvider.otherwise("/rooms/");
        //
        // Now set up the states
        ngDialogProvider.setDefaults({
            showClose: false
        });


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

            $http.defaults.headers.common = {'X-AuthTokenHeader': '53f6d1ad-5d84-4c84-8bb1-04b20130a31c'};

//      userService.validateSession();
//      $idle.watch();
        }])
;
