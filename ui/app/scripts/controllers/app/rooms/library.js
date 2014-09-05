/**
 * Created by himanshu on 21/8/14.
 */
angular.module('uiApp')
  .controller('libraryCtrl', ['$scope', '$stateParams' , 'roomService', 'notificationService', 'ngDialog',
    function ($scope, $stateParams, roomService, notificationService, ngDialog) {

      $scope.page = 1;
      $scope.pageEnd=false;
      $scope.topics = [];
      $scope.roomId = $stateParams.roomId;
      $scope.showContent = true;
      $scope.lastExpandedItemIndex = -1;
      $scope.editTopicName = false;
      $scope.libraryUpload = {};
      $scope.libraryUpload.id = null;
      $scope.libraryUpload.name = "";
      $scope.libraryUpload.files = ["file-0"];
      $scope.libraryUpload.links = [];
      $scope.linkIndex = 0;
      $scope.vm = {};
      $scope.vm.files = ["file-0"];
      $scope.vm.links = [
        {
          url: "",
          isVisible: true
        },
        {
          url: "",
          isVisible: false
        },
        {
          url: "",
          isVisible: false
        },
        {
          url: "",
          isVisible: false
        },
        {
          url: "",
          isVisible: false
        },
        {
          url: "",
          isVisible: false
        }
      ];
      $scope.isNewTopic = true;
      $scope.uploadFileFlag = true;

      roomService.getTopics($stateParams.roomId, $scope.page).then(function (result) {
        $scope.topics = result.data;
        $scope.canUpload = result.permissions.allowCUD;
      });

      roomService.getTopicsList($stateParams.roomId, $scope.page).then(function (result) {
        $scope.topicsList = result.data;
      });


      $scope.updatePage = function () {
        if (!$scope.pageEnd) {
          roomService.getTopics($stateParams.roomId, ++$scope.page).then(function (result) {
            if (!result.data.length)
              $scope.pageEnd = true;
            else
              $scope.topics = $scope.topics.concat(result.data);
          });
        }
      };
      $scope.showFileName = function (name) {
        var fileNameArray = name.split(".");
        if (fileNameArray.length > 1)
          fileNameArray.pop();
        var filename = fileNameArray.join(".");
        return filename;
      };
      $scope.deleteDoc = function (topic, index) {
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

      $scope.deletePresentation = function (topic, index) {
        roomService.deleteFile(topic.Presentations[index].id, "File").then(function (result) {
          notificationService.show(result.status, result.message);
          if (result.status) {
            topic.Presentations.splice(index, 1);
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

      $scope.showThumbnail = function (url) {
        var p = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
        var id = (url.match(p)) ? RegExp.$1 : false;
        return "http://img.youtube.com/vi/" + id + "/default.jpg";
      };

      $scope.deleteTopic = function (index) {
        roomService.deleteTopic(index).then(function (result) {
          notificationService.show(result.status, result.message);
          if (result.status)
            $scope.topics.splice(index, 1);
        });

      };

      $scope.deleteVideo = function (topic, index) {
        roomService.deleteFile(topic.Video[index].id, "File").then(function (result) {
          notificationService.show(result.status, result.message);
          if (result.status)
            topic.Video.splice(index, 1);
        });
      };
      $scope.showStep1 = function () {
        ngDialog.close();
        ngDialog.open({
          scope: $scope,
          template: 'views/app/rooms/uploadFileDialog1.html'
        });

      };
      $scope.displayContent = function (index) {
        if ($scope.lastExpandedItemIndex == -1) {
          $scope.lastExpandedItemIndex = index;
          $scope.topics[index].showContent = true;
        }
        else if ($scope.lastExpandedItemIndex == index) {
          $scope.lastExpandedItemIndex = -1;
          $scope.topics[index].showContent = false;
        }
        else {
          $scope.topics[$scope.lastExpandedItemIndex].showContent = false;
          $scope.topics[index].showContent = true;
          $scope.lastExpandedItemIndex = index;
        }
      };
      $scope.editTopic = function (name, id) {
        roomService.editTopic(name, id).then(function (result) {
          notificationService.show(result.status, result.message);
          //          if (result.status)
//            $scope.topics[index].Topic.name = $scope.newTopic;
        });
      };
      $scope.showStep2 = function () {
        if ($scope.libraryUpload.id == null && $scope.libraryUpload.name == "")
          notificationService.show(false, "Enter topic Name or choose a topic");
        else {
          ngDialog.close();
          ngDialog.open({
            scope: $scope,
            template: 'views/app/rooms/uploadFileDialog2.html'
          });
        }
      };
      $scope.checkNew = function () {
        if ($scope.libraryUpload.id) {
          $scope.isNewTopic = false;
          angular.forEach($scope.topicsList, function (value, key) {
            if (key == $scope.libraryUpload.id)
              $scope.libraryUpload.name = value;
          });
        }
        else {
          $scope.isNewTopic = true;
          $scope.libraryUpload.name = "";
          $scope.libraryUpload.id = null;
        }
      };
      $scope.uploadFiles = function () {

        angular.forEach($scope.vm.links, function (value, key) {
          if (value.url != "")
            $scope.libraryUpload.links.push(value.url);
        });

//        console.log($scope.libraryUpload.files);
//        console.log($scope.libraryUpload.links);
//        console.log($scope.vm.links);


        roomService.uploadFiles($stateParams.roomId, $scope.libraryUpload.id, $scope.libraryUpload.name, $scope.libraryUpload.files, $scope.libraryUpload.links).
          then(function (result) {
            notificationService.show(result.status, result.message);
            if (result.status)
              $scope.libraryUpload = {};
          });
      };

      $scope.addNewFile = function () {
        $scope.libraryUpload.files.push("file-" + $scope.libraryUpload.files.length);
      };

      $scope.addNewLink = function () {
        $scope.linkIndex++;
        $scope.vm.links[$scope.linkIndex].isVisible = true;
      };
    }])
;