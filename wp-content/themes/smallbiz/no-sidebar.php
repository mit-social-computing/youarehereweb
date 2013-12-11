<?php
/*
Template Name: Page without Sidebar
*/
if (is_front_page() && (get_option('smallbiz_mobile-layout-enabled') && $GLOBALS["smartphone"])){
    require(TEMPLATEPATH."/page.php");    
} else { 
?>
<?php get_header(); ?>
<style type="text/css">
#content{width:945px;float:none;}
</style>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<div style="width:945px !important;">
<?php 
if(isset($real_id)){
  $recent = new WP_Query("page_id=$real_id"); while($recent->have_posts()) : $recent->the_post();
  $pageClass = preg_replace("/[^a-z\d]/i", "", strtolower($recent->post->post_title));
  include("page_while.php"); 
  endwhile; 
} else {
?>

	<?php if(!is_page('home')) :?><h2 class="entry-title"><?php the_title(); ?></h2><?php endif; ?>
	
	<div class="entry">
  <?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
  <?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
<?php }?>
<?php endwhile; else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif;  ?>

</div>
</div>
<div style="clear: both;"></div>
</div>

<?php get_footer(); 
}
?>