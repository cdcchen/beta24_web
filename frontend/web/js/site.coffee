
$('.question .vote-up-off, .question .vote-down-off').one 'click', (event) ->
  event.preventDefault()
  tthis = $(this);
  dataClass = tthis.attr 'data-class'

  data =
    id: tthis.attr 'data-id'

  options =
    url: tthis.attr 'data-url'
    data: data
    type: 'POST'
    dataType: 'json'
    cache: false
    beforeSend: (xhr, setting) ->
      tthis.addClass dataClass

  jqXhr = $.ajax options

  jqXhr.done (data, textStatus, jqXHR) ->
    if data.errno
      alert data.message
      tthis.removeClass dataClass
    else
      tthis.siblings '.vote-count'
        .html data.vote_score
      $('.question .vote-up-off, .question .vote-down-off').off 'click'

  jqXhr.fail (xhr, textStatus, errorThrown) ->
    alert textStatus

  true

$('.question .star-off').on 'click', (event) ->
  event.preventDefault()
  tthis = $(this);
  dataClass = tthis.attr 'data-class'

  data =
    id: tthis.attr 'data-id'

  options =
    url: tthis.attr 'data-url'
    data: data
    type: 'POST'
    dataType: 'json'
    cache: false
    beforeSend: (xhr, setting) ->
      if tthis.hasClass dataClass
        tthis.removeClass dataClass
      else
        tthis.addClass dataClass

  jqXhr = $.ajax options

  jqXhr.done (data, textStatus, jqXHR) ->
    if data.errno
      alert data.message
      if tthis.hasClass dataClass
        tthis.removeClass dataClass
      else
        tthis.addClass dataClass

  jqXhr.fail (xhr, textStatus, errorThrown) ->
    alert textStatus

  true