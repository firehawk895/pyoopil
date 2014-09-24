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
    'ngCkeditor',
    'ui.bootstrap',
    'angularMoment',
    'ngImgCrop'
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
        .state('register', {
          url: '/register/',
          templateUrl: 'views/public/register.html',
          controller: "registerCtrl"
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
          abstract: true,
          url: "discussions/",
          templateUrl: "views/app/rooms/discussion/discussion.html",
          controller: "discussionCtrl"
        })
        .state('app.rooms.discussions.all', {
          url: "all/",
          templateUrl: "views/app/rooms/discussion/allDiscussion.html",
          controller: "allDiscussionCtrl"
        })
        .state('app.rooms.discussions.folded', {
          url: "folded/",
          templateUrl: "views/app/rooms/discussion/foldedDiscussion.html",
          controller: "foldedDiscussionCtrl"
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
        .state('app.rooms.submissions', {
          abstract: true,
          url: "submissions/",
          templateUrl: "views/app/rooms/submission.html",
          controller: "submissionCtrl"
        })
        .state('app.rooms.submissions.main', {
          url: "",
          templateUrl: "views/app/rooms/submissionMain.html"
        })
        .state('app.rooms.submissions.grading', {
          url: ":assignmentId/",
          templateUrl: "views/app/rooms/grading.html",
          controller: 'gradingCtrl'
        })
        .state('app.roomsDash', {
          url: "room/",
          templateUrl: "views/app/roomsDash/roomsdash.html",
          controller: "myRoomCtrl"
        })
        .state('app.roomsDash.myroom', {
          url: "my/",
          templateUrl: "views/app/roomsDash/myroom.html"
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
        })
        .state('app.profile', {
          url: "profile/",
          abstract: true,
          templateUrl: "views/app/profile/profile.html",
          controller: "profileCtrl"
        })
        .state('app.profile.my', {
          url: 'my/',
          templateUrl: "views/app/profile/myProfile.html"
        })
        .state('app.profile.feedback', {
          url: 'feedback/',
          templateUrl: "views/app/profile/feedback.html"
        });

    }])
//  .constant('angularMomentConfig', {
//    preprocess: 'unix', // optional
//    timezone: 'Asia/Kolkata' // optional
//  })
  .controller('MainController', ['$scope', 'globalService', function ($scope, globalService) {
    $scope.isLoggedIn = globalService.getIsAuthorised();
    $scope.showScroll = false;

    $scope.showScroller = function () {
      $scope.showScroll = true;
    };

    $scope.hideScroller = function () {
      $scope.showScroll = false;
    };

    $scope.getMimeTypes = function () {
      return ".xlsx,.xltx,.docx,.dotx,.xlam,.xlsb,application/excel,application/vnd.ms-excel,application/x-excel," +
        "application/x-msexcel,application/msword,.potx,.ppsx,.pptx,.sldx" +
        "text/plain,application/pdf,image/bmp,image/cis-cod,image/gif,image/ief,image/jpeg,image/jpeg,image/jpeg," +
        "image/pipeg,image/svg+xml,image/tiff,image/tiff,image/x-cmu-raster,image/x-cmx,image/x-icon," +
        "image/x-portable-anymap,image/x-portable-bitmap,image/x-portable-graymap,image/x-portable-pixmap," +
        "image/x-rgb,image/x-xbitmap,image/x-xpixmap,image/x-xwindowdump,.zip,.rar,audio/mpeg,audio/wav, " +
        "audio/x-wav,video/mpeg,video/msvideo, video/avi, video/x-msvideo,application/x-tar";
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

  })
  .filter('bytes', function () {
    return function (bytes, precision) {
      if (isNaN(parseFloat(bytes)) || !isFinite(bytes)) return '-';
      if (typeof precision === 'undefined') precision = 1;
      var units = ['bytes', 'kB', 'MB', 'GB', 'TB', 'PB'],
        number = Math.floor(Math.log(bytes) / Math.log(1024));
      return (bytes / Math.pow(1024, Math.floor(number))).toFixed(precision) + ' ' + units[number];
    }
  });


