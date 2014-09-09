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
    'ngDialog',
    'http-auth-interceptor',
    'ui.utils',
    'ui.select2',
    'angular-loading-bar',
    'highcharts-ng',
    'ngCkeditor'
  ])
  .config(['$stateProvider', '$urlRouterProvider', '$locationProvider', 'ngDialogProvider', '$httpProvider',
    function ($stateProvider, $urlRouterProvider, $locationProvider, ngDialogProvider, $httpProvider) {

      $httpProvider.interceptors.push(['$q', '$window', function ($q, $window) {
        return {
          'responseError': function (response) {
            //if status code is 404 / 403, redirect to respective pages
            // todo: implement this
            if (response.status == 404) {
              $window.location.href = '/';
            }
            else if (response.status == 403) {
              $window.location.href = '/';
            }

            return $q.reject(response);
          }
        };
      }]);
//      $locationProvider.html5Mode(true);
      $urlRouterProvider.otherwise("/");
      //
      // Now set up the states
      ngDialogProvider.setDefaults({
        showClose: false
      });


      $stateProvider
        .state('public', {
          url: "/",
          templateUrl: "views/public/public.html",
          controller: "publicCtrl"
        })
        .state('app', {
          abstract: true,
          url: "/app/",
          templateUrl: "views/app/app.html"
        })
        .state('app.rooms', {
          url: "rooms/:roomId/",
          abstract: true,
          templateUrl: "views/app/rooms/room.html"

        })
        .state('app.rooms.discussions', {
          url: "discussions/",
          templateUrl: "views/app/rooms/discussion.html",
          controller: "discussionCtrl"
        })
        .state('app.rooms.announcements', {
          url: "announcements/",
          templateUrl: "views/app/rooms/announcement.html",
          controller: "announcementCtrl"
        })
        .state('app.rooms.library', {
          url: "library/",
          templateUrl: "views/app/rooms/library.html",
          controller: "libraryCtrl"
        })
        .state('app.rooms.people', {
          url: "people/",
          templateUrl: "views/app/rooms/people.html",
          controller: "peopleCtrl"
        })
        .state('app.roomsDash', {
          url: "room/",
          templateUrl: "views/app/roomsDash/roomsdash.html",
          controller: "myRoomCtrl"
        })
        .state('app.roomsDash.myroom', {
          url: "my/",
          templateUrl: "views/app/roomsDash/myroom.html",
          controller: "myRoomCtrl"
        })
//        .state('app.roomsDash.staffroom', {
//          url: "staffroom/",
//          templateUrl: "views/app/roomsDash/staffroom.html"
////          controller: "myRoomCtrl"
//        })
//        .state('app.roomsDash.archived', {
//          url: "archived/",
//          templateUrl: "views/app/roomsDash/archived.html"
////          controller: "myRoomCtrl"
//        })

        .state('logout', {
          url: "/logout/",
          templateUrl: "views/app/logout.html",
          controller: "publicCtrl"
        });

    }])
  .controller('MainController', ['$scope', 'globalService', function ($scope, globalService) {
    $scope.isLoggedIn = globalService.getIsAuthorised();
    $scope.showScroll = false;

    $scope.showScroller = function () {
      $scope.showScroll = true;
    };

    $scope.hideScroller = function () {
      $scope.showScroll = false;
    };


  }])
  //main run module for the whole application
  .run(['$http', 'globalService', 'Restangular', 'userService', '$location',
    function ($http, globalService, restangular, userService, $location) {

      //set base path for restangular
      restangular.setBaseUrl(globalService.getBaseUrl());
      userService.validateSession();

//      if (globalService.getIsAuthorised()) {
//        $location.path('/app/room/my/');
//      }
//      else
//        $location.path('/');


//      $idle.watch();
    }])
  .filter('unsafe', function ($sce) {

    return function (val) {

      return $sce.trustAsHtml(val);

    };

  });

