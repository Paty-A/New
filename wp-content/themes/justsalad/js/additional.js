jQuery(document).ready(function() {
	jQuery("a#change-region").click(function (event) {
		jQuery("#change-box").slideToggle();
		event.stopPropagation();
	});

	jQuery('html').click(function() {
  jQuery("#change-box").slideUp();
	});

	jQuery('#change-box').click(function(event){
    	event.stopPropagation();
	});
});