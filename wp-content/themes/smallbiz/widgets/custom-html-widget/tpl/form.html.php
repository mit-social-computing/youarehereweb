<p><strong><a href="http://members.expand2web.com/smallbiz-theme-widgets" target="_blank">Help and UserGuide for this Widget</a></strong></p>


<?php foreach($this->labels as $key => $label): ?>
    <p>
        <label for="<?php echo $this->get_field_id($key); ?>">
            <?php echo $label; ?>:
        </label>
    	<?php if($key == 'html'): ?>
    		<div class="wp-media-buttons programista-it-custom-html-media-button"><a href="javascript:" tabindex="-1" class="button insert-media add_media" title="Add Media"><span class="wp-media-buttons-icon"></span> Add Media</a></div>
		<?php endif; ?>
        <?php if($key == 'html'): ?>
        	<div class="wp-editor-container programista-it-tinymce-container">
	        	<textarea style="display: block; width: 100%; height: 500px" id="tinyMCE-<?php echo $this->id; ?>" class="tinyMCE-<?php echo $this->id; ?>" name="<?php echo $this->get_field_name($key); ?>"><?php echo $instance[$key]; ?></textarea>
				<span style="display: none" class="programista_it_tinymce_widget_hidden"></span>
			</div>
    	<?php else: ?>
        	<input <?php echo ($key != 'posts_number' ? 'class="widefat"' : 'style="width: 50px"'); ?> id="<?php echo $this->get_field_id($key); ?>" name="<?php echo $this->get_field_name($key); ?>" type="text" value="<?php echo attribute_escape(strip_tags($instance[$key])); ?>">
		<?php endif; ?>
	</p>
<?php endforeach; ?>

<script>
	(function(){
		var id = "tinyMCE-<?php echo $this->id; ?>";
		if(id != 'tinyMCE-custom_html_widget-__i__') {
			programistaItDisplayTinyMce(id);
		}
	})();
</script>