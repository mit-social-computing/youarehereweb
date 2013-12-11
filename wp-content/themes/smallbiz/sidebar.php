	</div>

	<div id="sidebar">
	<div id="innersidebarwrap">
		<ul>
			<?php include_once dirname(__FILE__).'/global-sidebar.php'; ?>
			<?php 	/* Widgetized sidebar, if you have the plugin installed. */
					if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Main Sidebar') ) : ?>
					
			<?php endif; ?>
		</ul>
		</div><!--innersidebarwrap-->
	</div><!--sidebar-->
	
<div style="clear: both;"></div>