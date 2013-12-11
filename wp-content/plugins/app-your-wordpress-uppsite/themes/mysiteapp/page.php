<?php
get_template_part('header');
?><title><![CDATA[]]></title>
<posts>
<?php
    $curQuery = mysiteapp_get_current_query();
    if (!mysiteapp_should_hide_posts() && $curQuery->have_posts()) {
        $iterator = 0;
                while (mysiteapp_clean_output(array($curQuery, 'have_posts'))) {
                        mysiteapp_clean_output(array($curQuery, 'the_post'));
            mysiteapp_print_post($iterator);
            $iterator++;
        }
                comments_template();
        wp_reset_postdata();
    }
?>
</posts>
<?php
get_template_part('sidebar');
get_template_part('footer', 'nav');
