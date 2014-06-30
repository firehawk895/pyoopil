// Generated by CoffeeScript 1.7.1
var App, baseUrl, imagePath;

App = window.App || {};

baseUrl = App.rootPath;

imagePath = baseUrl + "images/";

google.load("visualization", "1", {
  packages: ["corechart"]
});

Handlebars.registerHelper("displayGamification", function(data) {
  var d, praisers, tmpl;
  tmpl = '';
  for (d in data) {
    praisers = '';
    _.each(data[d], function(d) {
      return praisers += "<li>" + d + "</li>";
    });
    if (data[d].length > 0) {
      tmpl += '<div class="enga"> <a href="javascript:void(0)" class="msg-link point-icon">' + d + '</a> <div class="enga-tooltip" style="display: none;"> <div class="enga-list"> <ul>' + praisers + '</ul> </div> </div> <span class="icon-title">' + data[d].length + '</span> </div>';
    } else {
      tmpl += '<div class="enga"> <a href="javascript:void(0)" class="msg-link point-icon">' + d + '</a> <span class="icon-title">' + data[d].length + '</span> </div>';
    }
  }
  return new Handlebars.SafeString(tmpl);
});

Handlebars.registerHelper('Poll', function(choices) {
  var choice, displayChoice, showPolling, tmpl, _i, _len;
  tmpl = '';
  displayChoice = function(choice) {
    if (_.isObject(choice) && ((choice.choice != null) && choice.choice !== '')) {
      if (showPolling === true) {
        return tmpl += '<a href="javascript:void(0)" class="ans-btn choice nopoll" data-poll-id="' + choice.id + '">' + choice.choice + '</a>';
      } else {
        return tmpl += '<a href="javascript:void(0)" class="ans-btn choice canpoll" data-poll-id="' + choice.id + '">' + choice.choice + '</a>';
      }
    }
  };
  choices = _.toArray(choices);
  showPolling = _.last(choices);
  for (_i = 0, _len = choices.length; _i < _len; _i++) {
    choice = choices[_i];
    displayChoice(choice);
  }
  return new Handlebars.SafeString(tmpl);
});

Handlebars.registerHelper('Chart', function(pollData) {
  return JSON.stringify(pollData);
});

Handlebars.registerHelper('safehtml', function(data) {
  data = '<div class="ttxt">' + data + '</div>';
  return new Handlebars.SafeString(data);
});

Handlebars.registerHelper('icon', function(data) {
  var image;
  image = '';
  if (data.mime_type === "application/pdf") {
    image = imagePath + "doc-icon.png";
  } else {
    image = imagePath + "word_icon.png";
  }
  return image;
});

Handlebars.registerHelper('image', function(image) {
  return imagePath + image;
});

Handlebars.registerHelper('link', function(link) {
  return baseUrl + link;
});
