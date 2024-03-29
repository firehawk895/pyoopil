// Generated by CoffeeScript 1.7.1
var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

angular.module('Pyoopil.Services').factory('classroomService', [
  'Base', function(Base) {
    var ClassroomService;
    return new (ClassroomService = (function(_super) {
      __extends(ClassroomService, _super);

      function ClassroomService() {
        ClassroomService.__super__.constructor.apply(this, arguments);
        this.path += 'Classrooms/';
      }

      ClassroomService.prototype.getData = function(url, data) {
        var path;
        path = this.path + url;
        return ClassroomService.__super__.getData.call(this, path, data);
      };

      ClassroomService.prototype.postData = function(url, data) {
        var path;
        path = this.path + url;
        return ClassroomService.__super__.postData.call(this, url, data);
      };

      ClassroomService.prototype.getClassrooms = function(pageNo) {
        var url;
        url = 'getclassrooms.json?page=' + pageNo;
        return this.getData(url);
      };

      ClassroomService.prototype.newClassroom = function(data) {
        var url;
        url = 'add.json';
        return this.postData(url, data);
      };

      ClassroomService.prototype.joinClassroom = function(data) {
        var url;
        url = 'join.json';
        return this.postData(url, data);
      };

      return ClassroomService;

    })(Base));
  }
]);
