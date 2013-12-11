<?php
/*
Template Name: Facebook Page - No Menu
*/
?>

<?php

$layout = smallbiz_get_current_layout();  

?>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head>

<meta name='robots' content='noindex,nofollow' />

<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<?php if(get_option('smallbiz_mobile-layout-enabled') && $GLOBALS["smartphone"]){ ?>

<meta name="viewport" content="width=320px; initial-scale=1.0; maximum-scale=1.0; minimum-scale=1.0; user-scalable=0;" />

<?php } else { ?>

<meta name="viewport" content="width=980px;user-scalable=1;" />

<?php } ?>

<?php /* for custom fields start */ ?>

	<title><?php 

         /* Override the Title if the custom tag "_smallbiz_title" has been set. */

         /* if "_smallbiz_extra_title" has been set, append this. */

         $title = "";
         $is_smallbiz_frontpage = is_front_page() || (get_option('smallbiz_page_on_front') == $wp_query->get_queried_object()->ID);
         if (is_singular() && 
             !$is_smallbiz_frontpage){
             if (get_post_meta($wp_query->get_queried_object()->ID, "_smallbiz_title", true) && get_post_meta($wp_query->get_queried_object()->ID, "_smallbiz_title", true) != ""){ ?><?php
                 $title = get_post_meta($wp_query->get_queried_object()->ID, "_smallbiz_title", true);

             }else {             

                 $title = wp_title('|', true, 'right').get_bloginfo('name');
             }

             if(get_post_meta($wp_query->get_queried_object()->ID, "_smallbiz_extra_title", true)){

                 if($title != ""){

                     $title .= ",";
                 }
                 $title .= get_post_meta($wp_query->get_queried_object()->ID, "_smallbiz_extra_title", true);
             }
         } else if ($is_smallbiz_frontpage){

             $title = biz_option('smallbiz_title');
         }
         if(!$title){ $title = wp_title('|', true, 'right').get_bloginfo('name');}

         echo $title;
         
	?></title>

	<?php echo biz_option('smallbiz_webmaster');?>

	<meta name="wp_theme" content="Expand2Web SmallBiz <?php echo biz_option('smallbiz_version');?>" />

	<!-- Styles -->

	<link href="<?php bloginfo('template_url'); ?>/css/screen.css?v=<?php echo biz_option('smallbiz_version'); ?>" media="screen,projection,tv" rel="stylesheet" type="text/css" />

	<link href="<?php echo get_bloginfo('template_url').'/layouts/'.$layout; ?>/css/screen.css?v=<?php echo biz_option('smallbiz_version'); ?>" media="screen,projection,tv" rel="stylesheet" type="text/css" />

	<link href="<?php bloginfo('template_url'); ?>/colorscheme/<?php echo biz_option('smallbiz_css') ?>" media="screen,projection,tv" rel="stylesheet" type="text/css" />

	<link href="<?php echo get_bloginfo('template_url').'/layouts/'.$layout.'/colorscheme/'.biz_option('smallbiz_css')."";  ?>" media="screen,projection,tv" rel="stylesheet" type="text/css" />

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />


<?php $hide = (biz_option('smallbiz_custom_css_menu_enabled')); if($hide != ""){ ?>


<style>


<?php } ?>	

 <!--[if lte IE 9]>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/ie.css" type="text/css" media="screen" />

<![endif]-->
<!--[if lte IE 7]>

 <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/ie7.css" type="text/css" media="screen" />

 <![endif]-->

<!--[if lte IE 6]>  

<script src="<?php bloginfo('template_directory'); ?>/js/ie6toie8.js" type="text/javascript"></script> 

<![endif]-->

<!-- RSS & Pingback -->

<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<!-- WP3 Background Color/image: -->

<?php 
if(get_background_color() && get_background_color() != "#"){
if(!get_background_image()){
echo "<style>body{background-image:none;}</style>";
}
}

?>

<!-- smallbiz WordPress Theme by http://www.Expand2Web.com -->
<!-- Visit http://www.expand2web.com/blog/smallbiz-getting-started/ for user docs and tutorials. -->

