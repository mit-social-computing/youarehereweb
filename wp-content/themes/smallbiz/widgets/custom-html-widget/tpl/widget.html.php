<?php echo $before_widget; ?>

<?php if(!empty($params['title'])): ?>
    <?php echo $before_title . $params['title'] . $after_title; ?>
<?php endif; ?>

<div class="custom_html_widget_content"><?php echo isset($params['html']) ? $params['html'] : ''; ?></div>

<?php echo $after_widget; ?>