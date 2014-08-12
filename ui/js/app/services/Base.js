// Generated by CoffeeScript 1.7.1
angular.module('Pyoopil.Services').factory('Base', [
  '$http', '$q', 'Auth', '$window', function($http, $q, Auth, $window) {
    var Base;
    return Base = (function() {
      function Base() {
        this.path = $window.location.origin + $window.location.pathname;
      }

      Base.prototype.getData = function(url, data) {
        var headers, xhr;
        headers = {
          'X-AuthTokenHeader': Auth.getAuthToken()
        };
        if (headers == null) {
          return false;
        }
        xhr = $http({
          method: 'GET',
          url: url,
          data: data,
          headers: headers
        });
        return xhr;
      };

      Base.prototype.getData = function(url, data) {
        var headers, xhr;
        headers = {
          'X-AuthTokenHeader': Auth.getAuthToken()
        };
        if (headers == null) {
          return false;
        }
        xhr = $http({
          method: 'POST',
          url: url,
          data: data,
          headers: headers
        });
        return xhr;
      };

      return Base;

    })();
  }
]);
