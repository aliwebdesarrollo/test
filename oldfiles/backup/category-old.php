<?php
/*------------------------------------------------------------------------
# Global News WordPress Theme v1.1 - August 2012
# ------------------------------------------------------------------------
# Copyright (C) 2008 instantShift. All Rights Reserved.
# @license - Global News WordPress Theme is available under the terms of the GNU General Public License.
# Author: http://www.rapidxhtml.com
# Websites:  http://www.instantshift.com
-------------------------------------------------------------------------*/

get_header();
?>
	<h1>PRUEBA CATEGORY.PHP</h1>
  <!-- main body -->
  <div id="PagePublicidad"></div>
  <div id="middle_single">
  
    <!-- right column -->
    <div id="right" class="clearingfix">
    
      <?php get_sidebar(); ?>
    
    </div>
    <!-- / right column -->
    
    <!-- content column -->
    <div id="main" class="clearingfix">

      <h3 class="pagetitle"><?php single_cat_title(); ?></h3>

      <?php
        $category_description = category_description();
        if ( ! empty( $category_description ) ) echo '<div class="archive-meta">' . $category_description . '</div>';
      ?>

      <div class="listposts">
        <?php
        get_template_part( 'loop', 'category' );
        ?>
      </div>

    </div>
    <!-- / content column -->
  
  </div>
  <!-- / main body -->

  <!-- main body -->
  <div id="middle_alt">
  
    <!-- right column -->
    <div id="right_alt" class="clearingfix">
    
      <!-- advert -->
      <div class="advert">
        <?php echo stripslashes(get_option('gbn_ad_300x250_footer_singlepage')); ?>
      </div>
      <!-- advert -->
    
    </div>
    <!-- / right column -->
    
    <!-- content column -->
    <div id="main_alt" class="clearingfix">
      <h1 id="UltimasNoticias">Ultimas Noticias</h1>	
      <!-- news boxes -->
      <div class="news_boxes">
      
        <div class="boxes first">
          <ul>
            <?php query_posts('showposts=1&tag=headlines'); ?>
            <?php while (have_posts()) : the_post(); ?>
            <li>
              <h5 class="category"><?php the_category(' '); ?></h5>
              <h3><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="title"><?php the_title(); ?></a></h3>
              <p><?php if(has_post_thumbnail()) { ?><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('home-thumb') ?></a><?php } ?>
              <?php $excerpt = get_the_excerpt(); echo string_limit_words($excerpt,16); ?></p>
              <div class="meta"><?php the_time('F j, Y') ?> | <a href="<?php the_permalink() ?>">Leer más...</a></div>
            </li>
            <?php endwhile; ?>
            <?php wp_reset_query(); ?>
          </ul>
        </div>
        
        <div class="boxes">
          <ul>
            <?php query_posts('showposts=1&tag=headlines&offset=1'); ?>
            <?php while (have_posts()) : the_post(); ?>
            <li>
              <h5 class="category"><?php the_category(' '); ?></h5>
              <h3><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="title"><?php the_title(); ?></a></h3>
              <p><?php if(has_post_thumbnail()) { ?><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('home-thumb') ?></a><?php } ?>
              <?php $excerpt = get_the_excerpt(); echo string_limit_words($excerpt,16); ?></p>
              <div class="meta"><?php the_time('F j, Y') ?> | <a href="<?php the_permalink() ?>">Leer más...</a></div>
            </li>
            <?php endwhile; ?>
            <?php wp_reset_query(); ?>
          </ul>
        </div>
        
        <div class="boxes">
          <ul>
            <?php query_posts('showposts=1&tag=headlines&offset=2'); ?>
            <?php while (have_posts()) : the_post(); ?>
            <li>
              <h5 class="category"><?php the_category(' '); ?></h5>
              <h3><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="title"><?php the_title(); ?></a></h3>
              <p><?php if(has_post_thumbnail()) { ?><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('home-thumb') ?></a><?php } ?>
              <?php $excerpt = get_the_excerpt(); echo string_limit_words($excerpt,16); ?></p>
              <div class="meta"><?php the_time('F j, Y') ?> | <a href="<?php the_permalink() ?>">Leer más...</a></div>
            </li>
            <?php endwhile; ?>
            <?php wp_reset_query(); ?>
          </ul>
        </div>
      
      </div>
      <!-- / news boxes -->
    
    </div>
    <!-- / content column -->
  
  </div>
  <!-- / main body -->

<?php get_footer(); ?>
