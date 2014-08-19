'use strict';

/**
 * @ngdoc service
 * @name uiApp.Notificationservice
 * @description
 * # Notificationservice
 * Service in the uiApp.
 */
angular.module('uiApp')
    .factory('notificationService', function () {

        var self = this;

        self.show = function (messageType, message) {


            if (messageType)
                toastr.success(message);
            else if(messageType==false)
            toastr.error(message);
        };


        return self;


        // AngularJS will instantiate a singleton by calling "new" on this function
    });
