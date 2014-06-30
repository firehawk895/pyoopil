App = window.App || {}

baseUrl = App.rootPath
imagePath = baseUrl + "images/"

google.load("visualization", "1", {packages:["corechart"]});

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
    if _.isObject(choice) and (choice.choice? and choice.choice isnt '')
      if showPolling is true
        tmpl += '<a href="javascript:void(0)" class="ans-btn choice poll" data-poll-id="'+choice.id+'">'+choice.choice+'</a>'
      else
        tmpl += '<a href="javascript:void(0)" class="ans-btn choice nopoll" data-poll-id="'+choice.id+'">'+choice.choice+'</a>'

  choices = _.toArray(choices)

  showPolling = _.last choices

  displayChoice choice for choice in choices

  new Handlebars.SafeString(tmpl)

)

Handlebars.registerHelper('Chart', (pollData)->

  JSON.stringify pollData

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

Handlebars.registerHelper('link', (link)->

  return baseUrl + link

)