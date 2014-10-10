angular.module('uiApp')
  .controller('submissionCtrl', ['$scope', '$stateParams' , 'roomService', 'notificationService', 'modalService', 'ngDialog', 'localStorageService', '$state',
    function ($scope, $stateParams, roomService, notificationService, modalService, ngDialog, localStorageService, $state) {
      $scope.submissions = [];
      $scope.roomId = $stateParams.roomId;
      $scope.fullName = localStorageService.get("name");
      $scope.profile_img = localStorageService.get("image");
      $scope.vm = {};

      $scope.vm.array_char = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
      $scope.page = 1;
      $scope.pageEnd = false;
      $scope.lastExpandedItemIndex = -1;

      $scope.createNewAssignment = function () {
        $scope.vm = {};
        $scope.vm.typeIsSubjective = true;
        $scope.vm.gradingType = 'marked';
        $scope.vm.areYouSure = false;
        ngDialog.open({
          template: 'views/app/rooms/submission/createAssignment.html',
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
//        if (angular.isDefined($scope.vm.file) && $scope.vm.file.size > 5242880)
//          notificationService.show(false, "Cannot upload more than 5 MB");
//        else {
        roomService.createSubjectiveAssignment($scope.vm, $scope.roomId).then(function (result) {
          if (result.status) {
            notificationService.show(result.status, result.message);
            $scope.submissions.unshift(result.data[0]);
            ngDialog.close();
          }
          else {
            var errorKey = Object.keys(result.message)[0];
            notificationService.show(result.status, result.message[errorKey][0]);
            $scope.vm.areYouSure = false;
          }
        });

//        }
      };

      $scope.makeTypeSubjective = function (value) {
        $scope.vm = {};
        $scope.vm.gradingType = 'marked';
//        $scope.vm.file = null;
        $scope.vm.typeIsSubjective = value;
      };
      $scope.createQuizDialog = function () {
        $scope.vm.areYouSure = false;
        $scope.vm.questionChoices = [
          {
            questionType: 'single-select',
            questionText: "",
            answerValue: null,
            maxMarks: null,
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
        $scope.vm.totalMarks = 0;
        ngDialog.close();
        ngDialog.open({
          template: 'views/app/rooms/submission/createQuiz.html',
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
          maxMarks: null,
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
            ngDialog.close();
          }
          else {
            var errorKey = Object.keys(result.message)[0];
            notificationService.show(result.status, result.message[errorKey]);
            $scope.vm.areYouSure = false;
          }
        });

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

      $scope.answerSubjective = function (index, id) {
        if ($scope.vm.answerText == "")
          notificationService.show(false, "Cannot submit blank Answer");
        else {
          $scope.vm.file = document.getElementById("fileupload").files[0];
          if (angular.isDefined($scope.vm.file) && $scope.vm.file.size > 5242880)
            notificationService.show(false, "Cannot upload more than 5 MB");
          else {
            roomService.answerSubjective($scope.vm.answerText, $scope.vm.file, id).then(function (result) {
              notificationService.show(result.status, result.message);
              if (result.status) {
                $scope.submissions[index] = result.data;
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
      $scope.openTakeQuizDialog = function (id, index) {
        $scope.vm.quizIndex = index;
        roomService.getQuiz(id).then(function (result) {
          if (result.status)
            $scope.quizDetails = result.data;
          $scope.vm.submitQuizAnswer = [];
        });
        ngDialog.open({
          template: 'views/app/rooms/submission/takeQuizDialog.html',
          scope: $scope
        });
      };
      $scope.openStartQuizDialog = function () {
        angular.forEach($scope.quizDetails.Quiz[0].Quizquestion, function (value, key) {
          if (value.type == 'match-columns') {
            value.evenArray = [];
            value.matchValues = [];
            angular.forEach(value.Column, function (result, key) {
              if (key % 2 !== 0) {
                value.evenArray.push(result);
                value.matchValues.push('');
              }
            });
          }
          else if (value.type == 'multi-select') {
            angular.forEach(value.Choice, function (value, key) {
              value.isChecked = false;
            });
          }
          value.evenArray = _.shuffle(value.evenArray);
        });
        ngDialog.close();
        $scope.vm.quesIndex = 0;
        angular.forEach($scope.quizDetails, function (value, key) {
          $scope.vm.submitQuizAnswer.push('');
        });
        ngDialog.open({
          scope: $scope,
          template: 'views/app/rooms/submission/startQuizDialog.html'
        })
      };
      $scope.showQuestion = function (index) {
        $scope.vm.quesIndex = index;
      };
      $scope.answerQuiz = function () {
        $scope.vm.quizAnswers = {};
        $scope.vm.quizAnswers.Choice = [];
        $scope.vm.quizAnswers.Columns = [];
        angular.forEach($scope.vm.submitQuizAnswer, function (value, key) {
          if (value)
            $scope.vm.quizAnswers.Choice.push(value);
        });
        angular.forEach($scope.quizDetails.Quiz[0].Quizquestion, function (value, key) {
          if (value.type == 'multi-select') {
            angular.forEach(value.Choice, function (value, key) {
              if (value.isChecked)
                $scope.vm.quizAnswers.Choice.push(value.id);
            });
          }
          else if (value.type == 'match-columns') {
            angular.forEach(value.matchValues, function (result, key) {
              if (result) {
                $scope.vm.quizAnswers.Columns.push(value.Column[2 * key].id);
                $scope.vm.quizAnswers.Columns.push(value.evenArray[$scope.vm.array_char.indexOf(result)].id);
              }
            });
          }
        });
        roomService.answerQuiz($scope.vm.quizAnswers).then(function (result) {
          if (result.status) {
            ngDialog.close();
            $scope.submissions[$scope.vm.quizIndex].Submission.is_submitted = true;
          }
        });
      };
      $scope.calculateTotalMarks = function () {
        $scope.vm.totalMarks = 0;
        angular.forEach($scope.vm.questionChoices, function (value, key) {
          $scope.vm.totalMarks += parseInt(value.maxMarks);
        });
      };
    }]);
