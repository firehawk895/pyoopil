angular.module('uiApp')
  .factory('notificationService', ['$q', '$firebase', 'localStorageService', function ($q, $firebase, localStorageService) {

    var self = this;
    var id = localStorageService.get("id");
//    todo:Make it general for logged in user
    var notificationsRef = new Firebase("https://vivid-torch-3610.firebaseio.com/19");

    self.getUnreadNotificationsCount = function () {
      var deferred = $q.defer();
      var unreadNotificationsCount = $firebase(notificationsRef.child('unread')).$asObject();
      unreadNotificationsCount.$loaded().then(function () {
        deferred.resolve(unreadNotificationsCount.$value);
      });
      return deferred.promise;
    };

    self.getInitialNotifications = function () {
      var deferred = $q.defer();
      var initialNotifications = $firebase(notificationsRef.child('nof').limit(10)).$asArray();
      initialNotifications.$loaded().then(function () {
        deferred.resolve(initialNotifications);
      });
      return deferred.promise;
    };
    self.getNotifications = function () {
      var deferred = $q.defer();
      var notifications = $firebase(notificationsRef.child('nof')).$asArray();
      notifications.$loaded().then(function () {
        deferred.resolve(notifications);
      });
      return deferred.promise;
    };
    return self;


    // AngularJS will instantiate a singleton by calling "new" on this function
  }]);