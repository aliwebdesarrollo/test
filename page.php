<?php
/*------------------------------------------------------------------------
# Aliweb Responsive V1.0 Febrero 2014
# ------------------------------------------------------------------------
# TemmplateName: Pagestandart
# Copyright (C) 2013 Aliweb Desarrollo. All Rights Reserved.
# @licencia - Aliweb Responsive Theme esta protegida bajo los terminos de las licencias GNU General Public License.
# Autor: http://www.aliweb.com.ar - Juan Manuel Piñeiro
-------------------------------------------------------------------------*/
if(is_page()) 
{
get_header();
?>
<div id="Cnt-Page" class="">
	<div id="Page-detail">
		<?php
		get_template_part( 'loop',"page" );
		?>
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