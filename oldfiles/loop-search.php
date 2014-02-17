<?php 
if(is_search()) 
{ 
	if ( have_posts() ) :
		global $query_string;
		query_posts( $query_string . '&posts_per_page=15' );
		get_search_form(); 
		while ( have_posts() ) : the_post(); 
			$image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'headlines' ); 
			?>
	<div class="NArticle" lang="es">
		<a href="<?php the_permalink() ?>" rel="bookmark" class="NArt-Title"><?php the_title(); ?></a>
			<?php 
			if(has_post_thumbnail()) 
			{
				$uploaddir=wp_upload_dir();
				$image_link = wp_get_attachment_image_src( get_post_thumbnail_id(),'large');
				$image = wp_get_attachment_metadata(get_post_thumbnail_id());
				if(isset($image['sizes']['headlines'])) 
				{			
					$image_url=$uploaddir['basedir']."/{$image['sizes']['headlines']['file']}";
				}elseif(isset($image['file'])) 
				{
					$image_url=$uploaddir['basedir']."/{$image['file']}";
				}
				if(file_exists($image_url)) 
				{
					$attr = array(
					'title'	=> get_the_title(),
					'class' => "NArt-img"
					);
					?>
					<a href="<?php the_permalink() ?>">
					<?php
					the_post_thumbnail('headlines',$attr);
					?>
					</a>
					<?php
				}else 
				{
					?>
			<a href="<?php the_permalink() ?>">
				<img src="<?=get_template_directory_uri().'/images/logo-200x120.png'?>" alt="" class="NArt-img">
			</a>
					<?php
				}
			}else 
			{
				?>
			<a href="<?php the_permalink() ?>">
				<img src="<?=get_template_directory_uri().'/images/logo-200x120.png'?>" alt="" class="NArt-img">
			</a>
				<?php
			}
			$excerpt = get_the_excerpt();
		?>
		<p class="NArt-Copete"><?php echo string_limit_words($excerpt,40);?></p>
	</div>
      <?php endwhile; ?>
	<div class="pagination">
	<?php
	global $wp_query; 
	$big = 999999999;
	echo paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'mid_size' => '10',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $wp_query->max_num_pages,
		'prev_next'    => true,
		'prev_text'    => __('&laquo; Anterior'),
		'next_text'    => __('Siguiente &raquo;'),
		'type'         => 'plain',
	) );
	?>
	</div>
	<?php
	else:
	?>
	<div id="Sch-not-found">
		<h3 id="Sch-nf-title"><?php _e( 'No se encuentran noticias con el criterio de busqueda ingresado.', 'aliwebnews' ); ?></h3>
      <?php get_search_form(); ?>
  </div>
	<?php
	endif;
}
?>