    <div class="single_sidebar">
    
      <?php
      $args = array(
//                   'category_name' => 'featured small',
                   'post_type' => 'post',
                  		   'orderby' => 'rand', 
				'posts_per_page' => 6,		
                   'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1),
                   );
      query_posts($args);
      $x = 0;
      while (have_posts()) : the_post(); ?>    
      
      <?php if($x % 2 == 0) { ?>
        <div class="recent_box">
      <?php } else { ?>
        <div class="recent_box recent_right">
      <?php } ?>
        
        <a href="<?php the_permalink(); ?>"class="img_hover_trans"><?php the_post_thumbnail('recent-sidebar'); ?></a>
        
        
        </div><!--//recent_box-->
        
        <?php if($x % 2 == 1) { ?>
          <div class="clear"></div>
        <?php } ?>
        <?php $x++; ?>
      
      <?php endwhile; ?>      
    
    </div><!--//single_sidebar-->