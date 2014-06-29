// Generated by CoffeeScript 1.7.1
(function($, window, document) {
  var DiscussionServices;
  DiscussionServices = (function() {
    function DiscussionServices() {
      this.isInitial = true;
      this.baseUrl = window.location.pathname;
    }

    DiscussionServices.prototype.getDiscussions = function() {
      var defer;
      defer = $.Deferred();
      if (this.isInitial === true) {
        defer.resolve(App.classrooms.discussions.data);
      }
      return defer.promise();
    };

    DiscussionServices.prototype.getData = function(url) {
      var ajax;
      ajax = $.ajax({
        url: url,
        method: 'GET'
      });
      return ajax;
    };

    DiscussionServices.prototype.postData = function(url, data) {
      var ajax;
      ajax = $.ajax({
        type: 'POST',
        url: this.baseUrl + "/" + url,
        data: data
      });
      return ajax;
    };

    DiscussionServices.prototype.newDiscussion = function(data) {
      var formData, url;
      console.log(data);
      formData = $(data).serialize();
      url = 'add.json';
      return this.postData(url, formData);
    };

    DiscussionServices.prototype.setGamification = function(data) {
      var url;
      url = 'setGamificationVote.json';
      return this.postData(url, data);
    };

    DiscussionServices.prototype.addReply = function(data) {
      var formData, url;
      formData = data.serialize();
      url = 'addReply.json';
      return this.postData(url, formData);
    };

    DiscussionServices.prototype.isValid = function(data) {
      return (data != null) && data.length > 0;
    };

    return DiscussionServices;

  })();
  return App.classrooms.discussionServices = new DiscussionServices();
})($, window, document);