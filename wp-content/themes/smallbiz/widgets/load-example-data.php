<?php

class ProgramistaIt_LoadExampleData {
	/*
	 * please use debug, to check what are the sidebars id,
	 * the best is to remove all widgets, add the one we whant to add in right places
	 * and debug will show right sidebar ids, and widget names
	 */
	
	protected $sidebar_names = array(
		'dropzone-full-width' => 'sidebar-6',
		'dropzone-main-content' => 'sidebar-9',
		'dropzone-4-columns' => 'sidebar-11'		
	);
	
	protected $widget_names = array(
		'visual-editor-text-widget' => 'custom_html_widget',
		'slideshow-widget' => 'nivo_slider_widget'		
	);
	
	function debug() {
		echo '<pre>';
		print_r(get_option( 'sidebars_widgets' ));
		echo '</pre>';
	}
	
	function __construct() {
		//update_option( 'expand2web_theme_configure_widgets', false);
		$this->loadExampleData();
	}
	
	function loadExampleData() {
		if(!isset( $_GET['activated'] )) {
			$setup_status = get_option( 'expand2web_theme_configure_widgets' );
			if($setup_status != true) {
				$this->addWidgetsToSidebars();
				update_option( 'expand2web_theme_configure_widgets', true);
			}
		}
	}
	
	protected function addWidgetsToSidebars() {

		$sidebars = get_option( 'sidebars_widgets' );
		$slideshow_widgets = get_option('widget_'.$this->widget_names['slideshow-widget']);
		$text_widgets = get_option('widget_'.$this->widget_names['visual-editor-text-widget']);
		
		// add 1 text widget to main content sidebar
		$sidebars[$this->sidebar_names['dropzone-main-content']] = array(
				$this->widget_names['visual-editor-text-widget'].'-2'
		);
		// add 4 text widgets to 4 columns sidebar
		$sidebars[$this->sidebar_names['dropzone-4-columns']] = array(
			$this->widget_names['visual-editor-text-widget'].'-3',
			$this->widget_names['visual-editor-text-widget'].'-4',
			$this->widget_names['visual-editor-text-widget'].'-5',
			$this->widget_names['visual-editor-text-widget'].'-6',
		);

		// add 1 slideshow widget to full width sidebar
		$sidebars[$this->sidebar_names['dropzone-full-width']] = array(
				$this->widget_names['slideshow-widget'].'-2'
		);		

		// update sidebars data
		update_option('sidebars_widgets', $sidebars);
		
		// configure slideshow widget
		$slideshow_widgets[2] =  array(
			'theme' => 'bar',
			'effect' => 'random',
			'speed' => 800,
			'pause' => 3000,
			'images' => 
				'[{"url":"http://cdn4.expand2web.com/sf-eileen.jpg","href":"","caption":""},'
				.'{"url":"http://cdn4.expand2web.com/hk-eileen.jpg","href":"","caption":""},'
				.'{"url":"http://cdn4.expand2web.com/ny-eileen.jpg","href":"","caption":""},'
				.'{"url":"http://cdn4.expand2web.com/sg-eileen.jpg","href":"","caption":""}]'
		);
		update_option('widget_'.$this->widget_names['slideshow-widget'], $slideshow_widgets);
		
		// configure text widgets
		$text_widgets[2] = array('title' => '', 'html' => '<h2>Welcome To My Business!</h2><p>If you are looking for first-class service, you have come to the right place! We aim to be friendly and approachable. We are in your area and have what you need. We are here to serve you and answer any questions you may have.</p>');
		$text_widgets[3] = array('title' => '', 'html' => '<h2>Blog</h2><hr /> <a href="#"><img src="http://cdn4.expand2web.com/cafe-eileen.png"; alt="Expand2Web Example Image" /></a>');
		$text_widgets[4] = array('title' => '', 'html' => '<h2>About</h2><hr /><a href="#"><img src="http://cdn4.expand2web.com/lobby-eileen.png"; alt="Expand2Web Example Image" /></a>');
		$text_widgets[5] = array('title' => '', 'html' => '<h2>Articles</h2><hr /><a href="#"><img src="http://cdn4.expand2web.com/bell-eileen.png"; alt="Expand2Web Example Image" /></a>');
		$text_widgets[6] = array('title' => '', 'html' => '<h2>Find Us</h2><hr /><a href="#"><img src="http://cdn4.expand2web.com/mobi-eileen.png"; alt="Expand2Web Example Image" /></a>');
		update_option('widget_'.$this->widget_names['visual-editor-text-widget'], $text_widgets);
	}
}

new ProgramistaIt_LoadExampleData();