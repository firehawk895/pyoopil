angular.module 'Classrooms'
.directive 'classroomHeader', ['Utilities', 'mainService', (Utilities, mainService)->

  return {
  restrict : 'E',
  replace : true,
  scope : {

  },
  templateUrl : '/pyoopil/js/app/partials/classrooms/header.html',
  link : (scope, elem, attrs)->

    scope.showModal = false

    $create = elem.find '#newClassroom'

    xhr = mainService.getClassrooms()

    xhr.then((data)->

      console.log data

    )


    $create.on 'click', (e)->

      Utilities.openModal 'create-classroom-form.html'

      false
  }

]