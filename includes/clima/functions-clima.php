<?php
// Inicio Modificacion 8-8-13 Widget Clima

include_once "includes/clima-setup-bd.php";
include_once "includes/clima-changeloc.php";

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
		$wpdb->query($wpdb->prepare("DELETE FROM ".$wpdb->prefix."clima_pronosticos WHERE cli_loc_id=%d",$loc));
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
		alr_clima_initialize($lid);
		alr_clima_updlocinfo($lid);
		return alr_clima_values($lid);
	}
}


add_action('wp_ajax_alr_clima', 'alr_clima_execute');
add_action('wp_ajax_nopriv_alr_clima', 'alr_clima_execute');


//Funcion principal de ejecucion del Widget de Clima
function alr_clima_execute()
{
	date_default_timezone_set('America/Buenos_Aires'); 
	//Seteo el id de la localidad
	$lid=(isset($_POST['loc']))? intval($_POST['loc']) : false; //16931 es la ciudad de Mar del Plata
	if($lid!=false)
	{
		//Valido si existe la estructura del clima en la bd
		$alr_clima=get_option("alr_clima",false);
		//Sino existe la creo
		if($alr_clima!=false) 
		{
			//Busco cuando fue la ultima vez que se actualizo el clima para la localidad seleccionada
			global $wpdb;
			$wpdb->hide_errors();
			$loclu=$wpdb->get_results($wpdb->prepare("SELECT loc_lastupd AS Upd FROM ".$wpdb->prefix."clima_localidades WHERE loc_id=%d",$lid));
			//Si existe la localidad
			if(($loclu!=false)&&($wpdb->num_rows>0)) 
			{
				//Valido si se actualizo alguna vez el clima para esta localidad
				if(!is_null($loclu[0]->Upd)) 
				{
					$hoy=getdate();
					$lastupdate=getdate(intval($loclu[0]->Upd));
					//Valido si la ultima actualizacion es menor al dia de hoy y actualizo
					if(($hoy['yday']>$lastupdate['yday'])&&($hoy['year']==$lastupdate['year'])) 
					{
						alr_clima_updlocinfo($lid);
					}
				}else 
				{
					alr_clima_updlocinfo($lid);
				}
				$json_response=alr_clima_values($lid);
			}else //Sino existe la localidad
			{
				$json_response=json_encode(array("request"=>"error","error"=>"Localidad Invalida"));
			}
		}else 
		{
			$json_response=json_encode(array("request"=>"error","error"=>"Acceso Invalido"));
		}
	}else 
	{
		$json_response=json_encode(array("request"=>"error","error"=>"Informacion Invalida"));
	}
	print($json_response);
	die();
}

add_action('wp_ajax_alr_clima_load', 'alr_clima_initialize');
add_action('wp_ajax_nopriv_alr_clima_load', 'alr_clima_initialize');
//Inicializacion del clima
function alr_clima_initialize()
{
	$alr_clima=get_option("alr_clima",false);
	if($alr_clima!=false) 
	{
		//Inicio de Session
		session_start();
		//Si esta seteada la variable de clima obtengo el valor, sino por defecto cargo Mar del Plata
		$loc=(isset($_SESSION['alr_clima_id'])) ? (intval($_SESSION['alr_clima_id'])!=0)? $_SESSION['alr_clima_id'] : 16931 : 16931;
		global $wpdb;
		$wpdb->hide_errors();
		//Busco si la localidad seleccionada existe
		$locid=$wpdb->get_results($wpdb->prepare("SELECT loc_id AS id FROM ".$wpdb->prefix."clima_localidades WHERE loc_id=%d",$loc));
		if(($wpdb->num_rows>0)&&($locid!=false)) 
		{
			$json_response=json_encode(array("request"=>"success","localidad"=>$locid[0]->id));
			print($json_response);
		}else 
		{//Si la busqueda genero un error o no se encontro el codigo de la localidad actualizo la informacion, si corresponde.
			$json_response=json_encode(array("request"=>"error","error"=>$wpdb->last_error));
			//alr_clima_execute($loc);
		}
	}else 
	{
		alr_clima_updbd();
		alr_clima_initialize();
	}
	//die();
}
?>