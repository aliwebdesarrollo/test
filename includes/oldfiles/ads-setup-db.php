<?php
function UpdateDatabase() 
{
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	
	$table_name1 = "wp_an_ads_pages_name";
	$sql_table1="CREATE TABLE IF NOT EXISTS $table_name1 (anp_id int(11) NOT NULL AUTO_INCREMENT, anp_name varchar(50) NOT NULL, PRIMARY KEY (anp_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	//echo $sql_table1;
	dbDelta( $sql_table1 );
	
	$sql_ins1="INSERT INTO $table_name1 (anp_id, anp_name) VALUES (1,'Pagina Principal'),(2,'Categorias'),(3,'Paginas'),(4,'Entradas'),(5,'Gossip');";
	//echo $sql_ins1;
	dbDelta( $sql_ins1 );



	$table_name2 = "wp_an_ads_banners_size";
	$sql_table2="CREATE TABLE IF NOT EXISTS $table_name2 (anbs_id int(11) NOT NULL AUTO_INCREMENT, anbs_name varchar(200) NOT NULL, anbs_width int(4) NOT NULL, anbs_height int(4) NOT NULL, PRIMARY KEY (anbs_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	//echo $sql_table2;
	dbDelta( $sql_table2 );
	
	$sql_ins2="INSERT INTO $table_name2 (anbs_name, anbs_width, anbs_height) VALUES ('Cuadrado 200 x 200', 200, 200),('Cuadrado 250 x 250', 250, 250),('Vertical 200 x 410', 200, 410),('Horizontal 950 x 200',950,200),('Horizontal 950 x 150', 950, 150),('Horizontal 950 x 100', 950, 100),('Vertical 180 x 410', 180, 410),('Vertical 250 x 300', 250, 300);";
	//echo $sql_ins2;
	dbDelta( $sql_ins2 );	



	$table_name3 = "wp_an_ads_banners";
	$sql_table3="CREATE TABLE IF NOT EXISTS $table_name3 (anb_id int(11) NOT NULL AUTO_INCREMENT, anb_url varchar(200), anb_image int (11), anb_anbs_id int(11), PRIMARY KEY (anb_id), KEY anb_anbs_id(anb_anbs_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	//echo $sql_table3;
	dbDelta( $sql_table3 );
	


	$table_name4 = "wp_an_ads_adsense_size";
	$sql_table4="CREATE TABLE IF NOT EXISTS $table_name4 (anas_id int(11) NOT NULL AUTO_INCREMENT, anas_name varchar(200) NOT NULL, anas_width int(4) NOT NULL, anas_height int(4) NOT NULL, PRIMARY KEY (anas_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	//echo $sql_table4;
	dbDelta( $sql_table4);
	
	$sql_ins4="INSERT INTO $table_name4 (anas_name, anas_width, anas_height) VALUES('300 x 250: rectangulo mediano ', 300, 250),('336 x 280: rectangulo grande ', 336, 280), ('728 x 90: skyscraper horizontal ', 728, 90), ('160 x 600: skyscraper ancho', 160, 600), ('468 x 60: banner', 468, 60),('234 x 60: medio banner',234,60),('120 x 600: skycrapper',120,600),('120 x 240: banner vertical',120,240),('250 x 250: cuadrado',250,250),('200 x 200: cuadrado pequeño',200,200),('180 x 150: rectangulo pequeño',180,150),('125 x 125: boton',125,125),('728 x 15: horizontal grande',728,15),('468 x 15: horizontal mediano',468,15),('200 x 90: vertical extragrande',200,90),('180 x 90: vertical grande',180,90),('160 x 90: vertical mediano',160,90),('120 x 90: vertical pequeño',120,90);";
	//echo $sql_ins4;
	dbDelta( $sql_ins4 );	



	$table_name5 = "wp_an_ads_adsense";
	$sql_table5="CREATE TABLE IF NOT EXISTS $table_name5 (ana_id int(11) NOT NULL AUTO_INCREMENT, ana_name varchar(200), ana_code text, ana_anas_id int(1), ana_anp_id int(11), PRIMARY KEY (ana_id), KEY ana_anas_id(ana_anas_id), KEY ana_anp_id(ana_anp_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	//echo $sql_table5;
	dbDelta( $sql_table5 );
	
	$sql_ins5="INSERT INTO $table_name5 (ana_name, ana_anp_id) VALUES ('AdSense 1',1),('AdSense 2',1),('AdSense 3',1),('AdSense Gossip 1',5),('AdSense Gossip 2',5),('AdSense 1',2),('AdSense 2',2),('AdSense 3',2),('AdSense 1',3),('AdSense 2',3),('AdSense 3',3),('AdSense 1',4),('AdSense 2',4),('AdSense 3',4);";
	//echo $sql_ins5;
	dbDelta( $sql_ins5 );


	$table_name6 = "wp_an_ads_publicidad";
	$sql_table6="CREATE TABLE IF NOT EXISTS $table_name6 (ads_id int(11) NOT NULL AUTO_INCREMENT, ads_name varchar(100) NOT NULL, ads_maxwidth int(4), ads_maxheight int(4), ads_resize int(1), ads_anb_id int(11), ads_anp_id int (11), PRIMARY KEY (ads_id), KEY ads_anb_id(ads_anb_id), KEY ads_anp_id(ads_anp_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	//echo $sql_table6;
	dbDelta( $sql_table6 );
	
	$sql_ins6="INSERT INTO $table_name6 (ads_name, ads_maxwidth, ads_maxheight, ads_resize, ads_anp_id) VALUES ('Banner 1 - Horizontal',950,100,1,1),('Banner 2 - Horizontal',950,200,1,1),('Banner 3 - Cuadrado',200,200,0,1),('Banner 4 - Cuadrado',200,200,0,1),('Banner 5 - Horizontal',950,200,1,1),('Banner 6 - Vertical',250,300,1,1),('Banner 7 - Horizontal',950,200,1,1),('Banner 8 - Horizontal',950,200,1,1),('Banner 9 - Vertical',200,410,0,1),('Banner 10 - Cuadrado',200,200,0,1),('Banner 11 - Horizontal',950,200,1,1),('Banner Gossip - Vertical',180,410,0,5),('Banner 1 - Cuadrado',250,250,0,2),('Banner 2 - Cuadrado',250,250,0,2),('Banner 3 - Cuadrado',250,250,0,2),('Banner 4 - Cuadrado',250,250,0,2),('Banner 5 - Cuadrado',250,250,0,2),('Banner 6 - Cuadrado',250,250,0,2),('Banner 1 - Cuadrado',250,250,0,3),('Banner 2 - Cuadrado',250,250,0,3),('Banner 3 - Cuadrado',250,250,0,3),('Banner 4 - Cuadrado',250,250,0,3),('Banner 5 - Cuadrado',250,250,0,3),('Banner 1 - Cuadrado',250,250,0,4),('Banner 2 - Cuadrado',250,250,0,4),('Banner 3 - Cuadrado',250,250,0,4),('Banner 4 - Cuadrado',250,250,0,4),('Banner 5 - Cuadrado',250,250,0,4);";
	//echo $sql_ins6;
	dbDelta( $sql_ins6 );
	
	
	update_option("an_aliwebnews_ads",true);
}		


//Verifico si esta en el sistema la opcion "an_aliwebnews_ads" funciona como control para agregar las tablas.
$opt=get_option("an_aliwebnews_ads");
if($opt!=false) 
{
}else 
{
	UpdateDatabase();
}
?>