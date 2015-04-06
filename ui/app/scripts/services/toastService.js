'use strict';

/**
 * @ngdoc service
 * @name uiApp.toastservice
 * @description
 * # toastservice
 * Service in the uiApp.
 */
angular.module('uiApp')
  .factory('toastService', function () {

    var self = this;

    self.show = function (messageType, message, login) {
      if (login == 'Feedback') {
        toastr.options = {
          "closeButton": true,
          "debug": false,
          "positionClass": "toast-top-right",
          "onclick": null,
          "showDuration": "20000",
          "hideDuration": "20000",
          "timeOut": "20000",
          "extendedTimeOut": "20000"
        };
        toastr.warning(message, login);
      }
      else {
        toastr.options = {
          "closeButton": false,
          "debug": false,
          "positionClass": "toast-top-right",
          "onclick": null,
          "showDuration": "300",
          "hideDuration": "1000",
          "timeOut": "1000",
          "extendedTimeOut": "1000"
        };
        if (messageType)
          toastr.success(message);
        else
          toastr.error(message);
      }
    };


    return self;


    // AngularJS will instantiate a singleton by calling "new" on this function
  });
