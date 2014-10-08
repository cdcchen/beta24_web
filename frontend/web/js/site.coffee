
$('.question .vote-up-off, .question .vote-down-off').one 'click', (event) ->
  event.preventDefault()
  tthis = $(this);

  data =
    id: tthis.attr 'data-id'
  options =
    url: tthis.attr 'data-url'
    data: data
    type: 'POST'
    dataType: 'json'
    cache: false

  jqXhr = $.ajax options

  jqXhr.done (data, textStatus, jqXHR) ->
    if data.errno
      alert data.message
    else
      tthis.addClass tthis.attr 'data-class'
      tthis.siblings '.vote-count'
        .html data.vote_score
      $('.question .vote-up-off, .question .vote-down-off').off 'click'

  jqXhr.fail (xhr, textStatus, errorThrown) ->
    alert textStatus

  true

$('.question .star-off').on 'click', (event) ->
  event.preventDefault()
  tthis = $(this);

  data =
    id: tthis.attr 'data-id'
  options =
    url: tthis.attr 'data-url'
    data: data
    type: 'POST'
    dataType: 'json'
    cache: false

  jqXhr = $.ajax options

  jqXhr.done (data, textStatus, jqXHR) ->
    if data.errno
      alert data.message
    else
      if data.action is 'insert'
        tthis.addClass tthis.attr 'data-class'
      else
        tthis.removeClass tthis.attr 'data-class'

  jqXhr.fail (xhr, textStatus, errorThrown) ->
    alert textStatus

  true