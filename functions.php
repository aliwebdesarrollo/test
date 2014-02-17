<?php
	define("Shortname","alr_");
	//Registrar Estilos y Javascript	
	function alr_enqueue_css_js() {
		
		//Estilos
		wp_enqueue_style( 'bootstrap-css', get_template_directory_uri()."/css/bootstrap.css" ,false,"3.0.1");
				
		wp_enqueue_style( 'bootstrap-theme-css', get_template_directory_uri()."/css/bootstrap-theme.css" ,array('bootstrap-css'),"3.0.3.1");
		wp_enqueue_style( 'sticky-footer-css', get_template_directory_uri()."/css/sticky-footer.css" ,array('bootstrap-css'),"1.0");	
		wp_enqueue_style( 'font-awesome-css', get_template_directory_uri()."/css/font-awesome/css/font-awesome.min.css", array('bootstrap-css'), "4.0.3" );
		wp_enqueue_style( 'custom-css', get_template_directory_uri()."/css/custom.css" ,false,"1.0");
		wp_enqueue_style( 'opensans-css', "http://fonts.googleapis.com/css?family=Open+Sans:400,300,700,600,800" ,false,"1.0");
		
		if(is_home()) {
			wp_enqueue_style( 'responsiveslides-css', get_template_directory_uri()."/css/responsiveslides.css" ,false,"1.54");
		}
		
		if(is_single()){
			wp_enqueue_style( 'bootstrap-blog-css', get_template_directory_uri()."/css/blog.css" ,array('bootstrap-css'),"1.0");
			wp_enqueue_style( 'colorbox-css', get_template_directory_uri()."/css/colorbox.css" ,false,"1.0");
		}
				
		//Javascript
		wp_deregister_script('jquery');
		wp_register_script('jquery', get_template_directory_uri().'/js/jquery.min.js', false, '1.10.2', false);
		//wp_register_script('jquery', "http://code.jquery.com/jquery.js", false, '1.11', false);
		
		wp_enqueue_script('jquery');
		
		wp_register_script('bootstrap-js', get_template_directory_uri().'/js/bootstrap.js', array( 'jquery' ), '3.0.3', false);
		wp_enqueue_script('bootstrap-js');
		
		wp_register_script('youtube-js', "https://apis.google.com/js/platform.js", false, '1.0', false);
		wp_enqueue_script('youtube-js');		
		
		if(is_home()){
			wp_register_script('responsiveslides', get_template_directory_uri().'/js/responsiveslides.js', array( 'jquery' ), '1.54', false);
			wp_enqueue_script('responsiveslides');
			
			wp_register_script('custom-js', get_template_directory_uri().'/js/custom.init.js', array( 'jquery'), '1.0', true);
			wp_enqueue_script('custom-js');
		}
		
		if(is_archive() || is_category() || is_tag() || is_author() || is_search()){

			wp_register_script('ImagesLoaded', get_template_directory_uri().'/js/imagesloaded.pkgd.js', array( 'jquery' ), '3.1.1', false);
			wp_enqueue_script('ImagesLoaded');
			
			wp_register_script('wookmark', get_template_directory_uri().'/js/jquery.wookmark.js', array( 'jquery' ), '1.4.5', false);
			wp_enqueue_script('wookmark');
			
			wp_register_script('custom-js', get_template_directory_uri().'/js/custom.inside.js', array( 'jquery', 'ImagesLoaded', 'wookmark' ), '1.0', true);
			wp_enqueue_script('custom-js');
		}
		
		if(is_single()){
			wp_register_script('colorbox', get_template_directory_uri().'/js/jquery.colorbox.js', array( 'jquery' ), '1.4.28', false);
			wp_enqueue_script('colorbox');

			wp_register_script('colorbox-es', get_template_directory_uri().'/js/jquery.colorbox-es.js', array( 'jquery' ), '1.4.28', false);
			wp_enqueue_script('colorbox-es');

			wp_register_script('custom-single', get_template_directory_uri().'/js/custom.single.js', array( 'jquery', 'colorbox', 'colorbox-es' ), '1.0', true);
			wp_enqueue_script('custom-single');
		}
	}
	add_action('wp_enqueue_scripts', 'alr_enqueue_css_js',60);
	
	
	//Register Specific Taxonomy Template
	add_action( 'init', 'alr_create_displays' );
	function alr_create_displays() {
 		$labels = array(
			'name' => _x( 'Display', 'taxonomy general name' ),
			'singular_name' => _x( 'Display', 'taxonomy singular name' ),
			'search_items' =>  __( 'Buscar Display' ),
			'all_items' => __( 'Todos Displays' ),
			'edit_item' => __( 'Editar' ), 
			'update_item' => __( 'Actualizar' ),
			'add_new_item' => __( 'Agregar Nuevo' ),
			'new_item_name' => __( 'Nuevo Nombre Display:' ),
		); 	
 
		register_taxonomy(
			'display','post',array(
				'hierarchical' => false,
				'labels' => $labels,
				'show_admin_column'=>true
			)
		);
	}
	
	
	//Register Specific Taxonomy Template
	add_action( 'init', 'alr_create_redactor' );
	function alr_create_redactor() {
 		$labels = array(
			'name' => _x( 'Redactor', 'taxonomy general name' ),
			'singular_name' => _x( 'Redactor', 'taxonomy singular name' ),
			'search_items' =>  __( 'Buscar Redactor' ),
			'all_items' => __( 'Todos los Redactores' ),
			'edit_item' => __( 'Editar' ), 
			'update_item' => __( 'Actualizar' ),
			'add_new_item' => __( 'Agregar Nuevo' ),
			'new_item_name' => __( 'Nuevo Nombre Redactor:' ),
		); 	
 
		register_taxonomy(
			'redactor','post',array(
				'hierarchical' => false,
				'labels' => $labels,
			)
		);
	}
	
	//Register Specific Taxonomy Template
	add_action( 'init', 'alr_create_fuente' );
	function alr_create_fuente() {
 		$labels = array(
			'name' => _x( 'Fuente', 'taxonomy general name' ),
			'singular_name' => _x( 'Fuente', 'taxonomy singular name' ),
			'search_items' =>  __( 'Buscar Fuente' ),
			'all_items' => __( 'Todos Fuente' ),
			'edit_item' => __( 'Editar' ), 
			'update_item' => __( 'Actualizar' ),
			'add_new_item' => __( 'Agregar Nuevo' ),
			'new_item_name' => __( 'Nuevo Nombre Fuente:' ),
		); 	
 
		register_taxonomy(
			'fuente','post',array(
				'hierarchical' => false,
				'labels' => $labels,
			)
		);
	}

	//Include all settings and personalized plugins
	get_template_part("includes/alr","settings");
	// Register Custom Navigation Walker
	get_template_part("includes/alr","bootstrap-navwalker");
	//Include Clima Functions
	get_template_part("includes/alr","clima");
	//Include Estrenos
	get_template_part("includes/alr","cine");
	//Include Galeria de Imagenes
	get_template_part("includes/alr","gallery");
	//Include Youtube Video
	get_template_part("includes/alr","youtube");
	//Include Cotizacion Dolar - Euro
	get_template_part("includes/alr","cotizacion");


	function alr_get_menu_name($needle)
	{
		$menu_locations = (array) get_nav_menu_locations();

		// In the line below change "primary" to your menu ID (the 'theme_location' parameter in wp_nav_menu())
		$menu_name = get_term_by( 'id', (int) $menu_locations[ $needle ], 'nav_menu', ARRAY_A );
		
		return $menu_name;
	}	
	
	function get_display_colors() {
		$colors=array("negro"=>"Negro",
			"rojo"=>"Rojo",
			"rojo-pastel"=>"Rojo Pastel",
			"rojo-oscuro" => "Rojo Oscuro",
			"azul" => "Azul",
			"verde" => "Verde",
			"amarillo" => "Amarillo",
			"violeta" => "Violeta",
			"celeste" => "Celeste",
			"celeste-pastel" => "Celeste Pastel",
			"pastel" => "Pastel",
			"pastel-oscuro" => "Pastel Oscuro",
			"gris" => "Gris",
			"gris-oscuro" => "Gris Oscuro",
			"gris-claro" => "Gris Claro",
			"naranja" => "Naranja",
			"limon-pastel" => "Limon Pastel",
			"marron-pastel" => "Marron Pastel",
			"rosa-pastel" => "Rosa Pastel",
			"verde-pastel" => "Verde Pastel"
		);
		return $colors;
	}	
	
	// Add term page
	function alr_new_color_display() {
	// this will add the custom meta field to the add new term page
	?>
	<div class="form-field">
		<label for="meta_color"><?php echo "Color de Fondo"; ?></label>
		<select name="meta_color" id="meta_color">
			<?php $colores=get_display_colors(); 
			foreach($colores as $k=>$v){?>
			<option value="<?php echo $k;?>"><?php echo $v;?></option>
			<?php }?>
		</select>
		<p class="description"><?php echo "Ingrese un color"; ?></p>
	</div>
	<?php
	}
	add_action( 'display_add_form_fields', 'alr_new_color_display', 10, 2 );
	
	// Edit term page
	function alr_edit_color_display($term) {
 
		// put the term ID into a variable
		$t_id = $term->term_id;
	 
		// retrieve the existing value(s) for this meta field. This returns an array
		$term_meta = get_option( "alr_color_$t_id",false );?>
	<tr class="form-field">
	<th scope="row" valign="top"><label for="meta_color"><?php echo "Color de Fondo"; ?></label></th>
		<td>
			<select name="meta_color" id="meta_color">
			<?php $colores=get_display_colors(); 
			foreach($colores as $k=>$v){?>
				<option value="<?php echo $k;?>" <?php (trim($term_meta['color'])==trim($k))? print("selected"):'';?>><?php echo $v;?></option>
			<?php }?>
			</select>			
			<p class="description"><?php echo "Ingrese un color"; ?></p>
		</td>
	</tr>
<?php
}
add_action( 'display_edit_form_fields', 'alr_edit_color_display', 10, 2 );

