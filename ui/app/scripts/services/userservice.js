'use strict';

/**
 * @ngdoc service
 * @name uiApp.userService
 * @description
 * # userService
 * Factory in the uiApp.
 */
angular.module('uiApp')
    .factory('userService', ["Restangular", "$http", 'localStorageService', 'crm.service.global' , '$q', '$timeout',
        function (restangular, $http, localStorageService, globalService) {

            var self = this;
            //login for the entire app
            self.login = function (user) {
                return restangular.all("users").all("login").post(user).then(
                    function (session) {
                        if (angular.isDefined(session.id)) {
                            //define headers for restangular
                            $http.defaults.headers.common = {'Authorization': session.id};

                            //put the session data in cookie
                            localStorageService.add("session", session);
                        }
                    }
                );
            };

            //logout function
            self.logout = function () {
                return restangular.all("users").all("logout").getList().then(
                    function () {
                        $http.defaults.headers.common = {'Authorization': ''};
                        localStorageService.remove("session");
                        globalService.setIsAuthorised(false);
                    }
                )
            };
            return self;
        }]);
