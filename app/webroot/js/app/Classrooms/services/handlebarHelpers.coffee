App = window.App || {}

baseUrl = App.rootPath
imagePath = baseUrl + "images/"

Handlebars.registerHelper("displayGamification", (data)->

  tmpl = ''

  for d of data

    praisers = ''

    _.each data[d], (d) ->
      praisers += "<li>" + d + "</li>"

    if data[d].length > 0
      tmpl += '<div class="enga">
                <a href="javascript:void(0)" class="msg-link point-icon">'+d+'</a>
                <div class="enga-tooltip" style="display: none;">
                  <div class="enga-list">
                    <ul>'+praisers+'</ul>
                  </div>
                </div>
                <span class="icon-title">'+data[d].length+'</span>
              </div>'
    else
      tmpl += '<div class="enga">
                <a href="javascript:void(0)" class="msg-link point-icon">'+d+'</a>
                <span class="icon-title">'+data[d].length+'</span>
              </div>'

  new Handlebars.SafeString(tmpl)

  

)


Handlebars.registerHelper('Poll', (choices)->

  tmpl = ''

  displayChoice = (choice)->
    tmpl += '<a href="javascript:void(0)" class="ans-btn choice" data-choice-id="'+choice.id+'">'+choice.choice+'</a>'
  choices = _.reject(choices, (choice)-> choice.choice is '')

  displayChoice choice for choice in choices

  new Handlebars.SafeString(tmpl)

)

Handlebars.registerHelper('safehtml', (data)->

  data = '<div class="ttxt">' + data + '</div>'

  new Handlebars.SafeString(data)

)

Handlebars.registerHelper('icon', (data)->

  image = ''

  if data.mime_type is "application/pdf"
    image = imagePath + "doc-icon.png"
  else
    image = imagePath + "word_icon.png"

  return image

)

Handlebars.registerHelper('image', (image)->

  return imagePath + image

)