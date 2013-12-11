////////////////////////////////////////
// init
jQuery(function() {

	// Slide Navigation
	jQuery('#small-menu').click(function(){
		jQuery('#menu-wrapper').toggleClass('current');
		var height = jQuery('body .wrapper').height();
		jQuery('ul#menu-primary-items').height(height);
	});

	// Home ThumbnailHover
	ThumbnailHover();

	// back to pagetop
    var totop = jQuery('#back-top');    
    totop.hide();
    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > 800) totop.fadeIn(); else totop.fadeOut();
    });
    totop.click(function () {
        jQuery('body,html').animate({scrollTop: 0}, 500); return false;
    });

	// Window Resize
	var timer = false;
	jQuery(window).resize(function() {
	    if (timer !== false) {
	        clearTimeout(timer);
	    }
	    timer = setTimeout(function() {
			centerThumbnail();
	    }, 200);
	});

	// Center Thumbnail Position
	jQuery(window).load(function() {
		centerThumbnail();
	});

});

////////////////////////////////////////
// ThumbnailHover
function ThumbnailHover () {

	jQuery('#thumbnails li.has-image').hover(function(){
		var caption = jQuery(this).find('.caption');
			caption.stop(true, true).animate(
				{opacity: 1,},
				{queue: false,
					duration: '300'.fadeout
				});
	}, function() {
		var caption = jQuery(this).closest('li').find('.caption');
		caption.stop(true, true).animate(
			{opacity: '0'},
			{queue: false,
				duration: '50'.fadein
			});
	});
}

////////////////////////////////////////
// Center Thumbnail Position
function centerThumbnail() {

	jQuery('.home .thumbnail img').each(function(i){
		var wrapperHeight = jQuery(this).parent().height();
		var wrapperWidth = jQuery(this).parent().width();
		var imageHeight = jQuery(this).height();
		var imageWidth = jQuery(this).width();

		if(imageWidth > imageHeight){
			// Horizontal Thumbnail
			var h = wrapperHeight;
			var w = (imageWidth/imageHeight) * h;
		}
		else{
			// Vertical Thumbnail
			var w = wrapperWidth;
			var h = (imageHeight/imageWidth) * w;
		}

		// Set Center
		var y = (wrapperHeight - h) / 2;
		var x = (wrapperWidth - w) / 2;

		jQuery(this).css({'height': h + 'px', 'width': w + 'px', 'top': y + 'px', 'left': x + 'px'});
	});
}
