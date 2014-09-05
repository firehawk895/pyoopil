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
      $scope.choices = [];
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
          value.Replies.newReply = "";
          value.isPraiseVisible = false;
          angular.forEach(value.Replies, function (value, key) {
            value.isIconVisible = false;
            value.isReplyPraiseVisible = false;
          });
          console.log($scope.discussions);
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

        roomService.delete($scope.discussions[parentIndex].Replies[index].Reply.id, "Reply").then(function (result) {
          notificationService.show(result.status, result.message);
          if (result.status)
            $scope.discussions[parentIndex].Replies.splice(index, 1);
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
        roomService.addReply($scope.discussions[index].Discussion.id, $scope.discussions[index].Replies.newReply).then(function (result) {
          notificationService.show(result.status, result.message);
          if (result.status) {
            $scope.discussions[index].Replies.push(result.data[0]);
          }
          $scope.discussions[index].Replies.newReply = "";

        });

      };
      $scope.setGamificationVoteDiscussion = function (index, vote) {
        roomService.setGamificationVote($scope.discussions[index].Discussion.id, vote, "Discussion").then(function (result) {
          if (result.status) {
            $scope.discussions[index].Discussion.display_praise = result.data.Discussion.display_praise;
            $scope.discussions[index].Discussion.cu = result.data.Discussion.cu;
            $scope.discussions[index].Discussion.in = result.data.Discussion.in;
            $scope.discussions[index].Discussion.co = result.data.Discussion.co;
            $scope.discussions[index].Discussion.en = result.data.Discussion.en;
            $scope.discussions[index].Discussion.ed = result.data.Discussion.ed;
            $scope.discussions[index].Discussion.showGamification = true;
          }

        });
      };
      $scope.setGamificationVoteReply = function (parentIndex, index, vote) {
        roomService.setGamificationVote($scope.discussions[parentIndex].Replies[index].Reply.id, vote, "Reply").then(function (result) {
          if (result.status) {
            $scope.discussions[parentIndex].Replies[index].Reply.display_praise = result.data.Reply.display_praise;
            $scope.discussions[parentIndex].Replies[index].Reply.cu = result.data.Reply.cu;
            $scope.discussions[parentIndex].Replies[index].Reply.in = result.data.Reply.in;
            $scope.discussions[parentIndex].Replies[index].Reply.co = result.data.Reply.co;
            $scope.discussions[parentIndex].Replies[index].Reply.en = result.data.Reply.en;
            $scope.discussions[parentIndex].Replies[index].Reply.ed = result.data.Reply.ed;
            $scope.discussions[parentIndex].Replies[index].Reply.showGamification = true;
          }
        });
      };
      $scope.showAll = function () {
        $scope.vm.showFold = false;

        roomService.getDiscussions($stateParams.roomId, $scope.page).then(function (result) {
          $scope.discussions = result.data;
          $scope.canCreate = result.permissions.allowCreate;
          angular.forEach($scope.discussions, function (value, key) {
            value.Replies.newReply = "";
            value.isPraiseVisible = false;
            angular.forEach(value.Replies, function (value, key) {
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
            value.Replies.newReply = "";
            value.isPraiseVisible = false;
            angular.forEach(value.Replies, function (value, key) {
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
              $scope.vm.subject = "";
              $scope.vm.body = "";
              $scope.vm.file = null;
            }
          });
      };

      $scope.createDiscussionPoll = function () {

        angular.forEach($scope.vm.answerChoices, function (value, key) {
          if (value.choice != "")
            $scope.choices.push(value.choice);
        });
        $scope.vm.file = document.getElementById("fileupload").files[0];
        roomService.createDiscussion($stateParams.roomId, $scope.vm.subject, $scope.vm.body, $scope.vm.file, "poll", $scope.choices)
          .then(function (added) {
            if (added.status) {
              $scope.discussions.unshift(added.data[0]);
              $scope.vm.subject = "";
              $scope.vm.body = "";
              $scope.vm.file = null;
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
              $scope.choices = [];
            }
          });
      };

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

      $scope.chartConfig = {
        options: {
          chart: {
            type: 'bar'
          }
        },
        series: [
          {
            data: [10, 15, 12]
          }
        ],
        title: {
          text: null
        },
        height: 400

      };


    }]);
