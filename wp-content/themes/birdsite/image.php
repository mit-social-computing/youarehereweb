<?php
/*
The template for displaying image attachments.
*/
get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<time class="postdate" datetime="<?php echo get_the_time('Y-m-d') ?>" pubdate><?php echo get_post_time(get_option('date_format')); ?></time>
		</header>

		<div class="entry-content">

			<div class="entry-attachment">
				<div class="attachment">
<?php
$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
foreach ( $attachments as $k => $attachment ) {
if ( $attachment->ID == $post->ID )
break;
}
$k++;

if ( count( $attachments ) > 1 ) {
if ( isset( $attachments[ $k ] ) )
$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
else
$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
} else {
$next_attachment_url = wp_get_attachment_url();
}
?>
					<a href="<?php echo esc_url( $next_attachment_url ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php
					$attachment_size = apply_filters( 'birdsite_attachment_size', 848 );
					echo wp_get_attachment_image( $post->ID, array( $attachment_size, 960 ) );
					?></a>

					<?php if ( ! empty( $post->post_excerpt ) ) : ?>
					<div class="wp-caption">
						<?php the_excerpt(); ?>
					</div>
					<?php endif; ?>
				</div>
			</div>

			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'birdsite' ), 'after' => '</div>' ) ); ?>
		</div>

		<nav id="nav-below">
			<span class="nav-previous"><?php next_image_link( false, __( 'Next Image' , 'birdsite' )); ?></span>
			<span class="nav-next"><?php previous_image_link( false, __( 'Previous Image' , 'birdsite' ) ); ?></span>
		</nav>
		<?php comments_template(); ?>

	</article>
<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>
