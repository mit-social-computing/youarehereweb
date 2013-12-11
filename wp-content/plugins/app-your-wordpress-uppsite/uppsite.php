<?php
/*
 Plugin Name: UppSite - Go Mobile&#0153;
 Plugin URI: http://www.uppsite.com/features/
 Description: UppSite is the best way to make your site mobile. Here is how you get started: 1) Activate your plugin by clicking the "Activate" link to the left of this description, and 2) Configure your mobile apps by visiting the Mobile tab under Settings (tab will show only after plugin is activated). Go Mobile&#0153; <strong>**** DISABLING THIS PLUGIN MAY PREVENT YOUR USERS FROM ACCESSING YOUR MOBILE APPS! ****</strong>
 Author: UppSite
 Version: 5.0
 Author URI: https://www.uppsite.com
 */
require_once( dirname(__FILE__) . '/fbcomments_page.inc.php' );
if (!defined('MYSITEAPP_AGENT')):
define('MYSITEAPP_PLUGIN_VERSION', '5.0');
define('MYSITEAPP_WEBAPP_PREF_THEME', 'uppsite_theme_select');
define('MYSITEAPP_WEBAPP_PREF_TIME', 'uppsite_theme_time');
define('MYSITEAPP_WEBAPP_PREVIEW', 'uppsite_preview');
define('MYSITEAPP_OPTIONS_DATA', 'uppsite_data');
define('MYSITEAPP_OPTIONS_OPTS', 'uppsite_options');
define('MYSITEAPP_OPTIONS_PREFS', 'uppsite_prefs');
define('MYSITEAPP_OPTIONS_BUSINESS', 'uppsite_biz');
define('MYSITEAPP_AGENT','MySiteApp');
require_once( dirname(__FILE__) . '/env_helper.php' );
define('MYSITEAPP_TEMPLATE_ROOT', mysiteapp_get_template_root() );
define('MYSITEAPP_TEMPLATE_APP', MYSITEAPP_TEMPLATE_ROOT.'/mysiteapp');
define('MYSITEAPP_TEMPLATE_WEBAPP', MYSITEAPP_TEMPLATE_ROOT.'/webapp');
define('MYSITEAPP_TEMPLATE_LANDING', MYSITEAPP_TEMPLATE_ROOT.'/landing');
define('MYSITEAPP_WEBSERVICES_URL', 'http://api.uppsite.com');
define('UPPSITE_REMOTE_URL', defined('UPPSITE_BASE_SITE') ? constant('UPPSITE_BASE_SITE') : 'https://www.uppsite.com');
define('MYSITEAPP_PUSHSERVICE', MYSITEAPP_WEBSERVICES_URL.'/push/notification.php');
define('MYSITEAPP_APP_NATIVE_URL', MYSITEAPP_WEBSERVICES_URL.'/getapplink.php?v=2');
define('MYSITEAPP_AUTOKEY_URL', MYSITEAPP_WEBSERVICES_URL.'/autokeys.php');
define('MYSITEAPP_PREFERENCES_URL', MYSITEAPP_WEBSERVICES_URL . '/preferences.php?ver=' . MYSITEAPP_PLUGIN_VERSION);
define('MYSITEAPP_WEBAPP_RESOURCES', 'http://static.uppsite.com/v3/webapp');
define('MYSITEAPP_FACEBOOK_COMMENTS_URL','http://graph.facebook.com/comments/?ids=');
define('MYSITEAPP_VIDEO_WIDTH', 270);
define('MYSITEAPP_ONE_DAY', 86400); 
define('MYSITEAPP_BUFFER_POSTS_COUNT', 5);
define('MYSITEAPP_HOMEPAGE_POSTS', 5);
define('MYSITEAPP_HOMEPAGE_MAX_CATEGORIES', 10);
define('MYSITEAPP_HOMEPAGE_DEFAULT_MIN_POSTS', 2);
define('MYSITEAPP_HOMEPAGE_FRESH_COVER', 'http://static.uppsite.com/plugin/cover.png');
define('MYSITEAPP_LANDING_DEFAULT_BG', 'http://static.uppsite.com/webapp/landing-background.jpg');
define('UPPSITE_UPPER_LIMIT', 15);
define('MYSITEAPP_TYPE_CONTENT', 1);
define('MYSITEAPP_TYPE_BUSINESS', 2);
define('MYSITEAPP_TYPE_BOTH', 3);
if (!defined('MYSITEAPP_PLUGIN_BASENAME'))
    define('MYSITEAPP_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
if (!defined( 'WP_CONTENT_URL' ))
    define('WP_CONTENT_URL', get_option('siteurl').'/wp-content');
if (!defined('WP_CONTENT_DIR'))
    define('WP_CONTENT_DIR', ABSPATH.'wp-content');
if (!defined( 'WP_PLUGIN_URL'))
    define( 'WP_PLUGIN_URL', WP_CONTENT_URL.'/plugins');
if (!defined('WP_PLUGIN_DIR'))
    define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR.'/plugins');
