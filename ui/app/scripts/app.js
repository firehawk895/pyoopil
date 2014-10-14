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
    'ngImgCrop',
    'timer',
    'satellizer',
    'offClick',
    'localytics.directives',
    'firebase'

  ])
  .config(['$stateProvider', '$urlRouterProvider', '$locationProvider', 'ngDialogProvider', '$httpProvider', '$authProvider',
    function ($stateProvider, $urlRouterProvider, $locationProvider, ngDialogProvider, $httpProvider, $authProvider) {

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
        showClose: false,
        closeByDocument: false
      });

      $authProvider.facebook({
        clientId: '1461772397445027'
      });

      $authProvider.google({
        clientId: '70596844330-v0ntmjak769bbim9bri47n6f41udnlhf.apps.googleusercontent.com'
      });

//creating states or routes for the app
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
          url: "/",
          templateUrl: "views/app/app.html"
        })
        .state('app.notifications', {
          url: "notifications/",
          templateUrl: "views/app/notification.html",
          controller: 'notificationCtrl'
        })
        .state('app.rooms', {
          url: "Classrooms/:roomId/",
          abstract: true,
          templateUrl: "views/app/rooms/room.html",
          controller: 'roomCtrl'
        })
        .state('app.rooms.discussions', {
          abstract: true,
          url: "discussions/",
          templateUrl: "views/app/rooms/discussion/discussion.html",
          controller: "discussionCtrl"
        })
        .state('app.rooms.discussions.all', {
          url: "",
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
          templateUrl: "views/app/rooms/submission/submission.html",
          controller: "submissionCtrl"
        })
        .state('app.rooms.submissions.main', {
          url: "",
          templateUrl: "views/app/rooms/submission/submissionMain.html"
        })
        .state('app.rooms.submissions.grading', {
          url: ":assignmentId/",
          templateUrl: "views/app/rooms/submission/grading.html",
          controller: 'gradingCtrl'
        })
        .state('app.rooms.reports', {
          abstract: true,
          url: "reports/",
          templateUrl: "views/app/rooms/report/report.html"
        })
        .state('app.rooms.reports.main', {
          abstract: true,
          url: "",
          templateUrl: "views/app/rooms/report/reportMain.html",
          controller: "reportCtrl"
        })
        .state('app.rooms.reports.main.view', {
          url: "",
          templateUrl: "views/app/rooms/report/reportView.html"
        })
        .state('app.rooms.reports.main.create', {
          url: "create/",
          templateUrl: "views/app/rooms/report/reportCreate.html"
        })
        .state('app.rooms.reports.main.takeAttendance', {
          url: "takeAttendance/",
          templateUrl: "views/app/rooms/report/reportAttendance.html",
          controller: 'takeAttendanceCtrl'
        })
        .state('app.rooms.reports.engagement', {
          url: "engagement/",
          templateUrl: "views/app/rooms/report/engagement.html",
          controller: 'engagementCtrl'
        })
        .state('app.rooms.reports.academic', {
          url: "academic/",
          templateUrl: "views/app/rooms/report/academic.html",
          controller: 'academicCtrl'
        })
        .state('app.rooms.reports.attendance', {
          url: "attendance/",
          templateUrl: "views/app/rooms/report/attendance.html",
          controller: 'attendanceCtrl'
        })
        .state('app.roomsDash', {
          abstract: true,
          url: "Classroom/",
          templateUrl: "views/app/roomsDash/roomsdash.html",
          controller: "myRoomCtrl"
        })
        .state('app.roomsDash.myroom', {
          url: "",
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
          url: "myprofile/",
          abstract: true,
          templateUrl: "views/app/profile/profile.html",
          controller: "profileCtrl"
        })
        .state('app.profile.my', {
          url: '',
          templateUrl: "views/app/profile/myProfile.html"
        })
        .state('app.profile.feedback', {
          url: 'feedback/',
          templateUrl: "views/app/profile/feedback.html"
        })
        .state('app.publicProfile', {
          url: 'profile/',
          templateUrl: "views/app/profile/publicProfile.html"
        });

    }])
//  .constant('angularMomentConfig', {
//    preprocess: 'unix', // optional
//    timezone: 'Asia/Kolkata' // optional
//  })
  .controller('MainController', ['$scope', 'globalService', '$window', function ($scope, globalService, $window) {
    $scope.isLoggedIn = globalService.getIsAuthorised();

    $scope.a3 = $window.innerHeight;
    $scope.w1 = $window.innerWidth;
    $scope.w2 = $scope.w1 - 575;
    $scope.w3 = $scope.w2 - 20;
    $scope.s1 = $scope.a3 - 200;
    $scope.msg = $scope.a3 - 149;


    $scope.showScroll = false;
    $scope.showScroller = function () {
      $scope.showScroll = true;
    };
    $scope.hideScroller = function () {
      $scope.showScroll = false;
    };
    $scope.gradesList = ['A+', 'A', 'B+', 'B', 'C+', 'C', 'D+', 'D'];
    $scope.getMimeTypes = function () {
      return ".xls,.xlsx,.xltx,.docx,.dotx,.xlam,.xlsb,application/excel,application/vnd.ms-excel,application/x-excel," +
        "application/x-msexcel,application/msword,.potx,.ppsx,.pptx,.sldx" +
        "text/plain,application/pdf,image/bmp,image/cis-cod,image/gif,image/ief,image/jpeg,image/jpeg,image/jpeg," +
        "image/pipeg,image/svg+xml,image/tiff,image/tiff,image/x-cmu-raster,image/x-cmx,image/x-icon," +
        "image/x-portable-anymap,image/x-portable-bitmap,image/x-portable-graymap,image/x-portable-pixmap," +
        "image/x-rgb,image/x-xbitmap,image/x-xpixmap,image/x-xwindowdump,.zip,.rar,audio/mpeg,audio/wav, " +
        "audio/x-wav,video/mpeg,video/msvideo, video/avi, video/x-msvideo,application/x-tar";
    };
    $scope.checkIfPic = function (mimeType) {
      return /^image[//].*/.test(mimeType) || /^video[//].*/.test(mimeType);
    };
    $scope.docIcon = function (mimeType) {
      if (/^application[//].*word.*/.test(mimeType))
        return 'images/word_icon.png';
      else if (mimeType == 'application/pdf')
        return 'images/doc_icon.png';
      else if (/^application[//].*powerpoint$/.test(mimeType))
        return 'images/ppt_icon.png';
      else if (/^application[//].*spreadsheet.*/.test(mimeType) || /^application[//].*excel.*/.test(mimeType))
        return 'images/excel_icon.jpg';

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
  })
  .directive('ngEnter', function () {
    return function (scope, element, attrs) {
      element.bind("keydown keypress", function (event) {
        if (event.which === 13) {
//          scope.$apply(function () {
          scope.$eval(attrs.ngEnter);
//          });

          event.preventDefault();
        }
      });
    };
  });


