angular.module 'Pyoopil.Services'
  .factory 'Auth', [()->

    new class Auth

      constructor : ->

        @token = sessionStorage.authToken || false

      getAuthToken : ->

        @token.toString()

      setAuthToken : (token)->

        sessionStorage.authToken = @token = token


      isLoggedIn : ->

        !!@token


      logout : ->

        delete sessionStorage.authToken

        true

]