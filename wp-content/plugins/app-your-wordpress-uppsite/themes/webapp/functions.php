<?php
define('UPPSITE_MAX_TITLE_LENGTH', 45);
define('UPPSITE_DEFAULT_ANALYTICS_KEY', "BDF2JD6ZXWX69Y9BZQBC");
define('MYSITEAPP_WEBAPP_DEFAULT_BIZ_COLOR', '#717880');
define('MYSITEAPP_WEBAPP_DEFAULT_CONTENT_COLOR', '#1d5ba0');
define('MYSITEAPP_WEBAPP_DEFAULT_NAVBAR_COLOR', '#f2f2f2');
if (isset($_REQUEST['uppsite_request'])) {
        define('UPPSITE_AJAX', sanitize_text_field($_REQUEST['uppsite_request']));
    remove_filter('template_redirect', 'redirect_canonical');
}
function uppsite_get_webapp_dir_uri() {
    if ( function_exists( 'wpcom_vip_noncdn_uri' ) ) {
        return trailingslashit( wpcom_vip_noncdn_uri( dirname( __FILE__ ) ) );
    } else {
        return get_template_directory_uri();
    }
}
function uppsite_get_appid() {
    $data = get_option(MYSITEAPP_OPTIONS_DATA);
    return isset($data['app_id']) ? $data['app_id'] : 0;
}
function uppsite_get_member() {
    $avatar = null;
    if (function_exists('get_the_author_meta')) {
        $avatar = get_avatar(get_the_author_meta('user_email'));
    } elseif (function_exists('get_the_author_id')) {
        $avatar = get_avatar(get_the_author_id());
    }
    return array(
        'name' => get_the_author(),
        'link' => get_the_author_link(),
        'avatar' => uppsite_extract_src_url($avatar),
    );
}
function uppsite_format_html_to_array($output) {
    preg_match_all('/href=("|\')(.*?)("|\')(.*?)>(.*?)<\/a>/', $output, $result);
    $array = array();
    for($i = 0; $i < count($result[0]); $i++) {
        $array[] = array(
            'title' => $result[5][$i],
            'permalink' => $result[2][$i],
        );
    }
    return $array;
}
function uppsite_get_comment_member(){
    $avatar = get_avatar(get_comment_author_email());
    return array(
        'name' =>  get_comment_author(),
        'avatar' => uppsite_extract_src_url($avatar),
    );
}
function uppsite_get_comment() {
    global $comment;
    return array(
        'comment_ID' => get_comment_ID(),
        'post_id' => get_the_ID(),
        'isApproved' => $comment->comment_approved == '0' ? "false" : "true",
        'permalink' => get_permalink(),
        'comment_date' => get_comment_date( '', 0 ),
        'unix_time' => get_comment_date( 'U', 0 ),
        'comment_content' => get_comment_text( 0 ),
        'comment_author' => uppsite_get_comment_member(get_comment_ID()),
    );
}
function uppsite_strlen($str) {
    if (function_exists('mb_strlen')) {
        return mb_strlen($str);
    }
    return strlen($str);
}
function uppsite_match($pattern, $subject) {
    $ret = array();
    if (function_exists('mb_eregi')) {
        mb_eregi($pattern, $subject, $ret);
    } else {
        preg_match("/" . $pattern . "/", $subject, $ret);
    }
    return $ret;
}
function uppsite_process_body_filters(&$content) {
    $filters = json_decode(mysiteapp_get_prefs_value('body_filter', null));
    if (count($filters) == 0) {
        return;
    }
    $tmpContent = $content;
    foreach ($filters as $filter) {
        $search = "/" . $filter[0] . "/ms";         $replace = $filter[1];
        $tmp = preg_replace($search, $replace, $tmpContent);
        if (!empty($tmp)) {
                        $tmpContent = $tmp;
        }
    }
    $content = $tmpContent;
}
function uppsite_is_homepage_carousel() {
    return $GLOBALS['wp_query'] == mysiteapp_get_current_query() && mysiteapp_get_posts_layout() == "homepage";
}
function uppsite_should_filter($obj) {
    $permalink = null;
    if ( is_object($obj) && isset($obj->permalink) ) {
        $permalink = $obj->permalink;
    } elseif ( is_array($obj) && array_key_exists('permalink', $obj) ) {
        $permalink = $obj['permalink'];
    } elseif ( is_string($obj) ) {
        $permalink = $obj;
    }
    $url_filters = json_decode(mysiteapp_get_prefs_value('url_filter', null), true);
    if (empty($permalink) || count($url_filters) == 0) {
        return false;
    }
    foreach ($url_filters as $filter) {
        if (uppsite_match($filter, $permalink)) {
            return true;
        }
    }
    return false;
}
function uppsite_process_post($with_content = false) {
    $ret = array(
        'id' => get_the_ID(),
        'permalink' => get_permalink(),
        'title' => html_entity_decode(get_the_title(), ENT_QUOTES, 'UTF-8'),
        'member' => uppsite_get_member(),
        'excerpt' => get_the_excerpt(),
        'time' => apply_filters('the_time', get_the_time( 'm/d/y G:i' ), 'm/d/y G:i'),
        'unix_time' => apply_filters('the_time', get_the_time( 'U' ), 'U'),
        'comments_link' => get_comments_link(),
        'comments_num' => get_comments_number(),
        'comments_open' => comments_open()
    );
    $post_content = null;
    if ($with_content) {
        ob_start();
        the_content();
        $post_content = ob_get_contents();
        ob_get_clean();
    }
    $ret['thumb_url'] = mysiteapp_extract_thumbnail($post_content);
    if ($with_content) {
        uppsite_process_body_filters($post_content);
        $ret['content'] = $post_content;
    }
        $maxChar = is_null($ret['thumb_url']) ? UPPSITE_MAX_TITLE_LENGTH + 15 : UPPSITE_MAX_TITLE_LENGTH;
    $maxChar += (isset($_GET['view']) && $_GET['view'] == "excerpt") ? 0 : 22;
    $maxChar += ($with_content) ? +10 : 0;
    if (uppsite_is_homepage_carousel()) {
        $maxChar = 66;
    }
    $orgLen = uppsite_strlen($ret['title']);
    if ($orgLen > $maxChar) {
        $matches = uppsite_match("(.{0," . $maxChar . "})\s", $ret['title']);
        $newTitle = rtrim($matches[1]);
        $newTitle .= (uppsite_strlen($newTitle) == $orgLen) ? "" : " ...";     }
    if (!is_null($newTitle)) {
                $ret['title'] = $newTitle;
    }
    return $ret;
}
function uppsite_posts_list($funcname, $echo = true) {
    $list = call_user_func($funcname, array('echo' => false));
    $tmpArr = uppsite_format_html_to_array($list);
        $arr = array();
    foreach ($tmpArr as $val) {
        if ( !uppsite_should_filter( $val ) ) {
            $arr[] = $val;
        }
    }
    if (!$echo) {
        return $arr;
    }
    print json_encode($arr);
}
function uppsite_get_webapp_page($template) {
    if (!defined('UPPSITE_AJAX')) {
        return $template;
    }
    if (function_exists('uppsite_func_' . UPPSITE_AJAX)) {
        call_user_func('uppsite_func_' . UPPSITE_AJAX);
        return null;
    }
    $page = TEMPLATEPATH . "/" . UPPSITE_AJAX . "-ajax.php";
    if (!file_exists($page)) {
        $page = TEMPLATEPATH . "/index-ajax.php";
    }
    return $page;
}
function uppsite_redirect_login($url, $queryRedirectTo, $user) {
    if (!defined('UPPSITE_AJAX')) {
        return $url;
    }
    if (UPPSITE_AJAX == "user_details") {
                if (is_user_logged_in()) {
            global $current_user;
            get_currentuserinfo();
            $res = array(
                'success' => true,
                'username' => $current_user->user_login,
                'userid' => $current_user->ID,
                'publish' => $current_user->has_cap('publish_posts'),
                'logged' => true
            );
        } else {
            $res = array('logged'=>false);
        }
        print json_encode($res);
    } elseif (UPPSITE_AJAX == "logout") {
                wp_logout();
    } else {
                if (isset($user->ID)) {
            print json_encode(
                array(
                    'success' => true,
                    'username' => $user->user_login,
                    'userid' => $user->ID,
                    'publish' => $user->has_cap('publish_posts')
                )
            );
        } else {
            print json_encode(array('success' => false));
        }
    }
    exit;
}
function uppsite_redirect_comment() {
    print json_encode(array('success' => true));
    exit;
}
function uppsite_get_analytics_key() {
    return mysiteapp_get_prefs_value('analytics_key', UPPSITE_DEFAULT_ANALYTICS_KEY);
}
function uppsite_func_create_quick_post() {
    if (current_user_can('publish_posts')) {
        if (empty($_POST['post_title']) || empty($_POST['content']) || "publish" != $_POST['post_status']) {
            exit;
        }
        $post_title =  esc_html(stripslashes($_POST['post_title']));
        $post_content = esc_html( stripslashes($_POST['content']));
        $post_date = current_time('mysql');
        $post_date_gmt = current_time('mysql', 1);
        $post_status = 'publish';
        $current_user = wp_get_current_user();
        $post_author = $current_user->ID;
        $post_data = compact('post_author', 'post_date', 'post_date_gmt', 'post_content', 'post_title', 'post_tags', 'post_status');
        $post_ID = wp_insert_post($post_data);
        print json_encode(array(
            'success' => !is_wp_error($post_ID) && is_numeric($post_ID),
            'post_id' => $post_ID
        ));
    }
    exit;
}
function uppsite_rgbhex2arr($rgbHex) {
    return array(
        hexdec(substr($rgbHex, 1, 2)),         hexdec(substr($rgbHex, 3, 2)),         hexdec(substr($rgbHex, 5, 2))     );
}
function uppsite_rgb2hsl($rgbHex) {
    $rgbArr = uppsite_rgbhex2arr($rgbHex);
    list($r, $g, $b) = array(
        $rgbArr[0] / 255.0,
        $rgbArr[1] / 255.0,
        $rgbArr[2] / 255.0);
    $max = max($r, $g, $b);
    $min = min($r, $g, $b);
    $d = $max - $min;
    if ($max == $min) {
        $h = 0;
        $s = 0;
    }
    else if ($max == $r)
        $h = 60 * ($g - $b) / $d;
    else if ($max == $g)
        $h = 60 * ($b - $r) / $d + 120;
    else if ($max == $b)
        $h = 60 * ($r - $g) / $d + 240;
    $l = ($max + $min) / 2;
    if ($l > 0.5)
        $s = (2 - $max - $min) != 0 ? $d / (2 - $max - $min) : 0;
    else
        $s = ($max + $min) != 0 ? $d / ($max + $min) : 0;
    while ($h > 360) $h -= 360;
    while ($h < 0) $h += 360;
    return array($h, $s * 100, $l * 100);
}
function uppsite_hue2rgb($p, $q, $t) {
    if ($t < 0)
        $t += 1;
    if ($t > 1)
        $t -= 1;
    if ($t < 1/6)
        $p = $p + ($q - $p) * 6 * $t;
    else if ($t < 1/2)
        $p = $q;
    else if ($t < 2/3)
        $p = $p + ($q - $p) * (2/3 - $t) * 6;
    return round($p * 255);
}
function uppsite_hsl2rgb($hsl) {
    $h = $hsl[0] / 360.0;
    $s = $hsl[1] / 100.0;
    $l = $hsl[2] / 100.0;
    $q = $l < 0.5 ? $l * (1 + $s)
        : $l + $s - $l * $s;
    $p = 2 * $l - $q;
        $red   = sprintf("%02x", uppsite_hue2rgb($p, $q, $h + 1/3));
    $green = sprintf("%02x", uppsite_hue2rgb($p, $q, $h));
    $blue  = sprintf("%02x", uppsite_hue2rgb($p, $q, $h - 1/3));
    return "#" . $red . $green . $blue;
}
function uppsite_rgb_lighten($rgbHex, $percent) {
    $hsl = uppsite_rgb2hsl($rgbHex);
    $hsl[2] = min(max(0, $percent+$hsl[2]), 100);     return uppsite_hsl2rgb($hsl);
}
function uppsite_rgb_darken($rgbHex, $percent) {
    return uppsite_rgb_lighten($rgbHex, -1.0 * $percent);
}
function uppsite_get_colours() {
    $navbarColor = mysiteapp_get_prefs_value("navbar_tint_color", MYSITEAPP_WEBAPP_DEFAULT_NAVBAR_COLOR);
    $conceptColor = mysiteapp_get_prefs_value("application_global_color",
        in_array(uppsite_get_type(), array(MYSITEAPP_TYPE_BUSINESS, MYSITEAPP_TYPE_BOTH)) ?
            MYSITEAPP_WEBAPP_DEFAULT_BIZ_COLOR : MYSITEAPP_WEBAPP_DEFAULT_CONTENT_COLOR);
    $navbarDarkColor = uppsite_rgb_darken($navbarColor, 10.3); 
    $conceptLightColor = uppsite_rgb_lighten($conceptColor, 10);
    $conceptDarkColor = uppsite_rgb_darken($conceptColor, 10);
    $conceptRgb = uppsite_rgbhex2arr($conceptColor); 
    $arr = array(
        "#f2f2f2" => $navbarColor,         "#1d5ba0" => $conceptColor,         "#d8d8d8" => $navbarDarkColor,         "#2574cb" => $conceptLightColor,         "#154275" => $conceptDarkColor,         "29,91,160" => implode($conceptRgb, ","),
    );
    $background_color = mysiteapp_get_prefs_value('background_color', null);
    if (!empty($background_color)) {
        $arr['#E2E7ED'] = $background_color. ' !important; background-image: none';
    } else {
        $background_url = mysiteapp_get_prefs_value('background_url', 'http://static.uppsite.com/v3/apps/new_bg.png');
        $arr['http://static.uppsite.com/v3/apps/webapp_background.png'] = $background_url;
    }
    return $arr;
}
function mysiteapp_homepage_carousel_rotate_interval() {
    $num = 5;
    $homepageSettings = uppsite_homepage_get_settings();
    if (isset($homepageSettings['rotate_interval']) && is_numeric($homepageSettings['rotate_interval'])) {
        $num = $homepageSettings['rotate_interval'];
    }
    return min( abs($num), 30 );
}
function uppsite_short_circuit_show_on_front($val) {
    if (!defined('UPPSITE_AJAX')) {
        return false;
    }
    return 'posts';
}
add_filter('pre_option_show_on_front', 'uppsite_short_circuit_show_on_front', 10, 1);
add_filter('index_template', 'uppsite_get_webapp_page');
add_filter('front_page_template', 'uppsite_get_webapp_page');
add_filter('home_template', 'uppsite_get_webapp_page');
add_filter('sidebar_template', 'uppsite_get_webapp_page');
add_filter('category_template', 'uppsite_get_webapp_page');
add_filter('search_template', 'uppsite_get_webapp_page');
add_filter('tag_template', 'uppsite_get_webapp_page');
add_filter('archive_template', 'uppsite_get_webapp_page');
add_filter('login_redirect', 'uppsite_redirect_login', 10, 3);
add_filter('comment_post_redirect', 'uppsite_redirect_comment', 10, 3);
function uppsite_fix_youtube($content) {
        if (!preg_match_all("/<iframe[^>]*src=\"[^\"]*youtube.com[^\"]*\"[^>]*>[^<]*<\/iframe>/x", $content, $matches)) {
        return $content;
    }
    foreach ($matches[0] as $iframe) {
        preg_match_all("/(src|width|height)=(?:\"|')([^\"']+)(?:\"|')/", $iframe, $fields);
        $vals = array(
            "height" => "",
            "width" => "",
            "src" => ""
        );
        $videoId = "";
        for ($i = 0; $i < count($fields[0]); $i++) {
            $key = $fields[1][$i];
            $vals[$key] = $fields[2][$i];
            if ($key == "src") {
                $vals[$key] = preg_replace("/([^\?]+)\??(.*)/", "$1", $vals[$key]);
                preg_match("/\/embed\/(.+)/", $vals[$key], $parts);
                $vals['videoId'] = $parts[1];
                $vals[$key] = str_replace("/embed/", "/watch?v=", $vals[$key]);
            }
        }
        $replacement = '<p><img class="uppsite-youtube-video" vid="' . $vals['src'] . '" src="http://i.ytimg.com/vi/' . $vals['videoId'] . '/0.jpg"/><img src="" height="10" width="10"/></p>';
        $content = str_replace($iframe, $replacement, $content);
    }
    return $content;
}
if (MySiteAppPlugin::detect_specific_os() == "ios") {
    add_filter('the_content', 'uppsite_fix_youtube', 100); }
