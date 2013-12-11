<?php

/**

 * Renders each page's content; included in page.php's while loop.

 *

 * @package WordPress

 * @subpackage Expand2Web SmallBiz

 * @since Expand2Web SmallBiz 3.3

 */ 

?>

  <div id="post-<?php the_ID(); ?>" class="post <?php echo $pageClass;?>post">

		<?php

 if (is_singular()) {  

		        the_title('<h2 class="entry-title">','</h2>');

		    } else { /* More than one item, so show links. */

		        the_title('<h2 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">', '</a></h2>');

		    }

		?>

		<div class="entry">

		    <?php global $more; $more = false; /* For any-page as homepage on older wordpress versions. */ ?>

			<?php the_content('...Continue Reading'); ?>

			<?php $more = true; ?>

			<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

		</div>



	  </div>

