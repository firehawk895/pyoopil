/**
 * Created by himanshu on 3/9/14.
 */
angular.module('uiApp')
  .controller('discussionCtrl', ['$scope', '$stateParams' , 'roomService', 'notificationService',
    function ($scope, $stateParams, roomService, notificationService) {
      $scope.page = 1;
      $scope.roomId = $stateParams.roomId;
      $scope.vm = {};
      $scope.vm.subject = "";
      $scope.vm.body = "";
      $scope.vm.file = null;
      $scope.discussions = [];
      $scope.vm.showFold = false;
      $scope.vm.discussionType = "";
      $scope.answerChoiceIndex = 1;
      $scope.vm.answerChoices = [
        {
          choice: "",
          isVisible: true
        },
        {
          choice: "",
          isVisible: true
        }

      ];
      roomService.getDiscussions($stateParams.roomId, $scope.page).then(function (result) {
        $scope.discussions = result.data;
        $scope.canCreate = result.permissions.allowCreate;
        angular.forEach($scope.discussions, function (value, key) {
          value.Reply.newReply = "";
          value.isPraiseVisible = false;
          angular.forEach(value.Reply, function (value, key) {
            value.isIconVisible = false;
            value.isReplyPraiseVisible = false;
          });
//          console.log($scope.discussions);
        });
      });
      $scope.deleteDiscussion = function (index) {
        roomService.delete($scope.discussions[index].Discussion.id, "Discussion").then(function (result) {
          notificationService.show(result.status, result.message);
          if (result.status)
            $scope.discussions.splice(index, 1);
        });
      };
      $scope.deleteReply = function (parentIndex, index) {

        roomService.delete($scope.discussions[parentIndex].Reply[index].id, "Reply").then(function (result) {
          notificationService.show(result.status, result.message);
          if (result.status)
            $scope.discussions[parentIndex].Reply.splice(index, 1);
        });
      };
      $scope.toggleFold = function (index) {
        roomService.toggleFold($scope.discussions[index].Discussion.id).then(function (result) {
          notificationService.show(result.status, result.message);
          if (result.status)
            $scope.discussions[index].Discussion.isFolded = !$scope.discussions[index].Discussion.isFolded;
        });
      };
      $scope.addReply = function (index) {
        roomService.addReply($scope.discussions[index].Discussion.id, $scope.discussions[index].Reply.newReply).then(function (result) {
          notificationService.show(result.status, result.message);
          if (result.status) {
            $scope.discussions[index].Reply.push(result.data[0]);
          }
          $scope.discussions[index].Reply.newReply = "";

        });

      };
      $scope.setGamificationVoteDiscussion = function (index, vote) {
        roomService.setGamificationVote($scope.discussions[index].Discussion.id, vote, "Discussion").then(function (result) {
          if (result.status) {

            ++$scope.discussions[index].Discussion[vote];
//            console.log($scope.discussions[index].Discussion);
            $scope.discussions[index].Discussion.showGamification = true;
          }

        });
      };
      $scope.setGamificationVoteReply = function (parentIndex, index, vote) {
        roomService.setGamificationVote($scope.discussions[parentIndex].Reply[index].id, vote, "Reply").then(function (result) {
          if (result.status) {

            ++$scope.discussions[parentIndex].Reply[index][vote];
//            console.log($scope.discussions[parentIndex].Reply);
            $scope.discussions[parentIndex].Reply[index].showGamification = true;
          }
        });
      };
      $scope.showAll = function () {
        $scope.vm.showFold = false;

        roomService.getDiscussions($stateParams.roomId, $scope.page).then(function (result) {
          $scope.discussions = result.data;
          $scope.canCreate = result.permissions.allowCreate;
          angular.forEach($scope.discussions, function (value, key) {
            value.Reply.newReply = "";
            value.isPraiseVisible = false;
            angular.forEach(value.Reply, function (value, key) {
              value.isIconVisible = false;
              value.isReplyPraiseVisible = false;
            });
//          console.log($scope.discussions);
          });
        });

      };
      $scope.showFold = function () {
        $scope.vm.showFold = true;

        roomService.getDiscussions($stateParams.roomId, $scope.page, "folded").then(function (result) {
          $scope.discussions = result.data;
          $scope.canCreate = result.permissions.allowCreate;
          angular.forEach($scope.discussions, function (value, key) {
            value.Reply.newReply = "";
            value.isPraiseVisible = false;
            angular.forEach(value.Reply, function (value, key) {
              value.isIconVisible = false;
              value.isReplyPraiseVisible = false;
            });
//          console.log($scope.discussions);
          });
        });
      };
      $scope.createDiscussionQuestion = function () {

        $scope.vm.file = document.getElementById("fileupload").files[0];
        roomService.createDiscussion($stateParams.roomId, $scope.vm.subject, $scope.vm.body, $scope.vm.file, "question")
          .then(function (added) {
            if (added.status) {
              $scope.discussions.unshift(added.data[0]);
              $scope.vm = {};
            }
          });
      };
//      $scope.createDiscussionPoll = function () {
//
//        angular.forEach($scope.vm.answerChoices, function (value, key) {
//          if (value.choice != "")
//            $scope.libraryUpload.links.push(value.url);
//        });
//        $scope.vm.file = document.getElementById("fileupload").files[0];
//        roomService.createDiscussion($stateParams.roomId, $scope.vm.subject, $scope.vm.body, $scope.vm.file, "question")
//          .then(function (added) {
//            if (added.status) {
//              $scope.discussions.unshift(added.data[0]);
//              $scope.vm = {};
//            }
//          });
//      };
      $scope.addNewChoice = function () {
        if ($scope.vm.answerChoices.length < 6)
          $scope.vm.answerChoices.push({
            choice: "",
            isVisible: true
          });

      };
      $scope.removeChoice = function (index) {
        if ($scope.vm.answerChoices.length == 2) {
          notificationService.show(true, "Cannot have less than two choices");
          return false;
        }
        $scope.vm.answerChoices.splice(index, 1);
      };
    }]);
