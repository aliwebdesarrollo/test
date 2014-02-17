<?php
function get_farmaciasdeturno() 
{
	$farmtur=array();
	//$j=file_get_contents("http://www.turnos.colfarmamdp.com.ar/");
	$j=file_get_contents("http://www.turnos.colfarmamdp.com.ar/farmaturno3.php?fecha=13/10/2013");
	//var_dump($j);
	$farm_file="http://www.turnos.colfarmamdp.com.ar/farmaturno3.php?fecha=13/10/2013";
	//var_dump($farm_file);
	//$farm_file=json_decode($farm_file);
	//var_dump($farm_file);
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL,$farm_file);
	// Disable SSL verification
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	// Will return the response, if false it print the response
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
	$HtmlFarm = curl_exec($curl);
	if(curl_errno($curl)==0) 
	{
		/*if($j!="") 
		{
		
			$begin=strrpos($HtmlFarm,"<tbody >");
			$end=strrpos($HtmlFarm,"</tbody>");
			$j=substr($HtmlFarm,$begin,$end-$begin);
			$j=str_replace("<td >","<td>",$HtmlFarm);
			$x=explode("<tbody >,",$HtmlFarm);
			$i=explode("<tr>",$x[0]);
			$n=0;
			foreach($i as $p)
			{
				if($n>0) 
				{
					$m=explode("<td>",$p);
					foreach($m as $l=>$t)
					{
						//echo strip_tags($l)." - ".strip_tags($t);
						if($l>1) 
						{
							$farmtur[$n][$l]=strip_tags($t);
							//echo strip_tags($t);
						}
					}
				}
				$n++;
			}
		//}*/
	}
	var_dump(json_decode($HtmlFarm));
	return;
}

//get_farmaciasdeturno();
?>