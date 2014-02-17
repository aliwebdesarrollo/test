<?php	
	
	add_action('wp_ajax_RefreshSchema', 'refresh_schema');
	add_action('wp_ajax_nopriv_RefreshSchema', 'refresh_schema');
	//Actualizo en la pantalla el nuevo cargo agregado.
	function refresh_schema()
	{
		$estado=($_POST['estado']==1)?"Habilitado":"Deshabilitado";
		global $wpdb;
		$query=$wpdb->prepare("SELECT s.sch_id AS ID, p.scp_name AS Prior FROM wp_an_staff_schema AS s INNER JOIN wp_an_staff_prioridad AS p ON s.sch_prioridad=p.scp_id WHERE sch_name LIKE %s ORDER BY s.sch_id DESC LIMIT 1",$_POST['name']);
		$Schemas=$wpdb->get_results($query);
		if ( $Schemas!=false ) 
		{
			$response=array("request"=>"success","prior"=>$Schemas[0]->Prior,"id"=>bin2hex($Schemas[0]->ID),"estado"=>$estado);
		}else 
		{
			$response=array("request"=>"error","error"=>"Cargo Laboral - Prioridad Invalida".$wpdb->last_query);
		}
		$response=json_encode($response);
		print ($response);
		die();
	}
	
	/*Puesto del Staff - Agregar, Editar*/
	function staff_schema() 
	{	
		global $wpdb;
		?>
		<div class="wrap staff-wrap">
			<div id="icon-tools" class="icon32"></div>
			<h2>Staff - Cargos Laborales</h2>
			<div class="clear"></div>
			<div id="cargos-details">
		<?php
		$Cargos_total=$wpdb->get_results("SELECT count(*) as Total FROM wp_an_staff_schema");
		if($Cargos_total[0]->Total != 0) 
		{
			$Cargos=$wpdb->get_results("SELECT s.sch_id as id, s.sch_name AS Name, s.sch_estado AS Estado , p.scp_name AS Prior, p.scp_id as PId FROM wp_an_staff_schema as s INNER JOIN wp_an_staff_prioridad as p ON s.sch_prioridad=p.scp_id ORDER BY sch_id ASC");
			$j=0;
			foreach($Cargos as $cargo)
			{
				?>
					<div class="cargo-detail-line" id="detail-line-<?=bin2hex($cargo->id);?>">
						<p class="cargo-name cargo-line">
							<span>Nombre: </span>
							<?=$cargo->Name?>
						</p>
						<p class="cargo-niv cargo-line">
							<span>Prioridad: </span>
							<?=$cargo->Prior?>
						</p>
						<p class="cargo-est cargo-line">
							<span>Estado: </span>
							<?=($cargo->Estado==1)?"Habilitado":"Deshabilitado";?>
						</p>	
						<a class="Staff-cargo-edit-icon" title="Editar Cargo" rel-id="<?=bin2hex($cargo->id)?>" rel-name="<?=$cargo->Name?>" rel-prior="<?=$cargo->PId?>" rel-status="<?=$cargo->Estado?>"></a>
					</div>
				<?php
				$j++;
			}
			if($j==0) 
			{
				?>
					<div id="cargo-empty">
						<p>No hay ningun Cargo Laboral cargado aun</p>
					</div>
				<?php
			}
		}else 
		{
			?>
					<div id="cargo-empty">
						<p>No hay ningun Cargo Laboral cargado aun</p>
					</div>
			<?php
		}
		?>
			</div>
			<div class="clear"></div>
			<div id="cnt-buttons">
				<a class="staff-button button-Skyblue-add " id="staff-cargo-add-new">Agregar Cargo</a>	
			</div>
		</div>
		<?php
	}
?>