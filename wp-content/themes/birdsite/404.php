<?php
/*
The template for displaying 404 pages (Not Found).
*/
get_header(); ?>

<article class="hentry">

	<header class="entry-header">
		<h1 class="entry-title"><?php _e('Error 404 - Not Found', 'birdsite'); ?></h1>
	</header>


	<div class="entry-content">
		<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'birdsite' ); ?></p>
		<div class="widget">
		<?php get_search_form(); ?>
		</div>
	</div>

</article>

<?php get_footer(); ?>
