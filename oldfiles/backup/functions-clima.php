
//Funcion para obtener los datos del clima asincronicamente
function widget_clima()
{
	//Inicio la sesion
	session_start();
	
	//Valido la ciudad que hay que mostrar, por defecto esta Mar del Plata (16931)
	if(!isset($_SESSION['clima_id'])) 
	{
		$_SESSION['clima_id']=16931;
		$_CID=16931;
	}else 
	{
		$_CID=intval($_SESSION['clima_id']);
	}	
	
	//Creo la cadena para buscar el tiempo en formato XML
	$feed_C = "http://api.tiempo.com/index.php?api_lang=ar&localidad={$_CID}&affiliate_id=mt25w1ffebr7";
	$curlc = curl_init();
	curl_setopt($curlc, CURLOPT_URL,$feed_C);
	curl_setopt($curlc, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curlc, CURLOPT_CONNECTTIMEOUT, 0);
	$xmlClimaStd = curl_exec($curlc);
	if(curl_errno($curlc)==0) 
	{
		curl_close($curlc);
		$xmlc = simplexml_load_string($xmlClimaStd);
		$Pron['city']=substr($xmlc->location->attributes()->city,0, strpos($xmlc->location->attributes()->city,"[")-1);
		foreach ($xmlc->location->var[0]->data->forecast as $TempMin)
		{
			$Day=intval($TempMin->attributes()->data_sequence);
			$Pron[$Day]['min']=intval($TempMin->attributes()->value);
		}
		foreach ($xmlc->location->var[1]->data->forecast as $TempMax)
		{
			$Day=intval($TempMax->attributes()->data_sequence);
			$Pron[$Day]['max']=intval($TempMax->attributes()->value);
		}
		
		foreach ($xmlc->location->var[3]->data->forecast as $TempIco)
		{
			$Day=intval($TempIco->attributes()->data_sequence);
			$Pron[$Day]['img']=intval($TempIco->attributes()->id);
			$Pron[$Day]['estado']=$TempIco->attributes()->value;
		}
		
		foreach ($xmlc->location->var[4]->data->forecast as $TempDia)
		{
			$Day=intval($TempDia->attributes()->data_sequence);
			$Pron[$Day]['dia']=$TempDia->attributes()->value;
		}	
		?>
		<p id='ClimaCity'><strong><?=$Pron['city']?></strong></p>
		<?php
		$xD=1;
		while($xD<=3) 
		{
			$ClimaDay=($xD==1)?"ClimaDays ClimaHoy":"ClimaDays ClimaPron";
			$DiaPronostico=($xD==1)?"Hoy":$Pron[$xD]['dia'];
			?>
	<div class="<?=$ClimaDay?>">
		<p class='ClimaFecha'><?=$DiaPronostico?></p>
		<img src="<?=bloginfo('stylesheet_directory')?>/images/clima/iconos/tiempo-weather/galeria1/<?=$Pron[$xD]['img']?>.png" alt="Pronostico" title="<?=$Pron[$xD]['estado']?>" >
		<p class='TempMin'>Min: <?=$Pron[$xD]['min']?>&deg;</p>
		<p class='TempMax'>Max: <?=$Pron[$xD]['max']?>&deg;</p>
	</div>
			<?php	
			$xD++;
		}
		?>
		<a id='ChangeCity' href="#" onclick='DisplayCities();return false;' title='Cambiar Ciudad'></a>
		<?php
	}else 
	{
		?>
		<h3 id="ClimaError">El Clima no se pudo cargar.</h3>
		<?php
	}
	die();
}


function LoadCiudades(){
	$feed_loc = "http://api.tiempo.com/index.php?api_lang=ar&provincia={$_POST['provincia']}&affiliate_id=mt25w1ffebr7";
	$curlL = curl_init();
	curl_setopt($curlL, CURLOPT_URL,"$feed_loc");
	curl_setopt($curlL, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curlL, CURLOPT_CONNECTTIMEOUT, 0);
	$xmlClimaLoc = curl_exec($curlL);
	curl_close($curlL);
	$xmlL = simplexml_load_string($xmlClimaLoc);
	$ciudad="";
	foreach ($xmlL->location->data as $lineL) 
	{
   	$ciudad.="<option value=\"".$lineL->name->attributes()->id."\" class=\"ClimaProv\">".$lineL->name."</option>";
   }
   print($ciudad);
   return;
}
add_action('wp_ajax_LoadCiudades', 'LoadCiudades');
add_action('wp_ajax_nopriv_LoadCiudades', 'LoadCiudades');  

