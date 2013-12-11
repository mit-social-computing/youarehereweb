<?php
/*
The template for displaying Archive pages.
*/
get_header(); ?>

<article class="hentry">

	<header class="entry-header">
		<h1 class="entry-title"><?php
			if(is_category()) {
				printf(__('Category Archives: %s', 'birdsite'), single_cat_title('', false));
			}
			elseif( is_tag() ) {
				printf(__('Tag Archives: %s', 'birdsite'), single_tag_title('', false) );
			}
			elseif (is_day()) {
				printf(__('Daily Archives: %s', 'birdsite'), get_post_time(get_option('date_format')));
			}
			elseif (is_month()) {
				printf(__('Monthly Archives: %s', 'birdsite'), get_post_time(__('F, Y', 'birdsite')));
			}
			elseif (is_year()) {
				printf(__('Yearly Archives: %s', 'birdsite'), get_post_time(__('Y', 'birdsite')));
			}
			elseif (is_author()) {
				printf(__('Author Archives: %s', 'birdsite'), get_the_author_meta('display_name', get_query_var('author')) );
			}
			elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
				_e('Blog Archives', 'birdsite');
			}
		?></h1>
	</header>

	<?php if (have_posts()) : ?>

		<ul>
		<?php while (have_posts()) : the_post(); ?>
			<?php get_template_part( 'content', get_post_format() ); ?>
		<?php endwhile; ?>
		</ul>

		<div class="tablenav"><?php birdsite_the_pagenation(); ?></div>
	<?php else: ?>
		<p><?php _e( 'Sorry, no posts matched your criteria.', 'birdsite' ); ?></p>
	<?php endif; ?>
</article>

<?php get_footer(); ?>
