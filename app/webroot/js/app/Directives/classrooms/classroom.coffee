angular.module 'Pyoopil.Directives'
  .directive 'classroom', [()->

    restrict : 'A'
    scope: {
      classroom : '='
    }
    link : (scope, elem, attrs)->

      if scope.$parent.$last
        scope.$emit 'classroom.RENDER'


  ]