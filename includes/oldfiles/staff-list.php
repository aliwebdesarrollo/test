<?php
	//Pagina Principal del Listado de Staffs
	function staff_list()
	{
		global $wpdb;
		?>
		<div class="wrap staff-wrap">
			<div id="icon-tools" class="icon32"></div>
			<h2>Staff - Listado del Staff</h2>
			<div class="clear"></div>
			<div id="staffs-details">
		<?php
		$Staff_total=$wpdb->get_results("SELECT count(*) as Total FROM wp_an_staff_list");
		$Staffs_sql="SELECT s.sch_id as CId, s.sch_name AS Cargo, p.scl_estado AS Estado , p.scl_name AS Name, p.scl_id as id FROM wp_an_staff_list as p INNER JOIN wp_an_staff_schema as s ON p.scl_sch_id=s.sch_id ORDER BY scl_id ASC";
		$Staffs=$wpdb->get_results($Staffs_sql);
		if($wpdb->num_rows != 0) 
		{
			$j=0;
			foreach($Staffs as $staff)
			{
				?>
					<div class="staff-detail-line" id="detail-line-<?=bin2hex($staff->id);?>">
						<p class="staff-name staff-line">
							<span>Nombre: </span>
							<?=$staff->Name?>
						</p>
						<p class="staff-niv staff-line">
							<span>Cargo: </span>
							<?=$staff->Cargo?>
						</p>
						<p class="staff-est staff-line">
							<span>Estado: </span>
							<?=($staff->Estado==1)?"Habilitado":"Deshabilitado";?>
						</p>	
						<a class="Staff-edit-icon" title="Editar Cargo" rel-id="<?=bin2hex($staff->id)?>" rel-name="<?=$staff->Name?>" rel-cargo="<?=$staff->CId?>" rel-status="<?=$staff->Estado?>"></a>
					</div>
				<?php
				$j++;
			}
			if($j==0) 
			{
				?>
					<div id="staff-empty">
						<p>Todavia no ha sido cargado ningun Staff</p>
					</div>
				<?php
			}
		}else 
		{
			?>
					<div id="staff-empty">
						<p>Todavia no ha sido cargado ningun Staff</p>
					</div>
			<?php
		}
		?>
			</div>
			<div class="clear"></div>
			<div id="cnt-buttons">
				<a class="staff-button button-Skyblue-add " id="staff-add-new">Agregar Staff</a>	
			</div>
		</div>
		<?php
	}
	
	add_action('wp_ajax_RefreshStaff', 'refresh_staff');
	add_action('wp_ajax_nopriv_RefreshStaff', 'refresh_staff');
	//Actualizo en la pantalla el nuevo cargo agregado.
	function refresh_staff()
	{
		$estado=($_POST['estado']==1)?"Habilitado":"Deshabilitado";
		global $wpdb;
		$id=pack("H*",$_POST['id']);
		$query=$wpdb->prepare("SELECT s.scl_id AS ID, p.sch_name AS Cargo FROM wp_an_staff_list AS s INNER JOIN wp_an_staff_schema AS p ON s.scl_sch_id=p.sch_id WHERE scl_id=%d",$id);
		$Staffs=$wpdb->get_results($query);
		if ( $Staffs!=false ) 
		{
			$response=array("request"=>"success","cargo"=>$Staffs[0]->Cargo,"id"=>bin2hex($Staffs[0]->ID),"estado"=>$estado);
		}else 
		{
			$response=array("request"=>"error","error"=>"Staff - Cargo / Nombre Invalido");
		}
		$response=json_encode($response);
		print ($response);
		die();
	}
?>