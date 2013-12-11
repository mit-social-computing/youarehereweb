<?php echo $before_widget; ?>

<?php if(!empty($params['title'])): ?>
    <?php echo $before_title . $params['title'] . $after_title; ?>
<?php endif; ?>

<div class="recent-blog-posts-widget">
	<?php query_posts('cat='.intval($params['post_category']).'&posts_per_page='.intval($params['posts_number'])); ?>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	    <div class="recent-blog-post">
<h4 class="title"><?php the_title() ?></h4>
	    	<div class="excerpt">
	    		<?php 
					if(has_post_thumbnail() && $params['post_thumbnails'] == 'yes') {
					  the_post_thumbnail('thumbnail');
					} 
				?>
				
				<?php the_post_thumbnail('thumbnail', array('class' => 'alignleft')); ?>
				
		    	<?php the_excerpt(); ?>
		    	<div style="clear: both"></div>
		    </div>
		    <p><a href="<?php the_permalink(); ?>" class="readmore button button-primary button-large">Read more...</a></p>	
		</div>
	<?php endwhile; endif; ?>
	<?php wp_reset_query(); ?>
</div>

<?php echo $after_widget; ?>