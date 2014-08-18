'use strict';

/**
 * @ngdoc service
 * @name uiApp.roomService
 * @description
 * # roomService
 * Factory in the uiApp.
 */
angular.module('uiApp')
  .factory('roomService', function () {
    var self = this;

    self.getRooms = function () {

    };

    self.getRoom = function (roomId) {

    };

    self.getAnnouncements = function(roomId){

    };

    self.createAnnouncement = function(subject, message, attachment){
      //todo: support attachments




    };


    return self;
  });
