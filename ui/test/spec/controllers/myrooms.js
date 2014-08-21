'use strict';

describe('Controller: MyroomsCtrl', function () {

  // load the controller's module
  beforeEach(module('uiApp'));

  var MyroomsCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    MyroomsCtrl = $controller('MyroomsCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
