Handlebars.registerHelper("displayGamification", (data)->

  '<div class="enga">
    <a href="javascript:void(0)" class="msg-link point-icon">EN</a>
    <div class="enga-tooltip" style="display: none;">
      <div class="enga-list">
        <ul>
          <li><p class="tt-name">Amar Verma</p></li>
          <li><p class="tt-name">Akriti Singh</p></li>
          <li><p class="tt-name">Deepti Singh</p></li>
        </ul>
      </div>
    </div>
    <span class="icon-title">17</span>
  </div>'

  ''

)



Handlebars.registerHelper("Replies", (data)->

  

  '<div class="bor-rep"><a href="javascript:void(0)" class="view-more">View all 5 answers <img src="http://localhost/PDD/pyoopil/images/view-all.png"></a>
                        </div>'

  ''

)

Handlebars.registerHelper('Poll', (choices)->

  tmpl = ''

  displayChoice = (choice)->
    tmpl += '<a href="javascript:void(0)" class="ans-btn choice" data-choice-id="'+choice.id+'">'+choice.choice+'</a>'
  choices = _.reject(choices, (choice)-> choice.choice is '')

  displayChoice choice for choice in choices

  tmpl

)