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
      self.login = function (model) {
        return restangular.all("").customPOST(model, "login.json");
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
