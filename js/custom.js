// Instalation form

$("#installnextbutton").click(function(){
  $("#installcardone").toggleClass('uk-visible uk-hidden');
  $("#installcardtwo").toggleClass('uk-hidden uk-visible');
});

// Submit comment form

$( "#commentformsubmit" ).click(function() {
  $('form#commentform').submit();
});


// Check for emtpy fields

$(document).ready(function(){
  $('.submit').prop('disabled',true);
  $('#required').keyup(function(){
      $('.submit').prop('disabled', this.value == "" ? true : false);
  })
});
