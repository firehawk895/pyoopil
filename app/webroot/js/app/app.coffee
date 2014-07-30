angular.module('Global.Services', [])
angular.module('Global.Controllers', [])
angular.module('Global.Directives', [])
angular.module('Global.Filters', [])

angular
  .module('pyoopil', [
    'Global.Services',
    'Global.Controllers',
    'Global.Directives',
    'Global.Filters',
    'ui.router'
  ])
  .config(['$stateProvider', '$locationProvider', '$urlRouterProvider', ($stateProvider, $locationProvider, $urlRouterProvider)->

    $stateProvider.state('index', {
      url : '/index',
      templateUrl : '/pyoopil/js/app/partials/landing.html'
    })

    $stateProvider.state('classrooms', {
      url : '/index',
      templateUrl : '/pyoopil/js/app/partials/landing.html'
    })

    $stateProvider.state('reset', {
      url : '/reset',
      templateUrl : '/pyoopil/js/app/partials/reset-password.html'
    })

    $urlRouterProvider.otherwise('/index');

    $urlRouterProvider.rule( ($injector, $location) ->

    )
  ])