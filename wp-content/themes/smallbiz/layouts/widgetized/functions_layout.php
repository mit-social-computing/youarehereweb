<?php
/**
 * Functions for Widgetized
 *
 * @package WordPress
 * @subpackage Expand2Web SmallBiz
 * @since Expand2Web SmallBiz 3.3
 */ 

/* Defaults overrides for Layout */
function smallbiz_defaults_for_layout(){
  global $smallbiz_defaults_for_layout, $smallbiz_cur_version;
  if($smallbiz_defaults_for_layout){
      return $smallbiz_defaults_for_layout;
  }

  $smallbiz_defaults_for_layout = array(
	"noside_text" => '',
	"layout_title" =>  'Widgetized',
	);
    return $smallbiz_defaults_for_layout;
}

/* Extra options for layout */
/* Not sure this is needed -- check. */ 
function smallbiz_on_layout_activate()
{
	global $wpdb;
	$smallbiz_defaults = smallbiz_defaults();
	$layout_defaults   = smallbiz_defaults_for_layout();
	if(!get_option('smallbiz_noside_text')){
	    //update_option('smallbiz_nosidek_text', $layout_defaults['noside_text']);
	}
}
/* Extra options for layout must also be defined here: */
function smallbiz_layout_extra_options()
{
    $options = array(
			'noside_text'
	);
	return $options;
}

/* Section on the options page for layout */
function smallbiz_theme_option_page_layout_options()
{
	global $wpdb, $smallbiz_cur_version ;
?>
<div id="outerbox"> 			
<h6>Widgetized Instructions</h6>
<div id="mainpagetext">

           <p><strong>You have selected the WIDGETIZED Layout - Please go to <a href="<?php bloginfo('url') ?>/wp-admin/widgets.php">"Appearance -> Widgets"</a> and drag your desired Widgets into a Dropzone of choice.</strong></p><p>For a map of Dropzones please look at the bottom of the Widget Page.</p>
           
           <p>PS. You will notice that we have pre-populated a few widgets for you. You can of course delete and change those. <br /> But we thought it may give you a headstart :-)</p>

</div> <!--mainpagetext-->
</div> <!--outerbox-->
			
			
<?php } ?>