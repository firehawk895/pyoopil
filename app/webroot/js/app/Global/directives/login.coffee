angular.module('Global.Directives')
.directive('login', ['mainService','$state', (mainService, $state)->

    return {

      restrict : 'E',
      scope : {

      }
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
              'data[AppUser][email]' : scope.login.email,
              'data[AppUser][password]' : scope.login.password
            }
            post = mainService.postLogin(data)

            post.error(-> toastr.error('Login Failed !'))
          ''

        elem.on('click', ->

          scope.$parent.$emit 'openModal'

          $loginDialog.show()

        )

        $close.on 'click', (e)->

          scope.$parent.$emit 'closeModal'
          $loginDialog.hide()

          false

        $resetPass.on 'click', ->
          e.preventDefault()
          scope.$parent.$emit 'closeModal'
          $state.go 'reset'

          false
    }


  ])