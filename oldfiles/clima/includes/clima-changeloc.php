<?php
	add_action('wp_ajax_an_clima_change', 'an_clima_cntmod');
	add_action('wp_ajax_nopriv_an_clima_change', 'an_clima_cntmod');
	
	//Pantalla para cambiar la localidad de donde se va a mostrar el clima
	function an_clima_cntmod()
	{
		global $wpdb;
		$provs=$wpdb->get_results("SELECT pro_id AS id, pro_name AS name FROM wp_an_clima_provincias ORDER BY pro_name ASC");
		if($wpdb->num_rows>0) 
		{
			foreach ($provs as $prov)
			{
				$response['provincias'][intval($prov->id)]=(string) $prov->name;
			}
			$pid=$provs[0]->id;
			$response['localidades']=an_clima_get_localidades($pid);
		}
		$response['request']="success";
		echo json_encode($response);
		die();
	}
		
	add_action('wp_ajax_an_clima_selloc', 'an_clima_localidades');
	add_action('wp_ajax_nopriv_an_clima_selloc', 'an_clima_localidades');
	
	
	function an_clima_localidades()
	{
		$response['localidades']=an_clima_get_localidades($_POST['pid']);
		$response['request']="success";
		echo json_encode($response);
		die();
	}
	
	
	function an_clima_get_localidades($pid=0)
	{
		global $wpdb;
		$wpdb->hide_errors();
		$locs=$wpdb->get_results($wpdb->prepare("SELECT * FROM wp_an_clima_localidades WHERE loc_pro_id=%d ORDER BY loc_name ASC",$pid));
		if($wpdb->num_rows>0) 
		{
			foreach ($locs as $loc)
			{
				$response[intval($loc->loc_id)]=(string) $loc->loc_name;
			}
			return $response;				
		}
	}
	
	add_action('wp_ajax_an_clima_NewLoc', 'an_clima_city_update');
	add_action('wp_ajax_nopriv_an_clima_NewLoc', 'an_clima_city_update');
	
	function an_clima_city_update()
	{
		if(isset($_POST['lid']) && intval($_POST['lid'])>0) 
		{
			global $wpdb;
			$wpdb->hide_errors();
			$wpdb->get_results($wpdb->prepare("SELECT loc_id AS id FROM wp_an_clima_localidades WHERE loc_id=%d",$_POST['lid']));
			if($wpdb->num_rows>0) 
			{
				session_start();
				$_SESSION['an_clima_id']=intval($_POST['lid']);
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