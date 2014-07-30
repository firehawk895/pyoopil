// Generated by CoffeeScript 1.7.1
(function() {
  angular.module('Global.Services').factory('mainService', [
    '$http', '$window', '$q', function($http, $window, $q) {
      var mainService;
      mainService = (function() {
        var self;

        self = mainService;

        function mainService() {
          self.url = $window.location.origin + $window.location.pathname;
        }

        mainService.prototype.postData = function(url, data) {
          var xhr;
          xhr = $http.post(url, data);
          return xhr;
        };

        mainService.prototype.postLogin = function(data) {
          var url;
          url = self.url + 'login';
          return this.postData(url, data);
        };

        mainService.prototype.postRegistration = function(data) {
          var d;
          d = $q.defer();
          d.resolve();
          return d.promise;
        };

        return mainService;

      })();
      return new mainService();
    }
  ]);

}).call(this);

//# sourceMappingURL=mainService.map
