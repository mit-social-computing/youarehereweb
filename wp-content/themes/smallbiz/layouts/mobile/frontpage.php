<?php
/**
 * Mobile front page theme.
 *
 * @package WordPress
 * @subpackage Expand2Web SmallBiz
 * @since Expand2Web SmallBiz 3.4
 */
  $hideSidebar = true;
?>
 
<head>

<meta http-equiv="Content-Type" value="application/xhtml+xml" /> 

<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.1//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile11.dtd"> 


<title><?php echo biz_option('smallbiz_title');?></title>
<meta name="description" content="<?php echo biz_option('smallbiz_description');?>"/>
<meta name="keywords" content="<?php echo biz_option('smallbiz_keywords');?>" />
<?php echo biz_option('smallbiz_analytics');?>	 

<style>
body{background:none;}
body.custom-background {
background-image:none;
background-color:#<?php echo biz_option('smallbiz_mobile-body-color')?>;}

#pagewrap{background-color:#<?php echo biz_option('smallbiz_mobile-body-color')?>;}

#headerstrip{
background-color: #<?php echo biz_option('smallbiz_mobile-nametag-color')?>;
margin-bottom: 14px;
padding-top: 10px;
}

#headerstrip img{
border:none;
padding:0px;
width:320px;
margin-top:-10px;
border:none;
}

#headerstrip h1{
font-family:<?php echo biz_option('smallbiz_font_family_header')?>; 
color: #<?php echo biz_option('smallbiz_mobiname_color')?>;
font-size:<?php echo biz_option('smallbiz_font_size_mobiname')?>px;
padding-top: 12px;
}

#headerstrip h2{
font-family:<?php echo biz_option('smallbiz_font_family_header')?>; 
color: #<?php echo biz_option('smallbiz_mobisub_header_color')?>;
font-size:<?php echo biz_option('smallbiz_font_size_mobisubheader')?>px;
border-bottom: 2px solid #000000;
padding-bottom: 19px;
}

#tab-area-small {
xxxbackground-color: #<?php echo biz_option('smallbiz_mobile-button-color')?>;
}

#tab-area-small a{
color: #<?php echo biz_option('smallbiz_mobile-text-button-color')?>;
}

#textbox img {
border: medium none;
width: 320px;
margin-left:-7px;
}

#content p{
font-size:18px;
margin:1em 0 1em 0;
line-height: 1.3em;
font-family:<?php echo biz_option('smallbiz_font_family_main')?>;
}

.tertiary-menu li{
xbackground-color: #<?php echo biz_option('smallbiz_mobile-button-color')?>;
background-image:url("<?php bloginfo('template_directory'); ?>/images/mobile/mobile-menu-arrow.png");
background-repeat:no-repeat;
}

.tertiary-menu a{
color: #<?php echo biz_option('smallbiz_mobile-text-button-color')?>;
font-family:<?php echo biz_option('smallbiz_font_family_main')?>;
biz_option('smallbiz_font_family_menu')?>;
display:block;
font-weight:bold;
font-size: 19px;
}

#combined{
background-color: #<?php echo biz_option('smallbiz_mobile-button-color')?>;
background-image:url('<?php bloginfo('template_directory'); ?>/images/mobile/combined.png');
}

#nomobidirections{display:none;}

#footerstrip p {
    color: black;
    font-size: 10px;
    text-align: center;
}

</style>

</head>
<body>

<div id="pagewrap">

<div id="headerstrip">

<?php if(biz_option('smallbiz_mobile-bannerhome-image')!=""){ ?>
<img src="<?php echo biz_option('smallbiz_mobile-bannerhome-image')?>" alt="Logo" />
<?php }?>

<?php if(biz_option('smallbiz_mobiname')!=""){ ?>
<h1>
<?php echo do_shortcode(biz_option('smallbiz_mobiname'))?>
</h1>
<?php }?>

<?php if(biz_option('smallbiz_mobisub_header')!=""){ ?>
<h2>
<?php echo do_shortcode(biz_option('smallbiz_mobisub_header'))?>
</h2>
<?php }?>

</div> <!--close headerstrip-->
     
<div id="textbox">
<?php echo do_shortcode(biz_option('smallbiz_mobile-home-text'))?>
</div> <!--close textbox-->

<div id="tab-area-small">
<a href="tel:<?php echo biz_option('smallbiz_countryprefix')?>-<?php echo biz_option('smallbiz_telephone'); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/mobile/full-calltoday.png" alt="call big button"/></a>
</div> <!--close tab-area-small1-->

<div id="home-mob-menu">
<!--Mobile Menu-->
<?php wp_nav_menu( array(
'container_class' => 'tertiary-menu', 'theme_location' => 'tertiary-menu', 'fallback_cb' => '' ) ); ?>
</div>

<div id="home-link">

<div id="combined">
<a href="<?php bloginfo('url'); ?>"><img src="<?php bloginfo('template_url'); ?>/images/mobile/full-home45-grey.png" alt="mobile-back-home" style="margin-right:19px;margin-left:6px;margin-top:1px;" /></a>

<a href="tel:<?php echo biz_option('smallbiz_countryprefix')?>-<?php echo biz_option('smallbiz_telephone'); ?>"><img src="<?php bloginfo('template_url'); ?>/images/mobile/full-phone45-grey.png" alt="mobile-call-now" style="margin-right:27px;"  /></a>

<a href="mailto:<?php echo biz_option('smallbiz_email')?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/mobile/full-mail45-grey.png" alt="mobile-mail-now" style="margin-right:16px;" /></a>

<!-- Hide header if checkbox is not equal to by adding div id noheader -->

<?php $hide = (biz_option('smallbiz_mobidirections_disabled')); if($hide != ""){ ?>

<div id="nomobidirections"> 		<?php } ?>	

<a href="<?php echo biz_option('smallbiz_mobile-map')?>" ><img src="<?php bloginfo('template_url'); ?>/images/mobile/full-map45-grey.png" alt="mobile-directions"></a>

<?php $hide = (biz_option('smallbiz_mobidirections_disabled')); if($hide != ""){ ?> </div> <?php } ?>

</div><!--combined-->
</div>

<div id="footerstrip">
<p><?php echo biz_option('smallbiz_credit');?></p>
</div> <!--close footerstrip-->

</div> <!--close pagewrap-->

</body>