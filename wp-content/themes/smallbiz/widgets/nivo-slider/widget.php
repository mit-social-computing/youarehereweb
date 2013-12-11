<?php

class ProgramistaIt_NivoSlider extends WP_Widget {

	protected $widget_id = 'nivo_slider_widget';

    // attributes with default values
    protected $attributes = array('theme' => 'bar', 'effect' => 'random', 'speed' => '800', 'pause' => '3000', 'images' => '[]');
    protected $labels = array('theme' => 'Choose the Template', 'effect' => 'Choose your Slide Transition Effect', 'speed' => 'Set your Slide Transition Speed (ms)', 'pause' => 'Set your Slide Pause Time (ms)');

    // constructor
    function ProgramistaIt_NivoSlider() {
        $options = array('classname' => $this->widget_id, 'description' => 'Add a Slideshow with different transitions');
        $this->WP_Widget($this->widget_id, 'Slideshow Widget', $options);
        add_action('admin_head', array($this, 'addToAdminHead'));
		add_action('wp_head', array($this, 'addToWpHead'));
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

		// fill params with defaults if empty
		foreach($params as $key => $val) {
			if(empty($val)) {
				$params[$key] = $this->attributes[$key];
			}
		}

		$nivoConfig = $this->generateNivoConfig($params);
		$images = json_decode($params['images']);
		
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
    function addToAdminHead() {
        require dirname(__FILE__).'/tpl/admin-head.html.php';
    }
	
	// add code to wp head
	function addToWpHead() {
        require dirname(__FILE__).'/tpl/wp-head.html.php';
	}
	
	function getSelectOptions($key) {
		if($key == 'effect')
			return explode(',', 'sliceDown,sliceDownLeft,sliceUp,sliceUpLeft,sliceUpDown,sliceUpDownLeft,fold,fade,random,slideInRight,slideInLeft,boxRandom,boxRain,boxRainReverse,boxRainGrow,boxRainGrowReverse');
		if($key == 'theme')
			return array('bar', 'dark', 'default', 'light');
	}
	
	function generateNivoConfig($params) {      
		return json_encode(array(
			'effect' => $params['effect'],
			'animSpeed' => $params['speed'],
			'pauseTime' => $params['pause']
		));
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
			$referer = strpos(wp_get_referer(), 'widget-nivo-slider');
			if($referer != '') {
				return 'Insert into Slider';
			}
		}
		return $translated_text;
	}
}

register_widget('ProgramistaIt_NivoSlider');