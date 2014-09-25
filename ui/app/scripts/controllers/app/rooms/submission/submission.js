angular.module('uiApp')
  .controller('submissionCtrl', ['$scope', '$stateParams' , 'roomService', 'notificationService', 'modalService', 'ngDialog', 'localStorageService', '$state',
    function ($scope, $stateParams, roomService, notificationService, modalService, ngDialog, localStorageService, $state) {
      $scope.submissions = [];
      $scope.roomId = $stateParams.roomId;
      $scope.fullName = localStorageService.get("name");
      $scope.profile_img = localStorageService.get("image");
      $scope.vm = {};
      $scope.page = 1;
      $scope.pageEnd = false;
      $scope.lastExpandedItemIndex = -1;
      $scope.createNewAssignment = function () {
        $scope.vm = {};
        $scope.vm.typeIsSubjective = true;
        $scope.vm.gradingType = 'marked';
//        $scope.vm.file = null;
        ngDialog.open({
          template: 'views/app/rooms/createAssignment.html',
          scope: $scope
        });
      };

      roomService.getSubmissions($stateParams.roomId, $scope.page).then(function (result) {
        $scope.submissions = result.data;
        $scope.canCreate = result.permissions.allowCreate;
        $scope.studentCount = result.users_classroom_count;
      });

      $scope.createSubjectiveAssignment = function () {
        $scope.vm.file = document.getElementById("fileUploadSubjective").files[0];
        if (angular.isDefined($scope.vm.file) && $scope.vm.file.size > 5242880)
          notificationService.show(false, "Cannot upload more than 5 MB");
        else {
          roomService.createSubjectiveAssignment($scope.vm, $scope.roomId).then(function (result) {
            if (result.status) {
              notificationService.show(result.status, result.message);
              $scope.submissions.unshift(result.data[0]);
            }
          });
          ngDialog.close();
        }
      };

      $scope.makeTypeSubjective = function (value) {
        $scope.vm = {};
        $scope.vm.gradingType = 'marked';
//        $scope.vm.file = null;
        $scope.vm.typeIsSubjective = value;
      };
      $scope.createQuizDialog = function () {
        $scope.vm.questionChoices = [
          {
            questionType: 'single-select',
            questionText: "",
            answerValue: null,
            maxMarks: 0,
            answerChoices: [
              {
                choice: "",
                answerValue: ""
              },
              {
                choice: "",
                answerValue: ""
              }
            ]
          }
        ];
        ngDialog.close();
        ngDialog.open({
          template: 'views/app/rooms/createQuiz.html',
          scope: $scope
        });
      };
      $scope.addNewAnswerChoice = function (index) {
        if ($scope.vm.questionChoices[index].answerChoices.length < 6)
          $scope.vm.questionChoices[index].answerChoices.push({
            choice: ""
          });
      };
      $scope.addNewQuestionChoice = function () {
        $scope.vm.questionChoices.push({
          questionType: 'single-select',
          questionText: "",
          answerValue: null,
          maxMarks: 0,
          answerChoices: [
            {
              choice: "",
              answerValue: ""
            },
            {
              choice: "",
              answerValue: ""
            }
          ]
        });
      };
      $scope.addFile = function () {
        $scope.vm.file = document.getElementById("fileUploadQuiz").files[0];
        if (angular.isDefined($scope.vm.file) && $scope.vm.file.size > 5242880)
          notificationService.show(false, "Cannot upload more than 5 MB");
      };
      $scope.createQuizAssignment = function () {
        roomService.createQuizAssignment($scope.vm, $scope.roomId).then(function (result) {
          if (result.status) {
            notificationService.show(result.status, result.message);
            $scope.submissions.unshift(result.data[0]);
          }
        });
        ngDialog.close();
      };
      $scope.displayContent = function (index) {
        if (!$scope.canCreate) {
          $scope.vm.showAnswer = false;
          $scope.vm.addAnswer = false;
          $scope.vm.answerText = "";
          if ($scope.lastExpandedItemIndex == -1) {
            $scope.lastExpandedItemIndex = index;
            $scope.submissions[index].showContent = true;
          }
          else if ($scope.lastExpandedItemIndex == index) {
            $scope.lastExpandedItemIndex = -1;
            $scope.submissions[index].showContent = false;
          }
          else {
            $scope.submissions[$scope.lastExpandedItemIndex].showContent = false;
            $scope.submissions[index].showContent = true;
            $scope.lastExpandedItemIndex = index;
          }
        }
        else
          $state.go("app.rooms.submissions.grading", {assignmentId: $scope.submissions[index].Submission.id});
      };
      $scope.openDocViewerDialog = function (path) {
        modalService.openDocViewerDialog($scope, path);
      };
      $scope.checkIfPic = function (mimeType) {
        return /^image[//].*/.test(mimeType) || /^video[//].*/.test(mimeType);
      };
      $scope.docIcon = function (mimeType) {
        if (/^application[//].*word.*/.test(mimeType))
          return 'images/word_icon.png';
        else if (mimeType == 'application/pdf')
          return 'images/doc_icon.png';
        else if (/^application[//].*powerpoint$/.test(mimeType))
          return 'images/ppt_icon.png';
      };
      $scope.answerSubjective = function (index, id) {
        if ($scope.vm.answerText == "")
          notificationService.show(false, "Cannot submit blank Answer");
        else {
          $scope.vm.file = document.getElementById("fileupload").files[0];
          if (angular.isDefined($scope.vm.file) && $scope.vm.file.size > 5242880)
            notificationService.show(false, "Cannot upload more than 5 MB");
          else {
            roomService.answerSubjective($scope.vm.answerText, $scope.vm.file, id).then(function (result) {
              if (result.status) {
                notificationService.show(true, 'Answer Submitted Successfully');
                $scope.submissions[index] = result.data[0];
              }
            });
          }
        }
      };
      $scope.updatePage = function () {
        if (!$scope.pageEnd) {
          roomService.getSubmissions($stateParams.roomId, ++$scope.page).then(function (result) {
            if (!result.data.length)
              $scope.pageEnd = true;
            else
              $scope.submissions = $scope.submissions.concat(result.data);
          });
        }
      };
      $scope.openTakeQuizDialog = function (id) {
        roomService.getQuiz(id).then(function (result) {
          if (result.status)
            $scope.quizDetails = result.data;
        });
        ngDialog.open({
          template: 'views/app/rooms/submission/takeQuizDialog.html',
          scope: $scope
        });
      };
      $scope.openStartQuizDialog = function () {
        ngDialog.close();
        $scope.vm.quesIndex = 0;
        $scope.vm.currentQuestion = $scope.quizDetails.Quiz[0].Quizquestion[0];
        ngDialog.open({
          scope: $scope,
          template: 'views/app/rooms/submission/startQuizDialog.html'
        })
      };
      $scope.showQuestion = function (index) {
        $scope.vm.quesIndex = index;
        $scope.vm.currentQuestion = $scope.quizDetails.Quiz[0].Quizquestion[index];
      };
    }]);

$(function () {
  $('.quiz-slider').bxSlider({
    minSlides: 9,
    maxSlides: 9,
    moveSlides: 1,
    slideMargin: 6,
    infiniteLoop: false,
    mode: 'vertical'
  });
});