'use strict';

/**
 * @ngdoc service
 * @name uiApp.roomService
 * @description
 * # roomService
 * Factory in the uiApp.
 */
angular.module('uiApp')
  .factory('roomService', ['Restangular', function (restangular) {
    var self = this;

    self.getRooms = function (page) {
      page = page || 1;
      return restangular.all('Classrooms').customGET('getclassrooms.json', {page: page});
    };
    self.getDiscussions = function (roomId, page, type) {
      page = page || 1;
//      return restangular.one("Classrooms", roomId).all("Discussions").customGET("getdiscussions.json", {page: page});
      if (type == "folded")
        return restangular.one("Classrooms", roomId).all("Discussions").customGET("getdiscussions.json", {page: page, folded: true});
      else
        return restangular.one("Classrooms", roomId).all("Discussions").customGET("getdiscussions.json", {page: page});
    };
    self.getReplies = function (id, page) {
      return restangular.all("Classrooms").all("Discussions").customGET("getreplies.json", {page: page, discussion_id: id});
    };
    self.getAnnouncements = function (roomId, page) {
      page = page || 1;
      return restangular.one("Classrooms", roomId).all("Announcements").customGET("getannouncements.json", {page: page});
    };
    self.getPeoples = function (roomId, page) {
      page = page || 1;
      return restangular.one("Classrooms", roomId).all("People").customGET("getpeople.json", {page: page});
    };
    self.getTopics = function (roomId, page) {
      page = page || 1;
      return restangular.one("Classrooms", roomId).all("Libraries").customGET("getTopics.json", {page: page});
    };
    self.getTopicsList = function (roomId, page) {
      page = page || 1;
      return restangular.one("Classrooms", roomId).all("Libraries").customGET("getTopicsList.json", {page: page});
    };
    self.getSubmissions = function (roomId, page) {
      page = page || 1;
      return restangular.one("Classrooms", roomId).all("Submissions").customGET("getSubmissions.json", {page: page});
    };
    self.createAnnouncement = function (roomId, subject, body, file) {

      var formData = new FormData();
      formData.append("data[Announcement][subject]", subject);
      formData.append("data[Announcement][body]", body);

      if (angular.isDefined(file))
        formData.append("data[Announcement][file_path]", file);
      return restangular.one("Classrooms", roomId)
        .all("Announcements")
        .withHttpConfig({transformRequest: angular.identity})
        .customPOST(formData, "add.json", undefined, {'Content-Type': undefined});
    };
    self.createDiscussion = function (roomId, topic, body, file, type, choices) {

      var formData = new FormData();
      formData.append("data[Discussion][topic]", topic);
      formData.append("data[Discussion][body]", body);
      formData.append("data[Discussion][type]", type);
      if (angular.isDefined(file))
        formData.append("data[Discussion][file_path]", file);
      if (angular.isDefined(choices)) {
        angular.forEach(choices, function (value, key) {
          if (angular.isDefined(value))
            formData.append("data[Pollchoice][" + key + "][choice]", value);
        });
      }

      return restangular.one("Classrooms", roomId)
        .all("Discussions")
        .withHttpConfig({transformRequest: angular.identity})
        .customPOST(formData, "add.json", undefined, {'Content-Type': undefined});
    };
    self.joinClassroom = function (accessCode) {
      var data = {
        Classroom: {
          access_code: accessCode
        }
      };
      return restangular.all("Classrooms").customPOST(data, "join.json");
    };
    self.createClassroom = function (classroom) {
      classroom.Classroom.minimum_attendance /= 100;
      return restangular.all("Classrooms").customPOST(classroom, "add.json");
    };
    self.getCampuses = function () {
      return restangular.all("Classrooms").customGET("getCampusesList.json");
    };
    self.getDepartments = function () {
      return restangular.all("Classrooms").customGET("getDepartmentsList.json");
    };
    self.getDegrees = function () {
      return restangular.all("Classrooms").customGET("getDegreesList.json");
    };
    self.removeModerator = function (roomId, id) {
      return restangular.one("Classrooms", roomId).all("People").customPOST({ids: id}, "removeModerator.json");
    };
    self.unRestrict = function (roomId, id) {
      return restangular.one("Classrooms", roomId).all("People").customPOST({ids: id}, "removeRestricted.json");
    };
    self.setModerator = function (roomId, setModIds) {
      var setModeratorIds = "";
      if (setModIds.length == 1)
        setModeratorIds = setModIds + ",";
      else
        setModeratorIds = setModIds.toString();
      return restangular.one("Classrooms", roomId).all("People").customPOST({ids: setModeratorIds}, "setModerator.json");
    };
    self.setRestricted = function (roomId, setRestrictIds) {
      var setRestrictedIds = "";
      if (setRestrictIds.length == 1)
        setRestrictedIds = setRestrictIds + ",";
      else
        setRestrictedIds = setRestrictIds.toString();
      return restangular.one("Classrooms", roomId).all("People").customPOST({ids: setRestrictedIds}, "setRestricted.json");
    };
    self.deleteFile = function (id, type) {
      var file = {id: id, type: type};
      return restangular.all("Classrooms").all("Libraries").customPOST(file, "deleteItem.json");
    };
    self.editTopic = function (name, id) {
      var data = {
        Topic: {
          id: id,
          name: name
        }
      };
      return restangular.all("Classrooms").all("Libraries").customPOST(data, "editTopic.json");
    };
    self.deleteTopic = function (id) {
      var data = {
        Topic: {
          id: id
        }
      };
      return restangular.all("Classrooms").all("Libraries").customPOST(data, "deleteTopic.json");
    };

    self.uploadFiles = function (roomId, id, name, files, links) {
      var formData = new FormData();

      if (id)
        formData.append("data[Topic][id]", id);
      else
        formData.append("data[Topic][name]", name);

      if (files.length) {
        angular.forEach(files, function (value, key) {
          if (angular.isDefined(value))
            formData.append("data[Pyoopilfile][" + key + "][file_path]", value);
        });
      }
      if (links.length) {
        angular.forEach(links, function (value, key) {
          if (angular.isDefined(value))
            formData.append("data[Link][" + key + "][linktext]", value);
        });
      }
      return restangular.one("Classrooms", roomId)
        .all("Libraries")
        .withHttpConfig({transformRequest: angular.identity})
        .customPOST(formData, "add.json", undefined, {'Content-Type': undefined});
    };
    self.deleteInDiscussion = function (id, type) {
      var data = {
        type: type,
        id: id
      };
      return restangular.all("Classrooms").all("Discussions").customPOST(data, "delete.json");
    };
    self.toggleFold = function (id) {
      return restangular.all("Classrooms").all("Discussions").customPOST({id: id}, "togglefold.json");
    };
    self.addReply = function (id, comment) {
      return restangular.all("Classrooms").all("Discussions").customPOST({discussion_id: id, comment: comment}, "addReply.json");
    };
    self.setGamificationVote = function (id, vote, type) {
      return restangular.all("Classrooms").all("Discussions").customPOST({id: id, vote: vote, type: type}, "setGamificationVote.json")
    };
    self.setPollVote = function (id) {
      return restangular.all("Classrooms").all("Discussions").customPOST({pollchoice_id: id}, "setPollVote.json");
    };
    self.getProfile = function () {
      return restangular.all("Profiles").customGET("getprofile.json");
    };
    self.saveMinProfile = function (fname, lname, gender, dob, location) {
      var data = {
        AppUser: {
          fname: fname,
          lname: lname,
          gender: gender,
          dob: dob,
          location: location
        }
      };
      return restangular.all('Profiles').customPOST(data, 'addMinProfile.json');
    };
    self.saveFullProfile = function (mobile, university_assoc, location_full, facebook_link, twitter_link, linkedin_link) {
      var data = {
        AppUser: {
          mobile: mobile,
          university_assoc: university_assoc,
          location_full: location_full,
          facebook_link: facebook_link,
          twitter_link: twitter_link,
          linkedin_link: linkedin_link
        }
      };
      return restangular.all('Profiles').customPOST(data, 'addFullProfile.json');
    };
    self.uploadPic = function (image) {
      var formData = new FormData();
      if (angular.isDefined(image))
        formData.append("data[AppUser][profile_img]", image);
      return restangular.all('Profiles')
        .withHttpConfig({transformRequest: angular.identity})
        .customPOST(formData, "addProfilePic.json", undefined, {'Content-Type': undefined});

    };
    self.createSubjectiveAssignment = function (subjective, roomId) {
      var formData = new FormData();
      formData.append("data[Submission][topic]", subjective.topic);
      formData.append("data[Submission][description]", subjective.description);
      formData.append("data[Submission][grading_policy]", subjective.gradingPolicy);
      formData.append("data[Submission][subjective_scoring]", subjective.gradingType);
      formData.append("data[Submission][total_marks]", subjective.totalMarks);
      formData.append("data[Submission][due_date]", subjective.dueDate);
      if (angular.isDefined(subjective.file))
        formData.append("data[Pyoopilfile][file_path]", subjective.file);
      return restangular.one("Classrooms", roomId)
        .all("Submissions")
        .withHttpConfig({transformRequest: angular.identity})
        .customPOST(formData, "addsubjective.json", undefined, {'Content-Type': undefined});
    };

    self.createQuizAssignment = function (quiz, roomId) {
      var formData = new FormData();
      formData.append("data[Submission][topic]", quiz.topic);
      formData.append("data[Submission][description]", quiz.description);
      formData.append("data[Submission][grading_policy]", quiz.gradingPolicy);
      formData.append("data[hrs]", quiz.hours);
      formData.append("data[mins]", quiz.minutes);
      formData.append("data[Submission][due_date]", quiz.dueDate);
      if (angular.isDefined(quiz.file))
        formData.append("data[Pyoopilfile][file_path]", quiz.file);
      angular.forEach(quiz.questionChoices, function (value, key) {
        formData.append("data[Quiz][0][Quizquestion][" + key + "][marks]", value.maxMarks);
        formData.append("data[Quiz][0][Quizquestion][" + key + "][type]", value.questionType);
        formData.append("data[Quiz][0][Quizquestion][" + key + "][question]", value.questionText);
        if (value.questionType == 'single-select') {
          formData.append("data[Quiz][0][Quizquestion][" + key + "][Choice][" + value.answerValue + "][is_answer]", true);
          angular.forEach(value.answerChoices, function (answerChoice, answerKey) {
            formData.append("data[Quiz][0][Quizquestion][" + key + "][Choice][" + answerKey + "][description]", answerChoice.choice);
          });
        }
        if (value.questionType == 'multi-select') {
          angular.forEach(value.answerChoices, function (answerChoice, answerKey) {
            formData.append("data[Quiz][0][Quizquestion][" + key + "][Choice][" + answerKey + "][description]", answerChoice.choice);
            if (answerChoice.answerValue)
              formData.append("data[Quiz][0][Quizquestion][" + key + "][Choice][" + answerKey + "][is_answer]", true);
          });
        }
        if (value.questionType == 'true-false') {
          formData.append("data[Quiz][0][Quizquestion][" + key + "][Choice][0][description]", 'True');
          formData.append("data[Quiz][0][Quizquestion][" + key + "][Choice][1][description]", 'False');
          formData.append("data[Quiz][0][Quizquestion][" + key + "][Choice][" + value.answerValue + "][is_answer]", true);
        }
        if (value.questionType == 'match-columns') {
          var matchColumns = [];
          angular.forEach(value.answerChoices, function (answerChoice, answerKey) {
            formData.append("data[Quiz][0][Quizquestion][" + key + "][Column][" + matchColumns.length + "][text]", answerChoice.choice);
            matchColumns.push(answerChoice.choice);
            formData.append("data[Quiz][0][Quizquestion][" + key + "][Column][" + matchColumns.length + "][text]", answerChoice.answerValue);
          });
        }
      });
      return restangular.one("Classrooms", roomId)
        .all("Submissions")
        .withHttpConfig({transformRequest: angular.identity})
        .customPOST(formData, "addquiz.json", undefined, {'Content-Type': undefined});
    };
    self.answerSubjective = function (text, file, id) {

      var formData = new FormData();
      formData.append("data[Submission][id]", id);
      formData.append("data[UsersSubmission][answer]", text);

      if (angular.isDefined(file))
        formData.append("data[Pyoopilfile][file_path]", file);
      return restangular.all("Classrooms")
        .all("Submissions")
        .withHttpConfig({transformRequest: angular.identity})
        .customPOST(formData, "answerSubjective.json", undefined, {'Content-Type': undefined});
    };
    self.getGradeSubmissions = function (roomId, assignmentId, page) {
      page = page || 1;
      return restangular.one("Classrooms", roomId).all("Submissions").customGET("gradeSubmissions.json", {page: page, id: assignmentId});
    };
    self.assignComment = function (submissionId, userId, comment) {
      var data = {
        Submission: {
          id: submissionId
        },
        AppUser: {
          id: userId
        },
        UsersSubmission: {
          grade_comment: comment
        }
      };
      return restangular.all('Classrooms').all('Submissions').customPOST(data, 'assignComment.json');
    };
    self.assignGrade = function (submissionId, userId, grade, type) {
      if (type == 'graded') {
        var data = {
          Submission: {
            id: submissionId
          },
          AppUser: {
            id: userId
          },
          UsersSubmission: {
            grade: grade
          }
        };
      }
      else if (type == 'marked') {
        var data = {
          Submission: {
            id: submissionId
          },
          AppUser: {
            id: userId
          },
          UsersSubmission: {
            marks: grade
          }
        };
      }
      return restangular.all('Classrooms').all('Submissions').customPOST(data, 'assignGrade.json');
    };
    self.getQuiz = function (id) {
      return restangular.all('Classrooms').all('Submissions').customGET('getQuiz.json', {submission_id: id})
    };
    self.answerQuiz = function (quizAnswers) {
      var data = {
        Choicesanswer: [],
        Columnanswer: []
      };
      angular.forEach(quizAnswers.Choice, function (value, key) {
        data.Choicesanswer.push({choice_id: value});
      });
      angular.forEach(quizAnswers.Columns, function (value, key) {
        if (key % 2 == 0)
          data.Columnanswer.push({column1_id: value}, {column2_id: quizAnswers.Columns[key + 1]});
      });
      return restangular.all('Classrooms').all('Submissions').customPOST(data, 'answerQuiz.json');
    };
    self.getReports = function (roomId) {
      return restangular.one('Classrooms', roomId).all('Reports').customGET('index');
    };
    self.getEngagementReports = function (roomId) {
      return restangular.one('Classrooms', roomId).all('Reports').customGET('engagement');
    };
    self.getAcademicReport = function (roomId) {
      return restangular.one('Classrooms', roomId).all('Reports').customGET('academic');
    };
    self.getAttendanceReport = function (roomId) {
      return restangular.one('Classrooms', roomId).all('Reports').customGET('attendance');
    };

    return self;
  }]);
