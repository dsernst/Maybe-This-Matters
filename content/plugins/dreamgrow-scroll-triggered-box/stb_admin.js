jQuery(function() {
    jQuery( "#tabs" ).tabs();
	
	jQuery('#cleanCookie').click(function(){
		jQuery.removeCookie('nopopup',{path: '/' });
		window.location.href = window.location.href;
		return false;
	});
});