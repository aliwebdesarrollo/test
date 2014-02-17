<?php
	//Add special CSS Stylesheet to Admin
	function an_load_staff_style($hook) 
	{
		switch(strtolower($hook))
		{
			case "staff_page_an_staff_schema":
			case "staff_page_an_staff_list":
				wp_deregister_script('jquery');
				wp_register_script('jquery', get_template_directory_uri().'/js/jquery-1.10.2.js', false, '1.10.2', false);
				wp_enqueue_script('jquery');
				
				wp_register_style( 'aliwebnewsStaff',  get_template_directory_uri().'/css/admin-staff.css', false, '1.0.0', 'all' );
				wp_enqueue_style( 'aliwebnewsStaff' );
					  
				wp_register_script('an-staff', get_template_directory_uri().'/js/an-staff.js', array( 'jquery' ), '0.1', true);
				wp_enqueue_script('an-staff');
			break;
		}
	}
	
	add_action( 'admin_enqueue_scripts', 'an_load_staff_style',15 );
	
	function an_staff_menu() 
	{
		add_menu_page( 'Staff', 'Staff', 'manage_options', 'aliweb_staff', '', '', 15);
		add_submenu_page( 'aliweb_staff', 'Cargos Laborales', 'Cargos Laborales', 'manage_options', 'an_staff_schema', 'staff_schema');
		add_submenu_page( 'aliweb_staff', 'Staff Completo', 'Staff Completo', 'manage_options', 'an_staff_list', 'staff_list');
		remove_submenu_page( "aliweb_staff", "aliweb_staff" );
	}
	add_action('admin_menu', 'an_staff_menu');
	
	include_once "includes/staff-schema.php";
	
	include_once "includes/staff-schema-add.php";
	
	include_once "includes/staff-schema-edit.php";
	
	include_once "includes/staff-list.php";
	
	include_once "includes/staff-list-add.php";
	
	include_once "includes/staff-list-edit.php";
	
	//Funcion para agregar las tablas correspondientes para utilizar esta funcion.
	function UpdateDatabaseStaff()
	{
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$table_name = "wp_an_staff_schema";
		$sql_table="CREATE TABLE IF NOT EXISTS $table_name (sch_id int(11) NOT NULL AUTO_INCREMENT, sch_name varchar(200), sch_prioridad int(1) NOT NULL, sch_estado int(1), PRIMARY KEY (sch_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		dbDelta( $sql_table );
				
		$table_name2 = "wp_an_staff_prioridad";
		$sql_table2="CREATE TABLE IF NOT EXISTS $table_name2 (scp_id int(11) NOT NULL AUTO_INCREMENT, scp_name varchar(50) NOT NULL, PRIMARY KEY (scp_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		dbDelta( $sql_table2 );
		
		$sql_ins2="INSERT INTO $table_name2 (scp_name) VALUES ('Alta'),('Media'),('Baja'),('Ninguna');";
		dbDelta( $sql_ins2 );
		
		$table_name3 = "wp_an_staff_list";
		$sql_table3="CREATE TABLE IF NOT EXISTS $table_name3 (scl_id int(11) NOT NULL AUTO_INCREMENT, scl_name varchar(150) NOT NULL, scl_sch_id int(11) NOT NULL, scl_estado int(1) NOT NULL, PRIMARY KEY (scl_id), KEY scl_sch_id (scl_sch_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		dbDelta( $sql_table3 );
		
		
		update_option("staff_schema",true);		
	}	
	
	//Verifico si esta en el sistema la opcion "staff_schema" funciona como control para agregar las tablas.
	$optstaff=get_option("staff_schema");
	if($optstaff!=false) 
	{
	}else 
	{
		UpdateDatabaseStaff();
	}
?>