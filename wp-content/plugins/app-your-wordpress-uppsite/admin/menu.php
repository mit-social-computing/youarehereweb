<?php
define('UPPSITE_ADMIN_REQUIRED_LEVEL', 'manage_options');
define('UPPSITE_ADMIN_SETUP_SLUG', 'uppsite-setup');
define('UPPSITE_ADMIN_SETTINGS', 'uppsite-settings');
class UppSiteAdmin {
    static $admin_options = array(
        array(
            'name' => 'Home',
            'slug' => 'home',
            'isMain' => true
        ),
        array(
            'name' => 'General',
            'slug' => 'general'
        ),
        array(
            'name' => 'Configuration',
            'slug' => 'config'
        ),
        array(
            'name' => 'Design',
            'slug' => 'design'
        ),
        array(
            'name' => 'App Stores',
            'slug' => 'stores'
        ),
        array(
            'name' => 'Analytics',
            'slug' => 'analytics'
        ),
        array(
            'name' => 'Support',
            'slug' => 'support'
        ),
        array(
            'name' => 'About',
            'slug' => 'about'
        )
    );
    static function getCurrentTab() {
        if (!isset($_GET['page'])) {
            return self::$admin_options[0];
        }
        foreach (self::$admin_options as $menu) {
            $menuPage = UPPSITE_ADMIN_SETTINGS . ( array_key_exists('isMain', $menu) ? "" : "-" . $menu['slug'] );
            if ($menuPage == $_GET['page']) {
                return $menu;
            }
        }
    }
}
function uppsite_admin_is_design_page() {
    return (isset($_GET['page']) && $_GET['page'] == "uppsite-settings-design");
}
function uppsite_admin_scripts() {
    wp_register_script('uppsite-postmessage', plugins_url('js/postmessage.js', __FILE__), array('jquery'));
    wp_enqueue_script('uppsite-postmessage');
    if (uppsite_admin_is_design_page()) {
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_register_script('uppsite-upload', plugins_url('js/upload.js', __FILE__), array('jquery','media-upload','thickbox'));
        wp_enqueue_script('uppsite-upload');
    }
}
function uppsite_admin_styles() {
    wp_register_style('uppsite-css', plugins_url('css/uppsite.css', __FILE__));
    wp_enqueue_style('uppsite-css');
    if (uppsite_admin_is_design_page()) {
        wp_enqueue_style('thickbox');
    }
}
function mysiteapp_admin_menu() {
    if (isset($_REQUEST['settings-updated']) && isset($_REQUEST['page']) && $_REQUEST['page'] == UPPSITE_ADMIN_SETUP_SLUG) {
        wp_safe_redirect( admin_url( 'admin.php?page=' . UPPSITE_ADMIN_SETTINGS ) );
        exit;
    }
    if (uppsite_admin_did_setup()) {
        $mainFunc = 'uppsite_admin_general';
        add_menu_page('UppSite - Go Mobile', 'Mobile', UPPSITE_ADMIN_REQUIRED_LEVEL, UPPSITE_ADMIN_SETTINGS, $mainFunc, 'div');
                $first = true;
        foreach (UppSiteAdmin::$admin_options as $menu) {
            add_submenu_page(
                UPPSITE_ADMIN_SETTINGS,
                'UppSite - ' . $menu['name'],
                $menu['name'],
                UPPSITE_ADMIN_REQUIRED_LEVEL,
                UPPSITE_ADMIN_SETTINGS . ( !$first ? "-" . $menu['slug'] : "" ),
                $mainFunc
            );
            $first = false;
        }
    } else {
                add_menu_page('UppSite - Go Mobile', 'Mobile', UPPSITE_ADMIN_REQUIRED_LEVEL, UPPSITE_ADMIN_SETUP_SLUG, 'uppsite_admin_setup', 'div');
    }
}
function upsite_admin_bar_link( $wp_admin_bar ) {
    global $wp_admin_bar;
    $args = array(
        'id' => 'uppsite-mobile',
        'title' => '<span class="ab-icon"></span><span class="ab-label">Mobile</span>',
        'href' => admin_url( 'admin.php?page=' . UPPSITE_ADMIN_SETTINGS )
    );
    $wp_admin_bar->add_node($args);
}
add_action('admin_menu', 'mysiteapp_admin_menu');
add_action('admin_print_scripts', 'uppsite_admin_scripts');
add_action('admin_print_styles', 'uppsite_admin_styles');
