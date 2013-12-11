<?php echo $before_widget; ?>

<?php if(!empty($params['title'])): ?>
    <?php echo $before_title . $params['title'] . $after_title; ?>
<?php endif; ?>

<div class="programista_it-<?php echo $this->widget_id; ?>">
	<iframe width="100%" src="http://www.youtube.com/embed/<?php echo $youtube_id; ?>?html5=1&amp;rel=0" frameborder="0" allowfullscreen></iframe>
</div>

<?php echo $after_widget; ?>