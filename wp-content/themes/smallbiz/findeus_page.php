<?php
/*
Template Name: Find Us Page
*/
if (is_front_page() && (get_option('smallbiz_mobile-layout-enabled') && $GLOBALS["smartphone"])){
    include("page.php");
} else { 
?>

<?php get_header(); ?>
<div class="post" id="post-<?php the_ID(); ?>">

<div class="entry">

<div class="smallbiz_maptitle">
<h2>Directions to <?php echo biz_option('smallbiz_name');?></h2>
</div>

<div class="smallbiz_map">
<?php echo biz_option('smallbiz_map_link');?>
</div>
				
<div class="smallbiz_localphone">
<h4>Call Us Now: <?php echo biz_option('smallbiz_telephone');?></h4>
</div>

<div class="smallbiz_localdirections">
<h4>Local directions:</h4>
<p><?php echo biz_option('smallbiz_directions');?></p>	
</div>

<div class="smallbiz_bhours">
<h4>Business Hours</h4>		
<table class="smallbiz_hours">
<?php
$b_hours = explode(',', biz_option('smallbiz_business_hours'));
?>
	<tr class="even"><td>Mon</td><td><?php echo $b_hours[0]?></td><td><?php echo $b_hours[1]?></td></tr>
	<tr class="odd"><td>Tues</td><td><?php echo $b_hours[2]?></td><td><?php echo $b_hours[3]?></td></tr>
	<tr class="even"><td>Wed</td><td><?php echo $b_hours[4]?></td><td><?php echo $b_hours[5]?></td></tr>
	<tr class="odd"><td>Thu</td><td><?php echo $b_hours[6]?></td><td><?php echo $b_hours[7]?></td></tr>
	<tr class="even"><td>Fri</td><td><?php echo $b_hours[8]?></td><td><?php echo $b_hours[9]?></td></tr>
	<tr class="odd"><td>Sat</td><td><?php echo $b_hours[10]?></td><td><?php echo $b_hours[11]?></td></tr>
	<tr class="even"><td>Sun</td><td><?php echo $b_hours[12]?></td><td><?php echo $b_hours[13]?></td></tr>
					</table>
</div>


</div>
</div>	
		
<div style="clear: both;"></div>
		
<?php include(TEMPLATEPATH."/sidebar-findus.php");?>
<?php get_footer(); ?>
<?php } ?>
