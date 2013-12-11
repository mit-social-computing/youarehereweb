<script type="text/javascript">
	
(function($){
	var youtubeInit = function(){
		var div = $('.programista_it-<?php echo $this->widget_id; ?>');
		var player = div.find('iframe');
		player.each(function(k,v){
			iframe = $(v);
			var width = parseInt(iframe.css('width'), 10);
			var height = Math.round(width * 390 / 640);
			iframe.css('height', height + 'px');
		});
	};
	
	$(window).load(youtubeInit);
	$(window).resize(youtubeInit);
})(jQuery);
	
</script>

<style type="text/css">

/* smallbiz theme fix */
@media screen and (max-width: 767px) {
	.programista_it-<?php echo $this->widget_id; ?> iframe {
		max-width: 100%;
	}
}

</style>
