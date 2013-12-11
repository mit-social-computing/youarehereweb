<?php
/*
The main template file.
*/
get_header(); ?>

<ul id="thumbnails" class="row">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'content', get_post_format() ); ?>
	<?php endwhile; ?>
</ul>
<div class="tablenav"><?php birdsite_the_pagenation(); ?></div>


<?php get_footer(); ?>
