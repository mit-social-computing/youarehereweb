<?php
/*
{{Template_name}}
*/
if (is_front_page() && (get_option('smallbiz_mobile-layout-enabled') && $GLOBALS["smartphone"])){
    include("page.php");
} else { 
?>
<?php get_header(); ?>

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
		<div class="entry">
		<?php if(!is_page('home')) :?><h2 class="entry-title"><?php the_title(); ?></h2><?php endif; ?>
		
							<?php global $more; $more = false; ?>
<?php the_content('...Continue Reading'); ?>
<?php $more = true; ?>
				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			</div>
		</div>
		<?php endwhile; endif; ?>

	</div>

	<div id="sidebar">
	<div id="innersidebarwrap">
		<ul>
			<?php include_once dirname(__FILE__).'/../global-sidebar.php'; ?>
			<?php 	/* Widgetized sidebar, if you have the plugin installed. */
					if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('{{Sidebar_name}}') ) : ?>
			<li class="box">
				
				<h3>Connect With Us: </h3>
				
				<p class="center"><a href="#" target="_blank"><img src="http://members.expand2web.com/E2W-theme-images/TW_icon2.png" class="frame" alt="Expand2Web Twitter Feed"/></a></p>
				
				<p class="center"><a href="#" target="_blank"><img src="http://members.expand2web.com/E2W-theme-images/YT_icon2.png" class="frame" alt="Expand2Web YouTube Link"/></a></p>
				
				<p class="center"><a href="#" target="_blank"><img src="http://members.expand2web.com/E2W-theme-images/FB_icon2.png" class="frame" alt="Expand2Web Facebook Link"/></a></p>
				
				<p>This demo sidebar widget will be replaced as soon as you add your own widget.</p>
				
				<p><strong><a href="http://userguide.expand2web.com/how-can-i-remove-the-default-social-media-widgets/" target="_blank">Click to Read the Tutorial</a><br /></strong></p>
			
			</li>
			<?php endif; ?>
		</ul>
		</div><!--innersidebarwrap-->
	</div><!--sidebar-->
	
<div style="clear: both;"></div>

<?php get_footer(); ?>
<?php } ?>