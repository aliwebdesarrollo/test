add_action('wp_ajax_Estrenos', 'CargaEstrenos');
add_action('wp_ajax_nopriv_Estrenos', 'CargaEstrenos');

function CargaEstrenos() 
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
			$m=0;
			foreach ($xml->channel->item as $item) 
			{
				$title=$item->title;
				$id_movie=str_replace("http://www.cinesargentinos.com.ar/pelicula/","",$item->guid);
				$id_movie=intval($id_movie);
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
					if(!file_exists($uploadfile))	 
					{	
						$file_headers=get_headers($file);
						if ($file_headers[0] == 'HTTP/1.1 200 OK')
						{
							$savefile = fopen($uploadfile, 'w');
							fwrite($savefile, file_get_contents($file));
							fclose($savefile);
							$img=$uploaddir['url'] . "/movies/{$id_movie}.jpg";
							$findit=true;
						}else 
						{
							$try++;
						}
					}else 
					{
						$img=$uploaddir['url'] . "/movies/{$id_movie}.jpg";
						$findit=true;
					}		
				}
				if($m==0) 
				{
					?>
				<div class="InfoShows activeShow" id="Show<?=$m?>">
					<?php
				}else 
				{
					?>
				<div class="InfoShows" id="Show<?=$m?>">
					<?php
				}
				?>
					<img src="<?=$img?>" alt="" >
					<h4><?=$title?></h4>
				</div>
				<?php
				$m++;   
			}
			$z=0;
			while($z<$m) 
			{
				if($z==0) 
				{
				?>
				<nav>
					<p title="Show<?=$z?>" onclick="ShowFilm(this)"><?=$z+1?></p>
					<?php
				}elseif($z==5)  
				{
					?>
					<p title="Show<?=$z?>" onclick="ShowFilm(this)"><?=$z+1?></p>
				</nav>
				<?php
				}else 
				{
					?>
					<p title="Show<?=$z?>" onclick="ShowFilm(this)"><?=$z+1?></p>
					<?php
				}
				$z++;	
			}
		}
	}
	// Cerrar recurso
	curl_close($curl);
	die();
}