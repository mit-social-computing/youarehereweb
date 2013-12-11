<?php
$layout = smallbiz_get_current_layout();  
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
<!--Expand2Web SmallBiz Dynamic 2.0 LITE Version-->
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />


<?php $real_layout = (get_option('smallbiz_layout')); ?>

<?php if(biz_option('smallbiz_mobile-layout-enabled') && $GLOBALS["smartphone"]){ ?>
<meta name="viewport" content="width=device-width" />

<?php } else {

if ($real_layout == "widgetized"){ ?>
<meta name="viewport" content="width=device-width" />

<?php } else { ?>
<meta name="viewport" content="width=1055px;user-scalable=1;" />
<?php }} ?>

<?php /* for custom fields start */ ?>
	<title><?php 
         /* Override the Title if the custom tag "_smallbiz_title" has been set. */
         /* if "_smallbiz_extra_title" has been set, append this. */
         $title = "";
         $is_smallbiz_frontpage = is_front_page() || (biz_option('smallbiz_page_on_front') == $wp_query->get_queried_object()->ID);
         if (is_singular() && 
             !$is_smallbiz_frontpage){
             if (get_post_meta($wp_query->get_queried_object()->ID, "_smallbiz_title", true) && get_post_meta($wp_query->get_queried_object()->ID, "_smallbiz_title", true) != ""){ ?><?php
                 $title = get_post_meta($wp_query->get_queried_object()->ID, "_smallbiz_title", true);
             }else {             
                 $title = wp_title('|', true, 'right').biz_option('smallbiz_name');
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
         if(!$title){ $title = wp_title('|', true, 'right').biz_option('smallbiz_name');}
         echo $title;
         
	?></title>
<?php $hide = (biz_option('smallbiz_seo_disabled')); if($hide == ""){ ?>
	<meta name="description" content="<?php 
         /* Override the description if the custom tag "_smallbiz_description" has been set. */
         /* if "_smallbiz_extra_descrition" has been set, append this. */
         $description = biz_option('smallbiz_description');
         if (is_singular()  &&
             !($is_smallbiz_frontpage)
             ){
             
             if (get_post_meta($wp_query->get_queried_object()->ID, "_smallbiz_description", true) && get_post_meta($wp_query->get_queried_object()->ID, "_smallbiz_description", true) != ""){ ?><?php
                 $description = get_post_meta($wp_query->get_queried_object()->ID, "_smallbiz_description", true);
             }else {             
                 $description = "";
             }
             if(get_post_meta($wp_query->get_queried_object()->ID, "_smallbiz_extra_description", true)){
                 if($description != ""){
                     $description .= ",";
                 }
                 $description .= get_post_meta($wp_query->get_queried_object()->ID, "_smallbiz_extra_description", true);
             }
             echo $description;
         } else {
             $description = biz_option('smallbiz_description');
            echo $description;
         }	
	?>" />
	<meta name="keywords" content="<?php 
         
         /* Override the keywords if the custom tag "_smallbiz_keywords" has been set. */
         /* if "_smallbiz_extra_keywords" has been set, append this. */
         if (is_singular()  &&
             !($is_smallbiz_frontpage)
             ){
             $keywords = "";
             if (get_post_meta($wp_query->get_queried_object()->ID, "_smallbiz_keywords", true) && get_post_meta($wp_query->get_queried_object()->ID, "_smallbiz_keywords", true) != ""){ ?><?php
                 $keywords = get_post_meta($wp_query->get_queried_object()->ID, "_smallbiz_keywords", true);
             }else {             
                 $keywords = "";
             }
             if(get_post_meta($wp_query->get_queried_object()->ID, "_smallbiz_extra_keywords", true)){
                 if($keywords != ""){
                     $keywords .= ",";
                 }
                 $keywords .= get_post_meta($wp_query->get_queried_object()->ID, "_smallbiz_extra_keywords", true);
             }
             echo $keywords;
         } else {
             $keywords = biz_option('smallbiz_keywords');
             echo $keywords;
         }	     
	     ?>" />
<?php /* for custom fields end */ ?>
<?php } ?>	
<?php echo biz_option('smallbiz_webmaster');?>
<link rel="author" href="<?php echo biz_option('smallbiz_gplusauthor');?>"/>
<link rel="publisher" href="<?php echo biz_option('smallbiz_gpluspublisher');?>"/>
<style type="text/css">
body{background-attachment: scroll;background-image: url("<?php bloginfo('template_url'); ?>/images/texture.png");
background-position: left top;background-repeat: repeat-x;}
#header h1 {font-family:<?php echo biz_option('smallbiz_font_family_header')?>; font-size:<?php echo biz_option('smallbiz_font_size_head')?>px;}
#header h2{font-size:<?php echo biz_option('smallbiz_font_size_headertag')?>px;
font-family:<?php echo biz_option('smallbiz_font_family_headertag')?>;}
#header .street-address {font-family:<?php echo biz_option('smallbiz_font_family_headeraddress')?>;font-size:<?php echo biz_option('smallbiz_font_size_headeraddress')?>px;}
#header .locality {font-family:<?php echo biz_option('smallbiz_font_family_headeraddress')?>;font-size:<?php echo biz_option('smallbiz_font_size_headeraddress')?>px;}
#header .region {font-family:<?php echo biz_option('smallbiz_font_family_headeraddress')?>;font-size:<?php echo biz_option('smallbiz_font_size_headeraddress')?>px;}
#header .postal-code {font-family:<?php echo biz_option('smallbiz_font_family_headeraddress')?>;font-size:<?php echo biz_option('smallbiz_font_size_headeraddress')?>px;}
#header .email {font-family:<?php echo biz_option('smallbiz_font_family_headeraddress')?>;font-size:<?php echo biz_option('smallbiz_font_size_headeraddress')?>px;}
#header .tel {font-family:<?php echo biz_option('smallbiz_font_family_headerphone')?>;font-size:<?php echo biz_option('smallbiz_font_size_headerphone')?>px; font-weight:bold; line-height: 33px;}
h2, #post-title a, .smallbiz_maptitle h4 {color: #<?php echo biz_option('smallbiz_headertag_color')?>;}
h1, #content h1, #sidebar h1, #featured h1, #footer h1{font-size:<?php echo biz_option('smallbiz_font_size_h1')?>px;}
h2, #content h2, #sidebar h2, #footer h2{font-size:<?php echo biz_option('smallbiz_font_size_h2')?>px;}
.menu a{font-family:<?php echo biz_option('smallbiz_font_family_menu')?>;font-size:<?php echo biz_option('smallbiz_font_size_menu')?>px;}
#post-title a {font-size:<?php echo biz_option('smallbiz_font_size_pagetitle')?>px; font-family:<?php echo biz_option('smallbiz_font_family_pagetitle')?>;}
.entry-title {font-family:<?php echo biz_option('smallbiz_font_family_pagetitle')?>;}
p, #content p, #content h1,#content h2, #content h3, #content h4, #content h5, #content ul, #content li {font-family:<?php echo biz_option('smallbiz_font_family_main')?>;}
p, #content p, #content ul, #content li {font-size:<?php echo biz_option('smallbiz_font_size_main')?>px;}
p, ul, li, small {color: #<?php echo biz_option('smallbiz_p_color')?>;}
h3 a.rsswidget  {background-color:#<?php echo biz_option('smallbiz_menu_color')?>;font-family:<?php echo biz_option('smallbiz_font_family_sideh3')?>;font-size:<?php echo biz_option('smallbiz_font_size_sideh3')?>px;color:#<?php echo biz_option('smallbiz_sideh3_color')?>;text-decoration:none;padding-left:5px;}
#sidebar h3 {background-color:#<?php echo biz_option('smallbiz_menu_color')?>;font-family:<?php echo biz_option('smallbiz_font_family_sideh3')?>;font-size:<?php echo biz_option('smallbiz_font_size_sideh3')?>px;color:#<?php echo biz_option('smallbiz_sideh3_color')?>;}
#sidebar p, #sidebar h1,#sidebar h2, #sidebar h4,#sidebar h5,#sidebar ul,#sidebar li, #sidebar a {font-family:<?php echo biz_option('smallbiz_font_family_side')?>;}
#sidebar p, #sidebar ul,#sidebar li {font-size:<?php echo biz_option('smallbiz_font_size_side')?>px;}
h3, #content h3, #featured h3, #footer h3{font-size:<?php echo biz_option('smallbiz_font_size_h3')?>px;}
.contactleft, .contactright {color: #<?php echo biz_option('smallbiz_p_color')?>;}
#respond {color: #<?php echo biz_option('smallbiz_p_color')?>;}
#featured p, #featured h1,#featured h2,#featured h3,#featured h4,#featured h5,#featured ul,#featured li,#featured a {font-family:<?php echo biz_option('smallbiz_font_family_feature')?>;}
#featured p, #featured h4, #featured h5, #featured ul, #featured li, #featured a 
{font-size:<?php echo biz_option('smallbiz_font_size_feature')?>px;}
#footer p,#footer h1,#footer h2,#footer h3,#footer h4,#footer h5,#footer ul,#footer li,#footer a, #footer b {font-family:<?php echo biz_option('smallbiz_font_family_footer')?>;}
#footer p,#footer h4,#footer h5,#footer ul,#footer li,#footer a, #footer b {font-size:<?php echo biz_option('smallbiz_font_size_footer')?>px;}
a:link, a:visited {color: #<?php echo biz_option('smallbiz_hyper_color')?>;}
a:hover {color: #<?php echo biz_option('smallbiz_hyperhover_color')?>;}
p.footercenter {color: #<?php echo biz_option('smallbiz_creds_color')?>;}
#footer, #footer a, #footer b {color: #<?php echo biz_option('smallbiz_creds_color')?>;}
#page{background:#<?php echo biz_option('smallbiz_pages_color')?>;}
#accesswrap{background-color:#<?php echo biz_option('smallbiz_menu_color')?>;}
#contentwrap{background-color:#<?php echo biz_option('smallbiz_wrapperpages_color')?>;}
#featuredwrap{background-color:#<?php echo biz_option('smallbiz_wrapperfeatures_color')?>;}

#access {background-color:#<?php echo biz_option('smallbiz_menu_color')?>;}
#access ul ul a {background-color:#<?php echo biz_option('smallbiz_menu_color')?>;}
#access ul ul :hover > a {
background-color:#<?php echo biz_option('smallbiz_menu_color')?>;color:#<?php echo biz_option('smallbiz_hover_color')?>;}
#access ul ul li.current_page_item > a,
#access ul ul li.current-menu-ancestor > a,
#access ul ul li.current-menu-item > a,
#access ul ul li.current-menu-parent > a {background-color:#<?php echo biz_option('smallbiz_menu_color')?>;color: #<?php echo biz_option('smallbiz_active_color')?>;}
#access a{color:#<?php echo biz_option('smallbiz_passive_color')?>;}
#access li:hover > a,{color:#<?php echo biz_option('smallbiz_hover_color')?>;}
#access ul :hover > a {color:#<?php echo biz_option('smallbiz_hover_color')?>;}
#access ul ul:hover > a{border:none;}
#access ul li.current_page_item > a,
#access ul li.current-menu-ancestor > a,
#access ul li.current-menu-item > a,
#access ul li.current-menu-parent > a {color: #<?php echo biz_option('smallbiz_active_color')?>;}

#sidebar h3:after{content:url(<?php bloginfo('template_directory'); ?>/images/corner.png);}

.appointment-request-widget .submit, #appointment_request_widget_footer_iframe button {
background-color:#<?php echo biz_option('smallbiz_widgetsubmit_bgcolor')?>;
font-family:<?php echo biz_option('smallbiz_font_family_sideh3')?>;
color:#<?php echo biz_option('smallbiz_widgetsubmit_color')?>;
border-color:#<?php echo biz_option('smallbiz_widgetsubmit_color')?>;
}

.recent-blog-posts-widget .readmore {
background-color:#<?php echo biz_option('smallbiz_widgetsubmit_bgcolor')?>;
font-family:<?php echo biz_option('smallbiz_font_family_sideh3')?>;
color:#<?php echo biz_option('smallbiz_widgetsubmit_color')?>;
border-color:#<?php echo biz_option('smallbiz_widgetsubmit_color')?>;
}

.programista-it-email-opt-in-form input[type=submit] {
background-color:#<?php echo biz_option('smallbiz_widgetsubmit_bgcolor')?>;
font-family:<?php echo biz_option('smallbiz_font_family_sideh3')?>;
color:#<?php echo biz_option('smallbiz_widgetsubmit_color')?>;
border-color:#<?php echo biz_option('smallbiz_widgetsubmit_color')?>;
}

.recent-blog-post h4{font-size:<?php echo biz_option('smallbiz_font_size_side')?>px;}


</style>



<!-- Styles -->
<link href="<?php bloginfo('template_url'); ?>/css/screen.css?v=<?php echo biz_option('smallbiz_version'); ?>" media="screen,projection,tv" rel="stylesheet" type="text/css" />

<link href="<?php echo get_bloginfo('template_url').'/layouts/'.$layout; ?>/css/screen.css?v=<?php echo biz_option('smallbiz_version'); ?>" media="screen,projection,tv" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />

 <!--[if lte IE 9]>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/ie.css" type="text/css" media="screen" />
<![endif]-->
<!--[if lte IE 7]>
 <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/ie7.css" type="text/css" media="screen" />
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
<!-- SmallBiz WordPress Theme by http://www.Expand2Web.com -->
<!-- WP Head -->	
<?php wp_head(); ?>
<?php echo biz_option('smallbiz_analytics');?>

<script>
(function($){
    $(function(){
    	// if we have only 1 widget, and it is slider, make it full width, and remove margins
        var widgets = $('.widgetized_before_content_widget');
        widgets.css('min-width', parseInt(100 / widgets.length, 10) + '%').css('margin-right', 0);
        if(widgets.length == 1 && widgets.find('.nivoSlider').length == 1) {
        	var before_content = $('#widgetize_before_content');
        	before_content.css('width', 'auto').css('padding', 0);
        	before_content.find('.slider-wrapper').css('margin', 0);
        }
        if(widgets.length == 0) {
        	$('#widgetize_before_content').css('display', 'none');
        }
    });
})(jQuery);
</script>

</head>
<body <?php body_class(); ?>>

<div id="site-wrap">
<div class= "vcard" id="header" onClick="document.location='<?php bloginfo('url')?>';" style="cursor:pointer;">

<div id="logo">
<?php if(biz_option('smallbiz_logo')!=""){ ?>
<img src="<?php echo biz_option('smallbiz_logo')?>" alt="Logo" />
<?php }?>
</div>


<div style="clear: both;"></div>

<!-- Hide Name and Tagline if checkbox is not equal to by adding div id noheader -->
<?php $hide = (biz_option('smallbiz_header_box_disabled')); if($hide != ""){ ?>
<style type="text/css">#header p{margin-top: -128px;}</style><div id="noheader"> 		<?php } ?>	

<!-- Hide Comoplete header if checkbox is not equal to by adding div id noheader -->
<?php $hide = (biz_option('smallbiz_header_box_disabled_complete')); if($hide != ""){ ?>
<div id="noheader"> 		<?php } ?>	

<h1><span class="fn org"><a style="color:#<?php echo biz_option('smallbiz_name_color') ?>;text-decoration:none;" href="<?php bloginfo('url')?>"><?php echo biz_option('smallbiz_name');//bloginfo('name'); ?></a></span></h1>
<h2 style="color:#<?php echo biz_option('smallbiz_sub_header_color')?>;"><?php echo biz_option('smallbiz_sub_header'); //bloginfo('description'); ?></h2>

<?php $hide = (biz_option('smallbiz_header_box_disabled')); if($hide != ""){ ?> </div> <?php } ?>

<p>
<span class="adr">
<span class="tel" style="color:#<?php echo biz_option('smallbiz_telephone_color')?>;"><?php echo biz_option('smallbiz_telephone')?></span> 

<?php if(biz_option('smallbiz_headertwitter')!=""){ ?>
<a href="<?php echo biz_option('smallbiz_headertwitter'); ?>" class="headertwitter" title="Follow Us on Twitter!" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/twitterheader.png" alt="Follow Us on Twitter!" style="padding-left:3px;"/></a>
<?php }?>

<?php if(biz_option('smallbiz_headerfacebook')!=""){ ?>
<a href="<?php echo biz_option('smallbiz_headerfacebook'); ?>" class="headerfacebook" title="Follow Us on Facebook!" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/fbheader.png" alt="Follow Us on Facebook!" /></a>
<?php }?>

<?php if(biz_option('smallbiz_headergoogle')!=""){ ?>
<a href="<?php echo biz_option('smallbiz_headergoogle'); ?>" class="headergoogle" title="Follow Us on Google+!" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/googleheader.png" alt="Follow Us on Google+!" /></a>
<?php }?>

<br />

<span class="street-address" style="color:#<?php echo biz_option('smallbiz_street_color')?>;"><?php echo biz_option('smallbiz_street')?> - </span>

<span class="locality" style="color:#<?php echo biz_option('smallbiz_city_color')?>;"><?php echo biz_option('smallbiz_city')?></span>

<span class="region" style="color:#<?php echo biz_option('smallbiz_state_color')?>;"><?php echo biz_option('smallbiz_state')?></span>

<span class="postal-code" style="color:#<?php echo biz_option('smallbiz_zip_color')?>;"><?php echo biz_option('smallbiz_zip')?></span><br />

<span class="email"><a style="color:#<?php echo biz_option('smallbiz_headeremail_color')?>;" href="mailto:<?php echo biz_option('smallbiz_headeremail')?>"><?php echo biz_option('smallbiz_headeremail')?></a></span>
</span>
</p>

<?php $hide = (biz_option('smallbiz_header_box_disabled_complete')); if($hide != ""){ ?> </div> <?php } ?>
	
</div> <!--company logo-->
</div> <!--header-->

<div id="accesswrap">
<div id="access" role="navigation" class="menu">
<?php /* SmallBiz navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu.  
The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.  */ ?>
<?php smallbiz_wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>
</div><!-- #access -->
<div style="clear: both;"></div>
</div><!-- accesswrap -->


<div id="contentwrap">
<div id="pagespace"></div>
<div id="contentsidespace">

<div id="page">
	
<!-- WIDGETIZED BEFORE CONTENT -->

<?php if(!(get_option('smallbiz_layout') == 'widgetized' && is_front_page())): ?>
	<div id="content">
<?php endif; ?>