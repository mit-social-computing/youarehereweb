<?php

class ProgramistaIt_CustomSidebars {
	
	function ProgramistaIt_CustomSidebars() {
		$this->save();
		$this->remove();
		$this->registerSidebars();
		add_action('admin_menu', array($this,'add_admin_menu'));
		add_action('admin_head', array($this, 'remove_from_menu'));
	}
	
	function remove_from_menu() {
		include_once dirname(__FILE__).'/tpl/admin-head.html.php';
	}
	
	function add_admin_menu() {
		add_submenu_page('themes.php', 'SmallBiz Custom Widget Areas', 'SmallBiz Custom Widget Areas', 'manage_options', 'custom-sidebars-panel', array($this, 'admin_page'));
	}

	function admin_page() {
		include_once dirname(__FILE__).'/tpl/custom-sidebars.html.php';
	}
	
	protected function remove() {
		if(isset($_GET['remove-area'])) {
			$data = $this->getSidebars();
			if(isset($data[intval($_GET['remove-area'])])) {
				$this->deleteTemplate($data[intval($_GET['remove-area'])]);
				unset($data[intval($_GET['remove-area'])]);
				$this->saveSidebars($data);
				wp_redirect('themes.php?page=custom-sidebars-panel');
				exit;
			}
		}
	}
	
	protected function save() {
		if(isset($_POST['CustomSidebar'])) {
			$name = trim(htmlspecialchars($_POST['CustomSidebar']['Name']));
			$data = $this->getSidebars();
			if(!in_array($name, $data) && !empty($name) && preg_match('/^[a-zA-Z0-9 ]+$/', $name)) {
				$data[] = $name;
				$this->saveSidebars($data);
				$this->createTemplate($name);
			}
		}
	}
	
	protected function getSidebars() {
		require dirname(__FILE__).'/data.php';
		return $programista_it_custom_sidebars;
	}

	protected function saveSidebars($data) {
		file_put_contents(dirname(__FILE__).'/data.php', '<?php $programista_it_custom_sidebars='.var_export($data, true).';');
		return $programista_it_custom_sidebars;
	}
	
	protected function createTemplate($name) {
		$pattern = file_get_contents(dirname(__FILE__).'/template-pattern.php');
		$pattern = str_replace('{{Sidebar_name}}', 'Custom Sidebar - '.$name, $pattern);
		$pattern = str_replace('{{Template_name}}', 'Template ' . 'Name: Custom Template - '.$name, $pattern);
		file_put_contents(dirname(__FILE__).'/../custom-templates/'.$name.'.php', $pattern);
	}
	
	protected function deleteTemplate($name) {
		unlink(dirname(__FILE__).'/../custom-templates/'.$name.'.php');
	}
	
	protected function registerSidebars() {
		if(function_exists('register_sidebar')) {
			foreach($this->getSidebars() as $sidebar) {
				register_sidebar(array('name'=> 'Custom Sidebar - '.$sidebar,'before_widget' => '','after_widget' => '','before_title' => '<h3>','after_title' => '</h3>',));
			}
		}
	}
};