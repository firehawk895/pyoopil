angular.module 'Pyoopil.Directives'
.directive 'classroomHeader', ['Utilities', 'mainService', '$timeout',(Utilities, mainService, $timeout)->

  return {
  restrict : 'E',
  replace : true,
  scope : {

  }
  templateUrl : '/pyoopil/js/app/partials/Classrooms/header.html',
  link : (scope, elem, attrs)->

    $timeout(->
      scope.permissions = scope.$parent.permissions
    ,100)

    elem.on 'click', '#newClassroom', (e)->

      Utilities.openModal 'create-classroom-form.html'

      false
  }

]