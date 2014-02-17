<?php

function adsense_admin() 
{
	?>
	<div class="wrap">
	<div id="icon-tools" class="icon32"></div>
	<h2>Adsense - Configuraci&oacute;n</h2>
	<div class="clear"></div>
	<div id="Main-Ads">
	<?php
	global $wpdb;
	$wpdb->flush();
	$ads=$wpdb->get_results("SELECT a.ana_id AS id, a.ana_name AS name, a.ana_code as code, a.ana_anas_id AS size, p.anp_name AS page FROM wp_an_ads_adsense AS a LEFT JOIN wp_an_ads_adsense_size AS s ON a.ana_anas_id=s.anas_id LEFT JOIN wp_an_ads_pages_name AS p ON a.ana_anp_id=p.anp_id");
	if($wpdb->num_rows>0) 
	{
		$sizes=$wpdb->get_results("SELECT anas_name AS name, anas_id AS id FROM wp_an_ads_adsense_size");
		foreach($ads as $ad)
		{
			?>
			<form class="Cnt-Ads" id="Ads-<?=bin2hex($ad->id)?>" onsubmit="UpdateAdSense(<?=bin2hex($ad->id)?>);return false;">
				<label>
					<span>Publicidad </span>
					<?=$ad->name." - ".$ad->page?>
				</label>
				<label>
					<span>Pagina </span>
					<?=$ad->page?>
				</label>
				<label>
					<span>Tama&ntilde;o Banner</span>
					<select id="Pub-Size-<?=bin2hex($ad->id)?>">
					<?php
					foreach($sizes as $size)
					{
						?>
						<option value="<?=bin2hex($size->id)?>" <?=(!is_null($ad->size))?($ad->size==$size->id)?"selected":"":"";?> ><?=$size->name?></option>
						<?php
					}
					?>
					</select>
				</label>
				<label><span>Codigo: </span><textarea id="code-<?=bin2hex($ad->id)?>" rel-id="<?=bin2hex($ad->id)?>"><?=(!is_null($ad->code))?stripslashes($ad->code):'';?></textarea></label>
				<div class="cnt-buttons">
					<a class="button-update button-Skyblue" onclick='jQuery("#Ads-<?=bin2hex($ad->id)?>").submit();'>Actualizar</a>
				</div>
			</form>
			<?php
		}
	}
	?>
	</div>
	<?php
	$wpdb->flush();
}

add_action('wp_ajax_UpdAdSenseContent', 'update_pubA');
add_action('wp_ajax_nopriv_UpdAdSenseContent', 'update_pubA');

function update_pubA() 
{
	$id=intval(pack("H*",$_POST['id']));
	global $wpdb;
	$query=$wpdb->prepare("SELECT * FROM wp_an_ads_adsense WHERE ana_id=%d",$id);
	$pub=$wpdb->get_results($query);
	if($wpdb->num_rows>0) 
	{
		$upd_code=($pub[0]->ana_code!=$_POST['code'])? "ana_code=%s":"";
		$upd_size=($pub[0]->ana_anas_id!=intval(pack("H*",$_POST['size'])))? "ana_anas_id=%d":"";
		if(($upd_code!="")&&($upd_size!="")) 
		{
			$update=$wpdb->prepare("UPDATE wp_an_ads_adsense SET {$upd_code}, {$upd_size} WHERE ana_id=%d",$_POST['code'],intval(pack("H*",$_POST['size'])),$id);
		}elseif(($upd_code!="")&&($upd_size=="")) 
		{
			$update=$wpdb->prepare("UPDATE wp_an_ads_adsense SET {$upd_code} WHERE ana_id=%d",$_POST['code'],$id);
		}elseif(($upd_code=="")&&($upd_size!="")) 
		{
			$update=$wpdb->prepare("UPDATE wp_an_ads_adsense SET {$upd_size} WHERE ana_id=%d",intval(pack("H*",$_POST['size'])),$id);
		}
		if(isset($update)) 
		{
			if($wpdb->query($update)!=false)
			{
				echo json_encode( array("request"=>"success"));
			}else 
			{
				echo json_encode( array("request"=>"error","error"=>"Error Actualizacion - los datos no fueron actualizados". $last_error .$wpdb->last_query));
			}
		}
	}else 
	{
		echo json_encode( array("request"=>"error","error"=>"Error Actualizacion - AdSense Inexistente"));
	}
	die();
}
?>