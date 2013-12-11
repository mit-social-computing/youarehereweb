<?php
/**
 * Functions for Rotator.
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

"rotator_main_text" =>  '<h2>Welcome to my Business!</h2>
<p>If you are looking for first-class service, you have come to the right place! We aim to be friendly and approachable.</p>
<h2>Call us today: 1.192.555.1212 </h2>
<p>We are here to serve you and answer any questions you may have. We are the only Certified and NRT Approved Center in the Pacific Region.</p><p>We specialize is exactly what you need - New customers and inquiries are always welcome.</p><p>Fast - Reliable - Local.</p>',


"rslider_theme" => 'light',    
  
"rslider_effect" => 'fade',  
 
"rslider_animSpeed" => '800',
  
"rslider_pauseTime" => '3000',

"rslider_slidewidth" => '320',
  
"rslider_imgs1" => 'http://cdn4.expand2web.com/Building.jpg',

"rslider_imgs2" => 'http://cdn4.expand2web.com/Cast.jpg',

"rslider_imgs3" => 'http://cdn4.expand2web.com/Dentist.jpg',

"rslider_imgs4" => 'http://cdn4.expand2web.com/Shipping.jpg',

"rslider_imgs5" => '',


"rslider_lks1" => 'http://members.expand2web.com/userguide/',

"rslider_lks2" => 'http://www.expand2web.com/',

"rslider_lks3" => 'http://www.smallbiztheme.com/affiliates/',

"rslider_lks4" => '#',

"rslider_lks5" => '',


"rotator_box1" => '<h2>Blog</h2><hr /> <a href="#"><img src="http://cdn4.expand2web.com/newyear.png" alt="Expand2Web Example Image" /></a>',

"rotator_box2" => '<h2>About</h2><hr /><a href="#"><img src="http://cdn4.expand2web.com/crew.png" alt="Expand2Web Example Image" /></a>',

"rotator_box3" => '<h2>Articles</h2><hr /><a href="#"><img src="http://cdn4.expand2web.com/xray.png" alt="Expand2Web Example Image" /></a>',

"rotator_box4" => '<h2>Find Us</h2><hr /><a href="#"><img src="http://cdn4.expand2web.com/maps.png" alt="Expand2Web Example Image" /></a>',

	"layout_title" =>  'Rotator',
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
	
	if(!get_option('smallbiz_rotator_main_text')){
	    update_option('smallbiz_rotator_main_text', $layout_defaults['rotator_main_text']);
	}
	if(!get_option('smallbiz_rotator_box1')){
	    update_option('smallbiz_rotator_box1', $layout_defaults['rotator_box1']);
	}
    if(!get_option('smallbiz_rotator_box2')){
        update_option('smallbiz_rotator_box2', $layout_defaults['rotator_box2']);
    }
    if(!get_option('smallbiz_rotator_box3')){
        update_option('smallbiz_rotator_box3', $layout_defaults['rotator_box3']);
    }
    if(!get_option('smallbiz_rotator_box4')){
        update_option('smallbiz_rotator_box4', $layout_defaults['rotator_box4']);
    }
     if(!get_option('smallbiz_rotator_lks1')){
        update_option('smallbiz_rotator_lks1', $layout_defaults['rotator_lks1']);
    }
}
/* Extra options for layout must also be defined here: */
function smallbiz_layout_extra_options()
{
    $options = array(
   'rotator_main_text',
    'rslider_theme',
    'rslider_effect',
    'rslider_animSpeed',
    'rslider_pauseTime',
    'rslider_slidewidth',
    'rslider_imgs1',
          'rslider_imgs2',
            'rslider_imgs3',
              'rslider_imgs4',
                'rslider_imgs5',
         'rslider_lks1',
         'rslider_lks2',
         'rslider_lks3',
         'rslider_lks4',
         'rslider_lks5',
			'rotator_box1',
			'rotator_box2',
			'rotator_box3',
			'rotator_box4',
	);
	return $options;
}

