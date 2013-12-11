<?php

class ProgramistaIt_Youtube_Widget extends WP_Widget {

	protected $description = 'Add a Youtube Video';
	protected $title = 'YouTube Video Widget';
	protected $widget_id;
	protected $directory;

    // attributes with default values
    protected $attributes = array('title' => '', 'url' => '');
    protected $labels = array('title' => 'Title', 'url' => 'YouTube link');

    // constructor
    function ProgramistaIt_Youtube_Widget() {
		$this->setupConfig();		
        $this->WP_Widget($this->widget_id, $this->title, array('classname' => $this->widget_id, 'description' => $this->description));
        add_action('admin_head', array($this, 'addToAdminHead'));
		add_action('wp_head', array($this, 'addToWpHead'));
    }

	protected function setupConfig() {
    	$path = explode('/', __FILE__);
		$this->directory = $path[count($path) - 2];
		$this->widget_id = str_replace('-', '_', $this->directory);
	}

    // widget content
    function widget($args, $instance) {
        extract($args, EXTR_SKIP);
        $params = array();
        foreach($this->attributes as $key => $chunk) {
            $params[$key] = apply_filters('widget_'.$key, trim($instance[$key]));
        }
		$youtube_id = $this->extractYoutubeId($params['url']);
        require dirname(__FILE__).'/tpl/widget.html.php';
    }

	protected function extractYoutubeId($url) {
		// http://www.youtube.com/watch?v=bXoIlvjRXuk
		$status = preg_match('/v=([^&]+)&?/', $url, $result);
		if($status) {
			return $result[1];
		}
		// http://youtu.be/bXoIlvjRXuk
		if(preg_match('/youtu\.be/', $url)) {
			list(, $status) = explode('youtu.be/', $url);
			return $status;
		}
		return false;
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
}

register_widget('ProgramistaIt_Youtube_Widget');