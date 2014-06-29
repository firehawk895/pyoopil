// Generated by CoffeeScript 1.7.1
(function() {
  var App;

  App = window.App || {};

  App.LeftNavScroll = App.LeftNavScroll || {};

  (function($, window, document) {
    var Templates;
    Templates = (function() {
      function Templates() {
        this.setTemplates();
      }

      Templates.prototype.setTemplates = function() {
        return this.templates = {
          'classroomTile': '<div class="scroll-content-item"> <a href="{{ Classroom.Campus.Url }}"> <div class="classouter"> <div class="doc-list"> <div class="doc-top"> <p class="subject">{{ Classroom.title }} <span>by</span> <span>{{ Classroom.Educator }}</span> <span class="totalstudent">( {{Classroom.users_classroom_count}} Students)</span> </div> </div> </div> </a> </div>',
          'default': '<p>No template Available'
        };
      };

      Templates.prototype.getTemplate = function(template) {
        if ((template != null) && this.templates.hasOwnProperty(template)) {
          return this.templates[template];
        } else {
          return this.templates["default"];
        }
      };

      return Templates;

    })();
    return App.LeftNavScroll.templates = new Templates('.sub');
  })($, window, document);

}).call(this);