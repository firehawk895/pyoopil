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
    'ui.select2'
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
      $locationProvider.html5Mode(true);
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
          url: "/app/",
          templateUrl: "views/app/app.html"
        })
        .state('app.rooms', {
          url: "rooms/",
          abstract: true,
          templateUrl: "views/app/rooms/room.html"

        })
        .state('app.rooms.announcements', {
          url: ":roomId/announcements/",
          templateUrl: "views/app/rooms/announcement.html",
          controller: "announcementCtrl"
        })
        .state('app.rooms.library', {
          url: ":roomId/library/",
          templateUrl: "views/app/rooms/library.html",
          controller: "libraryCtrl"
        })
        .state('app.rooms.people', {
          url: ":roomId/people/",
          templateUrl: "views/app/rooms/people.html",
          controller: "peopleCtrl"
        })
        .state('app.roomsDash', {
          url: "roomsDash/",
          templateUrl: "views/app/roomsDash/roomsdash.html",
          controller: "myRoomCtrl"
        })
        .state('app.roomsDash.myroom', {
          url: "myroom/",
          templateUrl: "views/app/roomsDash/myroom.html",
          controller: "myRoomCtrl"
        })
        .state('app.roomsDash.staffroom', {
          url: "staffroom/",
          templateUrl: "views/app/roomsDash/staffroom.html"
//          controller: "myRoomCtrl"
        })
        .state('app.roomsDash.archived', {
          url: "archived/",
          templateUrl: "views/app/roomsDash/archived.html"
//          controller: "myRoomCtrl"
        })

        .state('logout', {
          url: "/logout/",
          templateUrl: "views/app/logout.html"
//                controller: "logOutCtrl"
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
//        $location.path('/app/rooms/');
//      }

//      $idle.watch();
    }])
  .directive('uiLeftScroll', ['$timeout', function ($timeout) {
    return {
      restrict: 'AE',
      scope: {
        ngModel: '='
      },
      templateUrl: 'views/directives/ui-left-scroll.html',
      link: function (scope, element) {
        var model = element.attr("ng-model");

        scope.$watch(model, function (o, n) {
          $timeout(function () {
            setSlider(element);

            if (model.length < 4) {
              element.css('min-height', '200px')
            }

          }, 100);
        });
      }
    };
  }])
  .directive('uiDatePicker', ['$timeout', function ($timeout) {
    return{
      restrict: 'A',
      link: function (scope, element) {
        scope.watch()
      }

    }
  }])
;
