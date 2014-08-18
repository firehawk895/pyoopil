app
    .factory('announcementService',
    function (Restangular) {

        var self = this;

        self.getAnnouncements=function(){
            return Restangular.all('Announcements').getList().then(function(Announcements){
                self.allAnnouncements=Announcements;
                console.log(self.allAnnouncements);
            })
        };


        //login for the entire app
//        self.saveAnnouncement = function (announcement) {
//
//
//            announcement.Announcement.id = 33;
//            announcement.Announcement.user_id = 2;
//            announcement.Announcement.filename = null;
//            announcement.Announcement.filesize = null;
//            announcement.Announcement.file_path = null;
//            announcement.Announcement.created = "2014-07-29 13:23:12";
//            announcement.AppUser = {};
//            announcement.AppUser.fname = "Harsh";
//            announcement.AppUser.lname = "Alexander";
//
//
            return self.allAnnouncements;
//        };

           });
