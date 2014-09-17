angular.module('uiApp')
  .controller('submissionCtrl', ['$scope', '$stateParams' , 'roomService', 'notificationService', 'modalService', 'ngDialog',
    function ($scope, $stateParams, roomService, notificationService, modalService, ngDialog) {
      $scope.roomId = $stateParams.roomId;
      $scope.vm = {};
      $scope.vm.typeIsSubjective = true;
      $scope.vm.gradingType = 'marked';
      $scope.vm.questionChoices = [
        {
          questionType: 'single-select',
          questionText: "",
          answerChoices: [
            {
              choice: ""
            },
            {
              choice: ""
            }
          ]
        }
      ];

      $scope.createNewAssignment = function () {
        ngDialog.open({
          template: 'views/app/rooms/createAssignment.html',
          scope: $scope
        });
      };
      $scope.createSubjectiveAssignment = function () {
        $scope.vm.file = document.getElementById("fileupload").files[0];
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
      $scope.createQuizDialog = function () {
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
          answerChoices: [
            {
              choice: ""
            },
            {
              choice: ""
            }

          ]
        });

      };

    }])
;