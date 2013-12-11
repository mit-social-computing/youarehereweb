<?php
/**
 * Functions for slider.
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
  
"slider_theme" => 'default',    
  
"slider_effect" => 'slideInRight',  
 
"slider_animSpeed" => '500',
  
"slider_pauseTime" => '3000',
  
"slider_imgs1" => 'http://cdn4.expand2web.com/slider01.png',

"slider_imgs2" => 'http://cdn4.expand2web.com/slider02.png',

"slider_imgs3" => 'http://cdn4.expand2web.com/slider03.png',

"slider_imgs4" => 'http://cdn4.expand2web.com/slider04.png',

"slider_imgs5" => 'http://cdn4.expand2web.com/slider05.png',


"slider_lks1" => 'http://members.expand2web.com/userguide/',

"slider_lks2" => 'http://www.expand2web.com/',

"slider_lks3" => 'http://www.smallbiztheme.com/affiliates/',

"slider_lks4" => '#',

"slider_lks5" => '#',

    "slider_main_text" =>  '<h2>Welcome To My Business!</h2><p class="p">If you are looking for first-class service, you have come to the right place! We aim to be friendly and approachable. We are in your area and have what you need. We are here to serve you and answer any questions you may have.</p><h2>Call us today: 1.800.800.8888</h2><p class="p">We put our customers first. We listen to you and help you find what you need. Come visit to see what we are all about:</p><ul><li>Industry Leading Products</li><li>Quick Turnaround</li><li>Friendly and Approachable</li><li>And much, much more!</li></ul>',

	"layout_title" =>  'slider',
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
	if(!get_option('smallbiz_slider_main_text')){
	    //update_option('smallbiz_slider_main_text', $layout_defaults['slider_main_text']);
	}
}
/* Extra options for layout must also be defined here: */
function smallbiz_layout_extra_options()
{
    $options = array(
    'slider_theme',
    'slider_effect',
    'slider_animSpeed',
    'slider_pauseTime',
    'slider_imgs1',
          'slider_imgs2',
            'slider_imgs3',
              'slider_imgs4',
                'slider_imgs5',
         'slider_lks1',
         'slider_lks2',
         'slider_lks3',
         'slider_lks4',
         'slider_lks5',
			'slider_main_text',
			'slider_page_image'
			
	);
	return $options;
}

/* Section on the options page for layout */
function smallbiz_theme_option_page_layout_options()
{
	global $wpdb, $smallbiz_cur_version ;	
?>


<div id="outerbox"> 
<h6>Home Page Slider Settings and Images</h6>
<div id="homepageimage">


<p>Choose your Slider Navigation Color/Skin: </p>	

<label for="slider_theme">
					<select name="slider_theme" id="slider_theme">
					
					<option value="default" <?php if(get_option('smallbiz_slider_theme') == 'default'){echo 'selected';}?>>Default Navigation</option>
					
					<option value="light" <?php if(get_option('smallbiz_slider_theme') == 'light'){echo 'selected';}?>>Light Minimal Navigation</option>
					
					<option value="dark" <?php if(get_option('smallbiz_slider_theme') == 'dark'){echo 'selected';}?>>Dark Navigation Bar</option>	
	
					<option value="bar" <?php if(get_option('smallbiz_slider_theme') == 'bar'){echo 'selected';}?>>Hidden Navigation</option>	
			</select>
			</label>
			
<br />
	
<p>Choose your Slide Transition Effect: </p>	
	
	
			<label for="slider_effect">
			<select name="slider_effect" id="slider_effect">
					<option value="random" <?php if(get_option('smallbiz_slider_effect') == 'random'){echo 'selected';}?>>Random</option>
					<option value="fold" <?php if(get_option('smallbiz_slider_effect') == 'fold'){echo 'selected';}?>>Fold</option>
					<option value="fade" <?php if(get_option('smallbiz_slider_effect') == 'fade'){echo 'selected';}?>>Fade</option>
					<option value="slideInRight" <?php if(get_option('smallbiz_slider_effect') == 'slideInRight'){echo 'selected';}?>>Slide to Right</option>
					<option value="slideInLeft" <?php if(get_option('smallbiz_slider_effect') == 'slideInLeft'){echo 'selected';}?>>Slide to Left</option>
					<option value="sliceDown" <?php if(get_option('smallbiz_slider_effect') == 'sliceDown'){echo 'selected';}?>>Slice Down</option>
					<option value="sliceDownLeft" <?php if(get_option('smallbiz_slider_effect') == 'sliceDownLeft'){echo 'selected';}?>>Slice Down Left</option>
					<option value="sliceUp" <?php if(get_option('smallbiz_slider_effect') == 'sliceUp'){echo 'selected';}?>>Slice Up</option>
					<option value="sliceUpLeft" <?php if(get_option('smallbiz_slider_effect') == 'sliceUpLeft'){echo 'selected';}?>>Slice Up Left</option>
					<option value="sliceUpDown" <?php if(get_option('smallbiz_slider_effect') == 'sliceUpDown'){echo 'selected';}?>>Slice Up Down</option>
					<option value="sliceUpDownLeft" <?php if(get_option('smallbiz_slider_effect') == 'sliceUpDownLeft'){echo 'selected';}?>>Slice Up Down Left</option>
					<option value="boxRandom" id="boxslider_effect" <?php if(get_option('smallbiz_slider_effect') == 'boxRandom'){echo 'selected';}?>>Box Random</option>
					<option value="boxRain" id="boxslider_effect" <?php if(get_option('smallbiz_slider_effect') == 'boxRain'){echo 'selected';}?>>Box Rain</option>
					<option value="boxRainReverse" id="boxslider_effect" <?php if(get_option('smallbiz_slider_effect') == 'boxRainReverse'){echo 'selected';}?>>Box Rain Reverse</option>
					<option value="boxRainGrow" id="boxslider_effect" <?php if(get_option('smallbiz_slider_effect') == 'boxRainGrow'){echo 'selected';}?>>Box Rain Grow</option>
					<option value="boxRainGrowReverse" id="boxslider_effect" 
					<?php if(get_option('smallbiz_slider_effect') == 'boxRainGrowReverse'){echo 'selected';}?>> Box Rain Grow Reverse</option>
			</select>
			</label>
			

			
<p>Set your Slide Transition Speed (The time is in miliseconds 1000 = 1 second | 2000 = 2 seconds etc..)</p>

<input style="width:300px" type="text" name="slider_animSpeed" value="<?php echo get_option("smallbiz_slider_animSpeed")?>" /></p>


<p>Set your Slide Pause Time until the next Slide is loaded (The time is in miliseconds 1000 = 1 second | 2000 = 2 seconds etc..)</p>

<input style="width:300px" type="text" name="slider_pauseTime" value="<?php echo get_option("smallbiz_slider_pauseTime")?>" /></p>

 <br />
 
<p><strong>How to add your own Images to the Slider</strong></p> 
 
 <p class="userguide">1) Create 5 images (with image editing software of your choice - If you don't have image editing software - <a href="http://members.expand2web.com/userguide/free-and-online-based-image-editors/" target="_blank">look here</a>). Suggested size 960px Wide by 240px Height.</p>
<p>2) Upload your images to your <a href="<?php bloginfo('url') ?>/wp-admin/media-new.php">WordPress Media Library</a>.</p>
<p>3) Copy the image URL(s) generated by the Media Library into the field(s) below.</p>
<p>4) You can link each image to a page or any URL you want. Links must start with <em>http://</em> or <em>https://</em>. Leave field blank if you do not want to link the image.  </p>

               <br />
