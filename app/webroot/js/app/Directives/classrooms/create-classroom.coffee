angular.module 'Classrooms'
  .directive 'createClassroom', [()->

      return {
        restrict : 'E',
        replace : true,
        scope : {

        },
        templateUrl : '/pyoopil/js/app/partials/classrooms/create-classroom.html',
        link : (scope, elem, attrs)->
          console.log elem
      }

  ]