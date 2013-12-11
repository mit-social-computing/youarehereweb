<p><strong><a href="http://members.expand2web.com/smallbiz-theme-widgets" target="_blank">Help and UserGuide for this Widget</a></strong></p>

<?php foreach($this->labels as $key => $label): ?>
<p>
	<?php if(in_array($key, array('3rd-party', 'autoresponder'))): ?>
	<h3>
		<?php echo $label; ?>
	</h3>
	<?php else: ?>
		<label for="<?php echo $this->get_field_id($key); ?>"><?php echo $label; ?>:</label>
		<?php if($key == 'thank-you-page'): ?>
			<select name="<?php echo $this->get_field_name($key); ?>" style="display: block; width: 100%">
				<?php foreach(get_pages() as $page): ?>
					<option
						value="<?php echo $page->ID; ?>"
						<?php echo $page->ID == intval($instance[$key]) ? 'selected="selected"': ''; ?>
					><?php echo $page->post_title; ?></option>
				<?php endforeach; ?>
			</select>
		<?php else: ?>
			<?php if(in_array($key, array('opt-in-description', 'email-content', 'embed-code'))): ?>
				<textarea class="widefat"
					id="<?php echo $this->get_field_id($key); ?>"
					name="<?php echo $this->get_field_name($key); ?>"
					cols="30" rows="5"
					<?php echo isset($this->placeholders[$key]) ? "placeholder='{$this->placeholders[$key]}'" : ''; ?>
				><?php echo $key == 'embed-code' ? attribute_escape($instance[$key]) : attribute_escape(strip_tags($instance[$key])); ?></textarea>
				<?php if($key == 'embed-code'): ?>
					<b>Any 3rd party code added (Aweber, Mailchimp etc.) will override the default opt-in widget settings above.</b>
				<?php endif; ?>
			<?php else: ?>
				<input class="widefat"
					id="<?php echo $this->get_field_id($key); ?>"
					name="<?php echo $this->get_field_name($key); ?>" 
					type="<?php echo $key == 'admin-email' ? 'email' : 'text'; ?>"
					value="<?php echo attribute_escape(strip_tags($instance[$key])); ?>"
					<?php echo isset($this->placeholders[$key]) ? "placeholder='{$this->placeholders[$key]}'" : ''; ?>
				>
			<?php endif; ?>
		<?php endif; ?>
	<?php endif; ?>
</p>
<?php endforeach; ?>