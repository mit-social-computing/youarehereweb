<?php get_header(); ?>    
  
  <div id="featured_home_top">
  

   
    
  </div><!--//featured_home_top-->
  
  <div id="content">


<?php
      $args = array(
                   'category_name' => 'featured small',
                   'post_type' => 'post',
                   'posts_per_page' => 18,
                   'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1),
                   );
      query_posts($args);
      $x = 0;
      while (have_posts()) : the_post(); ?>
    
        <?php if($x == 0) { ?>
        <div class="featured_box ">
        <?php } elseif($x == 5) { ?>
        <div class="featured_box ">
        <?php } else { ?>
        <div class="featured_box">
        <?php } ?>
        
          <a href="<?php the_permalink(); ?>"class="img_hover_trans"><?php the_post_thumbnail('featured-small'); ?></a>
          <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
         <p><?php $temp_arr_content = explode(" ",substr(strip_tags(get_the_content()),0,170)); $temp_arr_content[count($temp_arr_content)-1] = ""; $display_arr_content = implode(" ",$temp_arr_content); echo $display_arr_content; ?><?php if(strlen(strip_tags(get_the_content())) > 170) echo "..."; ?></p>
       
	   
	    </div><!--//featured_box-->
        
        <?php if($x == 5) { $x=-1; ?>
        <div class="clear"></div>
        <div class="post_divider"></div>
        <?php } ?>
        
        <?php $x++; ?>
    
    <?php endwhile; ?>
    
    <div class="clear"></div>
    
    <div class="nav_container">
      <div class="left"><?php previous_posts_link('\\\ Previous') ?></div>
      <div class="right"><?php next_posts_link('Next //') ?></div>
      <?php wp_reset_query(); ?>
      <div class="clear"></div>
    </div>
    
  </div><!--//content-->
  

<?php get_sidebar(); ?>

<?php get_footer(); ?>