<p><input type="submit" value="Save Changes" name="sales_update" /></p>
<br />

<p>Image URL 1:<br /> <input style="width:600px" type="text" name="slider_imgs1" value="<?php echo get_option("smallbiz_slider_imgs1")?>" /></p>

<p>Optional: Link Image 1 to the following page...<br /> <input style="width:400px" type="text" name="slider_lks1" value="<?php echo get_option("smallbiz_slider_lks1")?>" /></p>

<br />

<p>Image URL 2:<br /> <input style="width:600px" type="text" name="slider_imgs2" value="<?php echo get_option("smallbiz_slider_imgs2")?>" /></p>

<p>Optional: Link Image 2 to the following page...<br /> <input style="width:400px" type="text" name="slider_lks2" value="<?php echo get_option("smallbiz_slider_lks2")?>" /></p>

<br />

<p>Image URL 3:<br /> <input style="width:600px" type="text" name="slider_imgs3" value="<?php echo get_option("smallbiz_slider_imgs3")?>" /></p>

<p>Optional: Link Image 3 to the following page...<br /> <input style="width:400px" type="text" name="slider_lks3" value="<?php echo get_option("smallbiz_slider_lks3")?>" /></p>

<br />

<p>Image URL 4:<br /> <input style="width:600px" type="text" name="slider_imgs4" value="<?php echo get_option("smallbiz_slider_imgs4")?>" /></p>

<p>Optional: Link Image 4 to the following page...<br /> <input style="width:400px" type="text" name="slider_lks4" value="<?php echo get_option("smallbiz_slider_lks4")?>" /></p>

<br />

<p>Image URL 5:<br /> <input style="width:600px" type="text" name="slider_imgs5" value="<?php echo get_option("smallbiz_slider_imgs5")?>" /></p>

<p>Optional: Link Image 5 to the following page...<br /> <input style="width:400px" type="text" name="slider_lks5" value="<?php echo get_option("smallbiz_slider_lks5")?>" /></p>

<br />

<p><em>We restricted the slider to 5 images to keep your page load times fast. Google does check for it.</em></p>
 <p class="userguide"><em>Advanced Users: Visit the SmallBiz UserGuide if you would like to have <a href="http://members.expand2web.com/userguide/more-or-less-thn-5-slides/" target="_blanK">more or less then 5 Slides</a>.</em></p>

               <br />
<p><input type="submit" value="Save Changes" name="sales_update" /></p>
            
</div> <!--homepageimage-->    
<div id="protip">
<p>ProTip: Advanced User option <a href="http://members.expand2web.com/userguide/slider-controls" target="_blank">custom slider control settings</a>.</p>
</div>
</div> <!--outerbox-->


<div id="outerbox">             
<h6>Home Page Text Box</h6>
<div id="mainpagetext">

            <?php echo tinyMCE_HTMLarea('slider_main_text',get_option("smallbiz_slider_main_text")); ?>
            

            <?php

            $pages = $wpdb->get_results('select * from '. $wpdb->prefix .'posts where post_type="page" and post_status="publish"');

            ?>
            
               <br />
	 <p><input type="submit" value="Save Changes" name="sales_update" /></p>
            
</div> <!--mainpagetext-->
  <div id="protip">
<p>ProTip: How to add an Image into the Homepage Text Box. <a href="http://members.expand2web.com/userguide/adding-images-to-the-4-bottom-boxes/" target="_blank">Click here to learn how</a>.</p>
</div>
</div> <!--outerbox-->
            

<?php } ?>