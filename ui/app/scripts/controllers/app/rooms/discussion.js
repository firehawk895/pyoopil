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
      $scope.pageEnd = false;
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
//        console.log($scope.discussions);
        angular.forEach($scope.discussions, function (value, key) {

          value.newReply = "";
          value.isPraiseVisible = false;
          angular.forEach(value.Replies, function (value, key) {
            value.isIconVisible = false;
            value.isReplyPraiseVisible = false;
          });


        });
      });
      $scope.deleteDiscussion = function (index) {
        roomService.deleteInDiscussion($scope.discussions[index].Discussion.id, "Discussion").then(function (result) {
          notificationService.show(result.status, result.message);
          if (result.status)
            $scope.discussions.splice(index, 1);
        });
      };
      $scope.deleteReply = function (parentIndex, index) {

        roomService.deleteInDiscussion($scope.discussions[parentIndex].Replies[index].Reply.id, "Reply").then(function (result) {
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
        roomService.addReply($scope.discussions[index].Discussion.id, $scope.discussions[index].newReply).then(function (result) {
          notificationService.show(result.status, "Comments Posted");
          if (result.status) {
            $scope.discussions[index].Replies = $scope.discussions[index].Replies || [];

            $scope.discussions[index].Replies.push(result.data[0]);
          }
          $scope.discussions[index].newReply = "";

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
            value.newReply = "";
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
            value.newReply = "";
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
        if ($scope.vm.subject == "" || $scope.vm.body == "")
          notificationService.show(false, "Cannot Create Discussion");
        else {
          $scope.vm.file = document.getElementById("fileupload").files[0];
          if (angular.isDefined($scope.vm.file) && $scope.vm.file.size > 2097152)
            notificationService.show(false, "Cannot upload more than 2mb");
          else {
            roomService.createDiscussion($stateParams.roomId, $scope.vm.subject, $scope.vm.body, $scope.vm.file, "question")
              .then(function (added) {
                if (added.status) {
                  $scope.discussions.unshift(added.data[0]);
                  $scope.vm.subject = "";
                  $scope.vm.body = "";
                  $scope.vm.file = null;
                }
              });
          }
        }
      };

      $scope.createDiscussionPoll = function () {
        if ($scope.vm.subject == "" || $scope.vm.body == "")
          notificationService.show(false, "Cannot Create Discussion");
        else {
          angular.forEach($scope.vm.answerChoices, function (value, key) {
            if (value.choice != "")
              $scope.choices.push(value.choice);
          });
          $scope.vm.file = document.getElementById("fileupload").files[0];
          if (angular.isDefined($scope.vm.file) && $scope.vm.file.size > 2097152)
            notificationService.show(false, "Cannot upload more than 2mb");
          else {
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
          }
        }
      };
      $scope.createDiscussionNote = function () {
        if ($scope.vm.subject == "" || $scope.vm.body == "")
          notificationService.show(false, "Cannot Create Discussion");
        else {
          $scope.vm.file = document.getElementById("fileupload").files[0];
          if (angular.isDefined($scope.vm.file) && $scope.vm.file.size > 2097152)
            notificationService.show(false, "Cannot upload more than 2mb");
          else {
            roomService.createDiscussion($stateParams.roomId, $scope.vm.subject, $scope.vm.body, $scope.vm.file, "note").
              then(function (added) {
                if (added.status) {
                  $scope.discussions.unshift(added.data[0]);
                  $scope.vm.subject = "";
                  $scope.vm.body = "";
                  $scope.vm.file = null;
                }

              })
          }
        }
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

      $scope.getChartConfig = function () {
        return{
          options: {
            chart: {
              type: 'bar'
            }
          },
          xAxis: {
            categories: ['A', 'B', 'C']
          },
          series: [
            {
              data: [1, 0]
            }
          ],
          title: {
            text: null
          },
          height: 400
        }
      };

      $scope.setPollVote = function (parentIndex, index) {

        roomService.setPollVote($scope.discussions[parentIndex].Pollchoice[index].id).then(function (result) {
          if (result.status) {
            $scope.discussions[parentIndex] = result.data[0];
//            angular.forEach(result.data[0].Pollchoice, function (value, key) {
//              $scope.answerCategories.push(value.choice);
//              $scope.answerData.push(value.votes);
//            });

          }
        })
      };
      $scope.chartConfig = $scope.getChartConfig();

      $scope.editorOptions = {
        height: 150
      };

      $scope.updatePage = function () {
        if (!$scope.pageEnd) {
          roomService.getDiscussions($stateParams.roomId, ++$scope.page).then(function (result) {
            if (!result.data.length)
              $scope.pageEnd = true;
            else
              $scope.discussions = $scope.discussions.concat(result.data);
          });
        }
      };

    }])
  .
  filter('unsafe', function ($sce) {
    return function (val) {
      return $sce.trustAsHtml(val);
    };

  });
