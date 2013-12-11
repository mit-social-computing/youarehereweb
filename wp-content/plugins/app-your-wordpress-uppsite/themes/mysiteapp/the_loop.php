<?php
$query = mysiteapp_get_current_query();
if ($query->have_posts()) {
    $iterator = 0;
        while (mysiteapp_clean_output(array($query, 'have_posts'))) {
                        mysiteapp_clean_output(array($query, 'the_post'));
                mysiteapp_homepage_add_post(get_the_ID());
        mysiteapp_print_post($iterator);
        $iterator++;
    }
    wp_reset_postdata();
}
?>
