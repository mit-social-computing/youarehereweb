<?php get_header(); ?>







	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>







		<div class="post" id="post-<?php the_ID(); ?>">







			<div class="post-title"><h2><?php the_title(); ?></h2></div>







			<br />







			<div class="entry">


<?php the_post_thumbnail('thumbnail', array('class' => 'alignleft')); ?>








				<?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>







				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>







				<?php the_tags( '<p>Tags: ', ', ', '</p>'); ?>







	







			</div>







		</div>



<div style="clear: both;"></div>



	<?php comments_template(); ?>







	<?php endwhile; else: ?>







		<p>Sorry, no posts matched your criteria.</p>







<?php endif; ?>







<?php include(TEMPLATEPATH."/sidebar-blog.php");?>







<?php get_footer(); ?>