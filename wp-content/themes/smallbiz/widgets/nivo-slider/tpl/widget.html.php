<?php echo $before_widget; ?>

<div class="slider-wrapper theme-<?php echo $params['theme']; ?>">
    <div id="programista_it_<?php echo $args['widget_id']; ?>" class="nivoSlider">
    	<?php if(count($images)): ?>
	    	<?php foreach($images as $image): ?>
	    		<?php if(!empty($image->href)): ?>
	    			<a href="<?php echo $image->href; ?>" target="_blank">
				<?php endif; ?>
	    		<img src="<?php echo $image->url; ?>" data-thumb="<?php echo $image->url; ?>" <?php echo empty($image->caption) ? '' : 'title="'.$image->caption.'"'; ?> alt="slider image"/>
	    		<?php if(!empty($image->href)): ?>
	    			</a>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php else: ?>
			<img src="<?php bloginfo('template_url'); ?>/widgets/nivo-slider/img/empty.png" alt="">
		<?php endif; ?>
    </div>
</div>

<script type="text/javascript">
	
	(function($){
	    $(window).load(function() {
	        $('#programista_it_<?php echo $args['widget_id']; ?>').nivoSlider(<?php echo $nivoConfig; ?>);
	    });
	})(jQuery);
	
</script>

<?php echo $after_widget; ?>