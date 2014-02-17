<?php
	add_action('wp_ajax_CargosAddCargo', 'AddNewCargo');
	add_action('wp_ajax_nopriv_CargosAddCargo', 'AddNewCargo');

	function AddNewCargo()
	{
		$name=$_POST['name'];
		$prior=intval($_POST['prior']);
		$estado=intval($_POST['estado']);
		global $wpdb;
		$wpdb->hide_errors();
		$query=$wpdb->prepare("SELECT * FROM wp_an_staff_schema WHERE sch_name LIKE %s",$name);
		$Names=$wpdb->get_results($query);
		if($wpdb->num_rows==0) 
		{
			$wpdb->flush();
			$query_ins=$wpdb->prepare("INSERT INTO wp_an_staff_schema(sch_name, sch_prioridad, sch_estado) VALUES(%s,%d,%d);",$name, $prior, $estado);
			$res_ins=$wpdb->query($query_ins);
			if ( $res_ins==false ) 
			{
				$response=array("request"=>"error","error"=>$wpdb->last_error);
				$response=json_encode($response);
				print ($response);
			}else 
			{
				$response=array("request"=>"success");
				$response=json_encode($response);
				print ($response);
			}
		}else 
		{
			$response=array("request"=>"error","error"=>"Cargo Laboral - NOMBRE Duplicado");
			$response=json_encode($response);
			print ($response);
		}
		die();
	}	
	
	add_action('wp_ajax_CargosAdd', 'Agregar_Cargo');
	add_action('wp_ajax_nopriv_CargosAdd', 'Agregar_Cargo');

	function Agregar_Cargo()
	{
		?>
		<div id="Cnt-edit-form">
			<h2>Agregar Cargo</h2>
			<form onsubmit="return AddNewCargo();" id="FormAddNewCargo">
				<label><p>Nombre:</p><input type="text" id="nameCargo" value="" placeholder="Ingrese nuevo Cargo Laboral"></label>
				<label><p>Prioridad:</p>
					<select id="priorCargo">
				<?php
				global $wpdb;
				$Priors=$wpdb->get_results("SELECT * FROM wp_an_staff_prioridad");
				$p=1;
				foreach($Priors as $Prior)
				{
					?>
						<option value="<?=$Prior->scp_id?>"><?=$Prior->scp_name?></option>
					<?php
					$p++;
				}
				?>
					</select>
				</label>
				<label><p>Estado:</p>
					<select id="estadoCargo">
						<option value="0" selected>Deshabilitado</option>
						<option value="1" >Habilitado</option>
					</select>
				</label>
				<fieldset>
					<a class="staff-button button-Skyblue-save" onclick="jQuery('#FormAddNewCargo').submit()">Agregar</a>
					<a class="staff-button button-Skyblue-cancel" id="Cancel-Edit">Cancelar</a>
				</fieldset>
			</form>
		</div>
		<?php
		die();
	}
?>