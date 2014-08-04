angular.module('Global.Services')
  .factory('mainService', ['$http', '$window', '$q' ,($http, $window, $q)->

    class mainService

      self = @

      constructor : ->

        self.url = $window.location.origin + $window.location.pathname

      postData : (url, data)->

        xhr = $http({
          method: 'POST',
          url: url,
          data: data
        })

        xhr
      postLogin : (data)->

        url = self.url + 'login'

        @postData(url, data)

      postRegistration : (data)->

        d = $q.defer()

        d.resolve()

        d.promise

    new mainService()

  ])