<?php
/**
 * Classic front page theme.
 *
 * @package WordPress
 * @subpackage Expand2Web SmallBiz
 * @since Expand2Web SmallBiz 3.3
 */
?>
<style>#content{padding-bottom:21px;}</style>
    <div id="homewrap">
	<div id="homeimage">
	    <p><a href="<?php echo biz_option('smallbiz_imagelinkclassic')?>">
	    
	    <img width="313" src="<?php bloginfo('template_url'); ?>/images/<?php echo biz_option('smallbiz_page_image')?>" alt="<?php echo biz_option('smallbiz_name')?>" title="<?php echo biz_option('smallbiz_name')?>" />
	</a></p>
	</div>
	
	<div id="hometext">  
	    <?php echo do_shortcode(biz_option('smallbiz_main_text'))?>
    </div>
    </div>
    
<div style="clear: both;"></div>