// Generated by CoffeeScript 1.7.1
var App,
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

App = window.App || {};

App.classrooms = App.classrooms || {};

(function($, window, document) {
  var $document, Announcement;
  $document = $(document);
  Announcement = (function() {
    function Announcement() {
      this.classroomsRendered = __bind(this.classroomsRendered, this);
    }

    Announcement.prototype.init = function(elem) {
      var $tinyscrollbar;
      this.$elem = $(elem);
      this.$createClassroomForm = $('#AnnouncementIndexForm');
      this.$viewport = this.$elem.closest('.tinyscrollbar').find('.viewport');
      this.currentPage = 1;
      this.hasScrollReached = false;
      this.services = App.classrooms.announcementServices;
      this.views = new App.classrooms.announcementViews(this.$elem.find('.announcements'));
      this.notifier = App.common.notifier;
      $tinyscrollbar = $('.tinyscrollbar');
      $tinyscrollbar.tinyscrollbar({
        thumbSize: 9
      });
      this.$tinyscrollbar = $tinyscrollbar.data("plugin_tinyscrollbar");
      this.setEventListeners();
      return this.getAnnouncements();
    };

    Announcement.prototype.getAnnouncements = function() {
      var promise;
      promise = this.services.getAnnouncements();
      return promise.then((function(_this) {
        return function(data) {
          if (_this.services.isValid(data) === true) {
            return $document.trigger('Announcements.UPDATE', [data]);
          } else {
            return _this.notifier.notify('error', 'No Announcements found');
          }
        };
      })(this));
    };

    Announcement.prototype.setEventListeners = function() {
      $document.on('Announcements.UPDATE', this.views.renderAnnouncements);
      $document.on('Announcements.CREATE', this.views.newClassroom);
      $document.on('Announcements.RENDER', this.classroomsRendered);
      this.$createClassroomForm.on('submit', this.newClassroomSubmit);
      return this.$viewport.on('endOfScroll', (function(_this) {
        return function() {
          var ajax;
          if (_this.hasScrollReached === false) {
            _this.hasScrollReached = true;
            _this.currentPage += 1;
            ajax = _this.services.getClassroomsByPage(_this.currentPage);
            return ajax.done(function(data) {
              if (data.data && data.data.length > 0) {
                $document.trigger('Announcements.UPDATE', [[data.data]]);
              } else {
                App.common.notifier.notify('error', 'No more Data to Display');
              }
              return _this.hasScrollReached = false;
            });
          }
        };
      })(this));
    };

    Announcement.prototype.newAnnouncement = function(e) {
      var ajax;
      e.preventDefault();
      ajax = App.classrooms.services.newClassroom($(this).serialize());
      return ajax.done(function(data) {
        if (data.status === false) {
          App.common.notifier.notify('error', data.message);
          return;
        }
        if (App.classrooms.services.isValid([data]) === true) {
          return $document.trigger('Announcements.CREATE', [data]);
        } else {
          return App.common.notifier.notify('error', 'New Classroom Creation failed');
        }
      });
    };

    Announcement.prototype.classroomsRendered = function(e, isInitial) {
      if (isInitial === true) {
        return this.$tinyscrollbar.update('relative');
      } else {
        return this.$tinyscrollbar.update();
      }
    };

    return Announcement;

  })();
  return App.classrooms.announcement = new Announcement();
})($, window, document);
