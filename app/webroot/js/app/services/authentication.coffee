angular.module 'Pyoopil.Services'
.factory 'Auth', [()->

  class Auth

    constructor : ->

      @token = sessionStorage.authToken || false

    getAuthToken : ->

      @token.toString()

    setAuthToken : (token)->
      sessionStorage.authToken = @token = token

  new Auth()


]