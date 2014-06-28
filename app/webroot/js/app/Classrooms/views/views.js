// Generated by CoffeeScript 1.7.1
var App,
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

App = window.App || {};

App.classrooms = App.classrooms || {};

(function($, window, document) {
  var Views;
  Views = (function() {
    function Views(elem) {
      this.newJoin = __bind(this.newJoin, this);
      this.newClassroom = __bind(this.newClassroom, this);
      this.renderClassrooms = __bind(this.renderClassrooms, this);
      this.init = __bind(this.init, this);
      this.$elem = elem;
      this.$createForm = $("#create-assign");
      this.$quizDialog = $('#quizdialog');
      this.init();
    }

    Views.prototype.init = function() {
      this.classroomTemplate = Handlebars.compile(App.classrooms.templates.getTemplate('classroomTile'));
      return this.quizDialogTemplate = Handlebars.compile(App.classrooms.templates.getTemplate('quizTmpl'));
    };

    Views.prototype.renderClassrooms = function(e, classrooms) {
      var classroom, classroomsHtml;
      classroomsHtml = (function() {
        var _i, _len, _results;
        if (classrooms != null) {
          _results = [];
          for (_i = 0, _len = classrooms.length; _i < _len; _i++) {
            classroom = classrooms[_i];
            _results.push(this.renderClassroom(classroom));
          }
          return _results;
        }
      }).call(this);
      this.$elem.append(classroomsHtml);
      return this.$elem.trigger('Classrooms.RENDER', true);
    };

    Views.prototype.renderClassroom = function(classroom) {
      var classroomHtml;
      if (classroom.hasOwnProperty('data')) {
        classroomHtml = this.classroomTemplate(classroom.data);
      } else {
        classroomHtml = this.classroomTemplate(classroom);
      }
      return classroomHtml;
    };

    Views.prototype.newClassroom = function(e, classroom) {
      var quizDialog;
      this.$createForm.dialog("close");
      quizDialog = this.quizDialogTemplate(classroom.data);
      this.$quizDialog.html(quizDialog);
      $('.ui-widget-overlay').addClass('custom-overlay');
      this.$quizDialog.dialog("open");
      this.$elem.prepend(this.renderClassroom(classroom));
      return this.$elem.trigger('Classrooms.RENDER', false);
    };

    Views.prototype.newJoin = function(e, classroom) {
      $(".newjoin").show();
      $(".accessclass").hide();
      this.$elem.prepend(this.renderClassroom(classroom));
      return this.$elem.trigger('Classrooms.RENDER', false);
    };

    return Views;

  })();
  return App.classrooms.views = Views;
})($, window, document);