/* Section on the options page for layout */
function smallbiz_theme_option_page_layout_options()
{
	global $wpdb, $smallbiz_cur_version ;
?>

<div id="outerbox">             
<h6>Home Page Main Text Box</h6>
<div id="mainpagetext">

            <?php echo tinyMCE_HTMLarea('rotator_main_text',get_option("smallbiz_rotator_main_text")); ?>
            

            <?php

            $pages = $wpdb->get_results('select * from '. $wpdb->prefix .'posts where post_type="page" and post_status="publish"');

            ?>
            
               <br />
	 <p><input type="submit" value="Save Changes" name="sales_update" /></p>
            
</div> <!--mainpagetext-->
</div> <!--outerbox-->
       
<div id="outerbox">             
<h6>Rotating Images - Slideshow on Homepage</h6>
<div id="mainpagetext">
<p>Choose your Slider Navigation Color/Skin: </p>	

<label for="rslider_theme">
					<select name="rslider_theme" id="rslider_theme">
					
					<option value="default" <?php if(get_option('smallbiz_rslider_theme') == 'default'){echo 'selected';}?>>Default Navigation</option>
					
					<option value="light" <?php if(get_option('smallbiz_rslider_theme') == 'light'){echo 'selected';}?>>Light Minimal Navigation</option>
					
					<option value="dark" <?php if(get_option('smallbiz_rslider_theme') == 'dark'){echo 'selected';}?>>Dark Navigation Bar</option>	
	
					<option value="bar" <?php if(get_option('smallbiz_rslider_theme') == 'bar'){echo 'selected';}?>>Hidden Navigation</option>	
			</select>
			</label>
			
<br />
	
<p>Choose your Slide Transition Effect: </p>	
	
	
			<label for="rslider_effect">
			<select name="rslider_effect" id="rslider_effect">
					<option value="random" <?php if(get_option('smallbiz_rslider_effect') == 'random'){echo 'selected';}?>>Random</option>
					<option value="fold" <?php if(get_option('smallbiz_rslider_effect') == 'fold'){echo 'selected';}?>>Fold</option>
					<option value="fade" <?php if(get_option('smallbiz_rslider_effect') == 'fade'){echo 'selected';}?>>Fade</option>
					<option value="slideInRight" <?php if(get_option('smallbiz_rslider_effect') == 'slideInRight'){echo 'selected';}?>>Slide to Right</option>
					<option value="slideInLeft" <?php if(get_option('smallbiz_rslider_effect') == 'slideInLeft'){echo 'selected';}?>>Slide to Left</option>
					<option value="sliceDown" <?php if(get_option('smallbiz_rslider_effect') == 'sliceDown'){echo 'selected';}?>>Slice Down</option>
					<option value="sliceDownLeft" <?php if(get_option('smallbiz_rslider_effect') == 'sliceDownLeft'){echo 'selected';}?>>Slice Down Left</option>
					<option value="sliceUp" <?php if(get_option('smallbiz_rslider_effect') == 'sliceUp'){echo 'selected';}?>>Slice Up</option>
					<option value="sliceUpLeft" <?php if(get_option('smallbiz_rslider_effect') == 'sliceUpLeft'){echo 'selected';}?>>Slice Up Left</option>
					<option value="sliceUpDown" <?php if(get_option('smallbiz_rslider_effect') == 'sliceUpDown'){echo 'selected';}?>>Slice Up Down</option>
					<option value="sliceUpDownLeft" <?php if(get_option('smallbiz_rslider_effect') == 'sliceUpDownLeft'){echo 'selected';}?>>Slice Up Down Left</option>
					<option value="boxRandom" id="boxrslider_effect" <?php if(get_option('smallbiz_rslider_effect') == 'boxRandom'){echo 'selected';}?>>Box Random</option>
					<option value="boxRain" id="boxrslider_effect" <?php if(get_option('smallbiz_rslider_effect') == 'boxRain'){echo 'selected';}?>>Box Rain</option>
					<option value="boxRainReverse" id="boxrslider_effect" <?php if(get_option('smallbiz_rslider_effect') == 'boxRainReverse'){echo 'selected';}?>>Box Rain Reverse</option>
					<option value="boxRainGrow" id="boxrslider_effect" <?php if(get_option('smallbiz_rslider_effect') == 'boxRainGrow'){echo 'selected';}?>>Box Rain Grow</option>
					<option value="boxRainGrowReverse" id="boxrslider_effect" 
					<?php if(get_option('smallbiz_rslider_effect') == 'boxRainGrowReverse'){echo 'selected';}?>> Box Rain Grow Reverse</option>
			</select>
			</label>
			

			
<p>Set your Slide Transition Effect Speed (The time is in miliseconds 1000 = 1 second | 2000 = 2 seconds etc..)</p>

<input style="width:100px" type="text" name="rslider_animSpeed" value="<?php echo get_option("smallbiz_rslider_animSpeed")?>" /></p>


<p>Set your Slide Pause Time until the next Slide is loaded (The time is in miliseconds 1000 = 1 second | 2000 = 2 seconds etc..)</p>

<input style="width:100px" type="text" name="rslider_pauseTime" value="<?php echo get_option("smallbiz_rslider_pauseTime")?>" /></p>

<p>Advanced User Option: Set your Slide Width in Pixel | Please upload images sized according to your new Slide Width. The height will scale automatically.</p>

<input style="width:100px" type="text" name="rslider_slidewidth" value="<?php echo get_option("smallbiz_rslider_slidewidth")?>" /> (Leave at 320 if in doubt)</p>

               <br />
<p><input type="submit" value="Save Changes" name="sales_update" /></p>
 <br />
<p><strong>How to add your own Images to the Slider</strong></p> 
 
 <p class="userguide">1) Create 5 images (with image editing software of your choice - If you don't have image editing software - <a href="http://members.expand2web.com/userguide/free-and-online-based-image-editors/" target="_blank">look here</a>). Suggested size 320px Wide by 225px Height.</p>
<p>2) Upload your images to your <a href="<?php bloginfo('url') ?>/wp-admin/media-new.php">WordPress Media Library</a>.</p>
<p>3) Copy the image URL(s) generated by the Media Library into the field(s) below.</p>
<p>4) You can link each image to a page or any URL you want. Links must start with <em>http://</em> or <em>https://</em>. Leave field blank if you do not want to link the image.  </p>