if (!array_key_exists('HTTP_USER_AGENT', $_SERVER)) {
        $_SERVER['HTTP_USER_AGENT'] = null;
}
function uppsite_get_type() {
    if (isset($_GET['forceBlog'])) {
        return MYSITEAPP_TYPE_CONTENT;
    }
    $options = get_option(MYSITEAPP_OPTIONS_OPTS, array());
    return array_key_exists('site_type', $options) ? $options['site_type'] : false;
}
function uppsite_is_business_panel() {
        $type = uppsite_get_type();
    return $type == MYSITEAPP_TYPE_BOTH || $type == MYSITEAPP_TYPE_BUSINESS;
}
function mysiteapp_should_preview_webapp() {
    if ( function_exists( 'vary_cache_on_function' ) ) {
                vary_cache_on_function(
            'return isset($_COOKIE["' . MYSITEAPP_WEBAPP_PREVIEW . '"]) && $_COOKIE["' . MYSITEAPP_WEBAPP_PREVIEW . '"];'
        );
    }
    if (isset($_COOKIE[MYSITEAPP_WEBAPP_PREVIEW]) && $_COOKIE[MYSITEAPP_WEBAPP_PREVIEW]) {
        return true;
    }
    if (isset($_REQUEST['uppPreview'])) {
        $previewRequest = $_REQUEST['uppPreview'];
        $hash = md5(get_bloginfo('pingback_url'));
        if ($previewRequest == $hash) {
                        setcookie(MYSITEAPP_WEBAPP_PREVIEW, true, time() + 60*60*24*30);
            return true;
        }
    }
    return false;
}
function mysiteapp_should_show_webapp() {
    $os = MySiteAppPlugin::detect_specific_os();
    if ($os == "wp") {
                return false;
    }
    if (uppsite_get_type() == MYSITEAPP_TYPE_BUSINESS) {
        return true;
    }
    $options = get_option(MYSITEAPP_OPTIONS_OPTS);
    return (isset($options['activated']) && $options['activated'] && isset($options['webapp_mode']) &&
        ($options['webapp_mode'] == "all" || $options['webapp_mode'] == "webapp_only")) || mysiteapp_should_preview_webapp();
}
function uppsite_get_native_app($type = "url", $os = null) {
    if (is_null($os)) {
        $os = MySiteAppPlugin::detect_specific_os();
    }
    if (!in_array($type, array("url", "identifier", "store_url", "banner"))) {
                return null;
    }
    $options = get_option(MYSITEAPP_OPTIONS_DATA);
    if (!isset($options['native_apps'])) {
        return null;
    }
    $apps = $options['native_apps'];
    return isset($apps[$os]) && array_key_exists($type, $apps[$os]) ? $apps[$os][$type] : null;
}
function mysiteapp_should_show_landing() {
    $options = get_option(MYSITEAPP_OPTIONS_OPTS);
    $showLanding = isset($options['activated']) && $options['activated'] && isset($options['webapp_mode']) &&
        ($options['webapp_mode'] == "all" || $options['webapp_mode'] == "landing_only");
    if ($showLanding && !mysiteapp_should_show_webapp()) {
                $showLanding = $showLanding && !is_null(uppsite_get_native_app());
    }
    return $showLanding;
}
class MySiteAppPlugin {
    var $is_mobile = false;
    var $is_app = false;
    var $new_template = null;
    static $_mobile_ua_os = array(
        "ios" => array(
            "iPhone",
            "iPad",
            "iPod"
        ),
        "android" => array(
            "Android"
        ),
        "wp" => array(
            "Windows Phone"
        )
    );
    static $os = null;
    static $_mobile_ua = array(
        "WebTV",
        "AvantGo",
        "Blazer",
        "PalmOS",
        "lynx",
        "Go.Web",
        "Elaine",
        "ProxiNet",
        "ChaiFarer",
        "Digital Paths",
        "UP.Browser",
        "Mazingo",
        "Mobile",
        "T68",
        "Syncalot",
        "Danger",
        "Symbian",
        "Symbian OS",
        "SymbianOS",
        "Maemo",
        "Nokia",
        "Xiino",
        "AU-MIC",
        "EPOC",
        "Wireless",
        "Handheld",
        "Smartphone",
        "SAMSUNG",
        "J2ME",
        "MIDP",
        "MIDP-2.0",
        "320x240",
        "240x320",
        "Blackberry8700",
        "Opera Mini",
        "NetFront",
        "BlackBerry",
        "PSP"
    );
    var $original_values = null;
    function MySiteAppPlugin() {
        if (is_admin()) {
            require_once( dirname(__FILE__) . '/admin/uppsite_admin.php' );
        }
        $this->detect_user_agent();
        if ($this->is_mobile || $this->is_app) {
            if (function_exists('add_theme_support')) {
                                add_theme_support( 'post-thumbnails');
            }
            $this->original_values = array(
                'template' => get_template(),
                'stylesheet' => get_stylesheet(),
                'template_directory' => get_template_directory(),
                'template_directory_uri' => get_template_directory_uri(),
                'stylesheet_directory' => get_stylesheet_directory(),
                'stylesheet_directory_uri' => get_stylesheet_directory_uri()
            );
            do_action('uppsite_is_running');
        }
    }
    private function _is_agent() {
        if ( function_exists( 'vary_cache_on_function' ) ) {
            vary_cache_on_function(
                'return strpos($_SERVER["HTTP_USER_AGENT"], "' . MYSITEAPP_AGENT . '") !== false;'
            );
        }
        return strpos($_SERVER['HTTP_USER_AGENT'], MYSITEAPP_AGENT) !== false;
    }
    static private function is_specific_os($osUAs) {
        if ( function_exists( 'vary_cache_on_function' ) ) {
            vary_cache_on_function(
                'return (bool)preg_match("/(' . implode("|", $osUAs). ')/i", $_SERVER["HTTP_USER_AGENT"]);'
            );
        }
        return (bool)preg_match('/('.implode('|', $osUAs).')/i', $_SERVER['HTTP_USER_AGENT']);
    }
    function detect_user_agent() {
        if ($this->_is_agent()) {
                        $this->is_app = true;
            $this->new_template = MYSITEAPP_TEMPLATE_APP;
        } elseif (mysiteapp_should_show_landing() || mysiteapp_should_show_webapp()) {
            if (self::is_specific_os(MySiteAppPlugin::$_mobile_ua) || mysiteapp_should_preview_webapp()) {
                                $this->is_mobile = true;
                $this->new_template = $this->get_webapp_template();
            }
        }
    }
    function get_webapp_template() {
        $ret = mysiteapp_should_show_landing() ? "landing" : ( mysiteapp_should_show_webapp() ? "webapp" : "normal" );
        if (isset($_COOKIE[MYSITEAPP_WEBAPP_PREF_THEME]) && isset($_COOKIE[MYSITEAPP_WEBAPP_PREF_TIME])) {
            $ret = $_COOKIE[MYSITEAPP_WEBAPP_PREF_THEME];
            $saveTime = $_COOKIE[MYSITEAPP_WEBAPP_PREF_TIME];
                        setcookie(MYSITEAPP_WEBAPP_PREF_THEME, $ret, time() + $saveTime);
        }
        switch ($ret) {
            case "webapp":
                if (mysiteapp_should_show_webapp()) {
                    return MYSITEAPP_TEMPLATE_WEBAPP;
                }
                break;
            case "landing":
                if (mysiteapp_should_show_landing()) {
                    return MYSITEAPP_TEMPLATE_LANDING;
                }
                break;
        }
                $this->is_mobile = false;         return null;
    }
    function has_custom_theme() {
        return !is_null($this->new_template);
    }
    static function detect_specific_os() {
        if (is_null(self::$os)) {
            foreach (self::$_mobile_ua_os as $osName => $ua) {
                if (self::is_specific_os($ua)) {
                    self::$os = $osName;
                    break;
                }
            }
        }
        return self::$os;
    }
}
foreach (MySiteAppPlugin::$_mobile_ua_os as $osName => $osUA) {
    MySiteAppPlugin::$_mobile_ua = array_merge(MySiteAppPlugin::$_mobile_ua, $osUA);
}
require_once( dirname(__FILE__) . '/business.php' );
global $msap;
$msap = new MySiteAppPlugin();
function mysiteapp_filter_template($newValue) {
    global $msap;
    return $msap->has_custom_theme() ? $msap->new_template : $newValue;
}
add_filter('option_template', 'mysiteapp_filter_template'); add_filter('option_stylesheet', 'mysiteapp_filter_template'); 
function uppsite_extract_src_url($html) {
    if (strpos($html, "http") === 0) {
                return $html;
    }
    if (preg_match("/src=[\"']([\s\S]+?)[\"']/", $html, $match)) {
        return $match[1];
    }
    return null;
}
function uppsite_nullify_thumb(&$content, &$thumb) {
        if (preg_match("/(.*?)(?:-)(\\d{1,4})([_x\\-]?\\d{0,4})(\\.[a-zA-Z]{1,4}.*)/", $thumb, $imgParts)) {
                        $sizeModifier = $imgParts[2];
        if (is_numeric($sizeModifier) && intval($sizeModifier) < 50 || empty($imgParts[3])) {
                                                        } else {
                        $thumb = $imgParts[1] . $imgParts[4];
        }
    }
    $content = preg_replace("/<img[^>]*src=\"". preg_quote($thumb, "/") ."[^>]*>/ms", "", $content);
}
function uppsite_extract_image_from_post_content(&$content) {
    if (!preg_match("/<img[^>]*src=\"([^\"]+)\"[^>]*>/", $content, $matches)) {
        return null;
    }
    if (strpos($matches[0], "uppsite-youtube-video") !== false) {
                return null;
    }
    return $matches[0]; }
