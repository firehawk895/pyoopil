'use strict';

/**
 * @ngdoc service
 * @name uiApp.userService
 * @description
 * # userService
 * Factory in the uiApp.
 */
angular.module('uiApp')
  .factory('userService', ["Restangular", "$http", 'localStorageService', 'globalService' , '$q', '$timeout',
    function (restangular, $http, localStorageService, globalService) {

      var self = this;
      //login for the entire app
      self.login = function (email, password) {
        var data = {
          AppUser: {
            email: email,
            password: password
          }
        };
        return restangular.all('').customPOST(data, 'login.json');
      };

      self.validateSession = function () {
        var token = localStorageService.get('token');
        if (token !== null && angular.isDefined(token)) {
          $http.defaults.headers.common = {'X-AuthTokenHeader': token};
          globalService.setIsAuthorised(true);
        }
      };
      //logout function
      self.logout = function () {
        var token = localStorageService.get('token');
        return restangular.all("").customPOST(token, 'logout.json');
      };
      return self;
    }]);