<br />

<p>Image URL 1:<br /> <input style="width:600px" type="text" name="rslider_imgs1" value="<?php echo get_option("smallbiz_rslider_imgs1")?>" /></p>

<p>Optional: Link Image 1 to the following page...<br /> <input style="width:400px" type="text" name="rslider_lks1" value="<?php echo get_option("smallbiz_rslider_lks1")?>" /></p>

<br />

<p>Image URL 2:<br /> <input style="width:600px" type="text" name="rslider_imgs2" value="<?php echo get_option("smallbiz_rslider_imgs2")?>" /></p>

<p>Optional: Link Image 2 to the following page...<br /> <input style="width:400px" type="text" name="rslider_lks2" value="<?php echo get_option("smallbiz_rslider_lks2")?>" /></p>

<br />

<p>Image URL 3:<br /> <input style="width:600px" type="text" name="rslider_imgs3" value="<?php echo get_option("smallbiz_rslider_imgs3")?>" /></p>

<p>Optional: Link Image 3 to the following page...<br /> <input style="width:400px" type="text" name="rslider_lks3" value="<?php echo get_option("smallbiz_rslider_lks3")?>" /></p>

<br />

<p>Image URL 4:<br /> <input style="width:600px" type="text" name="rslider_imgs4" value="<?php echo get_option("smallbiz_rslider_imgs4")?>" /></p>

<p>Optional: Link Image 4 to the following page...<br /> <input style="width:400px" type="text" name="rslider_lks4" value="<?php echo get_option("smallbiz_rslider_lks4")?>" /></p>

<br />

<p>Image URL 5:<br /> <input style="width:600px" type="text" name="rslider_imgs5" value="<?php echo get_option("smallbiz_rslider_imgs5")?>" /></p>

