/**
 * Created by greenapple on 19/8/14.
 */

angular.module('uiApp')
    .controller('myRoomCtrl', ['$scope' , 'roomService',
        function ($scope, roomService) {
            $scope.classroom = {};
            $scope.page = 1;

            roomService.getRooms($scope.page).then(function (result) {
                $scope.classrooms = result.data;

            });

//            $scope.getClass=function(value){
//                if(value)
//                return "lock-state";
//                return "";
//            };

        }]);