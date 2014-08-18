app.controller('announcementCtrl', ['$scope', 'announcementService', 'Restangular', function ($scope, announcementService, Restangular) {


//   $scope.announcements=announcementService.getAnnouncements();

    Restangular.all('Announcements').getList().then(function(Announcements) {
        $scope.allAnnouncements = Announcements;
        console.log($scope.allAnnouncements);
    });
//    var baseAnnounce= Restangular.all('Announcements');
//$scope.announcements=baseAnnounce.getList();
//   //    $scope.announcement = {};
//console.log($scope.announcements);
//    $scope.addAnnouncement = function () {
//        var newAnnouncement = announcementService.saveAnnouncement($scope.announcement);
//        $scope.announcements.unshift(newAnnouncement);
//        $scope.announcement = {};
//    };

}]);