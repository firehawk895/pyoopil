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

        self.createAnnouncement = function (roomId, announcement) {
            //todo: support attachments

            return restangular.one("Classrooms", roomId).all("Announcements").customPOST(announcement, "add.json");
        };


        return self;
    }]);
