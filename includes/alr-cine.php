<?php
//Modificacion 28-1-14 Widget Estrenos

add_action('wp_ajax_an_estrenos', 'get_Estrenos');
add_action('wp_ajax_nopriv_an_estrenos', 'get_Estrenos');

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
			$m=0;
			global $wpdb;
			foreach ($xml->channel->item as $item) 
			{
				$id_movie=str_replace("http://www.cinesargentinos.com.ar/pelicula/","",$item->guid);
				$id_movie=intval($id_movie);
				$query=$wpdb->prepare("SELECT * FROM ".$wpdb->prefix."estrenos WHERE est_nro=%d",$id_movie);
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
							$queryIns=$wpdb->prepare("INSERT INTO ".$wpdb->prefix."estrenos (est_nro, est_title, est_fecha, est_img) VALUES (%d, %s, %d, %s)",$id_movie,$title,$fecha, $img);
							$wpdb->query($queryIns);
							$findit=true;
						}else 
						{
							$try++;
						}
					}
				}
			}
			update_option("alr_EstrenosUpdated",strtotime($xml->channel->lastBuildDate));
		}
	}
	// Cerrar recurso
	curl_close($curl);
}

function VerEstrenos() 
{
	global $wpdb;

	$VerEst=$wpdb->get_results("SELECT * FROM ".$wpdb->prefix."estrenos  ORDER BY est_fecha DESC, est_id ASC LIMIT 6");
	if($wpdb->num_rows==0) 
	{
		UpdateEstrenos();
		VerEstrenos();
	}else {
		$j=0;
		foreach($VerEst as $Estreno)
		{
			$Estrenos[$j]['img']=$Estreno->est_img;
			$Estrenos[$j]['titulo']=$Estreno->est_title;
			$j++;
		}
		return $Estrenos;
	}
}

function Create_Table_Estrenos() 
{
	global $wpdb;
	
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	$sql_ins="CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."estrenos (est_id int(11) NOT NULL AUTO_INCREMENT, est_nro int(11) NOT NULL, est_title varchar(50) NOT NULL, est_img varchar(300) NOT NULL, est_fecha int(11), PRIMARY KEY (est_id,est_title), KEY est_nro (est_nro) ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";

	dbDelta( $sql_ins );
	update_option("alr_EstrenosUpdated",0);
}


//Funcion Principal
function get_Estrenos() 
{ 
	$optest=get_option("alr_EstrenosUpdated", false);
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
	return $json_response;
	//die();
} 
//Fin Modificacion 28-1-14 Widgets Cines
?>