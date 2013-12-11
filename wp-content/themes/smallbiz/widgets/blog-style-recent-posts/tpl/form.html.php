<p><strong><a href="http://members.expand2web.com/smallbiz-theme-widgets" target="_blank">Help and UserGuide for this Widget</a></strong></p>

<?php foreach($this->labels as $key => $label): ?>
    <p>
    	<?php if($key != 'post_thumbnails'): ?>
	        <label for="<?php echo $this->get_field_id($key); ?>">
	            <?php echo $label; ?>:
	        </label>
	    <?php else: ?>
	    	<input <?php echo attribute_escape(strip_tags($instance[$key])) == "yes" ? 'checked="checked"' : ''; ?> id="<?php echo $this->get_field_id($key); ?>" name="<?php echo $this->get_field_name($key); ?>" value="yes" type="checkbox">
	        <label for="<?php echo $this->get_field_id($key); ?>">
	            <?php echo $label; ?>:
	        </label>
	    <?php endif; ?>
        <?php if($key == 'post_category'): ?>
            <select class="widefat" id="<?php echo $this->get_field_id($key); ?>" name="<?php echo $this->get_field_name($key); ?>">
            	<option value="0" <?php echo (attribute_escape(strip_tags($instance[$key])) == 0 ? 'selected="selected"' : ''); ?>>All categories</option>
                <?php foreach(get_categories() as $category): ?>
                    <option value="<?php echo $category->cat_ID; ?>" <?php echo (attribute_escape(strip_tags($instance[$key])) == $category->cat_ID ? 'selected="selected"' : ''); ?>><?php echo $category->name; ?></option>
                <?php endforeach; ?>
            </select>
        <?php elseif($key != 'post_thumbnails'): ?>
            <input <?php echo ($key != 'posts_number' ? 'class="widefat"' : 'style="width: 50px"'); ?> id="<?php echo $this->get_field_id($key); ?>" name="<?php echo $this->get_field_name($key); ?>" type="text" value="<?php echo attribute_escape(strip_tags($instance[$key])); ?>">
        <?php endif; ?>
    </p>
<?php endforeach; ?>