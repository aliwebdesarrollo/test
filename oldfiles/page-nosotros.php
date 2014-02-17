<?php
/*------------------------------------------------------------------------
# Aliweb News V1.0 Septiembre 2013
# ------------------------------------------------------------------------
# Template Name: Nosotros 
# Copyright (C) 2013 Aliweb Desarrollo. All Rights Reserved.
# @licencia - Aliweb News Theme esta protegida bajo los terminos de las licencias GNU General Public License.
# Autor: http://www.aliweb.com.ar - Juan Manuel Piñeiro
-------------------------------------------------------------------------*/
if(is_page()) 
{
get_header();
?>
<div id="Cnt-Page" class="">
	<div id="Page-detail">
		<?php if (have_posts()) : while (have_posts()) : the_post();?>
		<h1 id="Page-title"><?=get_the_title()?></h1>
		<div id="Page-content">
		<?php 
		$content=get_the_content();
		$content=nl2br($content);
		echo $content;
		?>
		</div>
		<?php endwhile; endif; ?>
	</div>	
</div>
<div id="Sidebar">

	<?php
		get_template_part( 'sidebar',"page" );
		
	?>
</div>
<?php 
	get_footer();
}else 
{
	header("LOCATION:".home_url());
}	 

?>