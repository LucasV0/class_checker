function hold(inputId , spanId){
  let span = '#'+spanId;
  let input = '#'+inputId;
  $(span).toggleClass('fa-eye fa-eye-slash');
  $(input).attr("type", "text");
}

function let(inputId , spanId){
  let span = '#'+spanId;
  let input = '#'+inputId;
  $(span).toggleClass('fa-eye fa-eye-slash');
  $(input).attr("type", "password");
}

