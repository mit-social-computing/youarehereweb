</div> <!--content wrap-->
<div id="pagespace1"></div>
</div> <!--page closing-->
</div> <!--inline-->


<div style="clear: both;"></div>

<?php $hide = (biz_option('smallbiz_feature_box_disabled')); if($hide == ""){ ?>

<div id="featuredwrap">
<div id="featured">
<div id="firstfeatured">
<?php include(TEMPLATEPATH."/footer_left.php");?>
</div>
<div id="secondfeatured">
<?php include(TEMPLATEPATH."/footer_middle.php");?>
</div>
<div id="thirdfeatured">
<?php include(TEMPLATEPATH."/footer_right.php");?>
</div>
</div><!--featured-->

<?php } else { echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; /* Safari fix */} ?>

</div> <!--featuredwrap-->

<div style="clear: both;"></div>

<div id="footer">
<p class="footercenter"><?php echo biz_option('smallbiz_cities');?></p>
<p class="footercenter"><?php echo biz_option('smallbiz_credit');?></p>

<div id="footer-mobile-switch">			
<?php
$urlmd5 = md5(get_bloginfo('siteurl'));
 if(get_option('smallbiz_mobile-layout-enabled') && $_COOKIE[$urlmd5."device_type"] == "Mobile"){
 ?>          
<p>     
        View site in: 
        <<?php if($GLOBALS["smartphone"]){ echo "b"; } else { echo "a"; } ?> href="<?php echo get_bloginfo("wpurl"); ?>?ui=m">
           Mobile
        </<?php if($GLOBALS["smartphone"]){ echo "b"; } else { echo "a"; } ?>>
         |
        <<?php if(!$GLOBALS["smartphone"]){ echo "b"; } else { echo "a"; } ?> href="<?php echo get_bloginfo("wpurl"); ?>?ui=f">
           Desktop
        </<?php if(!$GLOBALS["smartphone"]){ echo "b"; } else { echo "a"; } ?>>
        
        </p> <!-- end site-ui-switch-link -->
        <?php
    }
?>
</div> <!--Footer Mobile Switch-->
</div> <!--footer-->
	
	
<?php wp_footer(); ?>

</body>
</html>