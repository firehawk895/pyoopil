// Generated by CoffeeScript 1.7.1
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
  var choice, displayChoice, tmpl, _i, _len;
  tmpl = '';
  displayChoice = function(choice) {
    return tmpl += '<a href="javascript:void(0)" class="ans-btn choice" data-choice-id="' + choice.id + '">' + choice.choice + '</a>';
  };
  choices = _.reject(choices, function(choice) {
    return choice.choice === '';
  });
  for (_i = 0, _len = choices.length; _i < _len; _i++) {
    choice = choices[_i];
    displayChoice(choice);
  }
  return new Handlebars.SafeString(tmpl);
});

Handlebars.registerHelper('safehtml', function(data) {
  data = '<div class="ttxt">' + data + '</div>';
  return new Handlebars.SafeString(data);
});
