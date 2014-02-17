<?php
/*------------------------------------------------------------------------
# Aliweb News V1.0 Septiembre 2013
# ------------------------------------------------------------------------
# Copyright (C) 2013 Aliweb Desarrollo. All Rights Reserved.
# @licencia - Aliweb News Theme esta protegida bajo los terminos de las licencias GNU General Public License.
# Autor: http://www.aliweb.com.ar - Aliweb Desarrollo
-------------------------------------------------------------------------*/
if(get_post_type( get_the_ID() )==="post") 
{
get_header();
?>
	<div id="Cnt-Single" class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
		<div id="Single-info">
			<div class="col-xs-10">
		<?php $category=get_the_category($post->ID);
		alr_category_tree($category[0]->term_id);?>
			</div>
			<div class="col-xs-2 text-right">
				<span id="single-timedate"><?php the_time('j F Y') ?></span>
			</div>
		</div>
	<?php
		get_template_part( 'loop', 'single' );
	?>
	</div>
<?php
	get_template_part( 'sidebar',"single" );
?>
	<div id="single-comments" class="col-md-12 col-lg-12 col-sm-12 col-xs-12 bgc-gris-claro">
		<div id="Cnt-Single" class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
			<div class="fb-comments" color-schema="light" data-href=" <?php the_permalink(); ?>" data-num_posts="10" data-order_by="time"  style="width:100%;"></div>
		</div>
		<div id="Cnt-Single" class="col-xs-3 col-sm-3 col-md-3 col-lg-3">	
			<div id="comment-terms">
				<p>Los comentarios publicados son de exclusiva responsabilidad de sus autores. Diario EsNoticia podra eliminar e inhabilitar para volver a comentar a todas aquellas personas que sus comentarios sean considerados ofensivo y/o agresivo para con terceros. <br><strong>Enviar un comentario implica la aceptacion de estas Reglas.</strong></p>
			</div>
		</div>
	</div>
<?php 
	get_footer();
}else 
{
	header("LOCATION:".home_url());
}	 

?>