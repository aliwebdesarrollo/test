<?php
//Modificacion 13-2-14 Widget Dolar

function getDolar() 
{
	$feed_dolar = "http://themoneyconverter.com/rss-feed/ES/USD/rss.xml";
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL,$feed_dolar);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
	$xmlUsd = curl_exec($curl);
	if(curl_errno($curl)==0) 
	{
		$xml = simplexml_load_string(str_replace(array("&amp;", "&"),array("&", "&amp;"),$xmlUsd));
		if($xml!=false) 
		{
			$dolar=false;
			foreach($xml->channel->item as $item) 
			{
				if($item->title=="ARS/USD"){
					$cots=explode("=",$item->description);
					foreach ($cots as $cot){
						$usd[]=floatval(str_replace(",",".",$cot));
					}
				}
			}
			return $usd[1];
		}
	}
	// Cerrar recurso
	curl_close($curl);
}


function getEuro() 
{
	$feed_euro = "http://themoneyconverter.com/rss-feed/ES/EUR/rss.xml";
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL,$feed_euro);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
	$xmlEuro = curl_exec($curl);
	if(curl_errno($curl)==0) 
	{
		$xml = simplexml_load_string(str_replace(array("&amp;", "&"),array("&", "&amp;"),$xmlEuro));
		if($xml!=false) 
		{
			$euro=false;
			foreach($xml->channel->item as $item) 
			{
				if($item->title=="ARS/EUR"){
					$cots=explode("=",$item->description);
					foreach ($cots as $cot){
						$euro[]=floatval(str_replace(",",".",$cot));
					}
				}
			}
			return $euro[1];
		}
	}
	// Cerrar recurso
	curl_close($curl);
}
function getCotizacion(){
	$cotiza['dolar']=getDolar();
	$cotiza['euro']=getEuro();
	return $cotiza;
}

//Fin Modificacion 13-2-14 Widgets Dolar
?>