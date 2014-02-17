<?php
// Inicio Modificacion 8-8-13 Widget Clima

include_once "clima/includes/clima-setup-bd.php";
include_once "clima/includes/clima-changeloc.php";

//Funcion para actualizar el clima de los proximos 3 dias de una localidad determinada
function alr_clima_updlocinfo($loc)
{
	$feedL = "http://api.tiempo.com/index.php?api_lang=ar&localidad={$loc}&affiliate_id=jcp8s666brbh";
	$curlL = curl_init();
	curl_setopt($curlL, CURLOPT_URL,$feedL);
	curl_setopt($curlL, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curlL, CURLOPT_CONNECTTIMEOUT, 0);
	$xml = curl_exec($curlL);
	if(curl_errno($curlL)==0) 
	{
		$xmlD = simplexml_load_string($xml);
		global $wpdb;
		$diahoy=$wpdb->get_results($wpdb->prepare("SELECT cli_dia AS dia FROM ".$wpdb->prefix."clima_pronosticos WHERE cli_loc_id=%d LIMIT 1",$loc));
		$wpdb->query("TRUNCATE TABLE ".$wpdb->prefix."clima_pronosticos");
		$wpdb->hide_errors();
		$maxDay=3;
		$xDay=0;
		$date=getdate();
		$date_day=intval(date("z"));
		$date_year=intval(date("Y"));
		while($xDay<$maxDay) 
		{
			$Dayname=(string) $xmlD->location->var[4]->data->forecast[$xDay]->attributes()->value;
			if($Dayname!=$diahoy[0]->dia) 
			{
				$Min=intval($xmlD->location->var[0]->data->forecast[$xDay]->attributes()->value);
				$Max=intval($xmlD->location->var[1]->data->forecast[$xDay]->attributes()->value);
				$Ico=intval($xmlD->location->var[3]->data->forecast[$xDay]->attributes()->id);
				$Estado= (string) $xmlD->location->var[3]->data->forecast[$xDay]->attributes()->value;
				$wpdb->query($wpdb->prepare("INSERT INTO ".$wpdb->prefix."clima_pronosticos(cli_loc_id, cli_min, cli_max, cli_ico, cli_estado, cli_dia, cli_diaano, cli_ano) VALUES(%d, %d, %d, %d, %s, %s, %d, %d)",$loc,$Min,$Max,$Ico,$Estado,$Dayname,$date_day + $xDay, $date_year));
			}else 
			{
				$maxDay++;
			}
			$diahoy[0]->dia="";
			$xDay++;
		}
		$wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."clima_localidades SET loc_lastupd=%s WHERE loc_id=%d",(string) time(),$loc));
	}
	curl_close($curlL);
}


//Funcion que devuelve los resultados del Widget de Clima
function alr_clima_values($lid)
{
	global $wpdb;
	$wpdb->hide_errors();
	$hoy=getdate();
	$pron=$wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."clima_pronosticos WHERE cli_loc_id=%d AND cli_diaano=%d AND cli_ano=%d ORDER BY cli_diaano DESC LIMIT 1",$lid,$hoy['yday'],$hoy['year']));
	if($wpdb->num_rows>0) 
	{
		$x=0;
		$pron=array_reverse($pron,true);
		foreach($pron as $dia)
		{
			$response['clima'][$x]['Tmin']=$dia->cli_min;
			$response['clima'][$x]['Tmax']=$dia->cli_max;
			$response['clima'][$x]['ico']=$dia->cli_ico;
			$response['clima'][$x]['estado']=$dia->cli_estado;
			$response['clima'][$x]['dia']=$dia->cli_dia;
			$x++;
		}
		$loc=$wpdb->get_results($wpdb->prepare("SELECT loc_name AS name FROM ".$wpdb->prefix."clima_localidades WHERE loc_id=%d",$lid));
		$response['localidad']=$loc[0]->name;
		return $response;
	}else 
	{
		$alr_clima=get_option("alr_clima",false);
		if($alr_clima==false) {
			alr_clima_updbd();
		}
		alr_clima_updlocinfo($lid);
		return alr_clima_values($lid);
	}
}
?>