<?php
/*
The template for displaying the footer.
*/
?>
		</div> <!-- /content -->
		</div><!-- /main -->
	</div> <!-- /container -->

	<footer id="footer">
		<div class="container">

			<ul class="row">
				<li><?php dynamic_sidebar( 'widget-area-footer-left' ); ?></li>
				<li><?php dynamic_sidebar( 'widget-area-footer-center' ); ?></li>
				<li><?php dynamic_sidebar( 'widget-area-footer-right' ); ?></li>
			</ul>

			<div class="site-title"><span class="home"><a href="<?php echo esc_url(home_url( '/' )) ; ?>"><?php bloginfo( 'name' ); ?></a></span><span class="generator"><a href="http://wordpress.org/" target="_blank"><?php printf( __( 'Proudly powered by WordPress', 'birdsite' ), 'WordPress' ); ?></a></span></div>
		</div>
		<p id="back-top"><a href="#top"><span><?php _e( 'Go Top', 'birdsite'); ?></span></a></p>
	</footer>

</div><!-- wrapper -->

<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/respond.min.js" type="text/javascript"></script>
<![endif]-->
<?php wp_footer(); ?>

</body>
</html>