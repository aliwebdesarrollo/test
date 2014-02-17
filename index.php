<?php 
/*------------------------------------------------------------------------
# Aliweb Responsive V1.0 Febrero 2014
# ------------------------------------------------------------------------
# Copyright (C) 2013 Aliweb Desarrollo. All Rights Reserved.
# @licencia - Aliweb Responsive Theme esta protegida bajo los terminos de las licencias GNU General Public License.
# Autor: http://www.aliweb.com.ar - Juan Manuel PiÃ±eiro
-------------------------------------------------------------------------*/
get_header();
//Inicializacion de Vector para ir excluyendo noticias a medida que se van mostrando en otras categorias
$_SESSION['exclude']=array();
?>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<?php

//Inicio Noticia Destacada
//Valores de seteo de filtro de noticias
$args = array('post_type' => 'post', 'showposts' => 1, 'tax_query' => array(
			array('taxonomy' => 'display','field' => 'slug','terms' => 'destacada')));

$query = new WP_Query( $args );

if ($query->have_posts()) : $query->the_post();
	//Agrego al vector el ID de la noticia 
	array_push($_SESSION['exclude'],$post->ID);
	//Tamaño columna 50% destacada
	get_template_part("col","lg-6-dest");
endif;
unset($query);
//Fin Noticia Destacada


//Inicio Noticias Secundarias
//Valores de seteo de filtro de noticias
$args=array('post_type' => 'post','showposts' => 2,'tax_query' => array(
			array('taxonomy' => 'display','field' => 'slug','terms' => 'secundaria')),
		'post__not_in' => $_SESSION['exclude']);
	
$query = new WP_Query( $args );
if($query->have_posts()): 
	while ($query->have_posts()) : $query->the_post();
		array_push($_SESSION['exclude'],$post->ID);
		get_template_part("col","lg-3");
	endwhile;
endif;
unset($query);
//Fin Noticias Secundarias
?>

	</div>
	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	
<?php
//Inicio Noticias Generales
//Valores de seteo de filtro de noticias
$args=array('post_type' => 'post','showposts' => 3,'tax_query' => array(
			array('taxonomy' => 'display','field' => 'slug','terms' => 'titular-1')),
		'post__not_in' => $_SESSION['exclude']);
$query = new WP_Query( $args );
if($query->have_posts()): 
	while (($query->have_posts()) && ($query->current_post < 2)) : $query->the_post();
		array_push($_SESSION['exclude'],$post->ID);
		get_template_part("col","lg-4");
	endwhile;
endif;
//Separar titular en titular-1 y titular-2
?>

	</div>
	<div class="clearfix"></div>
	
	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-secs">
<?php

//Valores de seteo de filtro de noticias
$args=array('post_type' => 'post','showposts' => 4,'tax_query' => array(
			array('taxonomy' => 'display','field' => 'slug','terms' => 'titular-2')),
		'post__not_in' => $_SESSION['exclude']);
$query = new WP_Query( $args );
if($query->have_posts()): 
	while ($query->have_posts()) : $query->the_post();
		array_push($_SESSION['exclude'],$post->ID);
		get_template_part("col","lg-6");
	endwhile;
endif;
unset($query);
//Fin Noticias Generales

//Inicio de Secciones
$Secciones=get_terms(array("display"),array('name__like'    => "seccion"));
foreach($Secciones as $sec)
{
?>
		<hr></hr>
		<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 col-section">
			<div class="panel-section<?php (($sec_color=get_option('alr_color_'.$sec->term_id, false))!=false)? print(' bgc-'.$sec_color['color']):''?>"><h3 class="panel-title"><?php echo $sec->description;?></h3>	</div>	
<?php
$args=array('post_type' => 'post','showposts' => 3,'tax_query' => array(
			array('taxonomy' => 'display','field' => 'slug','terms' => $sec->slug)),
		'post__not_in' => $_SESSION['exclude']);
$query = new WP_Query( $args );

if($query->have_posts()): 
	while ($query->have_posts()) : $query->the_post();
		array_push($_SESSION['exclude'],$post->ID);
		if($query->current_post==0)
		{ get_template_part("col","lg-12");
		}else {
		get_template_part("col","lg-6");}
	endwhile;
endif;
?>
		</div>
<?php
}
?>
	</div>
	<?php
//Inicio Barra Lateral
	get_template_part("sidebar","");
//Fin Barra Lateral
?>

	<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
<?php
$args=array('post_type' => 'post','showposts' => 4,'tax_query' => array(
			array('taxonomy' => 'display','field' => 'slug','terms' => 'titular-3')),
		'post__not_in' => $_SESSION['exclude']);
$query = new WP_Query( $args );

if($query->have_posts()): 
	while ($query->have_posts()) : $query->the_post();
		array_push($_SESSION['exclude'],$post->ID);
		get_template_part("col","lg-3");
	endwhile;
endif;
?>
	</div>
	<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
<?php
$args=array('post_type' => 'post','showposts' => 2,'tax_query' => array(
	array('taxonomy' => 'display','field' => 'slug','terms' => 'nota-final')),
	'post__not_in' => $_SESSION['exclude']);
$query = new WP_Query( $args );

if($query->have_posts()): 
	while ($query->have_posts()) : $query->the_post();
		array_push($_SESSION['exclude'],$post->ID);
		get_template_part("col","lg-3");
	endwhile;
endif;

$args=array('post_type' => 'post','showposts' => 1,'tax_query' => array(
	array('taxonomy' => 'display','field' => 'slug','terms' => 'diosa')),
	'post__not_in' => $_SESSION['exclude']);
$query = new WP_Query( $args );

if($query->have_posts()): 
	while ($query->have_posts()) : $query->the_post();
		array_push($_SESSION['exclude'],$post->ID);
		get_template_part("col","lg-12-diosa");
	endwhile;
endif;
?>
	</div>

<?php get_footer();?>