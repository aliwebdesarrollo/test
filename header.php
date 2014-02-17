<?php
/*------------------------------------------------------------------------
# Aliweb Responsive V1.0 Febrary 2014
# ------------------------------------------------------------------------
# Copyright (C) 2013 Aliweb Desarrollo. All Rights Reserved.
# @licencia - Aliweb News Theme esta protegida bajo los terminos de las licencias GNU General Public License.
# Autor: http://www.aliweb.com.ar - Aliweb Desarrollo
-------------------------------------------------------------------------*/
session_start();
$_SESSION['alr_clima_id']=(isset($_SESSION['arl_clima_id'])&&(intval($_SESSION['alr_clima_id'])>0))? $_SESSION['arl_clima_id']:16931;
setlocale(LC_ALL, 'es_ES');
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title><?php
global $page, $paged;
bloginfo( 'name' );
wp_title( '|', true, 'left' );
$site_description = get_bloginfo( 'description', 'display' );
if ( $site_description && ( is_home() || is_front_page() ) )
	echo " | $site_description";
if ( $paged >= 2 || $page >= 2 )
	echo ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );
?></title>
	<meta http-equiv="content-type" content="text/html;" >
	<meta charset="UTF-8">
	<meta name="country" content="Argentina" >
	<meta name="copyright" content="" >
	<meta name="coverage" content="Worldwide" >
	<meta name="identifier" content="http://www.diarioesnoticia.com" >
	<meta content="spanish" name="language" >
	<meta content="General" name="RATING" >
	<meta name="robots" content="index,follow" >
	<meta name="author" content="Aliweb Desarrollo" >
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/images/favicon.ico?v=20140201">
	
	<?php
if(is_single())
{
	?>
<meta property="og:url" content="<?php echo get_permalink($post->ID)?>">
<meta property="og:title" content="<?php echo htmlspecialchars($post->post_title, ENT_COMPAT, 'UTF-8');?>">
<?php
$og_image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID,'destacada'));
if(!$og_image) 
{
	$og_image[0] = get_template_directory_uri().'/images/logo-200x120.png';
}
$og_cats=get_the_category($post->ID);
$og_sections="";
foreach($og_cats as $og_cat)
{
	$og_sections.=$og_cat->cat_name;
}
$og_desc=htmlspecialchars(substr(strip_tags($post->post_content),0,200), ENT_COMPAT, 'UTF-8');
$og_desc = str_replace("\n", '', $og_desc);
$og_desc = str_replace("\r", '', $og_desc);?>
<meta property="og:image" content="<?php echo $og_image[0];?>">
<meta property="og:description" content="<?php echo $og_desc;?>">
<meta property="og:section" content="<?php echo $og_sections;?>">
<meta property="og:site_name" content="diarioesnoticia.com">
<meta property="fb:app_id" content="613008052086419">
<?php
}else if(is_home())
{
	?>
<meta property="og:url" content="diarioesnoticia.com">
<meta property="og:title" content="Diario Es Noticia">
<meta property="og:description" content=" Informacion que importa, aqui­ y ahora">
<meta property="og:image" content="<?php echo get_template_directory_uri().'/images/logo-200x120.png'?>">
<meta property="og:site_name" content="diarioesnoticia.com">
<?php
}?>

	<?php wp_head();?>
</head>
<body class="wrap">
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
  		var js, fjs = d.getElementsByTagName(s)[0];
  		if (d.getElementById(id)) return;
  		js = d.createElement(s); js.id = id;
  		js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1&appId=216971985133198";
  		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<nav class="navbar navbar-default  navbar-fixed-top navbar-collapse" role="navigation" id="top-menu-navbar">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			<?php
			wp_nav_menu( array(
				'menu'              => 'main-nav',
				'theme_location'    => 'topmenu',
				'depth'             => 2,
				'container'         => 'nav',
				'container_class'   => 'collapse navbar-collapse navbar-ex1-collapse',
				'menu_class'        => 'nav navbar-nav',
				'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
				'walker'            => new wp_bootstrap_navwalker())
			);
			?>
			</div>
		</div>
	</nav>
	<div class="container" id="main-div">
		<header class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
				<a href="<?php echo get_option('home'); ?>/">
					<img src="<?php echo get_template_directory_uri().'/images/logo-300x250.png';?>" alt="" class="pull-left img-responsive" id="logo-site">
				</a>
			</div>
			<div class="col-lg-3 col-md-3 invisible-xs invisible-sm"></div>
			<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
				<span style="font: 600 16px/2 'codelight'; text-align:center; color: #000; display:block;"><?php echo alr_get_date();?></span>
				<form role="search" method="get" id="searchform" action="<?php echo get_option('home'); ?>" >  
					<div class="col-xs-12">
						<div class="input-group">
							<input type="text" class="form-control" id="s" name="s" placeholder="Buscar&hellip;">
								<span class="input-group-btn">
									<button type="submit" class="btn btn-danger"  id="searchsubmit"><i class="fa fa-search"></i></button>
								</span>
						</div>
					</div>
				</form>
				<div id="social-container" style="text-align:center;">
					<!--<a href="" class="social-icon"><i class="fa fa-envelope"></i></a>-->
					<a href="https://www.facebook.com/DiarioEsNoticia" class="social-icon" target="_blank"><i class="fa fa-facebook"></i></a>
					<a href="https://www.twitter.com/DiarioEsNoticia" class="social-icon" target="_blank"><i class="fa fa-twitter"></i></a>
					<a href="http://www.youtube.com/user/DiarioEsNoticiaTV" class="social-icon" target="_blank"><i class="fa fa-youtube"></i></a>
				</div>
			</div>
			<div class="col-lg-1 col-md-1 invisible-xs invisible-sm"></div>
		</header>
		<div id="header-separator" class="bgc-rojo-oscuro"></div>