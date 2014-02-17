<?php

function catads_admin() 
{
	?>
	<div class="wrap">
	<div id="icon-tools" class="icon32"></div>
	<h2>Publicidad Categoria - Configuraci&oacute;n</h2>
	<div class="clear"></div>
	<div id="Main-Ads">
	<?php
	global $wpdb;
	$wpdb->flush();
	$query=$wpdb->prepare("SELECT p.ads_id AS id, p.ads_name AS name, p.ads_maxwidth AS w, p.ads_maxheight AS h, b.anb_image as ads, b.anb_url as url, p.ads_resize as resize, b.anb_anbs_id AS size FROM wp_an_ads_publicidad AS p LEFT JOIN wp_an_ads_banners AS b ON p.ads_anb_id=anb_id LEFT JOIN wp_an_ads_banners_size AS s ON b.anb_anbs_id=s.anbs_id WHERE p.ads_anp_id=%d",2);
	$ads=$wpdb->get_results($query); 
	if($wpdb->num_rows>0) 
	{
		$sizes=$wpdb->get_results("SELECT anbs_name AS name, anbs_height AS h, anbs_width AS w, anbs_id AS id FROM wp_an_ads_banners_size ORDER BY anbs_width ASC, anbs_height ASC");
		foreach($ads as $ad)
		{
			?>
			<form class="Cnt-Ads" id="Ads-<?=bin2hex($ad->id)?>" onsubmit="UpdatePublicidad('UpdCatContent',<?=bin2hex($ad->id)?>);return false;">
				<label>
					<span>Publicidad </span>
					<?=$ad->name?>
				</label>
				<label>
					<span>Tama&ntilde;o Banner</span>
					<select id="Pub-Size-<?=bin2hex($ad->id)?>">
					<?php
						if($ad->resize==1) 
						{
							foreach($sizes as $size)
							{
								if(($ad->w >= $size->w)&&($ad->h >= $size->h)) 
								{
									?>
						<option value="<?=bin2hex($size->id)?>" <?=(!is_null($ad->size))?($ad->size==$size->id)?"selected":"":"";?> ><?=$size->name?></option>
									<?php
								}
							}
						}else 
						{
							$query_resizes=$wpdb->prepare("SELECT anbs_name AS name, anbs_height AS h, anbs_width AS w, anbs_id AS id FROM wp_an_ads_banners_size WHERE anbs_height=%d AND anbs_width=%d",$ad->h,$ad->w);
							$resizes=$wpdb->get_results($query_resizes); 
							foreach($resizes as $resize)
							{
								var_dump($ad);	
								?>
						<option value="<?=bin2hex($resize->id)?>" <?=(!is_null($ad->size))?($ad->size==$resize->id)?"selected":"":"";?> ><?=$resize->name?></option>
								<?php
							}
						}
						?>
					</select>
				</label>
				<label><span>Banner ID: </span><input type="text" id="banner-<?=bin2hex($ad->id)?>" rel-id="<?=bin2hex($ad->id)?>" value="<?=(!is_null($ad->ads))?$ad->ads:'';?>"></label>
				<label><span>Banner Link: </span><input type="text" id="banner-url-<?=bin2hex($ad->id)?>" rel-id="<?=bin2hex($ad->id)?>" value="<?=(!is_null($ad->url))?$ad->url:'';?>"></label>
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

add_action('wp_ajax_UpdCatContent', 'update_pubC');
add_action('wp_ajax_nopriv_UpdCatContent', 'update_pubC');

function update_pubC() 
{
	global $wpdb;
	if(($_POST['img']!="") && (intval($_POST['img'])!=0)) 
	{
		$id=intval(pack("H*",$_POST['id']));
		$query=$wpdb->prepare("SELECT * FROM wp_an_ads_publicidad WHERE ads_id=%d AND ads_anp_id=%d",$id,2);
		$pub=$wpdb->get_results($query);
		if($wpdb->num_rows>0) 
		{
			if(is_null($pub->ads_anb_id)) 
			{
				$query_resizes=$wpdb->prepare("SELECT anbs_name AS name, anbs_height AS h, anbs_width AS w, anbs_id AS id FROM wp_an_ads_banners_size WHERE anbs_height<=%d AND anbs_width<=%d",$pub->ads_maxheight,$pub->ads_maxwidth);
				$resizes=$wpdb->get_results($query_resizes); 
				if(($ad->w >= $size->w)&&($ad->h >= $size->h)) 
				$insert=$wpdb->prepare("INSERT INTO wp_an_ads_banners(anb_image, anb_url, anb_anbs_id) VALUES(%d,%s,%d)",intval($_POST['img']),trim($_POST['url']),intval(pack("H*",$_POST['size'])));
				$wpdb->query($insert);
				if(!is_null($wpdb->insert_id!=0)) 
				{
					$update=$wpdb->prepare("UPDATE wp_an_ads_publicidad SET ads_anb_id=%d WHERE ads_id=%d",$wpdb->insert_id,$id);
					$wpdb->query($update);
					echo json_encode( array("request"=>"success"));
				}else 
				{
					echo json_encode( array("request"=>"error","error"=>"Error Actualizacion - Se produjo un error cuando se intentaba agregar el nuevo banner"));
				}
			}
		}
	}else 
	{
		$update=$wpdb->prepare("UPDATE wp_an_ads_publicidad SET ads_anb_id=NULL WHERE ads_id=%d",intval(pack("H*",$_POST['id'])));
		if($wpdb->query($update))
		{
			echo json_encode( array("request"=>"success"));
		}else 
		{
			echo json_encode( array("request"=>"error","error"=>"Error Actualizacion - Se produjo un error cuando se intentaba actualizar el banner"));
		}
	}
	die();
}
?>