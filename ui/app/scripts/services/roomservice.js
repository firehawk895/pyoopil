'use strict';

/**
 * @ngdoc service
 * @name uiApp.roomService
 * @description
 * # roomService
 * Factory in the uiApp.
 */
angular.module('uiApp')
  .factory('roomService', ['Restangular', function (restangular) {
    var self = this;

    self.getRooms = function (page) {
      page = page || 1;
      return restangular.all("Classrooms").customGET("getclassrooms.json", {page: page});
    };
    self.getDiscussions = function (roomId, page, type) {
      page = page || 1;
//      return restangular.one("Classrooms", roomId).all("Discussions").customGET("getdiscussions.json", {page: page});
      if (type == "folded")
        return restangular.one("Classrooms", roomId).all("Discussions").customGET("getdiscussions.json", {page: page, folded: true});
      else
        return restangular.one("Classrooms", roomId).all("Discussions").customGET("getdiscussions.json", {page: page});
    };
    self.getAnnouncements = function (roomId, page) {
      page = page || 1;
      return restangular.one("Classrooms", roomId).all("Announcements").customGET("getannouncements.json", {page: page});
    };
    self.getPeoples = function (roomId, page) {
      page = page || 1;
      return restangular.one("Classrooms", roomId).all("People").customGET("getpeople.json", {page: page});
    };
    self.getTopics = function (roomId, page) {
      page = page || 1;
      return restangular.one("Classrooms", roomId).all("Libraries").customGET("getTopics.json", {page: page});
    };
    self.getTopicsList = function (roomId, page) {
      page = page || 1;
      return restangular.one("Classrooms", roomId).all("Libraries").customGET("getTopicsList.json", {page: page});
    };
    self.createAnnouncement = function (roomId, subject, body, file) {

      var formData = new FormData();
      formData.append("data[Announcement][subject]", subject);
      formData.append("data[Announcement][body]", body);

      if (angular.isDefined(file))
        formData.append("data[Announcement][file_path]", file);
      return restangular.one("Classrooms", roomId)
        .all("Announcements")
        .withHttpConfig({transformRequest: angular.identity})
        .customPOST(formData, "add.json", undefined, {'Content-Type': undefined});
    };
    self.createDiscussion = function (roomId, topic, body, file, type) {

      var formData = new FormData();
      formData.append("data[Discussion][topic]", topic);
      formData.append("data[Discussion][body]", body);
      formData.append("data[Discussion][type]", type);
//      if (angular.isDefined(file))
//        formData.append("data[Announcement][file_path]", file);

      return restangular.one("Classrooms", roomId)
        .all("Discussions")
        .withHttpConfig({transformRequest: angular.identity})
        .customPOST(formData, "add.json", undefined, {'Content-Type': undefined});
    };
    self.joinClassroom = function (accessCode) {
      return restangular.all("Classrooms").customPOST(accessCode, "join.json");
    };
    self.createClassroom = function (classroom) {
      return restangular.all("Classrooms").customPOST(classroom, "add.json");
    };
    self.getCampuses = function () {
      return restangular.all("Classrooms").customGET("getCampusesList.json");
    };
    self.getDepartments = function () {
      return restangular.all("Classrooms").customGET("getDepartmentsList.json");
    };
    self.getDegrees = function () {
      return restangular.all("Classrooms").customGET("getDegreesList.json");
    };
    self.removeModerator = function (roomId, id) {
      return restangular.one("Classrooms", roomId).all("People").customPOST({ids: id}, "removeModerator.json");
    };
    self.unRestrict = function (roomId, id) {
      return restangular.one("Classrooms", roomId).all("People").customPOST({ids: id}, "removeRestricted.json");
    };
    self.setModerator = function (roomId, setModIds) {
      var setModeratorIds = "";
      if (setModIds.length == 1)
        setModeratorIds = setModIds + ",";
      else
        setModeratorIds = setModIds.toString();
      return restangular.one("Classrooms", roomId).all("People").customPOST({ids: setModeratorIds}, "setModerator.json");
    };
    self.setRestricted = function (roomId, setRestrictIds) {
      var setRestrictedIds = "";
      if (setRestrictIds.length == 1)
        setRestrictedIds = setRestrictIds + ",";
      else
        setRestrictedIds = setRestrictIds.toString();
      return restangular.one("Classrooms", roomId).all("People").customPOST({ids: setRestrictedIds}, "setRestricted.json");
    };
    self.deleteFile = function (id, type) {
      var file = {id: id, type: type};
      return restangular.all("Classrooms").all("Libraries").customPOST(file, "deleteItem.json");
    };
    self.editTopic = function (name, id) {
      var data = {
        Topic: {
          id: id,
          name: name
        }
      };
      return restangular.all("Classrooms").all("Libraries").customPOST(data, "editTopic.json");
    };
    self.deleteTopic = function (id) {
      var data = {
        Topic: {
          id: id
        }
      };
      return restangular.all("Classrooms").all("Libraries").customPOST(data, "deleteTopic.json");
    };

    self.uploadFiles = function (roomId, id, name, files, links) {
      var formData = new FormData();

      if (id)
        formData.append("data[Topic][id]", id);
      else
        formData.append("data[Topic][name]", name);

      if (files.length) {
        angular.forEach(files, function (value, key) {
          if (angular.isDefined(value))
            formData.append("data[Pyoopilfile][" + key + "][file_path]", value);
        });
      }
      if (links.length) {
        angular.forEach(links, function (value, key) {
          if (angular.isDefined(value))
            formData.append("data[Link][" + key + "][linktext]", value);
        });
      }
      return restangular.one("Classrooms", roomId)
        .all("Libraries")
        .withHttpConfig({transformRequest: angular.identity})
        .customPOST(formData, "add.json", undefined, {'Content-Type': undefined});
    };
    self.delete = function (id, type) {
      var data = {
        type: type,
        id: id
      };
      return restangular.all("Classrooms").all("Discussions").customPOST(data, "delete.json");
    };
    self.toggleFold = function (id) {
      return restangular.all("Classrooms").all("Discussions").customPOST({id: id}, "togglefold.json");
    };
    self.addReply = function (id, comment) {
      return restangular.all("Classrooms").all("Discussions").customPOST({discussion_id: id, comment: comment}, "addReply.json");
    };
    self.setGamificationVote = function (id, vote, type) {
      return restangular.all("Classrooms").all("Discussions").customPOST({id: id, vote: vote, type: type}, "setGamificationVote.json")
    };
    return self;
  }]);
