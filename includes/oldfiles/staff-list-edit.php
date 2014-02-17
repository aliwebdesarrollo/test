<?php
	add_action('wp_ajax_StaffsEditStaff', 'EditStaff');
	add_action('wp_ajax_nopriv_StaffsEditStaff', 'EditStaff');

	function EditStaff()
	{
		$id=intval(pack("H*",$_POST['id']));
		global $wpdb;
		$wpdb->hide_errors();
		$query=$wpdb->prepare("SELECT * FROM wp_an_staff_list WHERE scl_id=%d",$id);
		$ids=$wpdb->get_results($query);
		if($wpdb->num_rows!=0) 
		{
			$ins['name']=(trim($_POST['name'])==trim($ids[0]->scl_name))?"":"scl_name='{$_POST['name']}'";
			$ins['cargo']=(intval($_POST['cargo'])>0)? (intval($_POST['cargo'])!=$ids[0]->scl_sch_id)?"scl_sch_id=".intval($_POST['cargo']):"":"";
			$ins['estado']=(intval($_POST['estado'])>=0)? (intval($_POST['estado'])!=$ids[0]->scl_estado)?"scl_estado=".intval($_POST['estado']):"":"";
			$insert="";
			if(trim($ins['name'])!="")
			{
				$insert=$ins['name'];
			}
			if(trim($ins['cargo'])!="")
			{
				$insert.=($insert=="")? $ins['cargo']:", {$ins['cargo']}";
			} 
			if(trim($ins['estado'])!="")
			{
				$insert.=($insert=="")? $ins['estado']:", {$ins['estado']}";
			}
			if(trim($insert)!="") 
			{
				$wpdb->flush();
				$query_upd=$wpdb->prepare("UPDATE wp_an_staff_list SET {$insert} WHERE scl_id=%d",$id);
				$res_upd=$wpdb->query($query_upd);
				if ( $res_upd==false ) 
				{
					$response=array("request"=>"error","error"=>$wpdb->last_query.$ins['cargo']);
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
				$response=array("request"=>"nochange");
				$response=json_encode($response);
				print ($response);
			}
		}else 
		{
			$response=array("request"=>"error","error"=>"Cargo Laboral - ID Inexistente".$wpdb->num_rows);
			$response=json_encode($response);
			print ($response);
		}
		die();
	}		
	
	
	add_action('wp_ajax_StaffEdit', 'Edicion_de_Staff');
	add_action('wp_ajax_nopriv_StaffEdit', 'Edicion_de_Staff');

	function Edicion_de_Staff()
	{
		?>
		<div id="Cnt-edit-form" >
			<h2>Modificar Staff</h2>
			<form onsubmit="return EditStaff(<?=$_POST['id']?>);" id="FormEditStaff">
				<label><p>Nombre:</p><input type="text" id="nameStaff" value="<?=$_POST['name']?>"></label>
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
						<option value="0" <?=($_POST['estado']==0)?"selected":"";?>>Deshabilitado</option>
						<option value="1" <?=($_POST['estado']==1)?"selected":"";?>>Habilitado</option>
					</select>
				</label>
				<fieldset>
					<a class="staff-button button-Skyblue-save" onclick="jQuery('#FormEditStaff').submit()">Modificar</a>
					<a class="staff-button button-Skyblue-cancel" id="Cancel-Edit">Cancelar</a>
				</fieldset>
			</form>
		</div>
		<?php
		die();
	}
?>