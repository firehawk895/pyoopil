angular.module('uiApp')
  .controller('gradingCtrl', ['$scope', '$stateParams' , 'roomService', 'notificationService', 'modalService', 'ngDialog', 'localStorageService', '$state',
    function ($scope, $stateParams, roomService, notificationService, modalService, ngDialog, localStorageService, $state) {

      $scope.page = 1;
      $scope.vm.showSubmissionDetail = false;
      roomService.getGradeSubmissions($stateParams.assignmentId, $scope.page).then(function (result) {
        $scope.gradeSubmissions = result.data;
        angular.forEach($scope.gradeSubmissions, function (value, key) {
          value.editGrade = false;
        });
        $scope.vm.submissionDetail = result.submission;
      });
      $scope.updatePage = function () {
        if (!$scope.pageEnd) {
          roomService.getGradeSubmissions($stateParams.assignmentId, ++$scope.page).then(function (result) {
            if (!result.data.length)
              $scope.pageEnd = true;
            else
              $scope.gradeSubmissions = $scope.gradeSubmissions.concat(result.data);
            angular.forEach($scope.gradeSubmissions, function (value, key) {
              value.editGrade = false;
            });
          });
        }
      };
      $scope.displayContent = function (index) {
        $scope.vm.showComment = false;
        $scope.vm.addComment = false;
        $scope.vm.commentText = "";
        if ($scope.lastExpandedItemIndex == -1) {
          $scope.lastExpandedItemIndex = index;
          $scope.gradeSubmissions[index].showContent = true;
        }
        else if ($scope.lastExpandedItemIndex == index) {
          $scope.lastExpandedItemIndex = -1;
          $scope.gradeSubmissions[index].showContent = false;
        }
        else {
          $scope.gradeSubmissions[$scope.lastExpandedItemIndex].showContent = false;
          $scope.gradeSubmissions[index].showContent = true;
          $scope.lastExpandedItemIndex = index;
        }
      };
      $scope.assignComment = function (submissionId, userId, index) {
        roomService.assignComment(submissionId, userId, $scope.vm.commentText).then(function (result) {
          notificationService.show(result.status, result.message);
          if (result.status) {
            $scope.gradeSubmissions[index].UsersSubmission.grade_comment = $scope.vm.commentText;
//            $scope.gradeSubmissions[index] = result.data;
          }
        });
      };
      $scope.assignGrade = function (submissionId, userId, index) {
//        if ($scope.gradeSubmissions[index].UsersSubmission.UsersSubmission.marks || $scope.gradeSubmissions[index].UsersSubmission.UsersSubmission.grade) {
        if ($scope.vm.submissionDetail.Submission.subjective_scoring == 'marked') {
          roomService.assignGrade(submissionId, userId, $scope.gradeSubmissions[index].UsersSubmission.marks, 'marked').then(function (result) {
            if (result.status)
              notificationService.show(true, result.message);
//            $scope.gradeSubmissions[index] = result.data;
            $scope.gradeSubmissions[index].UsersSubmission.is_graded = true; //model update instead of replacing the object
          });
        }
        else if ($scope.vm.submissionDetail.Submission.subjective_scoring == 'graded') {
          roomService.assignGrade(submissionId, userId, $scope.gradeSubmissions[index].UsersSubmission.grade, 'graded').then(function (result) {
            if (result.status)
              notificationService.show(true, result.message);
//            $scope.gradeSubmissions[index] = result.data;
            $scope.gradeSubmissions[index].UsersSubmission.is_graded = true;
          });
        }

        $scope.gradeSubmissions[index].editGrade = false;
//        }
//        else
//          notificationService.show(false, "Marks/Grade cannot be blank");
      };
    }]);