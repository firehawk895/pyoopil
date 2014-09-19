angular.module('uiApp')
  .controller('submissionCtrl', ['$scope', '$stateParams' , 'roomService', 'notificationService', 'modalService', 'ngDialog',
    function ($scope, $stateParams, roomService, notificationService, modalService, ngDialog) {
      $scope.roomId = $stateParams.roomId;
      $scope.page = 1;
      $scope.createNewAssignment = function () {
        $scope.vm = {};
        $scope.vm.typeIsSubjective = true;
        $scope.vm.gradingType = 'marked';
        $scope.vm.file = null;
        ngDialog.open({
          template: 'views/app/rooms/createAssignment.html',
          scope: $scope
        });
      };

      roomService.getSubmissions($stateParams.roomId, $scope.page).then(function (result) {
        $scope.submissions = result.data;
        //        $scope.canPost = result.permissions.allowCreate;
      });


      $scope.createSubjectiveAssignment = function () {
        $scope.vm.file = document.getElementById("fileUploadSubjective").files[0];
        if (angular.isDefined($scope.vm.file) && $scope.vm.file.size > 5242880)
          notificationService.show(false, "Cannot upload more than 5 MB");
        else {
          roomService.createSubjectiveAssignment($scope.vm, $scope.roomId).then(function (result) {
            if (result.status)
              notificationService.show(true, 'Assignment Created Successfully');
          });
          ngDialog.close();
        }
      };
      $scope.makeTypeSubjective = function (value) {
        $scope.vm = {};
        $scope.vm.gradingType = 'marked';
        $scope.vm.file = null;
        $scope.vm.typeIsSubjective = value;
      };
      $scope.createQuizDialog = function () {
        $scope.vm.questionChoices = [
          {
            questionType: 'single-select',
            questionText: "",
            answerValue: null,
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
          if (result.status)
            notificationService.show(true, 'Assignment Created Successfully');
        });
        ngDialog.close();
      };
    }]);