<p>Optional: Link Image 5 to the following page...<br /> <input style="width:400px" type="text" name="rslider_lks5" value="<?php echo get_option("smallbiz_rslider_lks5")?>" /></p>

<br />

<p><em>We restricted the rslider to 5 images to keep your page load times fast. Google does check for it.</em></p>
 

               <br />
<p><input type="submit" value="Save Changes" name="sales_update" /></p>
    
</div> <!--mainpagetext-->
</div> <!--outerbox-->      

<div id="outerbox">             
<h6>Bottom Row Box 1</h6>
<div id="mainpagetext">

            <?php echo tinyMCE_HTMLarea('rotator_box1',get_option("smallbiz_rotator_box1")); ?>
            

            <?php

            $pages = $wpdb->get_results('select * from '. $wpdb->prefix .'posts where post_type="page" and post_status="publish"');

            ?>
            
               <br />
               
                     <p class="userguide"><strong>Visit the SmallBiz User Guide Post <a href="http://members.expand2web.com/userguide/adding-images-to-the-4-bottom-boxes/" target="_blank">on how to add your own image</a> to all text boxes.</strong> </p>
               <p>We strongly recommend to resize your images before uploading. Suggested size: 188px by 135px.</p>
               <p>The Theme will attempt to resize your images for you to a width of 188px. The image aspect ratio (width to height) will be maintained. However the quality may degrade. </p>
               
               <br />
	 <p><input type="submit" value="Save Changes" name="sales_update" /></p>
            
</div> <!--mainpagetext-->
<div id="protip">
<p>ProTip: For a fast loading page - resize your images to 188px width before uploading.</p>
</div>
</div> <!--outerbox-->
            
            
<div id="outerbox">             
<h6>Bottom Row Box 2</h6>
<div id="mainpagetext">

            <?php echo tinyMCE_HTMLarea('rotator_box2',get_option("smallbiz_rotator_box2")); ?>
            

            <?php

            $pages = $wpdb->get_results('select * from '. $wpdb->prefix .'posts where post_type="page" and post_status="publish"');

            ?>
            
               <br />
	 <p><input type="submit" value="Save Changes" name="sales_update" /></p>
            
</div> <!--mainpagetext-->
<div id="protip">
<p>ProTip: Need Bigger Boxes or want a different Box Background Colors? <a href="http://members.expand2web.com/userguide/changing-the-background-color-height-width-of-the-4-boxes/" target="_blank">Read the User Guide Post here</a>.</p>
</div>
</div> <!--outerbox-->
            
<div id="outerbox">             
<h6>Bottom Row Box 3</h6>
<div id="mainpagetext">

            <?php echo tinyMCE_HTMLarea('rotator_box3',get_option("smallbiz_rotator_box3")); ?>
            

            <?php

            $pages = $wpdb->get_results('select * from '. $wpdb->prefix .'posts where post_type="page" and post_status="publish"');

            ?>
            
               <br />
	 <p><input type="submit" value="Save Changes" name="sales_update" /></p>
            
</div> <!--mainpagetext-->
<div id="protip">
<p>ProTip: Change or remove the blue Divider line above the 4 boxes. <a href="http://members.expand2web.com/userguide/changing-the-blue-devider-line/" target="_blank">Here is how to</a>.</p>
</div>
</div> <!--outerbox-->
            
            

<div id="outerbox">             
<h6>Bottom Row Box 4</h6>
<div id="mainpagetext">

            <?php echo tinyMCE_HTMLarea('rotator_box4',get_option("smallbiz_rotator_box4")); ?>
            

            <?php

            $pages = $wpdb->get_results('select * from '. $wpdb->prefix .'posts where post_type="page" and post_status="publish"');

            ?>
            
               <br />
	 <p><input type="submit" value="Save Changes" name="sales_update" /></p>
            
</div> <!--mainpagetext-->      
<div id="protip">
<p>ProTip: Use an Image for Google maps and link to your Find Us Page. <a href="http://members.expand2web.com/userguide/adding-google-maps-to-homepage//" target="_blank">Read the tip here.</a>.</p>
</div>
</div> <!--outerbox-->
<?php } ?>
