<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<head> 
  <title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>          
  <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" title="no title" charset="utf-8"/>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js" type="text/javascript"></script>

<script language="javascript">
$(document).ready(function(){
  // Add the hover handler to the link
  $(".img_hover_trans").hover(
    function(){ // When mouse pointer is above the link
      // Make the image inside link to be transparent
      $(this).find("img").animate(
        {opacity:"1"},
        {duration:300}
      );
    },
    function(){ // When mouse pointer move out of the link
      // Return image to its previous state
      $(this).find("img").animate(
        {opacity:".8"},
        {duration:300}
      );
    }
  );
});
</script>
  <?php wp_head(); ?>
</head>
<body>
<div class="top_line">

</div><!--//top_line-->

<?php $shortname = "ultra_grid"; ?>

<?php if(get_option($shortname.'_custom_background_color','') != "") { ?>
<style type="text/css">
  body { background-color: <?php echo get_option($shortname.'_custom_background_color',''); ?>; }
</style>
<?php } ?>

<div id="main_container">

  <div id="menu_container">
    
    <div class="logo_new">
      <?php if(get_option($shortname.'_custom_logo_url','') != "") { ?>
        <a href="<?php bloginfo('url'); ?>"><img src="<?php echo stripslashes(stripslashes(get_option($shortname.'_custom_logo_url',''))); ?>" /></a>
      <?php } else { ?>
        <a href="<?php bloginfo('url'); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/logo.png" /></a>
      <?php } ?>    
    </div><!--//logo_new-->
  
    <?php wp_nav_menu('menu=header_menu&container=false&menu_class=left_list'); ?>
<!--    <ul class="left_list">
      <li><a href="/">Home</a></li>
      <li><a href="/about/">About</a></li>
      <li><a href="/contact/">Contact</a></li>
    </ul>-->
    
    <?php wp_nav_menu('menu=social_menu&container=false&menu_class=left_list_second'); ?>
<!--    <ul class="left_list_second">
      <li><a href="http://www.facebook.com">Facebook</a></li>
      <li><a href="http://www.twitter.com">Twitter</a></li>
      <li><a href="http://www.flickr.com">Flickr</a></li>    
    </ul>-->
  
    <div class="right_search">
      <form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
      <input type="text" value="" name="s" id="s" />
      <INPUT TYPE="image" SRC="<?php bloginfo('stylesheet_directory'); ?>/images/search-icon-small.png" class="search_icon" BORDER="0" ALT="Submit Form">
      </form>
    </div><!--//right_search-->
    
    <div class="header_text">
      <?php echo get_option($shortname.'_header_text','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.'); ?>
    </div><!--//header_text-->
    
    <div class="clear"></div>
  </div><!--//menu_container-->
  
  <div id="header_container">
   
    
   
    
    <div class="clear"></div>
  </div><!--//header_container-->
  
  <div id="header_category_container">
    
    <div class="clear"></div>
  </div><!--//header_category_container-->