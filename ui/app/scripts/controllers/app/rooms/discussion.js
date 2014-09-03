/**
 * Created by himanshu on 3/9/14.
 */
angular.module('uiApp')
  .controller('discussionCtrl', ['$scope', '$stateParams' , 'roomService', 'notificationService',
    function ($scope, $stateParams, roomService, notificationService) {
      $scope.page = 1;
      $scope.roomId = $stateParams.roomId;

      roomService.getDiscussions($stateParams.roomId, $scope.page).then(function (result) {
        $scope.discussions = result.data;
        $scope.canCreate = result.permissions.allowCreate;
      });
      $scope.deleteDiscussion = function (index) {

        roomService.delete($scope.discussions[index].Discussion.id, "Discussion").then(function (result) {
          notificationService.show(result.status, result.message);
          if (result.status)
            $scope.discussions.splice(index, 1);
        });
      };
      $scope.deleteReply = function (discussion, index) {

        roomService.delete(discussion.Reply[index].id, "Reply").then(function (result) {
          notificationService.show(result.status, result.message);
          if (result.status)
            $scope.discussions.splice(index, 1);
        });
      };
      $scope.toggleFold = function (index) {
        roomService.toggleFold($scope.discussions[index].Discussion.id).then(function (result) {
          notificationService.show(result.status, result.message);
          if (result.status)
            $scope.discussions[index].Discussion.isFolded = !$scope.discussions[index].Discussion.isFolded;
        });
      }

    }]);