// Save extra taxonomy fields callback function.
function save_taxonomy_custom_meta( $term_id ) {
	if ( isset( $_POST['meta_color'] ) ) {
		$t_id = $term_id;
		$term_meta = get_option( "alr_color_$t_id",false );
		if(trim($term_meta['color'])!=trim($_POST['meta_color'])) {
		// Save the option array.
		update_option( "alr_color_$t_id", array("color"=>$_POST['meta_color']) );
		}
	}
}  
add_action( 'edited_display', 'save_taxonomy_custom_meta', 10, 2 );  
add_action( 'create_display', 'save_taxonomy_custom_meta', 10, 2 );


//Agrego taxonomias a los attachments
function wptp_add_categories_to_attachments() {
    register_taxonomy_for_object_type( 'display', 'attachment' );
}
add_action( 'init' , 'wptp_add_categories_to_attachments' );

function alr_get_date(){
	$dia=array("Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo");
	$day=array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
	$mes=array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$month=array("January","February","March","April","May","June","July","August","September","October","November","Deceember");
	$date=date("l, d F Y");
	$date=str_replace($day,$dia,$date);
	$date=str_replace($month,$mes,$date);
	return $date;
}

function alr_category_tree($id){ //modificar clases y estilos
	global $wpdb;
	$query=$wpdb->prepare("SELECT t.name AS name, tr.parent AS parent FROM ".$wpdb->prefix."term_taxonomy AS tr INNER JOIN ".$wpdb->prefix."terms AS t ON t.term_id=tr.term_id WHERE tr.term_id=%d AND tr.taxonomy='category'",$id);		
	$res=$wpdb->get_results($query);
	foreach($res as $category)
	{
		if($category->parent != 0)
		{
			alr_category_tree($category->parent);
		}
		echo (($category->parent==0)? "<span class='font-cat-tree'><a href='".home_url( '/' )."'>Inicio</a> <i class='fa fa-chevron-right'></i> ":" <i class='fa fa-chevron-right'></i> ")."<a href='".get_category_link($id)."'>".$category->name."</a></span>";
	}
	$wpdb->flush();
}
	
