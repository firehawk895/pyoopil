angular.module('Global.Services', [])
angular.module('Global.Controllers', [])
angular.module('Global.Directives', [])
angular.module('Global.Filters', [])
angular.module('Classrooms', [])

angular
  .module('pyoopil', [
    'Global.Services',
    'Global.Controllers',
    'Global.Directives',
    'Classrooms',
    'Global.Filters',
    'ui.router',
    'reCAPTCHA'
  ])
  .config(['$stateProvider', '$locationProvider', '$urlRouterProvider', ($stateProvider, $locationProvider, $urlRouterProvider)->

    $stateProvider.state('index', {
      url : '/index',
      templateUrl : '/pyoopil/js/app/partials/landing.html'
    })
    .state('login', {
      url : '/login',
      templateUrl : '/pyoopil/js/app/partials/modules/landing.html'
    })
    .state('login.classrooms', {
        url: '/classrooms',
        views:{
          'nav':{
            templateUrl: '/pyoopil/js/app/partials/modules/leftNav.html'
          },
          'viewport' : {
            templateUrl : '/pyoopil/js/app/partials/classrooms/landing.html'
          }
        }
    })
    .state('reset', {
      url : '/reset',
      templateUrl : '/pyoopil/js/app/partials/reset-password.html'
    })

    $urlRouterProvider.otherwise('/index');

    $urlRouterProvider.rule( ($injector, $location) ->

    )
  ])
  .config(['reCAPTCHAProvider', (reCAPTCHAProvider)->

    reCAPTCHAProvider.setPublicKey('6LeO9fcSAAAAAMsp8vSGpYd8ZHDdcHxvXrZHGf6q')

  ])