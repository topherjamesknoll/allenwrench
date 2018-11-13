// Instalation form

$("#installnextbutton").click(function(){
  $("#installcardone").toggleClass('uk-visible uk-hidden');
  $("#installcardtwo").toggleClass('uk-hidden uk-visible');
});

// Select months

$(function() {
    $('#months').change(function() {
        this.form.submit();
    });
});
