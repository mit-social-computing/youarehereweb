<p><strong><a href="http://members.expand2web.com/smallbiz-theme-widgets" target="_blank">Help and UserGuide for this Widget</a></strong></p>
<p>Tip: Make sure all images are the same size before uploading. This widget is fully responsive and will take on the size of your images. Different sized images means the slider will resize itself during every transition from one image to the next.</p> 

<?php foreach($this->labels as $key => $label): ?>
	<p>
	    <label for="<?php echo $this->get_field_id($key); ?>">
	        <?php echo $label; ?>:
	    </label>
		<?php if($key == 'theme' || $key == 'effect'): ?>
			<select name="<?php echo $this->get_field_name($key); ?>" id="<?php echo $this->get_field_id($key); ?>">
				<?php foreach($this->getSelectOptions($key) as $option): ?>
					<option <?php echo attribute_escape(strip_tags($instance[$key])) == $option ? 'selected' : ''; ?> value="<?php echo $option; ?>"><?php echo $option; ?></option>
				<?php endforeach; ?>
			</select>
		<?php elseif($key != 'images'): ?>
		    <input <?php echo ($key != 'posts_number' ? 'class="widefat"' : 'style="width: 50px"'); ?> id="<?php echo $this->get_field_id($key); ?>" name="<?php echo $this->get_field_name($key); ?>" type="text" value="<?php echo attribute_escape(strip_tags($instance[$key])); ?>">
	    <?php endif; ?>
    </p>
<?php endforeach; ?>

<input type="hidden" name="<?php echo $this->get_field_name('images'); ?>" class="nivo-images programista-it-widget-nivo-images" value="<?php echo attribute_escape(strip_tags($instance['images'])); ?>" />

<div class="widget-nivo-images">
<?php foreach(json_decode($instance['images']) as $key => $image): ?>
	<div class="image_box programista-it-image-box">
		<h3>Image <?php echo $key + 1; ?></h3>
		<p>
			<label for="<?php echo($this->id); ?>-programista-it-image-url-<?php echo $key; ?>">Image URL:</label>
			<input id="<?php echo($this->id); ?>-programista-it-image-url-<?php echo $key; ?>" type="text" class="widefat nivo-url" value="<?php echo $image->url; ?>">
		</p>
		<div class="nivo-preview">
			<?php if(!empty($image->url)): ?>
				<img src="<?php echo $image->url; ?>" style="max-width: 100%; margin: 20px 0">
			<?php endif; ?>
		</div>
		<p>
			<label for="<?php echo($this->id); ?>-programista-it-image-href-<?php echo $key; ?>">Optional: Link image to the following page:</label>
			<input id="<?php echo($this->id); ?>-programista-it-image-href-<?php echo $key; ?>" type="text" class="widefat nivo-href" value="<?php echo $image->href; ?>">
		</p>
		<p>
			<label for="<?php echo($this->id); ?>-programista-it-image-caption-<?php echo $key; ?>">Optional: Add an image caption:</label>
			<input id="<?php echo($this->id); ?>-programista-it-image-caption-<?php echo $key; ?>" type="text" class="widefat nivo-caption" value="<?php echo $image->caption; ?>">
		</p>
		<p><input type="button" class="button button-primary programista-it-nivo-remove-image" value="Remove image"></p>
	</div>
<?php endforeach; ?>
</div>

<p>
	<input type="button" class="button button-primary programista-it-nivo-add-image" value="Add image">
</p>