<?php
/*
The template for displaying Search Results pages.
*/
get_header(); ?>

<article class="hentry">

	<header class="entry-header">
	<h1 class="entry-title"><?php printf(__('Search Results: %s', 'birdsite'), esc_html($s) ); ?></h1>
	</header>

	<?php if (have_posts()) : ?>

		<ul id="archive">
		<?php while (have_posts()) : the_post(); ?>
			<?php get_template_part( 'content', get_post_format() ); ?>
		<?php endwhile; ?>
		</ul>

	<?php else: ?>
		<p><?php printf(__('Sorry, no posts matched &#8216;%s&#8217;', 'birdsite'), esc_html($s) ); ?>
	<?php endif; ?>

</article>

<?php get_footer(); ?>
