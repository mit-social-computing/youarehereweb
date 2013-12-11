<?php
remove_all_filters('get_sidebar');
remove_all_filters('get_header');
remove_all_filters('get_footer');
remove_all_actions('loop_start');
remove_all_actions('loop_end');
remove_all_actions('the_excerpt');
remove_all_actions('wp_footer');
remove_all_actions('wp_print_footer_scripts');
remove_all_actions('comments_array');
class MysiteappXmlParser {
    public static function array_to_xml($data, $rootNodeName = 'data', $xml=null)
    {
                if (ini_get('zend.ze1_compatibility_mode') == 1) {
            ini_set ('zend.ze1_compatibility_mode', 0);
        }
        if ($xml == null) {
            $xml = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><$rootNodeName />");
        }
        $childNodeName = substr($rootNodeName, 0, strlen($rootNodeName)-1);
                foreach($data as $key => $value) {
                        if (is_numeric($key)) {
                                $key = $childNodeName;
            }
                        if (is_array($value)) {
                $node = $xml->addChild($key);
                                self::array_to_xml($value, $key, $node);
            } else  {
                                if (is_string($value)) {
                    $value = htmlspecialchars($value);
                    $xml->addChild($key,$value);
                } else {
                    $xml->addAttribute($key,$value);
                }
            }
        }
                return $xml->asXML();
    }
    public static function print_xml($parsed_xml) {
        header("Content-type: text/xml");
        print $parsed_xml;
    }
}
function mysiteapp_print_xml($arr) {
    $result = MysiteappXmlParser::array_to_xml($arr, "mysiteapp");
    MysiteappXmlParser::print_xml($result);
}
function mysiteapp_clean_output($func) {
    ob_start();
    $ret = call_user_func($func);
    ob_end_clean();
    return $ret;
}
function mysiteapp_should_hide_posts() {
    return isset($_REQUEST['posts_hide']) && $_REQUEST['posts_hide'] == '1';
}
function mysiteapp_should_show_sidebar() {
    return isset($_REQUEST['sidebar_hide']) && $_REQUEST['sidebar_hide'] == '0';
}
function mysiteapp_get_pic_from_fb_id($fb_id){
    return 'http://graph.facebook.com/'.$fb_id.'/picture?type=small';
}
function mysiteapp_get_pic_from_fb_profile($fb_profile){
    if(stripos($fb_profile,'facebook') === FALSE) {
        return false;
    }
    $user_id = basename($fb_profile);
    return mysiteapp_get_pic_from_fb_id($user_id);
}
function mysiteapp_get_member_for_comment(){
    $need_g_avatar = true;
    $user = array();
    $user['author'] = get_comment_author();
    $user['link'] = get_comment_author_url();
    $options = get_option('uppsite_options');
        if (isset($options['disqus'])){
        $user['avatar'] = mysiteapp_get_pic_from_fb_profile($user['link']);
        if ($user['avatar']) {
            $need_g_avatar = false;
        }
    }
    if ($need_g_avatar){
        if(function_exists('get_avatar') && function_exists('htmlspecialchars_decode')){
            $user['avatar']  = htmlspecialchars_decode(uppsite_extract_src_url(get_avatar(get_comment_author_email())));
        }
    }?>
<member>
    <name><![CDATA[<?php echo $user['author'] ?>]]></name>
    <member_link><![CDATA[<?php echo $user['link'] ?>]]></member_link>
    <avatar><![CDATA[<?php echo $user['avatar'] ?>]]></avatar>
</member><?php
}
function mysiteapp_print_single_facebook_comment($fb_comment){
    $avatar_url = mysiteapp_get_pic_from_fb_id($fb_comment['from']['id']);
    ?><comment ID="<?php echo $fb_comment['id'] ?>" post_id="<?php echo get_the_ID() ?>" isApproved="true">
    <permalink><![CDATA[<?php echo get_permalink() ?>]]></permalink>
    <time><![CDATA[<?php echo $fb_comment['created_time'] ?>]]></time>
    <unix_time><![CDATA[<?php echo strtotime($fb_comment['created_time']) ?>]]></unix_time>
    <member>
        <name><![CDATA[<?php echo $fb_comment['from']['name'] ?>]]></name>
        <member_link><![CDATA[]]></member_link>
        <avatar><![CDATA[<?php echo $avatar_url ?>]]></avatar>
    </member>
    <text><![CDATA[<?php echo $fb_comment['message'] ?>]]> </text>
</comment><?php
}
function mysiteapp_print_facebook_comments(&$comment_counter){
    $permalink = get_permalink();
    $comments_url = MYSITEAPP_FACEBOOK_COMMENTS_URL.$permalink;
    $res = '';
    $comment_counter = 0;
        $comment_json = wp_remote_get($comments_url);
    $avatar_url = htmlspecialchars_decode(uppsite_extract_src_url(get_avatar(0)));
        if($comment_json){
        $comments_arr = json_decode($comment_json['body'],true);
                if ($comments_arr == NULL||
            !array_key_exists($permalink,$comments_arr) ||
            !array_key_exists('data',$comments_arr[$permalink])) {
            return;
        }
        $comments_list = $comments_arr[$permalink]['data'];
        foreach($comments_list as $comment){
            $res .= mysiteapp_print_single_facebook_comment($comment,$avatar_url);
                        if (array_key_exists('comments', $comment)){
                foreach($comment['comments']['data'] as $inner_comment){
                    $res .= mysiteapp_print_single_facebook_comment($inner_comment);
                    $comment_counter++;
                }
            }
            $comment_counter++;
        }
    }
    return $res;
}
function mysiteapp_fix_youtube_helper(&$matches) {
    $new_width = MYSITEAPP_VIDEO_WIDTH;
    $toreturn = $matches['part1']."%d".$matches['part2']."%d".$matches['part3'];
    $height = is_numeric($matches['objectHeight']) ? $matches['objectHeight'] : $matches['embedHeight'];
    $width = is_numeric($matches['objectWidth']) ? $matches['objectWidth'] : $matches['embedWidth'];
    $new_height = ceil(($new_width / $width) * $height);
    return sprintf($toreturn, $new_width, $new_height);
}
function mysiteapp_fix_helper(&$matches) {
    if (strpos($matches['url1'], "youtube.com") !== false) {
        return mysiteapp_fix_youtube_helper($matches);
    }
    return $matches['part1'].$matches['objectWidth'].$matches['part2'].$matches['objectHeight'].$matches['part3'];
}
function mysiteapp_fix_videos(&$subject) {
    $matches = preg_replace_callback("/(?P<part1><object[^>]*width=['\"])(?P<objectWidth>\d+)(?P<part2>['\"].*?height=['\"])(?P<objectHeight>\d+)(?P<part3>['\"].*?value=['\"](?P<url1>[^\"]+)['|\"].*?<\/object>)/ms", "mysiteapp_fix_helper", $subject);
    return $matches;
}
function mysiteapp_should_show_post_content($iterator = 0) {
    $posts_layout = mysiteapp_get_posts_layout();
    if (
        empty($posts_layout) ||         $posts_layout == 'full' ||         ( $iterator < MYSITEAPP_BUFFER_POSTS_COUNT && ($posts_layout == 'ffull_rexcerpt' || $posts_layout == 'ffull_rtitle'))     ) {
        return true;
    }
    return false;
}
function mysiteapp_print_post($iterator = 0) {
    set_query_var('mysiteapp_should_show_post', mysiteapp_should_show_post_content($iterator));
    get_template_part('post');
}
function mysiteapp_logout_url_wrapper() {
    if (function_exists('wp_logout_url')) {
        return wp_logout_url();
    }
        $logout_url = site_url('wp-login.php') . "?action=logout";
    if (function_exists('wp_create_nonce')) {
                        $logout_url .= "&amp;_wpnonce=" . wp_create_nonce('log-out');
    }
    return $logout_url;
}
function mysiteapp_print_error($wp_error){
    ?><mysiteapp result="false">
    <?php foreach ($wp_error->get_error_codes() as $code): ?>
    <error><![CDATA[<?php echo $code ?>]]></error>
    <?php endforeach; ?>
</mysiteapp><?php
    exit();
}
function mysiteapp_login($user, $username, $password){
    $user = wp_authenticate_username_password($user, $username, $password);
    if (is_wp_error($user)) {
        mysiteapp_print_error($user);
    } else {
        set_query_var('mysiteapp_user', $user);
        get_template_part('user');
    }
    exit();
}
function mysiteapp_list($thelist, $nodeName, $idParam = "") {
    preg_match_all('/(?:class="[^"]*'.$idParam.'-(\d+)[^"]*".*?)?href=["\'](.*?)["\'].*?>(.*?)<\/a>/ms', $thelist, $result);
    $total = count($result[1]);
    $thelist = "";
    for ($i=0; $i<$total; $i++) {
        $curId = $result[1][$i];
        $thelist .= "\t<" . $nodeName . ( $curId ? " id=\"" . $curId ."\"" : "" ) .">\n\t\t";
        $thelist .= "<title><![CDATA[" . $result[3][$i] . "]]></title>\n\t\t";
        $thelist .= "<permalink><![CDATA[" . $result[2][$i] ."]]></permalink>\n\t";
        $thelist .= "</" . $nodeName .">\n";
    }
    return $thelist;
}
function mysiteapp_list_cat($thelist){
    return mysiteapp_list($thelist, 'category', 'cat-item');
}
function mysiteapp_list_tags($thelist){
    return mysiteapp_list($thelist, 'tag');
}
function mysiteapp_list_archive($thelist){
    return mysiteapp_list($thelist, 'archive');
}
function mysiteapp_list_pages($thelist){
    return mysiteapp_list($thelist, 'page', 'page-item');
}
function mysiteapp_list_links($thelist){
    return mysiteapp_list($thelist, 'link');
}
function mysiteapp_navigation($thelist){
    return mysiteapp_list($thelist, 'navigation');
}
function mysiteapp_comment_to_disq($location, $comment=NULL){
    $shortname  = strtolower(get_option('disqus_forum_url'));
    $disq_thread_url = '.disqus.com/thread/';
    $options = get_option('uppsite_options');
    if ($comment==NULL)
        $comment = $location;
    if(isset($options['disqus']) && strlen($shortname)>1){
        $post_details = get_post($comment->comment_post_ID, ARRAY_A);
        $fixed_title = str_replace(' ', '_', $post_details['post_title']);
        $fixed_title = strtolower($fixed_title);
        $str = 'author_name='.$comment->comment_author.'&author_email='.$comment->comment_author_email.'&subscribe=0&message='.$comment->comment_content;
        $post_data = array('body' =>$str);
        $url = 'http://'.$shortname.$disq_thread_url.$fixed_title.'/post_create/';
        $result = wp_remote_post($url,$post_data);
    }
    return $location;
}
function mysiteapp_error_handler($message, $title = '', $args = array()) {
    ?><mysiteapp result="false">
    <error><![CDATA[<?php echo $message ?>]]></error>
</mysiteapp>
<?php
    die();
}
function mysiteapp_call_error( $function ) {
    return 'mysiteapp_error_handler';
}
function mysiteapp_post_new() {
    global $msap;
    global $temp_ID, $post_ID, $form_action, $post, $user_ID;
    if ($msap->is_app) {
        if (!$post) {
            remove_action('save_post', 'mysiteapp_post_new_process');
            $post = get_default_post_to_edit( 'post', true );
            add_action('save_post', 'mysiteapp_post_new_process');
            $post_ID = $post->ID;
        }
        $arr = array(
            'user'=>array('ID'=>$user_ID),
            'postedit'=>array()
        );
        if ( 0 == $post_ID ) {
            $form_action = 'post';
        } else {
            $form_action = 'editpost';
        }
        $arr['postedit'] = array(
            'wpnonce' => wp_create_nonce( 0 == $post_ID ? 'add-post' : 'update-post_' .  $post_ID ),
            'user_ID' => (int)$user_ID,
            'original_post_status'=>esc_attr($post->post_status),
            'action'=>esc_attr($form_action),
            'originalaction'=>esc_attr($form_action),
            'post_type'=>esc_attr($post->post_type),
            'post_author'=>esc_attr( $post->post_author ),
            'referredby'=>esc_url(stripslashes(wp_get_referer())),
            'hidden_post_status'=>'',
            'hidden_post_password'=>'',
            'hidden_post_sticky'=>'',
            'autosavenonce'=>wp_create_nonce( 'autosave'),
            'closedpostboxesnonce'=>wp_create_nonce( 'closedpostboxes'),
            'getpermalinknonce'=>wp_create_nonce( 'getpermalink'),
            'samplepermalinknonce'=>wp_create_nonce( 'samplepermalink'),
            'meta_box_order_nonce'=>wp_create_nonce( 'meta-box-order'),
            'categories'=>array(),
        );
        if ( 0 == $post_ID ) {
            $arr['postedit']['temp_ID'] = esc_attr($temp_ID);
        } else {
            $arr['postedit']['post_ID'] = esc_attr($post_ID);
        }
        mysiteapp_print_xml($arr);
        exit();
    }
}
function mysiteapp_post_new_process($post_id) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;
    if ( wp_is_post_revision( $post_id ) )
        return;
    global $msap;
    if ($msap->is_app) {
        $arr = array(
            'user' => array('ID' => get_current_user_id()),
            'postedit' => array(
                'success'=>true,
                'post_ID'=>$post_id,
                'is_revision' => var_export(wp_is_post_revision($post_id), true),
                'permalink' => get_permalink($post_id)
            ),
        );
        mysiteapp_print_xml($arr);
        exit();
    }
}
function mysiteapp_logout() {
    global $msap;
    global $user_ID;
    if ($msap->is_app) {
        $arr = array(
            'user'=>array('ID'=>$user_ID),
            'logout'=>array('success'=> !empty($user_ID))
        );
        mysiteapp_print_xml($arr);
        exit();
    }
}
function mysiteapp_fix_content_more($more){
    return '(...)';
}
function mysiteapp_comment_author($comment_ID = 0)
{
    $author = html_entity_decode($comment_ID) ;
    $stripped = strip_tags($author);
    echo $stripped;
}
function mysiteapp_comment_form() {
    ob_start();
    do_action('comment_form');
    $dump = ob_get_clean();
    if (preg_match_all('/name="([a-zA-Z0-9\_]+)" value="([a-zA-Z0-9\_\'&@#]+)"/', $dump, $matches)) {
        $total = count($matches[1]);
        for ($i=0; $i<$total; $i++) {
            echo "<".$matches[1][$i]."><![CDATA[".$matches[2][$i]."]]></".$matches[1][$i].">\n";
        }
    }
}
function mysiteapp_comment_to_facebook(){
    $options = get_option('uppsite_options');
    $val = isset($_REQUEST['msa_facebook_comment_page']) ? $_REQUEST['msa_facebook_comment_page'] : NULL;
    if ($val) {
        if (isset($options['fbcomment']) && !isset($_POST['comment'])) {
            print mysiteapp_facebook_comments_page();
            exit;
        }
    }
}
function mysiteapp_homepage_is_only_show_posts() {
    return isset($_REQUEST['onlyposts']);
}
add_filter('the_category','mysiteapp_list_cat');
add_filter('wp_list_categories','mysiteapp_list_cat');
add_filter('the_tags','mysiteapp_list_tags');
add_filter('get_archives_link','mysiteapp_list_archive');
add_filter('wp_list_pages','mysiteapp_list_pages');
add_filter('wp_list_bookmarks','mysiteapp_list_links');
add_filter('wp_tag_cloud','mysiteapp_list_tags');
add_filter('next_posts_link','mysiteapp_navigation');
add_action('template_redirect','mysiteapp_comment_to_facebook', 10);
add_filter('wp_die_handler','mysiteapp_call_error');
add_action('load-post-new.php', 'mysiteapp_post_new');
add_action('save_post', 'mysiteapp_post_new_process');
add_action('wp_logout', 'mysiteapp_logout', 30);
add_action('comment_author', 'mysiteapp_comment_author');
add_filter('authenticate', 'mysiteapp_login', 2, 3);
add_filter('the_content_more_link','mysiteapp_fix_content_more', 10, 1);
function mysiteapp_fix_content_fb_social($content){
    $fixed_content = preg_replace('/<p class=\"FacebookLikeButton\">.*?<\/p>/','',$content);
    $fixed_content = preg_replace('/<iframe id=\"basic_facebook_social_plugins_likebutton\" .*?<\/iframe>/','',$fixed_content);
    return $fixed_content;
}
add_filter('the_content','mysiteapp_fix_content_fb_social',20,1);
