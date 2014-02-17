<?php
//Funcion para agregar todas las provincias del pais
function alr_clima_provincias()
{
	$response=array();
	$feed_url = "http://api.tiempo.com/index.php?api_lang=ar&pais=67&affiliate_id=jcp8s666brbh";
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL,$feed_url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
	$xmlProv = curl_exec($curl);
	if(curl_errno($curl)==0) 
	{
		$xml = simplexml_load_string($xmlProv);
		if(isset($xml->location->data[0]->name)) 
		{
			$x=0;
			foreach ($xml->location->data as $prov) 
			{
				$pid=intval($prov->name->attributes()->id);
				$response[$pid]=(string) $prov->name;
				$x++;	      	
   	   }
		}
	}
	curl_close($curl);			
	return $response;
}

//Funcion para agregar todas las localidades del pais
function alr_clima_localidad($pid=0)
{
	if($pid!=0)
	{
		$response=array();
		$feed_loc = "http://api.tiempo.com/index.php?api_lang=ar&provincia=".$pid."&affiliate_id=jcp8s666brbh";	
		$curlL = curl_init();
		curl_setopt($curlL, CURLOPT_URL,$feed_loc);
		curl_setopt($curlL, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curlL, CURLOPT_CONNECTTIMEOUT, 0);
		$xmlLoc = curl_exec($curlL);
		if(curl_errno($curlL)==0) 
		{
			$xml = simplexml_load_string($xmlLoc);
			if(isset($xml->location->data[0]->name)) 
			{			
				foreach ($xml->location->data as $loc) 
				{
					$lid=intval($loc->name->attributes()->id);
		      	$response[$lid]=(string)$loc->name;
	   	   }
			}
		}
		return $response;
		curl_close($curl);
	}
}


//Funcion para crear si no existen las tablas que se van a utilizar para ver el clima
function alr_clima_updbd()
{
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	$sql_table="CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."clima_provincias (pro_id int(11) NOT NULL, pro_name varchar(100) NOT NULL, PRIMARY KEY pro_id(pro_id)) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";
	dbDelta( $sql_table );
	
	$sql_table2="CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."clima_localidades (loc_id int(11) NOT NULL, loc_name varchar(100) NOT NULL, loc_pro_id int(11) NOT NULL, loc_lastupd VARCHAR(20), PRIMARY KEY loc_id (loc_id), KEY loc_pro_id(loc_pro_id)) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";
	dbDelta( $sql_table2 );
	
	$sql_table3="CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."clima_pronosticos (cli_id int(11) NOT NULL AUTO_INCREMENT, cli_loc_id int(11) NOT NULL, cli_min int(2) NOT NULL, cli_max int(2) NOT NULL, cli_ico int(2), cli_estado varchar(100), cli_dia varchar(25), cli_diaano int(3), cli_ano int(4), PRIMARY KEY cli_id(cli_id), KEY cli_loc_id (cli_loc_id), KEY cli_diaano(cli_diaano, cli_ano)) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";
	dbDelta( $sql_table3 );
	
	$response=alr_clima_provincias();
	$wpdb->hide_errors();
	foreach ($response as $cod=>$prov)
	{		
		$wpdb->query($wpdb->prepare("INSERT INTO ".$wpdb->prefix."clima_provincias(pro_id, pro_name) VALUES(%d, %s)",$cod,$prov));
		$arloc=alr_clima_localidad($cod);
		$sqlloc="";
		foreach ($arloc as $lid=>$loc)
		{
			$sqlloc.=$wpdb->prepare("(%d, %s, %d),", $lid, $loc, $cod);
		}
		if($sqlloc!="") 
		{
			$sqlloc=substr($sqlloc, 0, strlen($sqlloc)-1);
			$wpdb->query("INSERT INTO ".$wpdb->prefix."clima_localidades(loc_id, loc_name, loc_pro_id) VALUES $sqlloc;");
		}  
	}
	$wpdb->query($wpdb->prepare("INSERT INTO ".$wpdb->prefix."clima_provincias(pro_id, pro_name) VALUES(%d, %s)",13584, "Ciudad Autonoma de Buenos Aires"));
	$wpdb->query($wpdb->prepare("INSERT INTO ".$wpdb->prefix."clima_localidades(loc_id, loc_name, loc_pro_id) VALUES (%d, %s, %d)", 13584, "Ciudad Autonoma de Buenos Aires", 13584));
	update_option("alr_clima",true);
}

?>