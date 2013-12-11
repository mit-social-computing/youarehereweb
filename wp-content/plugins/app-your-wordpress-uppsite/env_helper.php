<?php
function uppsite_is_wpcom_vip() {
    return function_exists( 'wpcom_vip_load_plugin' ) || function_exists( 'wpcom_is_vip' );
}
function uppsite_remote_get_platform() {
    return uppsite_is_wpcom_vip() ? 3 : 1;
}
function mysiteapp_get_relative_path($from, $to) {
    $from     = explode('/', $from);
    $to       = explode('/', $to);
    $relPath  = $to;
    foreach($from as $depth => $dir) {
                if($dir === $to[$depth]) {
                        array_shift($relPath);
        } else {
                        $remaining = count($from) - $depth;
            if($remaining > 1) {
                                $padLength = (count($relPath) + $remaining - 1) * -1;
                $relPath = array_pad($relPath, $padLength, '..');
                break;
            } else {
                $relPath[0] = './' . $relPath[0];
            }
        }
    }
    return implode('/', $relPath);
}
function mysiteapp_get_template_root() {
    return mysiteapp_get_relative_path(get_theme_root() . "/", dirname(__FILE__) . "/themes");
}
function uppsite_change_webapp($state) {
    $myOpts = get_option(MYSITEAPP_OPTIONS_DATA);
    if (!isset($myOpts['fixes'])) {
        $myOpts['fixes'] = array();
    }
        $v = get_option('bnc_iphone_pages');
    if (isset($v)) {
        $serialize = !is_array($v);
        if ($serialize) {
            $v = unserialize($v);
        }
        if ($state == true && !array_key_exists('wptouch-enable-regular-default', $myOpts['fixes'])) {
                        $val = isset($v['enable-regular-default']) ? $v['enable-regular-default'] : false;
            $myOpts['fixes']['wptouch-enable-regular-default'] = $val;
            $v['enable-regular-default'] = "normal";
        } elseif ($state == false && array_key_exists('wptouch-enable-regular-default', $myOpts['fixes'])) {
                        if ($myOpts['fixes']['wptouch-enable-regular-default'] == false) {
                unset($v['enable-regular-default']);
            } else {
                $v['enable-regular-default'] = $myOpts['fixes']['wptouch-enable-regular-default'];
            }
            unset($myOpts['fixes']['wptouch-enable-regular-default']);
        }
        if ($serialize) {
            $v = serialize($v);
        }
        update_option('bnc_iphone_pages', $v);
    }
        if (!uppsite_is_wpcom_vip()) {
        uppsite_cache_fix_wp_super_cache(MySiteAppPlugin::$_mobile_ua, $state);         uppsite_cache_fix_w3_total_cache(MySiteAppPlugin::$_mobile_ua, $state);     }
    update_option(MYSITEAPP_OPTIONS_DATA, $myOpts);
}
function uppsite_options_updated($oldValues, $newValues) {
        uppsite_change_webapp(isset($newValues['webapp_mode']) && $newValues['webapp_mode'] != 'none');
    $dataOpts = get_option(MYSITEAPP_OPTIONS_DATA);
    if (isset($newValues['uppsite_key']) && isset($newValues['uppsite_secret'])) {
	    $dataOpts['uppsite_key'] = $newValues['uppsite_key'];
	    $dataOpts['uppsite_secret'] = $newValues['uppsite_secret'];
	    update_option(MYSITEAPP_OPTIONS_DATA, $dataOpts);
	}
}
function uppsite_options_added($optionName, $newValues) {
    uppsite_options_updated(null, $newValues);
}
add_action('add_option_' . MYSITEAPP_OPTIONS_OPTS, 'uppsite_options_added', 10, 2);
add_action('update_option_' . MYSITEAPP_OPTIONS_OPTS, 'uppsite_options_updated', 10, 2);
function uppsite_update_status($act) {
    if (!in_array($act, array("activated", "deactivated"))) {
                return;
    }
    wp_remote_post(MYSITEAPP_AUTOKEY_URL,
        array(
            'body' => 'status='.$act.'&pingback=' . get_bloginfo('pingback_url'),
            'timeout' => 5
        )
    );
    do_action("uppsite_is_" . $act);
}
function uppsite_deactivated() {
    uppsite_change_webapp(false);
    uppsite_update_status("deactivated");
}
register_deactivation_hook(dirname(__FILE__) . "/uppsite.php", 'uppsite_deactivated');
function uppsite_activated() {
    uppsite_update_status("activated");
}
register_activation_hook(dirname(__FILE__) . "/uppsite.php", 'uppsite_activated');
function uppsite_cache_fix_wp_super_cache($userAgents, $add = true) {
    if (function_exists('wp_cache_edit_rejected_ua')) {
        global $valid_nonce, $cache_rejected_user_agent;
        $shouldUpdate = false;
        foreach ($userAgents as $ua) {
            if ($add) {
                                if (!in_array($ua, $cache_rejected_user_agent)) {
                    $cache_rejected_user_agent[] = $ua;
                    $shouldUpdate = true;
                }
            } else {
                                $uakey = array_search($ua, $cache_rejected_user_agent);
                if ($uakey !== false) {
                    unset($cache_rejected_user_agent[$uakey]);
                    $shouldUpdate = true;
                }
            }
        }
        if ($shouldUpdate) {
            $valid_nonce = true;
            ob_start();
            $_POST['wp_rejected_user_agent'] = implode("\n", $cache_rejected_user_agent);
            wp_cache_edit_rejected_ua();
            ob_end_clean();
        }
    }
}
function uppsite_cache_fix_w3_total_cache($userAgents, $add = true) {
    if (class_exists('W3_Plugin_TotalCacheAdmin') &&
        (!isset($_REQUEST['page']) || stristr($_REQUEST['page'], "w3tc_") === false)) {
                $w3_config = & w3_instance('W3_Config');
        $w3_total_cache_plugins = array('PgCache', 'Minify', 'Cdn');
        $save = array();
        foreach ($w3_total_cache_plugins as $w3tc_plugin) {
                        $key = strtolower($w3tc_plugin) . '.reject.ua';
            $rejectArr = $w3_config->get_array($key);
            $shouldUpdate = false;
            foreach ($userAgents as $ua) {
                if ($add) {
                                        if (!in_array($ua, $rejectArr)) {
                        array_push($rejectArr, $ua);
                        $shouldUpdate = true;
                    }
                } else {
                                        $uakey = array_search($ua, $rejectArr);
                    if ($uakey !== false) {
                        unset($rejectArr[$uakey]);
                        $shouldUpdate = true;
                    }
                }
            }
            if ($shouldUpdate) {
                $w3_config->set($key, $rejectArr);
                                $save[] = $w3tc_plugin;
            }
        }
        if (count($save) > 0) {
            $w3_config->save(false);
            foreach ($save as $plugin) {
                $w3tc_admin_instance = & w3_instance('W3_Plugin_' . $plugin . 'Admin');
                if (!is_null($w3tc_admin_instance)) {
                    if (method_exists($w3tc_admin_instance, 'write_rules_core')) {
                        $w3tc_admin_instance->write_rules_core();
                    }
                    if (method_exists($w3tc_admin_instance, 'write_rules_cache')) {
                        $w3tc_admin_instance->write_rules_cache();
                    }
                }
            }
        }
    }
}
if (uppsite_is_wpcom_vip()):
        function uppsite_vip_load_original_functions() {
        add_action( 'setup_theme', 'uppsite_vip_include_original_functions', 1 );
    }
    function uppsite_vip_include_original_functions() {
        global $msap;
        $templateDir = $msap->original_values['template_directory'];
        include_once( $templateDir . "/functions.php" );
                remove_all_filters('after_setup_theme');
        remove_all_filters('widgets_init');
        remove_all_filters('get_the_excerpt');
        remove_all_filters('excerpt_more');
        remove_all_filters('excerpt_length');
    }
    add_action('uppsite_is_running', 'uppsite_vip_load_original_functions', 1); else:
        function mysiteapp_fix_seo_plugins() {
        global $msap;
        if (!$msap->is_mobile && !$msap->is_app) { return; }
                global $aioseop_options;
        if (is_array($aioseop_options)) {
            $curPage = trim($_SERVER['REQUEST_URI'],'/');
            if (!isset($aioseop_options['aiosp_ex_pages'])) {
                $aioseop_options['aiosp_ex_pages'] = $curPage;
            } else {
                $aioseop_options['aiosp_ex_pages'] .= ",".$curPage;
            }
        }
    }
    add_action('init', 'mysiteapp_fix_seo_plugins');
        function uppsite_fix_cache_plugins() {
                $userAgents = array(MYSITEAPP_AGENT);
        if (mysiteapp_should_show_webapp() || mysiteapp_should_show_landing()) {
            $userAgents = array_merge($userAgents, MySiteAppPlugin::$_mobile_ua);
        }
                uppsite_cache_fix_wp_super_cache($userAgents);
                uppsite_cache_fix_w3_total_cache($userAgents);
    }
    add_action('admin_init','uppsite_fix_cache_plugins',10);
endif; 
function uppsite_fix_interrupting_plugins() {
                $falseFunc = create_function('$state', 'return false;');
    add_action('lazyload_is_enabled', $falseFunc);
    add_action('jetpack_check_mobile', $falseFunc);
}
add_action('uppsite_is_running', 'uppsite_fix_interrupting_plugins', 15);
