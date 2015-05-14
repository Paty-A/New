$(document).ready(function(){
  $('.open').slideDown();
  $('section').click(function(){ 
    if (!$(this).children('.slider').hasClass('open')) {
    	// Close other open sliders
    	$('.open').find('.ribbon-green').removeClass('unfurl');
    	$('.open').parents('section').removeClass('green');
        $('.open').slideUp('fast', function(){
          $(this).removeClass('open');
        });
        // Give active section new background color
        $(this).addClass('green');
        // Open this slider
        $(this).children('.slider').slideDown(function(){
          $(this).addClass('open');
          // Scroll to the active section when clicked
          $('html,body').animate({
              scrollTop: $(this).parents('section').offset().top},
              'slow', 'swing'); //maybe remove 'swing; if it bogs down app too much
          // Slide ribbon into frame
          $(this).find('.ribbon-green').addClass('unfurl');
        });
      }
    else if ($(this).children('.slider').hasClass('open')) {
    	// Toggle this slider
      $(this).removeClass('green');
      $(this).find('.ribbon-green').removeClass('unfurl');
      $(this).children('.slider').slideUp('slow', function(){
        $(this).removeClass('open');
      });
    }
  });

 // Whole item div is clickable - triggers events bound to the link on click
 $('.labeled div.menu-item').click(function(e){
	if($(this).find('a').hasClass('item-nutrition-link')) {
		e.stopPropagation(); // stops outer div.slider from closing
		$(this).find('.item-nutrition-link').click();
	}
 });
 
 $('.list li').click(function(e){
	if($(this).find('a').hasClass('item-nutrition-link')) {
		e.stopPropagation(); // stops outer div.slider from closing
		$(this).find('.item-nutrition-link').click();
	}
 });

 $('.item-nutrition-pane').hide();
});