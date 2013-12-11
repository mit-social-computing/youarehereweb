<?php

class ProgramistaIt_Image_Widget extends WP_Widget {

    // url to help page
    protected $help_url = "http://members.expand2web.com/imagewidget";

    // attributes with default values
    protected $attributes = array('widget_title' => '', 'image_url' => '', 'image_alt_text' => '', 'image_title' => '', 'image_caption' => '', 'caption_alignment' => 'none', 'link_url' => '');
    protected $labels = array('widget_title' => 'Widget Title', 'image_url' => 'Image URL', 'image_alt_text' => 'Alternate text', 'image_title' => 'Image title', 'image_caption' => 'Caption', 'caption_alignment' => 'Alignment', 'link_url' => 'Link URL');

    // constructor
    function ProgramistaIt_Image_Widget() {
        $options = array('classname' => 'image_widget', 'description' => 'Add image to the sidebar');
        $this->WP_Widget('image_widget', 'Image Widget', $options);
        add_action('admin_head', array($this, 'addToHead'));
		add_action('admin_enqueue_scripts', array($this, 'enqueueScripts'));
		add_action('admin_init', array($this, 'replaceCaption'));
    }

    // widget content
    function widget($args, $instance) {
        extract($args, EXTR_SKIP);
        $params = array();
        foreach($this->attributes as $key => $chunk) {
            $params[$key] = apply_filters('widget_'.$key, trim($instance[$key]));
        }
        require dirname(__FILE__).'/tpl/widget.html.php';
    }

    // update widget options
    function update($new_instance, $instance) {
        foreach($this->attributes as $key => $value) {
            $instance[$key] = trim(strip_tags($new_instance[$key]));
        }
        return $instance;
    }

    // widget admin configuration
    function form($instance) {
        $instance = wp_parse_args((array) $instance, $this->attributes);
        require dirname(__FILE__).'/tpl/form.html.php';
    }

    // add code to admin head
    function addToHead() {
        require dirname(__FILE__).'/tpl/header.html.php';
    }

	// enqueue scripts for wp media uploader
	function enqueueScripts() {
		if(get_current_screen() -> id == 'widgets') {
			wp_enqueue_script('jquery');  
	        wp_enqueue_script('thickbox');  
	        wp_enqueue_style('thickbox');  
	        wp_enqueue_script('media-upload');  
	        wp_enqueue_script('wptuts-upload');
		}
	}

	// replace "insert to post" in media uploader
	function replaceCaption() {
		global $pagenow;
		if('media-upload.php' == $pagenow || 'async-upload.php' == $pagenow) {
			add_filter('gettext', array($this, 'replaceCaptionFilter'), 1, 3);
		}
	}

	function replaceCaptionFilter($translated_text, $text, $domain) {
		if('Insert into Post' == $text) {
			$referer = strpos(wp_get_referer(), 'widget-picture-widget');
			if($referer != '') {
				return 'Use this picture';
			}
		}
		return $translated_text;
	}
}

register_widget('ProgramistaIt_Image_Widget');