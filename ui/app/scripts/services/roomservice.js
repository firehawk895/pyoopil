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

    self.getRooms = function () {

    };

    self.getRoom = function (roomId) {

    };

    self.getAnnouncements = function (roomId, page) {
      page = page || 1;

      restangular.one("classrooms", roomId).all("announcements").customGET("getAnnouncements.json", {page: page});
    };

    self.createAnnouncement = function (subject, message, attachment) {
      //todo: support attachments


    };


    return self;
  }]);
