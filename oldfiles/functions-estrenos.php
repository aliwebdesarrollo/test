<?php
//Modificacion 18-9-13 Widget Estrenos

add_action('wp_ajax_an_estrenos', 'EstrenosDB');
add_action('wp_ajax_nopriv_an_estrenos', 'EstrenosDB');

function UpdateEstrenos() 
{
	$feed_movies = "http://feeds.feedburner.com/cinesargentinos-pelis?format=xml";
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL,$feed_movies);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
	$xmlMovies = curl_exec($curl);
	if(curl_errno($curl)==0) 
	{
		$xml = simplexml_load_string(str_replace(array("&amp;", "&"),array("&", "&amp;"),$xmlMovies));
		if($xml!=false) 
		{
			update_option("EstrenosUpdate",strtotime($xml->channel->lastBuildDate));
			$m=0;
			global $wpdb;
			foreach ($xml->channel->item as $item) 
			{
				$id_movie=str_replace("http://www.cinesargentinos.com.ar/pelicula/","",$item->guid);
				$id_movie=intval($id_movie);
				$query=$wpdb->prepare("SELECT * FROM wp_cine_estrenos WHERE wp_ce_nro=%d",$id_movie);
				$result=$wpdb->query($query);
				if($wpdb->num_rows==0) 
				{
					$title=$item->title;
					$try=1;
					$max_tries=4;
					$img="";
					$findit=false;
					$uploaddir = wp_upload_dir();
					if(!file_exists($uploaddir['path']."/movie")) 
					{
						mkdir($uploaddir['path']."/movie", 0755);
					}
					while(($try<$max_tries)&&(!$findit)) 
					{
						$file=trim($item->link);
						$file=str_replace("/pelicula/","/poster/",$file);
						$file_len=strlen($file)-1;
						$file=substr($file,0, $file_len);
						$file.="_168.jpg";
						$localfile = $uploaddir['path']."/movie/{$id_movie}.jpg";
						$ch = curl_init($file);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  						curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
						$file_save=curl_exec( $ch );
						$response_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
						curl_close( $ch );
						if($response_code==200)
						{
							file_put_contents($localfile,$file_save);
							$img=esc_sql($uploaddir['url'] . "/movie/{$id_movie}.jpg");
							$fecha=strtotime($item->pubDate);
							$queryIns=$wpdb->prepare("INSERT INTO wp_cine_estrenos (wp_ce_nro,wp_ce_title, wp_ce_fecha, wp_ce_img) VALUES (%d, %s, %d, %s)",$id_movie,$title,$fecha, $img);
							$wpdb->query($queryIns);
							$findit=true;
						}else 
						{
							$try++;
						}
					}
				}
			}
		}
	}
	// Cerrar recurso
	curl_close($curl);
}

function VerEstrenos() 
{
	global $wpdb;
	//$resEst=$wpdb->query("SELECT * FROM wp_cine_estrenos");
	$VerEst=$wpdb->get_results("SELECT * FROM wp_cine_estrenos  ORDER BY wp_ce_fecha DESC, wp_ce_id ASC LIMIT 10");
	if($wpdb->num_rows==0) 
	{
		UpdateEstrenos();
	}
	//$VerEst=$wpdb->get_results("SELECT * FROM wp_cine_estrenos  ORDER BY wp_ce_fecha DESC LIMIT 10");
	$j=0;
	foreach($VerEst as $Estreno)
	{
		$Estrenos[$j]['img']=$Estreno->wp_ce_img;
		$Estrenos[$j]['titulo']=$Estreno->wp_ce_title;
		$j++;
	}
	$Estrenos['request']="success";
	return json_encode($Estrenos);
}

function Create_Table_Estrenos() 
{
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	$sql_ins="CREATE TABLE IF NOT EXISTS wp_cine_estrenos (wp_ce_id int(11) NOT NULL AUTO_INCREMENT, wp_ce_nro int(11) NOT NULL, wp_ce_title varchar(50) NOT NULL, wp_ce_img varchar(300) NOT NULL, PRIMARY KEY (wp_ce_id,wp_ce_title), KEY wp_ce_nro (wp_ce_nro) ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";

	dbDelta( $sql_ins );
	update_option("EstrenosUpdate",0);
}


//Funcion Principal
function EstrenosDB() 
{ 
	$optest=get_option("EstrenosUpdate", false);
	if($optest!=false) 
	{
		$updW=date("W",$optest);
		$hoyW=date("W");
		if($hoyW>$updW) 
		{
			UpdateEstrenos();
			$json_response=VerEstrenos();
		}else 
		{
			$json_response=VerEstrenos();
		}
	}else 
	{
		Create_Table_Estrenos();
		UpdateEstrenos();
		$json_response=VerEstrenos();
	}
	echo $json_response;
	die();
} 
//Fin Modificacion 18-9-13 Widgets Cines
?>