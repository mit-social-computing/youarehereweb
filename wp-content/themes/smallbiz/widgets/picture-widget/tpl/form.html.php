<p><strong><a href="http://members.expand2web.com/smallbiz-theme-widgets" target="_blank">Help and UserGuide for this Widget</a></strong></p>
<div class="programista-it-picture-widget">
<?php foreach($this->labels as $key => $label): ?>
    <p>
        <label for="<?php echo $this->get_field_id($key); ?>">
            <?php echo $label; ?>:
            
        </label>
        <?php if($key == 'caption_alignment'): ?>
            <select class="widefat" id="<?php echo $this->get_field_id($key); ?>" name="<?php echo $this->get_field_name($key); ?>">
                <?php foreach(array('None', 'Center', 'Left', 'Right') as $align): $lower = strtolower($align); ?>
                    <option value="<?php echo $lower; ?>" <?php echo (attribute_escape(strip_tags($instance[$key])) == $lower ? 'selected="selected"' : ''); ?>><?php echo $align; ?></option>
                <?php endforeach; ?>
            </select>
        <?php else: ?>
            <input class="widefat <?php echo $key; ?>" id="<?php echo $this->get_field_id($key); ?>" name="<?php echo $this->get_field_name($key); ?>" type="text" value="<?php echo attribute_escape(strip_tags($instance[$key])); ?>" />
        <?php endif; ?>
    </p>
    <?php if($key == 'image_url'): ?>
    	<div class="picture-preview">
    		<?php if(attribute_escape(strip_tags($instance[$key])) != ''): ?>
    			<img style="max-width: 100%; margin: 20px 0" src="<?php echo attribute_escape(strip_tags($instance[$key])); ?>">
			<?php endif; ?>
    	</div>
	<?php endif; ?>
<?php endforeach; ?>
</div>