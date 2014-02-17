<?php
	add_action('wp_ajax_StaffsAddStaff', 'AddNewStaff');
	add_action('wp_ajax_nopriv_StaffsAddStaff', 'AddNewStaff');

	function AddNewStaff()
	{
		$name=$_POST['name'];
		$cargo=intval($_POST['cargo']);
		$estado=intval($_POST['estado']);
		global $wpdb;
		$wpdb->hide_errors();
		$query_ins=$wpdb->prepare("INSERT INTO wp_an_staff_list(scl_name, scl_sch_id, scl_estado) VALUES(%s,%d,%d)",$name,$cargo,$estado);
		$res_ins=$wpdb->query($query_ins);
		if ( $res_ins==false ) 
		{
			$response=array("request"=>"error","error"=>$wpdb->last_error);
			$response=json_encode($response);
			print ($response);
		}else 
		{
			$response=array("request"=>"success","lastid"=>bin2hex($wpdb->insert_id));
			$response=json_encode($response);
			print ($response);
		}
		die();
	}	
	
	
	add_action('wp_ajax_StaffsAdd', 'Agregar_Staff');
	add_action('wp_ajax_nopriv_StaffsAdd', 'Agregar_Staff');

	function Agregar_Staff()
	{
		?>
		<div id="Cnt-edit-form">
			<h2>Agregar Staff</h2>
			<form onsubmit="return AddNewStaff();" id="FormAddNewStaff">
				<label><p>Nombre:</p><input type="text" id="nameStaff" value="" placeholder="Ingrese nombre Staff"></label>
				<label><p>Cargo:</p>
					<select id="cargoStaff">
				<?php
				global $wpdb;
				$Cargos=$wpdb->get_results("SELECT * FROM wp_an_staff_schema WHERE sch_estado=1");
				$p=1;
				foreach($Cargos as $cargo)
				{
					?>
						<option value="<?=$cargo->sch_id?>" <?=($cargo->sch_id==$_POST['cargo'])?"selected":"";?>><?=$cargo->sch_name?></option>
					<?php
					$p++;
				}
				?>
					</select>
				</label>
				<label><p>Estado:</p>
					<select id="estadoStaff">
						<option value="0" selected>Deshabilitado</option>
						<option value="1" >Habilitado</option>
					</select>
				</label>
				<fieldset>
					<a class="staff-button button-Skyblue-save" onclick="jQuery('#FormAddNewStaff').submit()">Agregar</a>
					<a class="staff-button button-Skyblue-cancel" id="Cancel-Edit">Cancelar</a>
				</fieldset>
			</form>
		</div>
		<?php
		die();
	}
?>