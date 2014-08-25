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
    .config(['$stateProvider', '$urlRouterProvider', '$locationProvider', 'ngDialogProvider', function ($stateProvider, $urlRouterProvider, $locationProvider, ngDialogProvider) {

        $locationProvider.html5Mode(true);
        $urlRouterProvider.otherwise("/public/");
        //
        // Now set up the states
        ngDialogProvider.setDefaults({
            showClose: false
        });


        $stateProvider
            .state('public', {
                url: "/public/",
                templateUrl: "views/public/public.html",
                controller:"publicCtrl"
            })
            .state('app', {
                url: "/app/",
                templateUrl: "views/app/app.html"
            })
            .state('app.rooms', {
                url: "rooms/",
                templateUrl: "views/app/rooms/room.html",
                controller: "myRoomCtrl"
            })
            .state('app.staffroom', {
                url: "staffroom/",
                templateUrl: "views/app/rooms/staffroom.html",
                controller: "myRoomCtrl"
            })
            .state('app.archived', {
                url: "archived/",
                templateUrl: "views/app/rooms/archived.html",
                controller: "myRoomCtrl"
            })
//
            .state('app.rooms.announcements', {
                url: ":roomId/announcements/",
                templateUrl: "views/app/rooms/announcement.html",
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

            $http.defaults.headers.common = {'X-AuthTokenHeader': '53fac647-53b0-40da-b988-04850130a31c'};

//      userService.validateSession();
//      $idle.watch();
        }])
;
