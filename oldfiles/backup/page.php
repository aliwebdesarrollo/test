<?php
/*------------------------------------------------------------------------
# Aliweb News V1.0 Julio 2013
# ------------------------------------------------------------------------
# Copyright (C) 2013 Aliweb Desarrollo. All Rights Reserved.
# @licencia - Aliweb News Theme esta protegida bajo los terminos de las licencias GNU General Public License.
# Autor: http://www.aliweb.com.ar - Juan Manuel Piñeiro
-------------------------------------------------------------------------*/

get_header();
?>
	<h1>PRUEBA PAGE.PHP</h1>
  <!-- main body -->
  <div id="middle_single">
  
    <!-- right column -->
    <div id="right" class="clearingfix">
    
      <?php get_sidebar(); ?>
    
    </div>
    <!-- / right column -->
    
    <!-- content column -->
    <div id="main" class="clearingfix">

<?php get_template_part( 'loop', 'page' ); ?>

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
    
      <!-- news boxes -->
      <div class="news_boxes">
      
        <div class="boxes first">
<!-- Prueba juan-->
          <ul>
            <?php query_posts('showposts=1&tag=headlines'); ?>
            <?php while (have_posts()) : the_post(); ?>
            <li>
              <h5 class="category"><?php the_category(' '); ?></h5>
              <h3><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="title"><?php the_title(); ?></a></h3>
              <p><?php if(has_post_thumbnail()) { ?><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('home-thumb') ?></a><?php } ?>
              <?php $excerpt = get_the_excerpt(); echo string_limit_words($excerpt,16); ?></p>
              <div class="meta"><?php the_time('F jS, Y') ?> | <a href="<?php the_permalink() ?>">Leer más...</a></div>
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
              <div class="meta"><?php the_time('F jS, Y') ?> | <a href="<?php the_permalink() ?>">Leer más...</a></div>
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
              <div class="meta"><?php the_time('F jS, Y') ?> | <a href="<?php the_permalink() ?>">Leer más...</a></div>
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
