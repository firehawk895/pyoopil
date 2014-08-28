/**
 * Created by himanshu on 21/8/14.
 */
angular.module('uiApp')
  .controller('libraryCtrl', ['$scope', '$stateParams' , 'roomService', 'notificationService', 'ngDialog',
    function ($scope, $stateParams, roomService, notificationService, ngDialog) {

      $scope.page = 1;
      $scope.topics = [];
      $scope.roomId = $stateParams.roomId;

      roomService.getTopics($stateParams.roomId, $scope.page).then(function (result) {
        $scope.topics = result.data;
      });

      $scope.updatePage = function () {
        roomService.getTopics($stateParams.roomId, ++$scope.page).then(function (result) {
          $scope.topics = $scope.topics.concat(result.data);
        });
      };
      $scope.showFileName = function (name) {
        var fileNameArray = name.split(".");
        if (fileNameArray.length > 1)
          fileNameArray.pop();
        var filename = fileNameArray.join(".");
        return filename;
      };
      $scope.deleteFile = function (topic, index) {
        roomService.deleteFile(topic.Documents[index].id, "File").then(function (result) {
          notificationService.show(result.status, result.message);
          if (result.status) {
            topic.Documents.splice(index, 1);
          }
        });
      };
      $scope.deletePicture = function (topic, index) {
        roomService.deleteFile(topic.Pictures[index].id, "File").then(function (result) {
          notificationService.show(result.status, result.message);
          if (result.status) {
            topic.Pictures.splice(index, 1);
          }
        });
      };

      $scope.deleteLink = function (topic, index) {
        roomService.deleteLink(topic.Link[index].id, "link").then(function (result) {
          notificationService.show(result.status, result.message);
          if (result.status) {
            topic.Link.splice(index, 1);
          }
        });
      };
    }]);