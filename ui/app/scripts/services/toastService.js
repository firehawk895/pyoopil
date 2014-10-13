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

    self.show = function (messageType, message) {


      if (messageType)
        toastr.success(message);
      else
        toastr.error(message);
    };


    return self;


    // AngularJS will instantiate a singleton by calling "new" on this function
  });