function alr_tags_more_used(){
	$month_ago=date("Y/m/d", strtotime("-1 month"));
	global $wpdb;
	$query=$wpdb->prepare("SELECT count(T.term_id) AS total, T.term_id AS id, T.name AS name FROM (".$wpdb->prefix."posts AS P, ".$wpdb->prefix."term_relationships AS TR, ".$wpdb->prefix."term_taxonomy AS TT, ".$wpdb->prefix."terms AS T) WHERE P.ID = TR.object_id AND TR.term_taxonomy_id = T.term_id AND TR.term_taxonomy_id = TT.term_taxonomy_id AND TT.taxonomy='post_tag' AND P.post_date > %s AND P.post_type='post' AND P.post_status='publish' GROUP BY T.term_id ORDER BY Total DESC LIMIT 10",$month_ago);
	$res=$wpdb->get_results($query);
	shuffle($res);
	$wpdb->flush();
	return $res;
}

function alr_tags_total($obj){
	if(!empty($obj)) 
	{
		foreach($obj as $tag)
		{
			$total+=$tag->Total;
		}
		return $total;
	}else 
	{
		return;
	}
}
	
function alr_post_most_view($postid=0) {
	global $wpdb;
	$meta_key="_count-views_month-".date("Y").date("m");
	$query=$wpdb->prepare("SELECT DISTINCT(p.ID) FROM (".$wpdb->prefix."posts as p, ".$wpdb->prefix."postmeta as pm, ".$wpdb->prefix."term_relationships as tr, ".$wpdb->prefix."term_taxonomy as tt) WHERE p.ID=pm.post_id AND pm.meta_key= %s AND tr.object_id=p.ID AND tr.term_taxonomy_id=tt.term_taxonomy_id AND p.ID NOT IN (SELECT ID FROM (".$wpdb->prefix."posts as p2, ".$wpdb->prefix."term_relationships as tr2) WHERE p2.ID=tr2.object_id AND tr2.term_taxonomy_id IN(%d, %d, %d, %d, %d, %d)) AND p.ID NOT IN(%d) ORDER BY CAST(pm.meta_value AS DECIMAL(5,0))DESC LIMIT 5", $meta_key, get_option(Shortname."main-cat",0), get_option(Shortname."index-cat",0), get_option(Shortname."page-cat",0), get_option(Shortname."single-cat",0), get_option(Shortname."cat-cat",0), get_option(Shortname."tag-cat",0), $postid);
	$res=$wpdb->get_results($query);
	if(count($res)>0) {				
		$wpdb->flush();
		return $res;
	}else 
	{
		$wpdb->flush();
		return false;
	}		
}

