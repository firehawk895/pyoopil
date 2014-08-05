angular.module('Global.Services')
  .factory('mainService', ['$http', '$window', '$q', 'Auth', ($http, $window, $q, Auth)->

    class mainService

      self = @

      constructor : ->

        self.url = $window.location.origin + $window.location.pathname

      postData : (url, data, isLogin)->

        if isLogin
          headers = ''
        else
          headers = {'Authorization' : Auth.getAuthToken() }

        xhr = $http({
          method: 'POST',
          url: url,
          data: data,
          headers : headers
        })

        xhr

      getData : (url)->

        xhr = $http({
          method: 'GET',
          url: url,
          headers : {'X-AuthTokenHeader' : Auth.getAuthToken() }
        })

        xhr

      postLogin : (data)->

        url = self.url + 'login'

        @postData(url, data, true)

      postRegistration : (data)->

        d = $q.defer()

        d.resolve()

        d.promise

      newClassroom : (data)->

        url = self.url + 'add.json'

      getClassrooms : ->

        url = self.url + 'Classrooms/getclassrooms.json?page=1'

        @getData(url)

    new mainService()

  ])