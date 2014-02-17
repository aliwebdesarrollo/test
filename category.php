<?php
/*------------------------------------------------------------------------
# Aliweb Responsive V1.0 Febrero 2014
# ------------------------------------------------------------------------
# Copyright (C) 2013 Aliweb Desarrollo. All Rights Reserved.
# @licencia - Aliweb Responsive Theme esta protegida bajo los terminos de las licencias GNU General Public License.
# Autor: http://www.aliweb.com.ar - Juan Manuel Piñeiro
-------------------------------------------------------------------------*/
get_header();
if ( ! have_posts() ){?>
<div class="col-lg-9 col-md-9 col-xs-12 col-sm-12" id="tree-main">
	<?php get_search_form();?>
</div>
<?php 
	get_template_part("sidebar","tag");
}else {?>
<div class="col-lg-9 col-md-9 col-xs-12 col-sm-12" id="tree-main">
	<?php	if(is_archive() || is_category() || is_author()) 
	{
	//Inicio
	$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
	$args=array('post_type' => 'post','posts_per_page' => 16,'cat' => $cat, 'paged' => $paged);
	$query = new WP_Query( $args );
	if($query->have_posts()): 
		while ($query->have_posts()) : $query->the_post();
			if($query->current_post==0)
			{ get_template_part("col","lg-12");
			}else {
				if($query->current_post==1){ echo "<div class='col-lg-12 col-md-12 col-xs-12 col-sm-12' id='art-tree'>"; }
				get_template_part("loop","category");
				if($query->current_post== ($query->post_count - 1) ){ echo "</div>"; } }
		endwhile;
	endif;
	}
 
	?>
</div>
<?php
	get_template_part( 'sidebar',"category" );
?>
<?php
	$big = 999999999;
	$pagination=paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'mid_size' => '5',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $query->max_num_pages,
		'prev_next'    => true,
		'prev_text'    => __('&laquo;'),
		'next_text'    => __('&raquo;'),
		'type'         => 'array',
	) );
	if(!is_null($pagination)){?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">	
	<ul class="pagination">
	<?php
	foreach($pagination as $page){?>
		<li <?php (strpos($page,"current")!=false)? print("class='active'"):""; ?>><?php echo $page?></li>
	<?php	} ?>
	</ul>
</div>
	<?php } ?>
<?php } ?>
<?php get_footer(); ?>