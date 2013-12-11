<?php echo $before_widget; ?>

<div>

<?php if(!empty($params['widget_title'])): ?>
    <?php echo $before_title . $params['widget_title'] . $after_title; ?>
<?php endif; ?>

<?php if(!empty($params['image_url'])): ?>
<div class="e2wimagewidget">
  <div class="caption" style="text-align: <?php echo $params['caption_alignment']; ?>">
      <?php if(!empty($params['link_url'])): ?>
          <a href="<?php echo $params['link_url']; ?>" target="_blank">
      <?php endif; ?>
          <img src="<?php echo $params['image_url']; ?>" alt="<?php echo $params['image_alt_text']; ?>" title="<?php echo $params['image_title']; ?>" style="max-width: 100%; height: auto">
      <?php if(!empty($params['link_url'])): ?>
          </a>
      <?php endif; ?>
    </div>
  <?php if(!empty($params['image_caption'])): ?>
        <div class="caption" style="font-size: 12px; margin: 10px 0; text-align: <?php echo $params['caption_alignment']; ?>">
          <?php echo $params['image_caption']; ?>
        </div>
    <?php endif; ?>
    </div></div>
<?php else: ?>
  </div>
<?php endif; ?>


<?php echo $after_widget; ?>