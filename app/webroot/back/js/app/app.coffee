angular.module('Pyoopil.Services', [])
angular.module('Pyoopil.Controllers', [])
angular.module('Pyoopil.Directives', [])
angular.module('Pyoopil.Filters', [])

angular
  .module('pyoopil', [
    'Pyoopil.Services',
    'Pyoopil.Controllers',
    'Pyoopil.Directives',
    'Pyoopil.Filters',
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
    .state('login.Classrooms', {
        url: '/Classrooms',
        views:{
          'nav':{
            templateUrl: '/pyoopil/js/app/partials/modules/leftNav.html'
          },
          'viewport' : {
            templateUrl : '/pyoopil/js/app/partials/Classrooms/landing.html'
            controller : 'classroomCtrl'
          }
        }
    })
    .state('login.Classroom', {
        url: '/Classroom/:id',
        views:{
          'nav':{
            templateUrl: '/pyoopil/js/app/partials/modules/leftNav.html'
          },
          'viewport' : {
            templateUrl : '/pyoopil/js/app/partials/Classrooms/classroom.html'
            controller : 'announcementCtrl'
          }
        }
      })
    .state('reset', {
      url : '/reset',
      templateUrl : '/pyoopil/js/app/partials/reset-password.html'
    })
    .state('logout', {
      url : '/logout',
      templateUrl : '/pyoopil/js/app/partials/logout.html',
      controller : 'logoutCtrl'
    })

    $urlRouterProvider.otherwise('index')
  ])
  .config(['reCAPTCHAProvider', (reCAPTCHAProvider)->

    reCAPTCHAProvider.setPublicKey('6LeO9fcSAAAAAMsp8vSGpYd8ZHDdcHxvXrZHGf6q')

  ])
  .run(['$rootScope', '$state', '$stateParams', 'Auth', ($rootScope, $state, $stateParams, Auth)->

    $rootScope.$on '$stateChangeStart', (e, toState, toStateParams, fromState, fromStateParams)->

      $rootScope.toState = toState
      $rootScope.toStateParams = toStateParams

      if toState.name is 'index'
        if Auth.isLoggedIn()
          $state.go 'login.Classrooms'
          return
        return
      else
        if not Auth.isLoggedIn()
          $state.go 'index'

      false


  ])