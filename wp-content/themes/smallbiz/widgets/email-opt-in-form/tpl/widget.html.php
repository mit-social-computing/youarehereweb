<?php echo $before_widget; ?>

<?php if(!empty($params['title'])): ?>
    <?php echo $before_title . $params['title'] . $after_title; ?>
<?php endif; ?>

<?php if(empty($params['embed-code'])): ?>
	<div class="programista-it-email-opt-in-form">
		<p><b><?php echo $params['opt-in-description']?></b></p>
		<form action="?30c8d4c5a363936f380c203fc6a2733a" method="post">
			<p>
				<label for="<?php echo $this->id; ?>-name">Name</label>
				<input id="<?php echo $this->id; ?>-name" type="text" required name="OptIn[name]">
			</p>
			<p>
				<label for="<?php echo $this->id; ?>-email">E-mail</label>
				<input id="<?php echo $this->id; ?>-email" type="email" required name="OptIn[email]">
			</p>
			<input type="hidden" name="OptIn[widget]" value="<?php echo $this->number; ?>">
			<input type="submit" value="Submit">
		</form>
	</div>
<?php else: ?>
	<?php echo $params['embed-code']; ?>
<?php endif; ?>

<?php echo $after_widget; ?>