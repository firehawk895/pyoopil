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
        'ngTouch'
    ])
    .config(['$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {
        // For any unmatched url, redirect to /state1
        $urlRouterProvider.otherwise("/rooms");
        //
        // Now set up the states
        $stateProvider
            .state('rooms', {
                url: "/rooms",
                templateUrl: "views/rooms/index.html"
            });
//            .state('rooms.', {
//                url: "/list",
//                templateUrl: "partials/state1.list.html",
//                controller: function ($scope) {
//                    $scope.items = ["A", "List", "Of", "Items"];
//                }
//            })
//            .state('state2', {
//                url: "/state2",
//                templateUrl: "partials/state2.html"
//            })
//            .state('state2.list', {
//                url: "/list",
//                templateUrl: "partials/state2.list.html",
//                controller: function ($scope) {
//                    $scope.things = ["A", "Set", "Of", "Things"];
//                }
//            })


    }]);
