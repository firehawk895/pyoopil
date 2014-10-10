angular.module('uiApp')
  .controller('takeAttendanceCtrl', ['$scope', '$stateParams' , 'roomService', 'notificationService', 'modalService', 'ngDialog', 'localStorageService', '$state',
    function ($scope, $stateParams, roomService, notificationService, modalService, ngDialog, localStorageService, $state) {
      $scope.roomId = $stateParams.roomId;
      $scope.vm = {};
      $scope.vm.attendanceDate = "";
      $scope.vm.showAttendanceList = false;
      roomService.getAttendanceList($scope.roomId).then(function (result) {
        if (result.status) {
          $scope.vm.students = result.data;
          angular.forEach($scope.vm.students, function (value, key) {
            value.Attendance = {};
            value.Attendance.is_present = true;
          });
          $scope.vm.dates = result.dates;
        }
      });
      $scope.viewAttendance = function () {
        if ($scope.vm.dates.indexOf($scope.vm.attendanceDate) > -1) {
          roomService.viewAttendance($scope.roomId, $scope.vm.attendanceDate).then(function (result) {
            if (result.status) {
              $scope.vm.showAttendanceList = true;
              $scope.vm.currentStudents = result.data;
            }
          });
        }
        else {
          $scope.vm.currentStudents = $scope.vm.students;
          $scope.vm.showAttendanceList = true;
        }
      };
      $scope.addAttendance = function () {
        $scope.vm.absentList = [];
        angular.forEach($scope.vm.students, function (value, key) {
          if (!value.Attendance.is_present)
            $scope.vm.absentList.push(value.AppUser.id);
        });
        roomService.addAttendance($scope.roomId, $scope.vm.absentList, $scope.vm.attendanceDate).then(function (result) {
          if (result.status) {
//            $scope.vm.currentStudents = result.data;
            $scope.vm.dates.push($scope.vm.attendanceDate);
          }
        });
      };
    }])
;