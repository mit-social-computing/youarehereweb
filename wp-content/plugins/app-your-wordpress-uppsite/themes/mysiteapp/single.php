<?php
get_template_part('header');
?><title><![CDATA[]]></title><?php
if (have_posts()) {
	while (mysiteapp_clean_output('have_posts')) {
		mysiteapp_clean_output('the_post');
		mysiteapp_print_post();
		$options = get_option('uppsite_options');
		comments_template();
	}
}
get_template_part('footer', 'nav');
