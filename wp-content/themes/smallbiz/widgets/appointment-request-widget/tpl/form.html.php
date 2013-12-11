<p><strong><a href="http://members.expand2web.com/smallbiz-theme-widgets" target="_blank">Help and UserGuide for this Widget</a></strong></p>

<?php foreach($this->labels as $key => $label): ?>
    <p>
	    <label for="<?php echo $this->get_field_id($key); ?>">
	        <?php echo $label; ?>:
	    </label>
	    <input id="<?php echo $this->get_field_id($key); ?>" name="<?php echo $this->get_field_name($key); ?>" type="text" value="<?php echo attribute_escape(strip_tags($instance[$key])); ?>">
    </p>
<?php endforeach; ?>