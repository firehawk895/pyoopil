// Generated by CoffeeScript 1.7.1
Handlebars.registerHelper("displayGamification", function(data) {
  '<div class="enga"> <a href="javascript:void(0)" class="msg-link point-icon">EN</a> <div class="enga-tooltip" style="display: none;"> <div class="enga-list"> <ul> <li><p class="tt-name">Amar Verma</p></li> <li><p class="tt-name">Akriti Singh</p></li> <li><p class="tt-name">Deepti Singh</p></li> </ul> </div> </div> <span class="icon-title">17</span> </div>';
  return '';
});

Handlebars.registerHelper("Replies", function(data) {
  '<div class="bor-rep"><a href="javascript:void(0)" class="view-more">View all 5 answers <img src="http://localhost/PDD/pyoopil/images/view-all.png"></a> </div>';
  return '';
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
  return tmpl;
});
