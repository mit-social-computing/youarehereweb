<?php

class ProgramistaIt_Custom_Html_Widget extends WP_Widget {

	protected $widget_id = 'custom_html_widget';
	protected $directory = 'custom-html-widget';

    // attributes with default values
    protected $attributes = array('title' => '', 'html' => '');
    protected $labels = array('title' => 'Title', 'html' => 'Content');

    // constructor
    function ProgramistaIt_Custom_Html_Widget() {
        $options = array('classname' => $this->widget_id, 'description' => 'Add your own content using a Visual Editor');
        $this->WP_Widget($this->widget_id, 'Visual Editor Text Widget', $options);
        add_action('admin_head', array($this, 'addToAdminHead'));
		add_action('wp_head', array($this, 'addToWpHead'));
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
            $instance[$key] = trim($new_instance[$key]);
        }
        return $instance;
    }

    // widget admin configuration
    function form($instance) {
        $instance = wp_parse_args((array) $instance, $this->attributes);
        require dirname(__FILE__).'/tpl/form.html.php';
    }

    // add code to admin head
    function addToAdminHead() {
    	global $pagenow;
    	if($pagenow == 'widgets.php') {
    		echo "<link rel='stylesheet' id='editor-buttons-css'  href='".home_url()."/wp-includes/css/editor.min.css'>";
    	}
        require dirname(__FILE__).'/tpl/admin-head.html.php';
    }
	
	// add code to wp head
	function addToWpHead() {
        require dirname(__FILE__).'/tpl/wp-head.html.php';
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
			$referer = strpos(wp_get_referer(), 'widget-custom-html-programista-it');
			if($referer != '') {
				return 'Insert picture';
			}
		}
		return $translated_text;
	}
}

register_widget('ProgramistaIt_Custom_Html_Widget');