class UppSiteImageAlgo {
        const NATIVE_FUNC = 0x1;
        const THE_ATTACHED_IMAGE = 0x2;
        const GET_THE_IMAGE = 0x4;
        const CUSTOM_FIELD = 0x8;
        const FIRST_IMAGE = 0x10;
        const ALL = 0xFFFFFFFF;
}
function uppsite_get_image_algos() {
    $imageAlgos = mysiteapp_get_prefs_value('thumbnail_algo',
        array(
            'type' => UppSiteImageAlgo::ALL,
            'extra' => null
        )
    );
        if (!is_array($imageAlgos)) {
        $imageAlgos = json_decode($imageAlgos, true);
        if (!is_array($imageAlgos)) {
                        $imageAlgos = array();
        }
    }
    if (!array_key_exists('type', $imageAlgos)) {
        $imageAlgos['type'] = UppSiteImageAlgo::ALL;
    }
    if (!array_key_exists('extra', $imageAlgos)) {
        $imageAlgos['extra'] = null;
    }
    return $imageAlgos;
}
function uppsite_has_image_algo(&$imageAlgos, $imageAlgoType) {
    return ($imageAlgos['type'] & $imageAlgoType) > 0;
}
function mysiteapp_extract_thumbnail(&$content = null) {
    $thumb_url = null;
        $imageAlgos = uppsite_get_image_algos();
    if (uppsite_has_image_algo($imageAlgos, UppSiteImageAlgo::NATIVE_FUNC) &&
        function_exists('has_post_thumbnail') && has_post_thumbnail()) {
                $thumb_url = get_the_post_thumbnail();
    }
    if (uppsite_has_image_algo($imageAlgos, UppSiteImageAlgo::THE_ATTACHED_IMAGE) &&
        empty($thumb_url) && function_exists('the_attached_image')) {
                $temp_thumb = the_attached_image('img_size=thumb&echo=false');
        if (!empty($temp_thumb)) {
            $thumb_url = $temp_thumb;
        }
    }
    if (uppsite_has_image_algo($imageAlgos, UppSiteImageAlgo::GET_THE_IMAGE) &&
        empty($thumb_url) && function_exists('get_the_image')) {
                $temp_thumb = get_the_image(array('size' => 'thumbnail', 'echo' => false, 'link_to_post' => false));
        if (!empty($temp_thumb)) {
            $thumb_url = $temp_thumb;
        }
    }
    if (uppsite_has_image_algo($imageAlgos, UppSiteImageAlgo::CUSTOM_FIELD) &&
        empty($thumb_url) && !is_null($imageAlgos['extra'])) {
                $thumb_url = get_post_meta(get_the_ID(), $imageAlgos['extra'], true);
    }
    if (uppsite_has_image_algo($imageAlgos, UppSiteImageAlgo::FIRST_IMAGE) &&
        empty($thumb_url)) {
        if (mysiteapp_is_fresh_wordpress_installation()) {
                        $thumb_url = MYSITEAPP_HOMEPAGE_FRESH_COVER;
        } else {
            if (is_null($content)) {
                ob_start();
                the_content();
                $content = ob_get_contents();
                ob_get_clean();
            }
            $thumb_url = uppsite_extract_image_from_post_content($content);
        }
    }
    if (!empty($thumb_url)) {
                $thumb_url = uppsite_extract_src_url($thumb_url);
        if (!is_null($content)) {
                        uppsite_nullify_thumb($content, $thumb_url);
        }
    }
    return $thumb_url;
}
function mysiteapp_sign_message($message){
    $options = get_option(MYSITEAPP_OPTIONS_DATA);
    $str = $options['uppsite_secret'].$message;
    return md5($str);
}
function mysiteapp_is_need_new_link(){
    $dataOptions = get_option(MYSITEAPP_OPTIONS_DATA);
    $lastCheck = isset($dataOptions['last_native_check']) ? $dataOptions['last_native_check'] : 0;
        return time() > $lastCheck + MYSITEAPP_ONE_DAY;
}
function uppsite_biz_init() {
    $bizOpts = get_option(MYSITEAPP_OPTIONS_BUSINESS, array());
    update_option(MYSITEAPP_OPTIONS_BUSINESS, $bizOpts);
}
function uppsite_prefs_init($forceUpdate = false) {
    if (!uppsite_api_values_set()) {
                return;
    }
        uppsite_biz_init();
    mysiteapp_get_app_links();
    $prefsOptions = get_option(MYSITEAPP_OPTIONS_PREFS, array());
    if (count($prefsOptions) > 0 && !$forceUpdate) {
        return;
    }
    $dataOptions = get_option(MYSITEAPP_OPTIONS_DATA);
    $uppPrefs = wp_remote_post(MYSITEAPP_PREFERENCES_URL,
        array(
            'body' => 'os_id=4&json=1&key=' . $dataOptions['uppsite_key'],
            'timeout' => 5
        )
    );
    if (is_wp_error($uppPrefs)) { return; }
    $newPrefs = json_decode($uppPrefs['body'], true);
    if (is_array($newPrefs) && is_array($newPrefs['preferences'])) {
        $prefsOptions = array_merge($prefsOptions, $newPrefs['preferences']);
        $dataOptions['app_id'] = isset($prefsOptions['id']) ? $prefsOptions['id'] : 0;
        update_option(MYSITEAPP_OPTIONS_PREFS, $prefsOptions);
        $dataOptions['prefs_update'] = time();
        update_option(MYSITEAPP_OPTIONS_DATA, $dataOptions);
    }
}
function mysiteapp_get_app_links() {
    if (!mysiteapp_is_need_new_link()) {
        return false;
    }
    $options = get_option(MYSITEAPP_OPTIONS_DATA);
    if (empty($options['uppsite_key']))
        return false;
    $hash = mysiteapp_sign_message($options['uppsite_key']);
    $get = '&api_key='.$options['uppsite_key'].'&hash='.$hash;
    $response = wp_remote_get(MYSITEAPP_APP_NATIVE_URL.$get);
    if (is_wp_error($response)) {
        return false;
    }
    $data = json_decode($response['body'],true);
    if ($data) {
        $options['native_apps'] = $data;
                $options['last_native_check'] = time();
        update_option(MYSITEAPP_OPTIONS_DATA, $options);
    }
    return true;
}
function mysiteapp_get_posts_layout() {
    $posts_list_view = isset($_REQUEST['posts_list_view']) ? esc_html(stripslashes($_REQUEST['posts_list_view'])) : "";
        switch ($posts_list_view) {
        case "full":
        case "ffull_rexcerpt":
        case "ffull_rtitle":
        case "title":
        case "excerpt":
        case "homepage":
            return $posts_list_view;
    }
    return "";
}
function mysiteapp_set_webapp_theme() {
    $templateType = isset($_REQUEST['msa_theme_select']) ? esc_html(stripslashes($_REQUEST['msa_theme_select'])) : "";
    $templateSaveForever = isset($_REQUEST['msa_theme_save_forever']) ? esc_html(stripslashes($_REQUEST['msa_theme_save_forever'])) : "";
    if (empty($templateType)) {
        return;
    }
        if (!in_array($templateType, array("webapp", "normal"))) {
        return;
    }
    $cookieTime = $templateSaveForever ? 60*60*24*7 : 60*60;     setcookie(MYSITEAPP_WEBAPP_PREF_THEME, $templateType, time() + $cookieTime);
        setcookie(MYSITEAPP_WEBAPP_PREF_TIME, $cookieTime, time() + 60*60*24*30);
        $cleanUrl = remove_query_arg(array("msa_theme_select","msa_theme_save_forever"));
    wp_safe_redirect($cleanUrl);
    exit;
}
function mysiteapp_update_mysiteapp_options($curOpts, $newVals){
    $newVals = json_decode($newVals, true);
    if ($newVals === false) {
        return $curOpts;
    }
    $curOpts = ($curOpts === false) ? array() : $curOpts;
    return array_merge($curOpts, $newVals);
}
function uppsite_provide_feedback($feedback) {
    if (is_bool($feedback)) {
        $ret = $feedback;
    } else {
        $ret = array('error' => $feedback);
    }
    print json_encode($ret);
    exit;
}
function uppsite_reset_db_vals($dataOpts) {
    update_option(MYSITEAPP_OPTIONS_DATA, array(
        'uppsite_key' => $dataOpts['uppsite_key'],
        'uppsite_secret' => $dataOpts['uppsite_secret']
    ));
    delete_option(MYSITEAPP_OPTIONS_OPTS);
    delete_option(MYSITEAPP_OPTIONS_BUSINESS);
    delete_option(MYSITEAPP_OPTIONS_PREFS);
    uppsite_provide_feedback('Options reset');
}
function uppsite_remote_activation() {
    $query_var = isset($_REQUEST['msa_remote_activation']) ? $_REQUEST['msa_remote_activation'] : "";
    if (empty($query_var)) {
        return;
    }
    $decoded = json_decode(base64_decode($query_var), true);
    $dataOpts = get_option(MYSITEAPP_OPTIONS_DATA, array());
    $signKey = 1;
    $signVal = get_bloginfo('pingback_url');
    if (array_key_exists('uppsite_secret', $dataOpts) && !empty($dataOpts['uppsite_secret'])) {
        $signKey = 2;
        $signVal = $dataOpts['uppsite_secret'];
    }
    $signVal = md5($signVal);
    if (md5($decoded['data'].$decoded['secret' . $signKey]) != $decoded['verify' . $signKey]
        || $decoded['secret' . $signKey] != $signVal) {
        uppsite_provide_feedback(array(
            'error' => 'verification failed',
            'signKey' => $signKey
        ));
        return;
    }
    $data = json_decode($decoded['data'], true);
    $prefsOptions = get_option(MYSITEAPP_OPTIONS_PREFS, array());
    $opts = get_option(MYSITEAPP_OPTIONS_OPTS, array());
    $bizOpts =  get_option(MYSITEAPP_OPTIONS_BUSINESS, array());
    $refreshPrefs = false;
    $debugPrefs = false;
    foreach ($data as $key=>$val) {
                switch ($key) {
            case "app_id":
            case "uppsite_key":
            case "uppsite_secret":
            case "last_native_check":
                $dataOpts[$key] = $val;
                break;
            case "update_prefs":
                $refreshPrefs = true;
                break;
            case "activated":
            case "webapp_mode":
            case "site_type":
            case "push_control":
                $opts[$key] = $val;
                break;
            case "change_biz":
                $bizOpts = mysiteapp_update_mysiteapp_options($bizOpts, $val);
                break;
            case "change_prefs":
                $prefsOptions = mysiteapp_update_mysiteapp_options($prefsOptions, $val);
                break;
            case 'debug_uppsite':
                $debugPrefs = true;
                break;
            case 'reset_uppsite':
                uppsite_reset_db_vals($dataOpts);
                break;
        }
    }
    update_option(MYSITEAPP_OPTIONS_DATA ,$dataOpts);
    update_option(MYSITEAPP_OPTIONS_OPTS, $opts);
    update_option(MYSITEAPP_OPTIONS_BUSINESS, $bizOpts);
    update_option(MYSITEAPP_OPTIONS_PREFS, $prefsOptions);
    if ($refreshPrefs) {
                uppsite_prefs_init(true);
    }
    if ($debugPrefs) {
        unset($dataOpts['uppsite_key'], $dataOpts['uppsite_secret']);
        $uppsite_options[MYSITEAPP_OPTIONS_DATA] = $dataOpts;
        $uppsite_options[MYSITEAPP_OPTIONS_OPTS] = $opts;
        $uppsite_options[MYSITEAPP_OPTIONS_PREFS] = $prefsOptions;
                uppsite_provide_feedback($uppsite_options);
    }
    uppsite_provide_feedback(true);
}
function mysiteapp_get_ads() {
    $ad_active = mysiteapp_get_prefs_value('ad_display', false);
    $ret = array(
        "active" => $ad_active && $ad_active != "false",
        "html" => mysiteapp_get_prefs_value('ads', '')
    );
    if (mysiteapp_get_prefs_value('matomy_site_id', false) && mysiteapp_get_prefs_value('matomy_zone_id', false)) {
        $ret['matomy_site_id'] = mysiteapp_get_prefs_value('matomy_site_id');
        $ret['matomy_zone_id'] = mysiteapp_get_prefs_value('matomy_zone_id');
    }
    $state_arr = array(
        '0' => 'none',
        '1' => 'top',
        '2' => 'bottom'
    );
    $ad_state = mysiteapp_get_prefs_value('ad_state', 1);
    $ret['ad_state'] = array_key_exists($ad_state, $state_arr) ? $state_arr[$ad_state] : 'top';
    return json_encode($ret);
}
function mysiteapp_get_options_value($options_name,$key,$default = null){
    $prefs = get_option($options_name);
    if ($prefs === false || !is_array($prefs) ||
        ( is_array($prefs) && !array_key_exists($key, $prefs) )) {
        return $default ? $default : null;
    }
    if (!is_null($default) && empty($prefs[$key])) {
        return $default;
    }
    return $prefs[$key];
}
function mysiteapp_get_prefs_value($key, $default = null) {
    return mysiteapp_get_options_value(MYSITEAPP_OPTIONS_PREFS, $key, $default);
}
function mysiteapp_get_optionsbiz_value($key, $default = null){
    return mysiteapp_get_options_value(MYSITEAPP_OPTIONS_BUSINESS, $key, $default);
}
function mysiteapp_convert_datetime($datetime) {
    $values = explode(" ", $datetime);
    $dates = explode("-", $values[0]);
    $times = explode(":", $values[1]);
    return mktime($times[0], $times[1], $times[2], $dates[1], $dates[2], $dates[0]);
}
function uppsite_api_values_set() {
    $dataOpts = get_option(MYSITEAPP_OPTIONS_DATA, array());
    return array_key_exists('uppsite_key', $dataOpts) && array_key_exists('uppsite_secret', $dataOpts) &&
        !empty($dataOpts['uppsite_key']) && !empty($dataOpts['uppsite_secret']);
}
function mysiteapp_send_push($post_id, $post_details = NULL) {
    if (!uppsite_api_values_set() ||
        uppsite_push_control_enabled() && !isset($_POST['send_push'])) {
                return;
    }
    if (is_null($post_details)) {
                $post_details = get_post($post_id, ARRAY_A);
    }
    $dataOpts = get_option(MYSITEAPP_OPTIONS_DATA);
    $json_str = json_encode(array(
        'title' => $post_details['post_title'],
        'post_id' => $post_details['ID'],
        'utime' => mysiteapp_convert_datetime($post_details['post_date']),
        'api_key' => $dataOpts['uppsite_key']
    ));
    $hash = mysiteapp_sign_message($json_str);
    wp_remote_post(MYSITEAPP_PUSHSERVICE, array(
        'body' => 'data='.$json_str.'&hash='.$hash,
        'timeout' => 5,
    ));
}
function mysiteapp_new_post_push($post_id) {
    if ($_POST['post_status'] != 'publish') { return; }
    if ( (isset($_POST['original_post_status']) && $_POST['original_post_status'] != $_POST['post_status']) ||         (isset($_POST['_status']) && $_POST['_status'] != $_POST['post_status']) ) {         mysiteapp_send_push($post_id);
    }
}
function mysiteapp_future_post_push($post_id) {
    $post_details = get_post($post_id, ARRAY_A);
    if ($post_details['post_status'] != 'publish') { return; }
    if (!$_POST &&
        false == (isset($post_details['sticky']) && $post_details['sticky'] == 'sticky')) {
                mysiteapp_send_push($post_id, $post_details);
    }
}
function mysiteapp_append_native_link() {
    global $msap, $wp;
    if ($msap->has_custom_theme()) {
                return;
    }
    $appleId = uppsite_get_native_app("identifier", "ios");
    if (!is_null($appleId) && uppsite_get_native_app("banner", "ios")) {
        $currentUrl = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
        print '<meta name="apple-itunes-app" content="app-id=' . $appleId . ', app-argument=' . esc_attr($currentUrl) . '"/>';
    }
}
function mysiteapp_get_current_query() {
    global $mysiteapp_cur_query, $wp_query;
    return !is_null($mysiteapp_cur_query) ? $mysiteapp_cur_query : $wp_query;
}
function mysiteapp_set_current_query($query) {
    global $mysiteapp_cur_query;
    $mysiteapp_cur_query = new WP_Query($query);
    return $mysiteapp_cur_query;
}
function uppsite_homepage_get_settings() {
    $hpSettings = mysiteapp_get_prefs_value('homepage_settings');
    return !is_null($hpSettings) ? json_decode($hpSettings, true) : array();
}
function mysiteapp_homepage_carousel_posts_num() {
    $num = MYSITEAPP_HOMEPAGE_POSTS;
    $homepageSettings = uppsite_homepage_get_settings();
    if (isset($_REQUEST['homepage_post']) && is_numeric($_REQUEST['homepage_post'])) {
        $num = $_REQUEST['homepage_post'];
    } elseif (isset($homepageSettings['homepage_post']) && is_numeric($homepageSettings['homepage_post'])) {
        $num = $homepageSettings['homepage_post'];
    }
    return min( abs($num), UPPSITE_UPPER_LIMIT );
}
function mysiteapp_homepage_cat_posts() {
    $num = MYSITEAPP_HOMEPAGE_DEFAULT_MIN_POSTS;
    $homepageSettings = uppsite_homepage_get_settings();
    if (isset($_REQUEST['posts_num']) && is_numeric($_REQUEST['posts_num'])) {
        $num = $_REQUEST['posts_num'];
    } elseif (isset($homepageSettings['posts_num']) && is_numeric($homepageSettings['posts_num'])) {
        $num = $homepageSettings['posts_num'];
    }
    return min( abs($num), UPPSITE_UPPER_LIMIT );
}
function mysiteapp_homepage_add_post($post_id){
    global $homepage_post_ids;
    if (!is_array($homepage_post_ids)) {
        $homepage_post_ids = array();
    }
    array_push($homepage_post_ids, $post_id);
}
function mysiteapp_homepage_get_excluded_posts() {
    global $homepage_post_ids;
    return !is_array($homepage_post_ids) ? array() : $homepage_post_ids;
}
function mysiteapp_is_fresh_wordpress_installation(){
     return wp_count_posts()->publish == 1;
}
function mysiteapp_homepage_get_popular_categories() {
    $pop_cat = get_categories( 'order=desc&orderby=count&number=' . MYSITEAPP_HOMEPAGE_MAX_CATEGORIES );
    return array_map(create_function('$cat', 'return $cat->term_id;'), $pop_cat);
}
function uppsite_homepage_get_categories() {
    $cats = null;
    if (array_key_exists('cats_ar', $_REQUEST) && is_array($_REQUEST['cats_ar'])) {
        $cats = $_REQUEST['cats_ar'];
    } else {
        $settings = uppsite_homepage_get_settings();
        $cats = array_key_exists('cats_ar', $settings) ? $settings['cats_ar'] : mysiteapp_homepage_get_popular_categories();
    }
        $cats = array_splice($cats, 0, UPPSITE_UPPER_LIMIT);
    $cats = array_map( 'sanitize_text_field', $cats );
    return $cats;
}
function mysiteapp_should_show_homepage() {
    return mysiteapp_get_posts_layout() == "homepage";
}
function uppsite_pre_get_posts($query = false) {
    global $wp_the_query,             $msap;
    if (!$msap->has_custom_theme() || !is_a($query, 'WP_Query') || ($query != $wp_the_query)) {
                return;
    }
        if (mysiteapp_get_prefs_value('disable_sticky', false)) {
                $query->set(get_bloginfo('version') >= 3.1 ? 'ignore_sticky_posts' : 'caller_get_posts', 1);
    }
    if (is_home() && mysiteapp_should_show_homepage()) {
                $query->set('paged', 1);
        $query->set('posts_per_page', mysiteapp_homepage_carousel_posts_num());
        $query->set('order', 'desc');
    }
}
function uppsite_filter_show_on_front($val) {
    global $msap;
    return $msap->has_custom_theme() && mysiteapp_get_prefs_value('always_show_posts', false) ? 'posts' : $val;
}
function uppsite_get_biz_pages() {
    $pages = null;
    $filter = array(
        'sort_column' => 'menu_order',
        'sort_order' => 'ASC',
    );
    $bizOpts = get_option(MYSITEAPP_OPTIONS_BUSINESS);
    $include = null;
    if (array_key_exists('menu_pages', $bizOpts)) {
        $include = $bizOpts['menu_pages'];
        $filter['include'] = $include;
    }
    $pages = get_pages($filter);
    if (!is_null($include)) {
                array_walk(
            $pages,
            create_function('&$page, $key, $include', '$page->menu_order = array_search($page->ID, $include)+1;'),
            $include
        );
    }
    return $pages;
}
function uppsite_ajax_verify_nonce() {
    $nonce = isset($_REQUEST['nonce_name']) ? $_REQUEST['nonce_name'] : null;
    $token = isset($_REQUEST['token']) ? $_REQUEST['token'] : null;
    $requesterUid = isset($_REQUEST['nonce_requester']) && is_numeric($_REQUEST['nonce_requester']) ? $_REQUEST['nonce_requester'] : null;
    if (empty($nonce) || empty($token) || empty($requesterUid) ||
        strpos($nonce, "uppsite_nonce_") === false) {
        return;
    }
            $requesterUser = new WP_User(""); 
            add_filter('deprecated_argument_trigger_error', 'uppsite_supress_deprecated_warnings');
    $requesterUser->ID = $requesterUser->id = $requesterUid;
    global $current_user;
    $current_user = $requesterUser; 
    print json_encode(array(
        'nonce' => wp_verify_nonce($token, $nonce)
    ));
    exit;
}
function uppsite_get_bloginfo(){
    print json_encode(
        array(
            'name' => get_bloginfo('name'),
            'url' => site_url(),
            'version' => get_bloginfo('version'),
            'tagline' => get_bloginfo('description')
        )
    );
}
define('MYSITEAPP_GET_MAX_ITEMS',100);
function uppsite_get_bizinfo(){
    $businessData = get_option(MYSITEAPP_OPTIONS_BUSINESS);
    unset($businessData['all_images']);
    unset($businessData['selected_images']);
    unset($businessData['featured']);
    if (is_array($businessData)) {
        print json_encode($businessData);
    }
}
function uppsite_remove_duplicate_photos($photos = array()){
    $data = array_unique($photos,SORT_STRING);
    return $data;
}
function uppsite_set_selected_image($list,$listname,&$result){
    foreach($result as $key=>$val){
        if(in_array(html_entity_decode($result[$key]['img_url']),$list,false)){
            array_push($result[$key]['found'],$listname);
        }
    }
    return $result;
}
 function uppsite_set_image_array_format($arr){
    $result = array();
    foreach (array_values($arr) as $val) {
        $result[] = array('img_url'=>$val,'found'=>array());
    }
    return $result;
}
 function uppsite_get_images_lib($images_ar,$selected,$featured){
     if(!isset($images_ar)) return array();
    $selected_image['photos'] = is_array($selected) ?  $selected :  array();
    $selected_image['homepage'] =is_array($featured) ?  $featured :  array();
    $res['all_images'] = uppsite_set_image_array_format($images_ar);
    $res['all_images'] = uppsite_set_selected_image($selected_image['photos'],'photos',$res['all_images']);
    $res['all_images'] = uppsite_set_selected_image($selected_image['homepage'],'homepage',$res['all_images']);
    return $res['all_images'];
}
define('IMAGES_PER_PAGE',30);
function uppsite_get_bizimages(){
    $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 0;
    $businessData = get_option(MYSITEAPP_OPTIONS_BUSINESS);
    $image_ar = $businessData['all_images'];
    $image_ar = uppsite_remove_duplicate_photos($image_ar);
    $current_page_ar = array_slice($image_ar,$page*IMAGES_PER_PAGE,IMAGES_PER_PAGE);
    $list_image = array();
    if(count($current_page_ar) > 0){
        $list_image = uppsite_get_images_lib($current_page_ar, $businessData['selected_images'], $businessData['featured']);
    }
    print json_encode($list_image);
    exit;
}
function uppsite_get_categorieslist() {
    $allCats = array_map(
        create_function('$cat', 'return array($cat->term_id, $cat->name);'),
        get_categories( 'order=desc&orderby=count&number='.MYSITEAPP_GET_MAX_ITEMS)
    );
    $selectedCats = uppsite_homepage_get_categories();
    print json_encode(array(
        'all' => $allCats,
        'selected' => $selectedCats
    ));
}
function uppsite_get_pagelist() {
    $filterValues = create_function('$page', 'return array($page->ID, $page->post_title);');
    $allPages = array_map(
        $filterValues,
        get_pages('sort_order=ASC&post_status=publish&post_type=page&sort_column=post_title&number=' . MYSITEAPP_GET_MAX_ITEMS)
    );
    $selectedPages = uppsite_get_biz_pages();
    usort($selectedPages, create_function('$a, $b', 'if ($a->menu_order == $b->menu_order) { return 0; }; return ($a->menu_order < $b->menu_order) ? -1 : 1;'));
    $selectedPages = array_map(
        $filterValues,
        $selectedPages
    );
    print json_encode(array(
        'all' => $allPages,
        'selected' => $selectedPages
    ));
}
function uppsite_ajax_get_info(){
    $req = sanitize_text_field($_REQUEST['uppsite_request']);
    if (function_exists('uppsite_get_' . $req)) {
         call_user_func('uppsite_get_' . $req);
    }
    exit;
}
function uppsite_supress_deprecated_warnings() {
    return false;
}
add_action('wp', 'mysiteapp_set_webapp_theme');
add_action('init', 'uppsite_remote_activation');
add_action('publish_post','mysiteapp_new_post_push', 10, 1);
add_action('publish_future_post','mysiteapp_future_post_push', 10, 1);
add_action('wp_head', 'mysiteapp_append_native_link');
add_action('pre_get_posts', 'uppsite_pre_get_posts');
add_filter('option_show_on_front', 'uppsite_filter_show_on_front');
add_action('wp_ajax_nopriv_uppsite_verify_nonce', 'uppsite_ajax_verify_nonce');
add_action('wp_ajax_nopriv_uppsite_get_info', 'uppsite_ajax_get_info');
add_action('wp_ajax_uppsite_get_info', 'uppsite_ajax_get_info');  
endif; 
