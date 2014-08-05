// Generated by CoffeeScript 1.7.1
(function() {
  angular.module('Pyoopil.Services').factory('Utilities', [
    '$document', function($document) {
      var Utilities;
      Utilities = (function() {
        function Utilities() {
          this.modalPath = '/pyoopil/js/app/partials/modules/';
          this.currentModal = false;
          this._body = angular.element($document[0].body);
        }

        Utilities.prototype.init = function(scope) {
          return this.scope = scope;
        };

        Utilities.prototype.openModal = function(template) {
          var self;
          self = this;
          this.scope.template.url = this.modalPath + template;
          this.scope.showModal = true;
          if (!this.scope.$$phase) {
            this.scope.$digest();
          }
          this._body.on('click', '.close-link', function(e) {
            e.preventDefault();
            return self.closeModal(e);
          });
          return this.scope.$broadcast('openModal');
        };

        Utilities.prototype.closeModal = function(e) {
          this.scope.template.url = null;
          this.scope.$broadcast('closeModal');
          if (!this.scope.$$phase) {
            return this.scope.$digest();
          }
        };

        return Utilities;

      })();
      return new Utilities();
    }
  ]);

}).call(this);

//# sourceMappingURL=utilities.map
