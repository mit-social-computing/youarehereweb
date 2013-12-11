<?php echo $before_widget; ?>

<?php if(!empty($params['title'])): ?>
    <?php echo $before_title . $params['title'] . $after_title; ?>
<?php endif; ?>

<div class="appointment-request-widget">
	<p>
		<span class="datepicker">
			<input type="text" readonly="readonly" value="DD/MM/YYYY">
			<img src="<?php bloginfo('template_url'); ?>/widgets/appointment-request-widget/img/calendar.png" alt="calendar">
		</span>
		<div class="calendar"></div>
	</p>
	<p>
		<select>
			<?php for($i=8; $i<=20; $i++): ?>
				<option value="<?php echo $i; ?>:00"><?php echo date('h:i A', strtotime($i.':00')); ?></option>
				<option value="<?php echo $i; ?>:30"><?php echo date('h:i A', strtotime($i.':30')); ?></option>
			<?php endfor; ?>
		</select>
	</p>
	<p>
		<button class="submit">Submit</button>
	</p>
</div>

<?php echo $after_widget; ?>
