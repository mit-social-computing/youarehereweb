<div id="footer-right-sidebar">
<ul>
	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Dropzone Footer Right') ) : else : ?>
<li class="third featured">
				<h2><?php $page = get_page_(biz_option('smallbiz_feature_page_3')); echo $page->post_title?></h2>
				<p style="color:#<?php echo biz_option('smallbiz_page_summary_3_color')?>;">
				<?php echo biz_option('smallbiz_feature_page_summary_3');?></p>
					<p><a href="<?php bloginfo('url'); ?>/?page_id=<?php echo $page->ID ?>">continue reading...</a>
				</p>
			</li>
<?php endif; ?>
</ul>
</div>