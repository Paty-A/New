$(document).ready(function(){
  $('.open').slideDown();
  $('section').click(function(){ 
    if (!$(this).children('.slider').hasClass('open')) {
        $('.open').slideUp(function(){
          $(this).removeClass('open');
        });
        $(this).children('.slider').slideDown(function(){
          $(this).addClass('open');
        });
      }  
    else if ($(this).children('.slider').hasClass('open')) {
      $(this).children('.slider').slideUp(function(){
        $(this).removeClass('open');
      });
    }
  });
});