angular.module('Global.Controllers')
  .controller('mainCtrl', ['$scope', 'Utilities', 'mainService', 'Auth', '$state', ($scope, Utilities, mainService, Auth, $state)->

    $scope.template = {}
    $scope.showModal = false
    $scope.classroom = {}

    Utilities.init $scope

    $scope.newClassroom = ->

      if not $scope.classroom.name?
        toastr.error 'Enter a classroom Name'
        return

      if not $scope.classroom.type?
        toastr.error 'Enter a classroom Type'
        return






  ])