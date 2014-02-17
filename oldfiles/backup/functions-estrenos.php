<?php
//Modificacion 18-9-13 Widget Estrenos

add_action('wp_ajax_Estrenos', 'EstrenosDB');
add_action('wp_ajax_nopriv_Estrenos', 'EstrenosDB');

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
		$xml = simplexml_load_string($xmlMovies);
		if($xml!=false) 
		{
			update_option("EstrenosUpdate",strtotime($xml->channel->lastBuildDate));
			$m=0;
			global $wpdb;
			foreach ($xml->channel->item as $item) 
			{
				$id_movie=str_replace("http://www.cinesargentinos.com.ar/pelicula/","",$item->guid);
				$id_movie=intval($id_movie);
				$query="SELECT count(*) as tot FROM wp_cine_estrenos WHERE wp_ce_nro={$id_movie}";
				$result=$wpdb->get_results($query,OBJECT_K);
				foreach($result as $resEst)
				{
					if($resEst->tot==0) 
					{
						$title=$item->title;
						$try=1;
						$max_tries=4;
						$img="";
						$findit=false;
						$uploaddir = wp_upload_dir();
						if(!file_exists($uploaddir['path']."/movies")) 
						{
							mkdir($uploaddir['path']."/movies", 755);
						}
						while(($try<$max_tries)&&(!$findit)) 
						{
							$file=trim($item->link);
							$file=str_replace("/pelicula/","/poster/",$file);
							$file_len=strlen($file)-1;
							$file=substr($file,0, $file_len);
							$file.="_168.jpg";
							$uploadfile = $uploaddir['path']."/movies/{$id_movie}.jpg";
							$file_headers=get_headers($file);
							if ($file_headers[0] == 'HTTP/1.1 200 OK')
							{
								$savefile = fopen($uploadfile, 'w');
								fwrite($savefile, file_get_contents($file));
								fclose($savefile);
								$img=esc_sql($uploaddir['url'] . "/movies/{$id_movie}.jpg");
								$queryIns="INSERT INTO wp_cine_estrenos (wp_ce_nro,wp_ce_title,wp_ce_img) VALUES ('{$id_movie}','{$title}','{$img}')";
								//var_dump($queryIns);
								$wpdb->query($wpdb->prepare($queryIns));
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
	}
	// Cerrar recurso
	curl_close($curl);
}

function VerEstrenos() 
{
	global $wpdb;
	$resEst=$wpdb->get_results("SELECT count(*) as tot FROM wp_cine_estrenos");
	if($resEst->tot==0) 
	{
		UpdateEstrenos();
	}
	$VerEst=$wpdb->get_results("SELECT * FROM wp_cine_estrenos LIMIT 10");
	$j=0;
	foreach($VerEst as $Estreno)
	{
		if($j==0) 
		{
			?>
		<div class="InfoShows activeShow" id="Show<?=$j?>">
			<?php
		}else 
		{
			?>
		<div class="InfoShows" id="Show<?=$j?>">
			<?php
		}
		?>
			<img src="<?php print($Estreno->wp_ce_img); ?>" alt="<?php print($Estreno->wp_ce_title); ?>" >
			<h4><?php print($Estreno->wp_ce_title)?></h4>
		</div>
		<?php
		$j++;
	}
	$z=0;
	?>
	<nav>
	<?php
	while($z<$j) 
	{
		/*if($z==0) 
		{*/
		?>
		<!--<img src="<?php bloginfo('stylesheet_directory'); ?>/images/cinesargentinos.png" alt="" >-->
		<!--<nav>-->
		<p title="Show<?=$z?>" onclick="ShowFilm(this)"><?=$z+1?></p>
			<?php
		/*}elseif($z==9)  
		{*/
			?>
		<!--	<p title="Show<?=$z?>" onclick="ShowFilm(this)"><?=$z+1?></p>
		</nav>-->
		<?php
		/*}else 
		{*/
			?>
			<!--<p title="Show<?=$z?>" onclick="ShowFilm(this)"><?=$z+1?></p>-->
			<?php
		//}
		$z++;	
	}	
	?>
	</nav>
	<?php
}

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
			VerEstrenos();
		}else 
		{
			VerEstrenos();
		}
	}else 
	{
		update_option("EstrenosUpdate",0);
		UpdateEstrenos();
		VerEstrenos();
	}
	die();
} 
//Fin Modificacion 18-9-13 Widgets Cines
?>