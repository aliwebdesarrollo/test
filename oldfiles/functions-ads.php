<?php
/*
Plugin Name: aliwebnewsAds
Plugin URI:http://www.aliwebnews.com.ar
Description: Complemento para la plantilla Aliwebnews permite agregar las publicidades a la plantilla.
Version: 1.0
Author: Aliweb Desarrollo
Author URI: http://www.aliweb.com.ar
License:GPL2
*/

/*
	Copyright 2012  Aliweb Desarrollo  (email : contacto@aliweb.com.ar)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

//Add special CSS Stylesheet to Admin
function an_load_custom_wp_admin_style($hook) 
{
	switch(strtolower($hook))
	{
		case "publicidades_page_an_mainads":
		case "publicidades_page_an_catads":
		case "publicidades_page_an_pageads":
		case "publicidades_page_an_postads":
		case "publicidades_page_an_adsense":
	
			wp_register_style( 'an-ads-style',  get_template_directory_uri().'/css/admin-ads.css', false, '1.0.0', 'all' );
			wp_enqueue_style( 'an-ads-style' );

			wp_deregister_script('jquery');
			wp_register_script('jquery', get_template_directory_uri().'/js/jquery-1.10.2.js', false, '1.10.2', false);
			wp_enqueue_script('jquery');
	
			wp_register_script('an-ads', get_template_directory_uri().'/js/an-ads.js', array( 'jquery' ), '1.0', true);
			wp_enqueue_script('an-ads');
			break;
	}
}
add_action( 'admin_enqueue_scripts', 'an_load_custom_wp_admin_style',15 );

//include_once "includes/Elementos.php";

function mytheme_add_admin() 
{
	add_menu_page( 'Publicidades', 'Publicidades', 'manage_options', 'aliweb_ads', '', '', 6 );
	add_submenu_page( 'aliweb_ads', 'Pagina Principal', 'Pagina Principal', 'manage_options', 'an_mainads', 'mainads_admin');
	add_submenu_page( 'aliweb_ads', 'Categorias', 'Categorias', 'manage_options', 'an_catads', 'catads_admin');
	add_submenu_page( 'aliweb_ads', 'Paginas', 'Paginas', 'manage_options', 'an_pageads', 'pageads_admin');
	add_submenu_page( 'aliweb_ads', 'Entradas', 'Entradas', 'manage_options', 'an_postads', 'postads_admin');
	add_submenu_page( 'aliweb_ads', 'AdSense', 'AdSense', 'manage_options', 'an_adsense', 'adsense_admin');
	remove_submenu_page( "aliweb_ads", "aliweb_ads" );
}
add_action('admin_menu', 'mytheme_add_admin');

include_once "includes/ads-setup-db.php";

include_once "includes/ads-home.php";

include_once "includes/ads-category.php";

include_once "includes/ads-page.php";

include_once "includes/ads-single.php";

include_once "includes/ads-adSense.php";

function ads_add_admin($opts) 
{
	if ( isset($_GET['page']))
	{
		if ( 'save' == isset($_REQUEST['action']) ) 
		{
			foreach ($opts as $value) 
			{
				update_option( $value['id'], $_REQUEST[ $value['id'] ] ); 
			}
			foreach ($opts as $value) 
			{
				if( isset( $_REQUEST[ $value['id'] ] ) ) 
				{ 
					update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); 
				}else 
				{ 
					delete_option( $value['id'] ); 
				}	 
			}
		}else if( 'reset' == isset($_REQUEST['action']) ) 
		{
			foreach ($opts as $value) 
			{
				delete_option( $value['id'] ); 
			}
    	}
  	}
}
?>