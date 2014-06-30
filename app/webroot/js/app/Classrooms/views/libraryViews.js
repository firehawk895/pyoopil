// Generated by CoffeeScript 1.7.1
var App,
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

App = window.App || {};

App.classrooms = App.classrooms || {};

(function($, window, document) {
  var LibraryViews;
  LibraryViews = (function() {
    function LibraryViews(elem) {
      this.newLibrary = __bind(this.newLibrary, this);
      this.renderLibraries = __bind(this.renderLibraries, this);
      this.init = __bind(this.init, this);
      this.$elem = elem.find('#library');
      console.log(this.$elem);
      this.init();
    }

    LibraryViews.prototype.init = function() {
      this.libraryTemplate = Handlebars.compile(App.classrooms.templates.getTemplate('libraryTmpl'));
      return '';
    };

    LibraryViews.prototype.renderLibraries = function(e, libraries) {
      var librariesHtml, library;
      librariesHtml = (function() {
        var _i, _len, _results;
        if (libraries != null) {
          _results = [];
          for (_i = 0, _len = libraries.length; _i < _len; _i++) {
            library = libraries[_i];
            _results.push(this.renderLibrary(library));
          }
          return _results;
        }
      }).call(this);
      this.$elem.append(librariesHtml);
      return $("a[rel^='prettyPhoto']").prettyPhoto({
        deeplinking: false
      });
    };

    LibraryViews.prototype.renderLibrary = function(library) {
      var libraryHtml;
      if (library.hasOwnProperty('data')) {
        libraryHtml = this.libraryTemplate(library.data);
      } else {
        libraryHtml = this.libraryTemplate(library);
      }
      return libraryHtml;
    };

    LibraryViews.prototype.newLibrary = function(e, library) {
      library = JSON.parse(library);
      return this.$elem.prepend(this.renderLibrary(library));
    };

    return LibraryViews;

  })();
  return App.classrooms.libraryViews = LibraryViews;
})($, window, document);
