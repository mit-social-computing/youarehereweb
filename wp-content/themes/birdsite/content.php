<?php
/*
The default template for displaying content. Used for both single and index/page/archive/search.
*/
?>

<?php if ( is_home() ) : /* Display Excerpts for Home */ ?>

	<?php has_post_thumbnail()? $birdsite_image_tag = 'has-image' : $birdsite_image_tag = ''; ?>

	<li id="post-<?php the_ID(); ?>" <?php post_class($birdsite_image_tag); ?>>
		<?php if(has_post_thumbnail()): ?>
			<div class="thumbnail">
				<?php the_post_thumbnail('large'); ?>
				<div class="more-link"><a href="<?php the_permalink(); ?>"><?php _e( 'more', 'birdsite' ); ?></a></div>
			</div>
		<?php endif; ?>

		<div class="caption">
			<header class="entry-header">
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'birdsite' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			</header><!-- .entry-header -->

			<footer class="entry-meta">
				<div class="icon postdate"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'birdsite' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><time datetime="<?php echo get_the_time('Y-m-d') ?>" pubdate><?php echo get_post_time(get_option('date_format')); ?></time></a></div>

				<div class="icon author"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a></div>
				<div class="icon category"><?php the_category(', ') ?></div>
				<?php if ( comments_open() ) : ?>
					<div class="icon comment"><?php comments_popup_link(__('No Comments', 'birdsite'), __('1 Comment', 'birdsite'), __('% Comments', 'birdsite'), '', __('Comments Closed', 'birdsite') ); ?></div>
				<?php endif; ?>
			</footer><!-- .entry-meta -->
			<div class="more-link"><a href="<?php the_permalink(); ?>"><?php _e( 'more', 'birdsite' ); ?></a></div>
		</div>
	</li><!-- #post -->

<?php elseif(is_singular()): // Display Excerpts for Single/Page ?>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'birdsite' ), 'after' => '</div>' ) ); ?>
	</div>

	<?php if(is_single()): // Only Display Excerpts for Single ?>
		<footer class="entry-meta">

			<div class="icon postdate"><time datetime="<?php echo get_the_time('Y-m-d') ?>" pubdate><?php echo get_post_time(get_option('date_format')); ?></time></div>

			<div class="icon author"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a></div>

			<div class="icon category"><?php the_category(', ') ?></div>
			<?php the_tags('<div class="icon tag">', ', ', '</div>') ?>
			
		</footer>
	<?php endif; ?>

<?php else: // Display Excerpts for Archive/Search ?>

	<li><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail('thumbnail'); ?><p><span><?php the_title(); ?></span><span class="postdate"><time datetime="<?php echo get_the_time('Y-m-d') ?>" pubdate><?php echo get_post_time(get_option('date_format')); ?></time></span></p></a></li>
<?php endif; ?>
