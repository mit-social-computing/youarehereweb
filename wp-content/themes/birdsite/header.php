<?php
/*
The Header for our theme.
*/
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" >
<meta name="viewport" content="width=device-width" >
<title><?php wp_title('|', true, 'right'); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" >
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" >
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div class="wrapper">
	<div class="container">

<?php
	// The header image
	$birdsite_header_image = get_header_image();
	$birdsite_header_image? $birdsite_image_tag = '' : $birdsite_image_tag = 'class="no-image"';
?>

	<header id="header" <?php echo $birdsite_image_tag; ?>>
		<div class="branding">
			<?php $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div'; ?>
			<<?php echo $heading_tag; ?> class="site-title">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
			</<?php echo $heading_tag; ?>>
			<p class="site-description"><?php bloginfo( 'description' ); ?></p>
		</div>

		<?php if ( ! empty( $birdsite_header_image ) ) : ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="header-image"><img src="<?php header_image(); ?>" alt="<?php bloginfo( 'name' ); ?>" ></a>
		<?php endif; ?>

		<nav id="menu-wrapper" <?php echo $birdsite_image_tag; ?>>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'menu', 'menu_class' => '', 'menu_id' => 'menu-primary-items', 'items_wrap' => '<div id="small-menu"></div><ul id="%1$s" class="%2$s">%3$s</ul>', 'fallback_cb' => '' ) ); ?>
		</nav>
	</header>

	<div class="main">
	<div id="content">
