<?php
	add_action('wp_ajax_CargosEditCargo', 'EditCargo');
	add_action('wp_ajax_nopriv_CargosEditCargo', 'EditCargo');

	function EditCargo()
	{
		$name=$_POST['name'];
		$id=intval(pack("H*",$_POST['id']));
		$prior=(intval($_POST['prior'])>0)? ", sch_prioridad=".intval($_POST['prior']):"";;
		$estado=(intval($_POST['estado'])>0)? ", sch_estado=".intval($_POST['estado']):"";
		global $wpdb;
		$wpdb->hide_errors();
		$query=$wpdb->prepare("SELECT count(*) as Total FROM wp_an_staff_schema WHERE sch_id=%d",$id);
		$ids=$wpdb->get_results($query);
		if($wpdb->num_rows!=0) 
		{
			$wpdb->flush();
			$query2=$wpdb->prepare("SELECT count(*) as Total FROM wp_an_staff_schema WHERE sch_name LIKE %s",$name);
			$Names=$wpdb->get_results($query2);	
			if($wpdb->num_rows==0) 
			{
				$wpdb->flush();
				$query_upd=$wpdb->prepare("UPDATE wp_an_staff_schema SET sch_name='{$name}' {$prior} {$estado} WHERE sch_id=%d",$id);
				$res_upd=$wpdb->query($query_upd);
				if ( $res_upd==false ) 
				{
					$response=array("request"=>"error","error"=>"Cargo Laboral - Se produjo un error cuando se intentaba actualizar los datos");
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
		}else 
		{
			$response=array("request"=>"error","error"=>"Cargo Laboral - ID Inexistente");
			$response=json_encode($response);
			print ($response);
		}
		die();
	}		
	
	
	add_action('wp_ajax_CargosEdit', 'Edicion_de_Cargos');
	add_action('wp_ajax_nopriv_CargosEdit', 'Edicion_de_Cargos');

	function Edicion_de_Cargos()
	{
		?>
		<div id="Cnt-edit-form" >
			<h2>Modificar Cargo</h2>
			<form onsubmit="return EditCargo(<?=$_POST['id']?>);" name="FormEditCargo" id="FormEditCargo">
				<label><p>Nombre:</p><input type="text" id="nameCargo" value="<?=$_POST['name']?>"></label>
				<label><p>Prioridad:</p>
					<select id="priorCargo">
				<?php
				global $wpdb;
				$Priors=$wpdb->get_results("SELECT * FROM wp_an_staff_prioridad");
				$p=1;
				foreach($Priors as $Prior)
				{
					?>
						<option value="<?=$Prior->scp_id?>" <?=($Prior->scp_id==$_POST['prior'])?"selected":"";?>><?=$Prior->scp_name?></option>
					<?php
					$p++;
				}
				?>
					</select>
				</label>
				<label><p>Estado:</p>
					<select id="estadoCargo">
						<option value="0" <?=($_POST['estado']==0)?"selected":"";?>>Deshabilitado</option>
						<option value="1" <?=($_POST['estado']==1)?"selected":"";?>>Habilitado</option>
					</select>
				</label>
				<fieldset>
					<a class="staff-button button-Skyblue-save" onclick="jQuery('#FormEditCargo').submit()">Modificar</a>
					<a class="staff-button button-Skyblue-cancel" id="Cancel-Edit">Cancelar</a>
				</fieldset>
			</form>
		</div>
		<?php
		die();
	}
?>