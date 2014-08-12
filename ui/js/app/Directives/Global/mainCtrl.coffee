angular.module('Pyoopil.Controllers')
  .controller('mainCtrl', ['$scope', 'Utilities', 'Auth', '$state','mainService',  ($scope, Utilities, Auth, $state, mainService)->

    $scope.template = {}
    $scope.showModal = false
    $scope.classroom = {
      campus_id : 1,
      department_id : 1,
      duration_start_date : '06/21/2014',
      duration_end_date : '06/21/2014',
      semester : 1,
      is_private : 0,
      description : 'Description',
      degree_id : 1
    }

    Utilities.init $scope

    $scope.newClassroom = (form)->

      if not $scope.classroom.title?
        toastr.error 'Please enter a classroom name'
        return false

      data = {
        "Classroom" : $scope.classroom
      }


      promise = mainService.newClassroom(data)

      promise.then(
        (data)->
          console.log data
          toastr.success 'Classroom Successfully Created'
          if $scope.classroom.is_private is 0
            template = 'public-classroom-success-message.html'
          else
            $scope.code = data.data.data.Classroom.access_code
            template = 'private-classroom-success-message.html'

          Utilities.openModal(template)
          $scope.$broadcast 'Classroom.CREATE', data.data
      )


  ])