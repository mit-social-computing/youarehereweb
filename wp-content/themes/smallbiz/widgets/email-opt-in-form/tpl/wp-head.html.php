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

.programista-it-email-opt-in-form {
  padding-left:0px;
}

.programista-it-email-opt-in-form input[type=submit] {
	text-decoration: none;
	text-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
	display: inline-block;
	text-decoration: none;
	font-size: 12px;
	line-height: 23px;
	height: 24px;
	margin-left: 15px;
	padding: 0 10px 1px;
	cursor: pointer;
	border-width: 1px;
	border-style: solid;
	-webkit-border-radius: 3px;
	-webkit-appearance: none;
	border-radius: 3px;
	white-space: nowrap;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
}

.programista-it-email-opt-in-form input[type=text], .programista-it-email-opt-in-form input[type=email] {
  padding: 2px 6px;
  border: 1px solid #000;
  border-radius: 5px;
  max-width: 60%;
}

</style>
