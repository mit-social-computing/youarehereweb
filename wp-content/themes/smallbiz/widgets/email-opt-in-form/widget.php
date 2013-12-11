<?php

class ProgramistaIt_EmailOptInFormWidget extends WP_Widget {

	protected $description = 'Add email opt-in form to the sidebar';
	protected $title = 'Email Opt-in Form';
	protected $widget_id;
	protected $directory;

	// attributes with default values
	protected $labels = array('title' => 'Title', 'opt-in-description' => 'Opt-In Description', 'thank-you-page' => 'Thank you page', 'autoresponder' => 'Autoresponder E-mail', 'admin-email' => 'Admin E-mail', 'email-subect' => 'Email Subject', 'email-content' => 'Email Content', '3rd-party' => '3rd Party E-Mail Service', 'embed-code' => 'Embed Code (Optional)');
	protected $placeholders = array('admin-email' => 'admin@domain.com', 'email-subject' => 'Opt-In Email', 'title' => 'Download your FREE Plan!', 'opt-in-description' => 'Simply enter your first name &amp; e-mail below for instant access to your FREE Plan!');

	// constructor
	function ProgramistaIt_EmailOptInFormWidget() {
		$this->setupConfig();
		$this->WP_Widget($this->widget_id, $this->title, array('classname' => $this->widget_id, 'description' => $this->description));
		add_action('admin_head', array($this, 'addToAdminHead'));
		add_action('wp_head', array($this, 'addToWpHead'));
		add_action('init', array($this, 'sendEmail'));
	}

	function sendEmail() {
		// check if request is sent from this widget
		if(isset($_GET['30c8d4c5a363936f380c203fc6a2733a']) && isset($_POST['OptIn'])) {
			$post = $_POST['OptIn'];
			foreach($this->get_settings() as $id => $settings) {
				if(isset($post['widget']) && $post['widget'] == $id) {
					$redirect_url = get_permalink(intval($settings['thank-you-page']));
					
					// send email to user
					if(!empty($settings['admin-email'])) {
						add_filter('wp_mail_from', create_function('$content_type','return "'.$settings['admin-email'].'";'));
						add_filter('wp_mail_from_name', create_function('$content_type','return "'.get_userdata(1)->user_login.'";'));
					}			
					wp_mail( $post['email'], $settings['email-subect'], $settings['email-content']);
					// send email to admin
					if(!empty($settings['admin-email'])) {
						wp_mail( $settings['admin-email'], 'Opt-In email', 'Site: '.home_url()."\nName: " .$post['name']."\nEmail: " .$post['email'] );
					}
					
					if(empty($settings['thank-you-page'])) {
						$redirect_url = home_url();
					}
					
					wp_redirect($redirect_url);
					exit;
				}
			}
		}
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
		foreach($this->labels as $key => $chunk) {
			$params[$key] = apply_filters('widget_'.$key, trim($instance[$key]));
		}
		require dirname(__FILE__).'/tpl/widget.html.php';
	}

	// update widget options
	function update($new_instance, $instance) {
		foreach($this->labels as $key => $chunk) {
			$value = trim($new_instance[$key]);
			if($key != 'embed-code') {
				$value = strip_tags($value);
			}
			$instance[$key] = $value;
		}
		return $instance;
	}

	// widget admin configuration
	function form($instance) {
		$instance = wp_parse_args((array) $instance, $this->getAttributes());
		require dirname(__FILE__).'/tpl/form.html.php';
	}

	protected function getAttributes() {
		$res = array();
		foreach($this->labels as $key => $val) {
			$res[$key] = isset($this->placeholders[$key]) ? $this->placeholders[$key] : '';
		}
		return $res;
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

register_widget('ProgramistaIt_EmailOptInFormWidget');