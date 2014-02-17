<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<h1>PRUEBA LOOP-PAGE.PHP</h1>
      <div class="post" id="post-<?php the_ID(); ?>">
        <h1><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
        <?php if(has_post_thumbnail()) { ?><div class="post_image"><a href="<?php echo get_post_meta($post->ID, "thumb", $single = true); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('single') ?></a></div><?php } ?>
        <div class="post_entry"><?php the_content(''); ?></div>
        <?php the_tags( '<div class="tags"><span>Tags:</span> ', ', ', '</div>'); ?>
        <div id="comments"><?php comments_template(); ?></div>
      </div>

<?php endwhile; ?>