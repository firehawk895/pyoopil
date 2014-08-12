angular.module('Pyoopil.Directives')
.controller('loginCtrl', ['$scope', ($scope)->

    @closeModal = ->
      $scope.$parent.$emit 'closeModal'

    ''
])
.directive('login', ['mainService','$state', 'Auth',(mainService, $state, Auth)->

    return {

      restrict : 'E',
      scope : {

      },
      controller : 'loginCtrl',
      templateUrl : '/pyoopil/js/app/partials/login.html'
      link : (scope, elem, attrs, loginCtrl)->

        $loginDialog = elem.find '#dialog'
        $close = elem.find 'a.close-link'
        $resetPass = elem.find '#for-pass'
        $form = elem.find ''

        scope.login = {}

        scope.submit = (form)->

          toastr.clear()

          if form.email.$invalid
            toastr.error 'Please enter a valid email'
            return

          if form.password.$invalid
            toastr.error 'Please enter a valid password'
            return

          if form.$valid
            data = {
              "AppUser":{
                "email": scope.login.email,
                "password": scope.login.password
              }
            }

            post = mainService.postLogin(data)

            post.then(
              (data)->
                if data.data.status is true
                  loginCtrl.closeModal()
                  Auth.setAuthToken(data.data.data['auth_token'])
                  $state.go 'login.Classrooms'
                else
                  toastr.error('Login Failed !')
            ,
              ()->
                toastr.error('Login Failed !')
            )
          ''

        elem.on('click', ->

          scope.$parent.$emit 'openModal'

          $loginDialog.show()

        )

        $close.on 'click', (e)->

          scope.$parent.$emit 'closeModal'
          $loginDialog.hide()

          false

        $resetPass.on 'click', (e)->
          e.preventDefault()
          scope.$parent.$emit 'closeModal'
          $state.go 'reset'

          false

    }


  ])