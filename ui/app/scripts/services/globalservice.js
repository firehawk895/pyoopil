'use strict';

/**
 * @ngdoc service
 * @name uiApp.globalService
 * @description
 * # globalService
 * Factory in the uiApp.
 */
angular.module('uiApp')
  .factory('globalService', ['$rootScope', 'Restangular', '$interval', '$location',
    function ($rootScope, restangular, $interval, $location) {
      var self = {};
      self.isAuthorised = false;
      self.messages = [];
      self.baseUrl = "http://api.pyoopil.localhost.com";
      //to remove the messages which have expired.
      $interval(
        function () {
          angular.forEach(self.messages, function (val) {
            var currentTime = new Date();
            if (val.expireBy.getSeconds() <= currentTime.getSeconds())
              self.removeMessage(val);
          });
        }, 1000);

      self.setIsAuthorised = function (loginStatus) {
        self.isAuthorised = loginStatus
      };
      self.getIsAuthorised = function () {
        return self.isAuthorised;
      };
      /*
       * type - info, error, success
       */
      self.setMessage = function (message, type) {
        var t = new Date();
        t.setSeconds(t.getSeconds() + 5);
        self.messages.push({text: message, type: type, expireBy: t})
      };
      self.getMessages = function () {
        return self.messages;
      };
      self.removeMessage = function (message) {
        var idx = self.messages.indexOf(message);
        if (idx != -1)
          self.messages.splice(idx, 1);
      };
      self.getOnlineStatus = function () {
        return restangular.all("ping").getList();
      };
      self.getBaseUrl = function () {
        switch ($location.host()) {
          case 'localhost':
            self.baseUrl = "http://api.pyoopil.localhost.com";
            break;
          case '127.0.0.1':
            self.baseUrl = "http://api.pyoopil.localhost.com";
            break;
          case 'beta.pyoopil.com':
            self.baseUrl = "http://apibeta.pyoopil.com";
            break;
          case 'www.pyoopil.com':
            self.baseUrl = "http://api.pyoopil.com";
            break;
        }
        return self.baseUrl;
      };
      self.getUrl = function (relativeUrl) {
        return self.baseUrl + relativeUrl;
      };
      self.setUrl = function (object) {
        return jQuery.param(object);
      };
      return self;
    }])
;