<!-- WP Head -->	
<?php wp_head(); ?>
<?php echo biz_option('smallbiz_analytics');?>

<style>
#access{
background-color:#<?php echo biz_option('smallbiz_menu_color')?>;
}
#access a{
color:#<?php echo biz_option('smallbiz_passive_color')?>;
   }
#access ul :hover > a {
color:#<?php echo biz_option('smallbiz_hover_color')?>;
}
#access li:hover > a,{
color:#<?php echo biz_option('smallbiz_hover_color')?>;
}
#access ul li.current_page_item > a,
#access ul li.current-menu-ancestor > a,
#access ul li.current-menu-item > a,
#access ul li.current-menu-parent > a {
color: #<?php echo biz_option('smallbiz_active_color')?>;
}
#access ul ul a {
background-color:#<?php echo biz_option('smallbiz_menu_color')?>;
}
#access ul ul :hover > a {
background-color:#<?php echo biz_option('smallbiz_menu_color')?>;
color:#<?php echo biz_option('smallbiz_hover_color')?>;
}
#access ul ul li.current_page_item > a,
#access ul ul li.current-menu-ancestor > a,
#access ul ul li.current-menu-item > a,
#access ul ul li.current-menu-parent > a {
background-color:#<?php echo biz_option('smallbiz_menu_color')?>;
color: #<?php echo biz_option('smallbiz_active_color')?>;
}
#sidebar h3 {
background-color:#<?php echo biz_option('smallbiz_menu_color')?>;
color: #<?php echo biz_option('smallbiz_active_color')?>;
}
h2, .smallbiz_map h4 {
color: #<?php echo biz_option('smallbiz_headertag_color')?>;
}
a:link, a:visited { 
color: #<?php echo biz_option('smallbiz_hyper_color')?>;
}
p, ul, li {
color: #<?php echo biz_option('smallbiz_p_color')?>;
}
.contactleft {
color: #<?php echo biz_option('smallbiz_p_color')?>;
}
p.footercenter {
color: #<?php echo biz_option('smallbiz_creds_color')?>;
}
#content {
padding-left:0px;
}
.entry {
padding-left:0px;
}
.entry p{
padding-left:0px;
}
#page{background:none;border:none;}
#header{border:none;}
#site-wrap{background:none;border:none;}
</style>

<script type="text/javascript">
window.fbAsyncInit = function() {
FB.Canvas.setSize();

}

// Do things that will sometimes call sizeChangeCallback()

function sizeChangeCallback() {
FB.Canvas.setSize();
}

</script>

<script type="text/javascript">
window.fbAsyncInit = function() {
FB.Canvas.setSize();
}
// Do things that will sometimes call sizeChangeCallback()
function sizeChangeCallback() {
FB.Canvas.setSize();
}
</script>

</head>
    <?php 
    // For wordpress page admin bar:
    if(isset($_REQUEST["page_admin"])){
        ?>
        <iframe frameborder="0" style="width:780px;height:20px; overflow:hidden;" 
            src="<?php echo $_REQUEST["page_admin"]; ?>" 
            id="blog_frame_admin" 
            name="blog_frame_admin">
            </iframe>
        <?php
    }
    ?>



<body style="background-color:#fff; background-image:none;overflow:hidden;">

<div id="page"  style="width:780px;">

<div>

<div id="content">


		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		<div style="width:780px !important;">

		<div class="post" id="post-<?php the_ID(); ?>">

		<?php if(!is_page('')) :?><h2><?php the_title(); ?></h2><?php endif; ?>

			<div class="entry">

							<?php global $more; $more = false; ?>

<?php the_content('...Continue Reading'); ?>

<?php $more = true; ?>

				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

			</div>

		</div>

		<?php endwhile; endif; ?>
</div>
</div>
<div id="fb-root"></div>

<script src="https://connect.facebook.net/en_US/all.js"></script>

<script>

FB.init({

appId : 197985243569210,

status : true, // check login status

cookie : true, // enable cookies to allow the server to access the session

xfbml : true // parse XFBML

});

</script>
</body>
</html>