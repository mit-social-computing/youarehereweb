<script type="text/javascript">
(function($){
    $(function(){
        $('.widget').each(function(k,v){
            v = $(v);
            if(v.attr('id').match(/^widget-[0-9]+_image_widget/)) {
                var title = v.find('.widget-top .widget-title');
                title.addClass('picture_widget_title');
                title.prepend('<img class="picture_widget_icon" src="<?php bloginfo('template_url'); ?>/widgets/picture-widget/img/icon.png">');
            }
        });

		var senderInput = null;     
        $('.programista-it-picture-widget .image_url').live('focus', function(){
        	senderInput = $(this);
        	tb_show('Select image', 'media-upload.php?referer=widget-picture-widget&type=image&TB_iframe=true&post_id=0', false); 
        });

		var old_fn = window.send_to_editor;
		window.send_to_editor = function(html) {
			if(senderInput) {
			    var image_url = $('img','<div>' + html + '</div>').attr('src');  
			    senderInput.val(image_url);
			    if(image_url != '' && image_url) {
			    	senderInput.parent().parent().find('.picture-preview').html('<img style="max-width: 100%; margin: 20px 0" src="' + image_url + '">');
			    } else {
			    	senderInput.parent().parent().find('.picture-preview').html('');
			    }
			    senderInput = null;
			    tb_remove();
		    }
		    if(old_fn) {
		    	old_fn(html);
		    }
		}

    });
})(jQuery);
</script>
<style type="text/css">

.picture_widget_title {
    position: relative;
    padding-left: 27px !important;
}

.picture_widget_icon {
    width: 20px;
    height: 20px;
    position: absolute;
    top: 3px;
    left: 2px;
}

.programista-it-picture-widget .image_url {
	cursor: pointer;
}

</style>