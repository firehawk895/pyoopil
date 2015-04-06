angular.module('uiApp')
  .controller('foldedDiscussionCtrl', ['$scope', '$stateParams' , 'roomService', 'toastService', 'modalService',
    function ($scope, $stateParams, roomService, toastService, modalService) {
      $scope.page = 1;
      $scope.discussions = [];
      roomService.getDiscussions($stateParams.roomId, $scope.page, "folded").then(function (result) {
        $scope.discussions = result.data;
        $scope.canEndorse = result.permissions.allowEndorse;
        angular.forEach($scope.discussions, function (value, key) {
          if (value.Discussion.showPollVote) {
            var choiceCategories = [];
            var choiceData = [];
            angular.forEach(value.Pollchoice, function (value, key) {
              choiceCategories.push(value.choice);
              choiceData.push(parseInt(value.votes));
            });
            value.chartConfig = {
              options: {
                chart: {
                  type: 'bar',
                  width: 380,
                  height: 270
                },
                legend: {
                  align: 'right',
                  verticalAlign: 'top'
                },
                yAxis: {
                  labels: {
                    enabled: false
                  },
                  min: 0,
                  title: {
                    text: ''
                  }
                }
              },
              xAxis: {
                categories: choiceCategories
              },
              series: [
                {
                  name: 'Reply',
                  data: choiceData,
                  color: '#ff992f'
                }
              ],
              title: {
                text: null
              }
            };
          }
          value.Replies = value.Replies || [];
          if (value.Replies.length)
            value.Replies = value.Replies.reverse();
          value.currentPage = 1;
          value.newReply = "";
          value.isPraiseVisible = false;
          angular.forEach(value.Replies, function (value, key) {
            value.isIconVisible = false;
            value.isReplyPraiseVisible = false;
          });
        });
      });
      $scope.updatePage = function () {
        if (!$scope.pageEnd) {
          roomService.getDiscussions($stateParams.roomId, ++$scope.page, "folded").then(function (result) {
            if (!result.data.length)
              $scope.pageEnd = true;
            else
              angular.forEach(result.data, function (value, key) {
                if (value.Discussion.showPollVote) {
                  var choiceCategories = [];
                  var choiceData = [];
                  angular.forEach(value.Pollchoice, function (value, key) {
                    choiceCategories.push(value.choice);
                    choiceData.push(parseInt(value.votes));
                  });


                  value.chartConfig = {
                    options: {
                      chart: {
                        type: 'bar',
                        width: 380,
                        height: 270
                      },
                      legend: {
                        align: 'right',
                        verticalAlign: 'top'
                      },
                      yAxis: {
                        labels: {
                          enabled: false
                        },
                        min: 0,
                        title: {
                          text: ''
                        }
                      }
                    },
                    xAxis: {
                      categories: choiceCategories
                    },
                    series: [
                      {
                        name: 'Reply',
                        data: choiceData,
                        color: '#ff992f'
                      }
                    ],
                    title: {
                      text: null
                    }
                  };
                }
                value.Replies = value.Replies || [];
                if (value.Replies.length)
                  value.Replies = value.Replies.reverse();
                value.currentPage = 1;
                value.newReply = "";
                value.isPraiseVisible = false;
                angular.forEach(value.Replies, function (value, key) {
                  value.isIconVisible = false;
                  value.isReplyPraiseVisible = false;
                });
              });
            $scope.discussions = $scope.discussions.concat(result.data);
          });
        }
      };
      $scope.getReplies = function (index) {
        roomService.getReplies($scope.discussions[index].Discussion.id, $scope.discussions[index].currentPage).then(function (result) {
          if (result.status) {
            if (!result.data.length)
              toastService.show(false, "No more replies to load");
            else if ($scope.discussions[index].currentPage == 1) {
              $scope.discussions[index].Replies = result.data.reverse();
              $scope.discussions[index].currentPage++;

            }
            else {
              $scope.discussions[index].Replies = result.data.reverse().concat($scope.discussions[index].Replies);
              $scope.discussions[index].currentPage++;
            }
          }
        });
      };
      $scope.deleteDiscussion = function (index) {
        roomService.deleteInDiscussion($scope.discussions[index].Discussion.id, "Discussion").then(function (result) {
          toastService.show(result.status, result.message);
          if (result.status)
            $scope.discussions.splice(index, 1);
        });
      };
      $scope.deleteReply = function (parentIndex, index) {

        roomService.deleteInDiscussion($scope.discussions[parentIndex].Replies[index].Reply.id, "Reply").then(function (result) {
          toastService.show(result.status, result.message);
          if (result.status)
            $scope.discussions[parentIndex].Replies.splice(index, 1);
        });
      };
      $scope.toggleFold = function (index) {
        roomService.toggleFold($scope.discussions[index].Discussion.id).then(function (result) {
          toastService.show(result.status, result.message);
          if (result.status)
            $scope.discussions[index].Discussion.isFolded = !$scope.discussions[index].Discussion.isFolded;
        });
      };
      $scope.addReply = function (index) {
        roomService.addReply($scope.discussions[index].Discussion.id, $scope.discussions[index].newReply).then(function (result) {
          toastService.show(result.status, "Comments Posted");
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
            $scope.discussions[index].Gamificationvote = result.data.Gamificationvote;
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
            $scope.discussions[parentIndex].Replies[index].Gamificationvote = result.data.Gamificationvote;
          }
        });
      };
      $scope.setPollVote = function (parentIndex, index) {

        if (!$scope.discussions[parentIndex].Discussion.showPollVote) {
          roomService.setPollVote($scope.discussions[parentIndex].Pollchoice[index].id).then(function (result) {
            if (result.status) {
              $scope.discussions[parentIndex] = result.data[0];
              var choiceCategories = [];
              var choiceData = [];
              angular.forEach($scope.discussions[parentIndex].Pollchoice, function (value, key) {
                choiceCategories.push(value.choice);
                choiceData.push(parseInt(value.votes));
              });
              $scope.discussions[parentIndex].chartConfig = {
                options: {
                  chart: {
                    type: 'bar',
                    width: 380,
                    height: 270
                  },
                  legend: {
                    align: 'right',
                    verticalAlign: 'top'
                  },
                  yAxis: {
                    labels: {
                      enabled: false
                    },
                    min: 0,
                    title: {
                      text: ''
                    }
                  }
                },

                xAxis: {
                  categories: choiceCategories
                },
                series: [
                  {
                    name: 'Reply',
                    data: choiceData,
                    color: '#ff992f'
                  }
                ],
                title: {
                  text: null
                }
              };
            }
          })
        }
        else
          toastService.show(false, "Cannot vote on poll")
      };
      $scope.getNames = function (arr) {
        return arr.join('\n');
      };
      $scope.openDocViewerDialog = function (path) {
        modalService.openDocViewerDialog($scope, path);
      };
    }]);