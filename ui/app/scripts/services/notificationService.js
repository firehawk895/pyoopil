angular.module('uiApp')
  .factory('notificationService', ['$q', '$firebase', 'localStorageService', function ($q, $firebase, localStorageService) {

    var self = this;
    var id = localStorageService.get("id");
    var ref = new Firebase("https://vivid-torch-3610.firebaseio.com/" + id);
    var unreadNotificationsCountRef = $firebase(ref.child('unread'));
    var initialNotificationsRef = $firebase(ref.child('nof').limit(20));
    var notificationsRef = $firebase(ref.child('nof'));
    var unreadNotificationsCount = unreadNotificationsCountRef.$asObject();
    var initialNotifications = initialNotificationsRef.$asArray();
    var notifications = notificationsRef.$asArray();


    self.getUnreadNotificationsCount = function () {
      var deferred = $q.defer();
      unreadNotificationsCount.$loaded().then(function () {
        deferred.resolve(unreadNotificationsCount);
      });
      return deferred.promise;
    };

    self.getInitialNotifications = function () {
      var deferred = $q.defer();
      unreadNotificationsCountRef.$set("0");
      initialNotifications.$loaded().then(function () {
        deferred.resolve(initialNotifications);
      });
      return deferred.promise;
    };

    self.getNotifications = function () {
      var deferred = $q.defer();
      notifications.$loaded().then(function () {
        deferred.resolve(notifications);
      });
      return deferred.promise;
    };

    self.setClickedInitial = function (index) {
      initialNotifications.$save(index);
    };
    self.setClicked = function (index) {
      notifications.$save(index);
    };

    return self;
    // AngularJS will instantiate a singleton by calling "new" on this function
  }]);