function alr_get_fuentes($pID){
	$fuentes=wp_get_post_terms($pID, "fuente", array("name","description"));
	return (count($fuentes)>0)? $fuentes:false;
}


function alr_get_redactores($pID){
	$redactores=wp_get_post_terms($pID, "redactor", array("name","description"));
	return (count($redactores)>0)? $redactores:false;
}

function alr_get_view_counts($pID){
	$views=do_shortcode('[post_view id='.$pID.']');
	return ($views>50)? $views:false;
}

function alr_get_videos($pID){
	$meta_youtube =get_post_meta( $pID, 'meta-alr-youtube', false );
	return (($meta_youtube!=false) && ($meta_youtube[0]!=""))? $meta_youtube:false;
}

function alr_get_gallery($pID){
	$gallery=get_post_meta($pID,'meta-gallery',false);
	return $gallery;
}

function alr_post_preview($pID){
	$redactores=alr_get_redactores($pID);
	$gallery=alr_get_gallery($pID);
	$videos=alr_get_videos($pID);
	$view=alr_get_view_counts($pID);
	if($redactores || $gallery || $videos || $view){?>
		<div class="info">
		<?php if($redactores!=false){?>
			<div <?php ($gallery!=false || $videos!=false || $view!=false)? print('class="col-sm-9 col-xs-9 col-md-9 col-lg-9 redactores"') : print('class="col-sm-12 col-xs-12 col-md-12 col-lg-12 redactores"');?> >
			<?php	foreach($redactores as $redactor){?>
				<span class="redactor-info"><?php echo $redactor->description.": ".$redactor->name; ?></span>
			<?php }?>
			</div>
		<?php  }
		if($gallery || $videos || $view){?>
			<div <?php ($redactores!=false)? print('class="col-sm-3 col-xs-3 col-md-3 col-lg-3 info-gral"'):print('class="col-sm-12 col-xs-12 col-md-12 col-lg-12 info-gral"');?> >
			<?php echo ($gallery!=false)? "<i class='fa fa-camera-retro'> ".count(explode(",",$gallery[0]))."</i>":"";?>
			<?php if($view!=false){?><i class="fa fa-eye"><?php echo $view;?></i><?php }?>
  			<?php if($videos!=false){?> <i class="fa fa-video-camera"> 1</i> <?php	} ?>
			</div>
		<?php	} ?>
		</div>
<?php } 
}

function alr_get_title($pID){
	$p = get_the_tags($pID);
	if($p!=false){$p=array_shift($p);} 
	return $p;
}
?>