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

    self.getRoom = function (roomId) {

    };

    self.getAnnouncements = function (roomId, page) {
      page = page || 1;

      return restangular.one("Classrooms", roomId).all("Announcements").customGET("getannouncements.json", {page: page});
    };

    self.getPeoples = function (roomId, page) {
      page = page || 1;

      return restangular.one("Classrooms", roomId).all("People").customGET("getpeople.json", {page: page});
    };

    self.createAnnouncement = function (roomId, announcement) {
      //todo: support attachments

      return restangular.one("Classrooms", roomId).all("Announcements").customPOST(announcement, "add.json");
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


    return self;
  }]);