function ChangeCity(){
	session_start();
	$GClima=get_clima(intval($_POST['ciudad']));
	$_SESSION['clima_id']=intval($_POST['ciudad']);
   print (widget_clima($GClima));
	return; 
}

add_action('wp_ajax_ChangeCity', 'ChangeCity');
add_action('wp_ajax_nopriv_ChangeCity', 'ChangeCity');  

add_action('wp_ajax_Sel_City', 'ListadoCiudades');
add_action('wp_ajax_nopriv_Sel_City', 'ListadoCiudades'); 

function ListadoCiudades()
{
	?>
<!-- Listado Cambio de Clima -->
<div id="ClimaFlow">
	<h1>Pronostico del Tiempo</h1>
	<p>Selecciona la Ciudad de Argentina de la cual queres ver el pronostico</p>
	<div id="CntCities">
	<?php
	$feed_url = "http://api.tiempo.com/index.php?api_lang=ar&pais=67&affiliate_id=mt25w1ffebr7";
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL,$feed_url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
	$xmlClima = curl_exec($curl);
	if(curl_errno($curl)==0) 
	{
		$xml = simplexml_load_string($xmlClima);
		if(isset($xml->location->data[0]->name)) 
		{
			curl_close($curl);
			
			?>
		<h3 class="CitiesTitle">Seleccione la Provincia</h3>
		<select id="ListClimaP" class="ListaClima" onchange="LoadCities(this.value);">
			<?php
			foreach ($xml->location->data as $line) 
			{
	      	?>
   		<option value="<?=$line->name->attributes()->id?>" class="ClimaProv"><?=$line->name?></option>
	      	<?php
   	   }
    		?>
		</select>
		<h3 class="CitiesTitle">Seleccione la Ciudad</h3>
			<?php
			$feed_loc = "http://api.tiempo.com/index.php?api_lang=ar&provincia=".$xml->location->data[0]->name->attributes()->id."&affiliate_id=mt25w1ffebr7";	
			$curlL = curl_init();
			curl_setopt($curlL, CURLOPT_URL,"$feed_loc");
			curl_setopt($curlL, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curlL, CURLOPT_CONNECTTIMEOUT, 0);
			$xmlClimaLoc = curl_exec($curlL);
			if(curl_errno($curlL)==0)
			{
				curl_close($curlL);
				$xmlL = simplexml_load_string($xmlClimaLoc);
				?>
		<select id="ListClimaL" class="ListaClima">
				<?php
				foreach ($xmlL->location->data as $lineL) 
				{
   	   		?>
   		<option value="<?=$lineL->name->attributes()->id?>" class="ClimaProv"><?=$lineL->name?></option>
   	   		<?php
	   	   }
	    		?>
		</select>
		<button onclick="ChangeCity();">Cambiar Ciudad</button>
		<button onclick=" return CloseCities();">Cerrar</button>
				<?php
			}else 
			{
				?>
		<h2>Lamentablemente el servicio se encuentra momentaneamente deshabilitado.</h2>
		<h3>Disculpe las molestias.</h3>
		<button onclick=" return CloseCities();">Cerrar</button>
				<?php
			}
		}else 
		{
			?>
		<h2>Lamentablemente el servicio se encuentra momentaneamente deshabilitado.</h2>
		<h3>Disculpe las molestias.</h3>
		<button onclick=" return CloseCities();">Cerrar</button>
			<?php
		}
	}else 
	{
		?>
		<h2>Lamentablemente el servicio se encuentra momentaneamente deshabilitado.</h2>
		<h3>Disculpe las molestias.</h3>
		<button onclick=" return CloseCities();">Cerrar</button>
		<?php
	}
	?>
	</div>
</div>
	<?php
	die();
}
//Fin Modificacion 8-8-13 Widget Clima
