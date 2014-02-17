<?php
/*------------------------------------------------------------------------
# Aliweb News V1.0 Septiembre 2013
# ------------------------------------------------------------------------
# Template Name: Staff 
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
		<h1 id="Page-title">Nuestro Staff</h1>
		<div id="Page-content">
		<?php 
		global $wpdb;
		$query=$wpdb->prepare("SELECT s.scl_name AS Persona, p.sch_name AS Cargo FROM wp_an_staff_list as s INNER JOIN wp_an_staff_schema AS p ON s.scl_sch_id=p.sch_id WHERE s.scl_estado=%d ORDER BY p.sch_id ASC, p.sch_prioridad ASC, s.scl_id ASC",1);
		$staffs=$wpdb->get_results($query);
		if($wpdb->num_rows!=0) 
		{
			$cargo="";
			foreach($staffs as $staff)
			{
				if(($cargo=="")||($cargo!=$staff->Cargo)) 
				{
					$cargo=$staff->Cargo;
					?>
					<h2 class="Staff-Cargo"><?=$staff->Cargo?></h2>
					<?php
				}
				?>
				<p class="Staff-Persona"><?=$staff->Persona?></p>
				<?php
			}
		}
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