angular.module('uiApp')
  .controller('gradingCtrl', ['$scope', '$stateParams' , 'roomService', 'notificationService', 'modalService', 'ngDialog', 'localStorageService', '$state',
    function ($scope, $stateParams, roomService, notificationService, modalService, ngDialog, localStorageService, $state) {
      $scope.page = 1;
      $scope.vm.showSubmissionDetail = false;
      roomService.getGradeSubmissions($stateParams.roomId, $stateParams.assignmentId, $scope.page).then(function (result) {
        $scope.gradeSubmissions = result.data;
        $scope.submissionDetail = result.submission;
      });
      $scope.updatePage = function () {
        if (!$scope.pageEnd) {
          roomService.getGradeSubmissions($stateParams.roomId, $stateParams.assignmentId, ++$scope.page).then(function (result) {
            if (!result.data.length)
              $scope.pageEnd = true;
            else
              $scope.gradeSubmissions = $scope.gradeSubmissions.concat(result.data);
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
          if (result.status)
            $scope.gradeSubmissions[index].UsersSubmission.UsersSubmission.grade_comment = $scope.vm.commentText;
        });
      }
    }]);