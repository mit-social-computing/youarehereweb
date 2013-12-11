<?php

class ProgramistaIt_Recent_Posts extends WP_Widget {

	protected $widget_id = 'recent_posts_widget';

    // attributes with default values
    protected $attributes = array('title' => '', 'post_category' => '', 'posts_number' => '', 'post_thumbnails' => '');
    protected $labels = array('title' => 'Title', 'post_category' => 'Post Category', 'posts_number' => 'Number of posts to show', 'post_thumbnails' => 'Show Post Thumbnails');

    // constructor
    function ProgramistaIt_Recent_Posts() {
        $options = array('classname' => $this->widget_id, 'description' => 'Show the latest posts from specified category');
        $this->WP_Widget($this->widget_id, 'Blog Style Recent Posts', $options);
        add_action('admin_head', array($this, 'addToAdminHead'));
		add_action('wp_head', array($this, 'addToWpHead'));
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
    function addToAdminHead() {
        require dirname(__FILE__).'/tpl/admin-head.html.php';
    }
	
	// add code to wp head
	function addToWpHead() {
        require dirname(__FILE__).'/tpl/wp-head.html.php';
	}
}

register_widget('ProgramistaIt_Recent_Posts');