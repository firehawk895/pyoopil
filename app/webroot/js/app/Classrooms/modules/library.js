// Generated by CoffeeScript 1.7.1
var App,
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

App = window.App || {};

App.classrooms = App.classrooms || {};

(function($, window, document) {
  var $document, Library;
  $document = $(document);
  Library = (function() {
    function Library() {
      this.announcementsRendered = __bind(this.announcementsRendered, this);
    }

    Library.prototype.init = function(elem) {
      this.$elem = $(elem);
      this.services = App.classrooms.libraryServices;
      this.views = new App.classrooms.libraryViews(this.$elem);
      this.notifier = App.common.notifier;
      this.setEventListeners();
      return this.getLibraries();
    };

    Library.prototype.getLibraries = function() {
      var promise;
      promise = this.services.getLibraries();
      return promise.then((function(_this) {
        return function(data) {
          if (_this.services.isValid(data) === true) {
            return $document.trigger('Libraries.UPDATE', [data]);
          } else {
            return _this.notifier.notify('error', 'No Libraries found');
          }
        };
      })(this));
    };

    Library.prototype.setEventListeners = function() {
      $document.on('Libraries.UPDATE', this.views.renderLibraries);
      $document.on('Libraries.CREATE', this.views.newAnnouncement);
      return $document.on('click', '#upload', function() {
        return $('#TopicIndexForm').submit();
      });
    };

    Library.prototype.newAnnouncement = function(e) {
      var ajax;
      e.preventDefault();
      ajax = App.classrooms.services.newClassroom($(this).serialize());
      return ajax.done(function(data) {
        if (data.status === false) {
          App.common.notifier.notify('error', data.message);
          return;
        }
        if (App.classrooms.services.isValid([data]) === true) {
          return $document.trigger('Libraries.CREATE', [data]);
        } else {
          return App.common.notifier.notify('error', 'New Classroom Creation failed');
        }
      });
    };

    Library.prototype.announcementsRendered = function(e, isInitial) {
      if (isInitial === true) {
        return this.$tinyscrollbar.update('relative');
      } else {
        return this.$tinyscrollbar.update();
      }
    };

    return Library;

  })();
  return App.classrooms.library = new Library();
})($, window, document);