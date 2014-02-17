<?php
	add_action('wp_ajax_alr_clima_change', 'alr_clima_cntmod');
	add_action('wp_ajax_nopriv_alr_clima_change', 'alr_clima_cntmod');
	
	//Pantalla para cambiar la localidad de donde se va a mostrar el clima
	function alr_clima_cntmod()
	{
		global $wpdb;
		$provs=$wpdb->get_results("SELECT pro_id AS id, pro_name AS name FROM ".$wpdb->prefix."clima_provincias ORDER BY pro_name ASC");
		if($wpdb->num_rows>0) 
		{
			foreach ($provs as $prov)
			{
				$response['provincias'][intval($prov->id)]=(string) $prov->name;
			}
			$pid=$provs[0]->id;
			$response['localidades']=alr_clima_get_localidades($pid);
		}
		$response['request']="success";
		echo json_encode($response);
		die();
	}
		
	add_action('wp_ajax_alr_clima_selloc', 'alr_clima_localidades');
	add_action('wp_ajax_nopriv_alr_clima_selloc', 'alr_clima_localidades');
	
	
	function alr_clima_localidades()
	{
		$response['localidades']=alr_clima_get_localidades($_POST['pid']);
		$response['request']="success";
		echo json_encode($response);
		die();
	}
	
	
	function alr_clima_get_localidades($pid=0)
	{
		global $wpdb;
		$wpdb->hide_errors();
		$locs=$wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."clima_localidades WHERE loc_pro_id=%d ORDER BY loc_name ASC",$pid));
		if($wpdb->num_rows>0) 
		{
			foreach ($locs as $loc)
			{
				$response[intval($loc->loc_id)]=(string) $loc->loc_name;
			}
			return $response;				
		}
	}
	
	add_action('wp_ajax_alr_clima_NewLoc', 'alr_clima_city_update');
	add_action('wp_ajax_nopriv_alr_clima_NewLoc', 'alr_clima_city_update');
	
	function alr_clima_city_update()
	{
		if(isset($_POST['lid']) && intval($_POST['lid'])>0) 
		{
			global $wpdb;
			$wpdb->hide_errors();
			$wpdb->get_results($wpdb->prepare("SELECT loc_id AS id FROM ".$wpdb->prefix."clima_localidades WHERE loc_id=%d",$_POST['lid']));
			if($wpdb->num_rows>0) 
			{
				session_start();
				$_SESSION['alr_clima_id']=intval($_POST['lid']);
				$response['localidad']=intval($_POST['lid']);
				$response['request']="success";
				echo json_encode($response);
			}else 
			{
				$response['request']="error";
				$response['error']="Localidad Inexistente";
				echo json_encode($response);
			}
		}else 
		{
			$response['request']="error";
			$response['error']="ID Localidad - Invalido";
			echo json_encode($response);
		}
		die();
	}
?>