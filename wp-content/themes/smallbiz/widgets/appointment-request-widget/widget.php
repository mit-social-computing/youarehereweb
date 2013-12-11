<?php

class ProgramistaIt_Appointment_Request_Widget extends WP_Widget {

	protected $widget_id = 'appointment_request_widget';

    // attributes with default values
    protected $attributes = array('title' => '');
    protected $labels = array('title' => 'Title');

    // constructor
    function ProgramistaIt_Appointment_Request_Widget() {
        $options = array('classname' => $this->widget_id, 'description' => 'Show appointment form');
        $this->WP_Widget($this->widget_id, 'Appointment Request Widget', $options);
        add_action('admin_head', array($this, 'addToAdminHead'));
		add_action('wp_head', array($this, 'addToWpHead'));
		add_action('wp_footer', array($this, 'addToWpFooter'));
		add_action('init', array($this, 'wpInit'));
    }

	  // add jquery to the site
	  function wpInit() {
		  // add jquery
		  wp_enqueue_script('jquery');
		  if(isset($_GET['appointment_request_widget_footer_iframe'])) {
			  require dirname(__FILE__).'/tpl/appointment.html.php';
			  exit;
		  }
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
	
	function addToWpFooter() {
		require dirname(__FILE__).'/tpl/wp-footer.html.php';
	}
	
	// add code to wp head
	function addToWpHead() {
        require dirname(__FILE__).'/tpl/wp-head.html.php';
	}
}

register_widget('ProgramistaIt_Appointment_Request_Widget');
