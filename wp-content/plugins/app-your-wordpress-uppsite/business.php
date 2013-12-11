<?php
define('MYSITEAPP_BIZ_OPTIONS', 'uppsite_biz_options');
class Vcard_Creator{
    var $user_details;
    var $card = null;
    function  __construct($details){
        $this->user_details  = $details;
    }
    function create_vcard($version = '2.1'){
        $this->card = "BEGIN:VCARD\r\n".
        $this->card .= "VERSION:".$version."\r\n".
        $this->card .=  isset($this->user_details['name']) ? "N:".$this->user_details['name']."\r\n" : "";
        $this->card .=  isset($this->user_details['name']) ? "FN:".$this->user_details['name']."\r\n" : "";
        $this->card .=  isset($this->user_details['company']) ? "ORG:".$this->user_details['company']."\r\n" : "";
        $this->card .=  isset($this->user_details['address']) ? "ADR;WORK:".$this->user_details['address']."\r\n" : "";
        $this->card .=  isset($this->user_details['phone']) ? "TEL;WORK;VOICE;PREF:".$this->user_details['phone']."\r\n" : "";
        $this->card .=  isset($this->user_details['fax']) ? "TEL;WORK;FAX:".$this->user_details['fax']."\r\n" : "";
        $this->card .=  isset($this->user_details['email']) ? "EMAIL;INTERNET;PREF:".$this->user_details['email']."\r\n" : "";
        $this->card .=  isset($this->user_details['url']) ? "URL;WORK;PREF:".$this->user_details['url']."\r\n" : "";
        $this->card .=  isset($this->user_details['note']) ? "NOTE:".$this->user_details['note']."\r\n" : "";
        if($version == '3')
            $this->card .=  isset($this->user_details['icon']) ? "PHOTO;VALUE=URL;TYPE=PNG:".$this->user_details['icon']."\r\n" : "";
        $this->card .= "REV:3\r\n";
        $this->card .= "END:VCARD\r\n";
    }
    function get_vcard(){
        if($this->card == null){
            $this->create_vcard();
        }
        header("Content-type:text/x-vcard");
        header('Content-Disposition: attachment; filename=contact.vcf');
        echo $this->card;
    }
    function get_vcard_iphone(){
        if($this->card == null){
            $this->create_vcard();
        }
        header("Content-type: text/x-vcalendar; charset=utf-8");
        header("Content-Disposition: attachment; filename=\"iphonecontact.ics\";");
        echo "BEGIN:VCALENDAR\n";
        echo "VERSION:2.0\n";
        echo "BEGIN:VEVENT\n";
        echo "SUMMARY:Click attached contact below to save to your contacts\n";
        $dtstart = date("Ymd")."T".date("Hi")."00";
        echo "DTSTART;TZID=Europe/London:".$dtstart."\n";
        $dtend = date("Ymd")."T".date("Hi")."01";
        echo "DTEND;TZID=Europe/London:".$dtend."\n";
        echo "DTSTAMP:".$dtstart."Z\n";
        echo "ATTACH;VALUE=BINARY;ENCODING=BASE64;FMTTYPE=text/directory;\n";
        echo " X-APPLE-FILENAME=iphonecontact.vcf:\n";
        $b64vcard = base64_encode($this->card);						        $b64mline = chunk_split($b64vcard,74,"\n");				        $b64final = preg_replace('/(.+)/', ' $1', $b64mline);	        echo $b64final;											        echo "END:VEVENT\n";
        echo "END:VCALENDAR\n";
    }
}
class Data_Miner{
    var $current_info = null;
    var $adress_regex = null;
    var $color_array = null;
    var $front_page = null;
    function get_phone_from_content($content){
          preg_match_all("/([1](\.|-|\s))?(\(?)[0-9]{3}(\)?)(\.|-|\s)[0-9]{3}(\.|-|\s)[0-9]{4}/", $content,$matched);
          if(empty($matched[0][0])) return;
          return $matched[0][0];
    }
    function get_address_regex(){
        if($this->adress_regex == null){
            require_once( dirname(__FILE__) . '/country_regex.inc.php' );
            $this->adress_regex = $regex;
        }
        return $this->adress_regex;
    }
    function get_front_page(){
        if($this->front_page) return $this->front_page;
        $response = wp_remote_get(home_url());
        if (is_wp_error($response)) {
            return false;
        }
        $this->front_page = $response['body'];
        return $this->front_page;
    }
    function parse_address_google($address) {
        $url = 'http://maps.googleapis.com/maps/api/geocode/json?sensor=false&address='.urlencode($address);
        $response = wp_remote_get($url);
        if (is_wp_error($response)) {
            return false;
        }
        $results = json_decode($response['body'],true);
        $parts = array(
            'street_number'=>array('street_number'),
            'address'=>array('route'),
            'city'=>array('locality'),
            'state'=>array('administrative_area_level_1'),
            'zip'=>array('postal_code'),
        );
        if (!empty($results['results'][0]['address_components'])) {
            $ac = $results['results'][0]['address_components'];
            foreach($parts as $need=>&$types) {
                foreach($ac as &$a) {
                    if (in_array($a['types'][0],$types)) $address_out[$need] = $a['short_name'];
                    elseif (empty($address_out[$need])) $address_out[$need] = '';
                }
            }
        } else{
            return false;
        }
        return $address_out;
    }
    function format_address($address_ar, $toVcf = false){
        if ($toVcf) {
            return sprintf("%s %s;%s;%s;%s",$address_ar['street_number'],$address_ar['address'],$address_ar['city'],$address_ar['state'],$address_ar['zip']);
        }
        return sprintf("%s %s\n%s, %s %s",$address_ar['street_number'],$address_ar['address'],$address_ar['city'],$address_ar['state'],$address_ar['zip']);
    }
    function get_address_from_content($content){
        $regex = $this->get_address_regex();
        preg_match_all($regex, $content,$matched);
        if(empty($matched[0][0])) return false;
        return $matched[0][0];
    }
    function get_email_from_content($content){
       preg_match_all('/[_a-z0-9-]+(\.[_a-z0-9-]+)*([ ]{0,2})@[a-z0-9- ]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})/i',$content,$matched);
       if(empty($matched[0][0])) return false;
        return $matched[0][0];
    }
    function parse_page_for_info($content){
        if(empty($this->current_info['phone'])){
            $this->current_info['phone'] = $this->get_phone_from_content($content);
            if($this->current_info['phone'])
                $this->current_info['email'] = $this->get_email_from_content($content);
        }
        if(empty($this->current_info['address'])){
            $this->current_info['address'] = $this->get_address_from_content($content);
            if(!$this->current_info['address'] != false){
                $parsed =  $this->parse_address_google($this->current_info['address']);
                if($parsed){
                    $this->current_info['address'] = $this->format_address($parsed);
                    $this->current_info['address_vcf'] = $this->format_address($parsed, true);
                }
            }
        }
        if(empty($this->current_info['email'])){
                $this->current_info['email'] = $this->get_email_from_content($content);
        }
    }
    private function all_missing($type){
        return !type;
    }
    private function get_missing_info(){
        return array_filter($this->current_info,'all_missing');
    }
    private function is_page_match($current_pages,$pages){
        foreach($pages as $page_name){
            if(stristr($current_pages,$page_name) !== FALSE){
                return true;
            }
        }
        return false;
    }
    function get_missing_info_from_homepage(){
        $home_page = $this->get_front_page();
        if(!$home_page) return;
        $this->parse_page_for_info($home_page);
    }
    function parse_shareing($share_site){
        $response = $this->get_front_page();
        preg_match_all('/<a[^>]*href=["\']([^"\']*('.$share_site.')[^"\']*)["\']/i',$response, $matches);
        if(!is_array($matches[1]) || count($matches[1]) == 0) return false;
        return $matches[1][0];
    }
    function get_share_info(){
        $result = array();
        $result['twitter'] = $this->parse_shareing('twitter');
        if (!empty($result['twitter'])) {
            preg_match("/twitter\.com\/(?:([^\/]+)\/)*([^\/]+)/i", $result['twitter'], $parts);
            $result['twitter'] = $parts[2];
        }
        $result['facebook'] = $this->parse_shareing('facebook');
        if (!empty($result['facebook'])) {
            preg_match("/facebook\.com\/(?:([^\/]+)\/)*([^\/\?]+)/i", $result['facebook'], $parts);
            $result['facebook'] = $parts[2];
        }
        return $result;
    }
    function get_weak_phone_from_content($content){
        preg_match_all("/(((\d){2,6}[\s\-\.]){3,6})/", $content,$matched);
        if(empty($matched[0][0])) return false;
        return $matched[0][0];
    }
    function weak_search(){
        if(!empty($this->current_info['phone'])) return false;
        $home = $this->get_front_page();
        $this->current_info['phone'] = $this->get_weak_phone_from_content($home);
        if(!empty($this->current_info['phone'])) return;
        $all_pages = get_pages();
        foreach($all_pages as $page){
                if($this->current_info['phone'] == false){
                    $this->current_info['phone']  = $this->get_weak_phone_from_content($page->post_content);
                }
        }
    }
    function get_site_contact($site_info = null){
        $pages_for_contact = array('Contact','About','Info','Home');          $all_pages = get_pages();
        $front_page_id = get_option('page_on_front');
        if($front_page_id != 0){
            $home = get_page($front_page_id);
            $this->parse_page_for_info($home->post_content);
        }
        foreach($all_pages as $page){
            if($this->is_page_match($page->post_title,$pages_for_contact)){
                $this->parse_page_for_info($page->post_content);
            }
        }
        $this->get_missing_info_from_homepage();
        $this->weak_search();
    }
    function get_all_images($content){
        preg_match_all('/<img[^>]*src=["\'](.+?)["\']/i',$content, $matches);
        if(!is_array($matches[1])) return array();
        return $matches[1];
    }
    function get_site_images(){
        $all_images = array();
        if ($this->get_front_page()) {
            $all_images = array_merge($all_images, $this->get_all_images($this->get_front_page()));
        }
        $all_pages = get_pages();
        foreach($all_pages as $page){
            $all_images = array_merge($all_images,$this->get_all_images($page->post_content));
        }
        return $all_images;
    }
    public function build_site_info($force){
        $site_info = get_option(MYSITEAPP_OPTIONS_BUSINESS);
        $this->get_site_contact($site_info);
        $site_info['title'] = get_bloginfo('name');
        $site_info['description'] = get_bloginfo('description');
        $site_info['contact_phone'] =  $this->current_info['phone'];
        $site_info['contact_address'] =  $this->current_info['address'];
        $site_info['contact_address_vcf'] = isset($this->current_info['address_vcf']) ? $this->current_info['address_vcf'] : '';
        $site_info['email'] = $this->current_info['email'] ? $this->current_info['email'] : get_bloginfo('admin_email');
        $site_info['featured'] = $this->get_images_from_homepage();
        $share_arr = $this->get_share_info();
        $site_info['facebook'] = $share_arr['facebook'];
        $site_info['twitter'] = $share_arr['twitter'];
        $site_info['all_images'] = $this->get_site_images();
        if (!isset($site_info['navbar_display']) || $force) {
            $site_info['navbar_display'] = true;
        }
        if (!isset($site_info['selected_images']) || $force) {
            $site_info['selected_images'] = $site_info['all_images'];
        }
        if (!isset($site_info['show_pages']) || $force) {
            $pages = get_pages(array('sort_column'=>'menu_order','sort_order'=>'asc'));
            $arr = array();
            foreach ($pages as $page) {
                $arr[] = $page->ID;
            }
            $site_info['menu_pages'] = $arr;
         }
        update_option(MYSITEAPP_OPTIONS_BUSINESS, $site_info);
    }
    public function get_images_from_homepage(){
        $options = get_option(MYSITEAPP_BIZ_OPTIONS);
        $number_images = isset($options['img_home_num']) ? $options['img_home_num'] : 3;
        $found_images = array();
        $response = $this->get_front_page();
        if(!$response) return;
        $wp_dir = wp_upload_dir();
        $escaped = preg_quote($wp_dir['baseurl'], '/');
        preg_match_all('/<img[^>]*src=["\']('.$escaped.'.+?)["\']/i',$response, $matches);
        if (!is_array($matches[1]) || count($matches[1]) == 0) {
                        $escaped = preg_quote(content_url('themes'), '/');
            preg_match_all('/<img[^>]*src=["\']('.$escaped.'.+?)["\']/i',$response, $matches);
            if (!is_array($matches[1]) || count($matches[1]) == 0) {
                return array();
            }
        }
        return array_slice($matches[1],0,$number_images);
    }
    function get_main_theme_color($css_content){
        preg_match_all('/background(?:-color)?:(.*?)[;}\s]/i',$css_content, $matches);
        if(!is_array($matches[1])) return;
        foreach($matches[1] as $color){
            if (strlen($color) == 4) {                 $color .= substr($color, 1);
            }
            if (strlen($color) == 7 && $color != "#ffffff" && $color != "#000000") {
                $this->color_array[$color] = isset($this->color_array[$color]) ? $this->color_array[$color] + 1 : 1;
            }
        }
    }
    function load_css_file($css_url,$handle){
        $options = get_option(MYSITEAPP_BIZ_OPTIONS);
        if(isset($options['main_bg_color']) || !is_home()) return $css_url;
        $trim = trim($css_url);
        if (empty($trim) || array_key_exists($css_url, $this->css_loaded)) { return $css_url; };
        $response = wp_remote_get($css_url);
        if (is_wp_error($response) || strpos("<body", $response['body']) !== false) {
                        return false;
        }
        $body = $response['body'];
        $this->get_main_theme_color($body);
        return $css_url;
    }
    function get_maxcolors_css(){
        $response = $this->get_front_page();
        preg_match_all('/<link[^>]*href=["\']([^"\']*(\.css)[^"\']*)["\']/i',$response, $matches);
        if(!is_array($matches[1])) return false;
        $this->color_array = array();
        foreach($matches[1] as $css){
            $this->load_css_file($css,null);
        }
        $options = get_option(MYSITEAPP_BIZ_OPTIONS);
        $options['matching_colors'] = $this->color_array;
        update_option(MYSITEAPP_BIZ_OPTIONS,$options);
    }
    private function clean_options($option_name){
        $options = get_option($option_name);
        if(empty($options) || count($options) == 0) {
            return true;
        }
        return false;
    }
    public function init_miner($force = false){
        if(($force == true) || $this->clean_options(MYSITEAPP_OPTIONS_BUSINESS)){
            $this->build_site_info($force);
            $this->get_maxcolors_css();
        }
    }
    public function miner_on_upgrade($version){
        if($version < 5){
            $this->init_miner(true);
        }
    }
    public function __construct() {
        $this->current_info = array('phone'=>false,'address'=>false,'email'=>false);
        $this->color_array = array();
        $this->css_loaded = array();
    }
}
$a = new Data_Miner();
if (isset($_REQUEST['miner'])) {
    $a->init_miner(true);
}
add_action( 'uppsite_is_activated', array($a, 'init_miner' ));
add_action('uppsite_has_upgraded', array($a, 'miner_on_upgrade'),1,1);
if (isset($_GET['vcard'])) {
    $func = null;
    switch (MySiteAppPlugin::detect_specific_os()) {
        case "wp":
        case "android":
            $func = "get_vcard";
            break;
        case "ios":
            $func = "get_vcard_iphone";
            break;
    }
    if (!is_null($func)) {
        $site_info = get_option(MYSITEAPP_BIZ_INFO);
        $arr = array();
        if (!empty($site_info['name'])) { $arr['company'] = $site_info['name']; }
        if (!empty($site_info['description'])) { $arr['note'] = $site_info['description']; }
        if (!empty($site_info['contact_phone'])) { $arr['phone'] = preg_replace("/[\.\(\)\s]/im", "", $site_info['contact_phone']); }
        if (!empty($site_info['contact_address'])) {
            $addr = $site_info['contact_address'];
            if ($site_info['contact_address_vcf']) {
                $addr = $site_info['contact_address_vcf'];
            } else {
                $addr = implode(";", explode("\n", str_replace(",", "\n", $addr)));
            }
            $arr['address'] = $addr;
        }
        $arr['url'] = home_url();
        if (!empty($site_info['admin_email'])) { $arr['email'] = $site_info['admin_email']; }
        $vc = new Vcard_Creator($arr);
        $vc->$func();
        exit;
    }
}
