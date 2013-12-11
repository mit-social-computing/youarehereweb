<style>#content{padding-bottom:0px;}</style>
<?php
/**
 * Widgetized front page theme.
 *
 * @package WordPress
 * @subpackage Expand2Web SmallBiz
 * @since Expand2Web SmallBiz 3.3
 */

$hideSidebar = true;

if (is_front_page() && (get_option('smallbiz_mobile-layout-enabled') && $GLOBALS["smartphone"])){
    include("page.php");
} else {
	//$header_content = ob_get_clean();
	//ob_start();
?>
<div class="entry" style="padding-left:0px;">

	<div id="widgetize_before_content" style="width: 945px; margin: 0 auto">
	<?php if (!(!function_exists('dynamic_sidebar') || !dynamic_sidebar('Dropzone Full Width'))): ?>
		<span style="clear: both;"></span>
	<?php endif; ?>
	</div>
	
	<?php
		//$widgetized_before_content = ob_get_clean();
		//echo str_replace('<!-- WIDGETIZED BEFORE CONTENT -->', $widgetized_before_content, $header_content);
	?>
	<div id="content">
	<?php if (function_exists('dynamic_sidebar')) { !dynamic_sidebar('Dropzone Main Content'); } ?>
</div> <!--content closing-->
	
<div id="sidebar">
<div id="innersidebarwrap">

		<?php if (function_exists('dynamic_sidebar')){ !dynamic_sidebar('Dropzone Right Sidebar'); } ?>

	</div><!--innersidebarwrap-->
</div><!--sidebar-->

<div style="clear: both;"></div>
<div id="widgetize_twocol_left"><?php if(function_exists('dynamic_sidebar')) { dynamic_sidebar('Dropzone Two Column Left'); }; ?></div>
<div id="widgetize_twocol_right"><?php if(function_exists('dynamic_sidebar')) { dynamic_sidebar('Dropzone Two Column Right'); }; ?></div>
<div style="clear: both;"></div>
<div id="widgetize_below_content"><?php if(function_exists('dynamic_sidebar')) { dynamic_sidebar('Dropzone 4 Column'); }; ?></div>
<div style="clear: both;"></div>

</div> <!--entry closing-->
<?php get_footer(); ?>
<?php } ?>