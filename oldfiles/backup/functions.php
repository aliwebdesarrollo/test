<?php
/*
Theme Name: Aliweb News
Theme URI: http://www.aliweb.com.ar/
Description: Theme de Noticias <a href="http://www.aliweb.com.ar">Aliweb Desarrollo</a>. Developed by <a href="http://www.aliweb.com.ar">Aliweb Desarrollos</a>.
Version: 1.0
Author: Juan Manuel PiÃ±eiro
Author URI: http://www.aliweb.com.ar
TAGS: news, newspaper, one-column, fixed-width, theme-options, threaded-comments
*/
if ( ! isset( $content_width ) )
  $content_width = 950;


// Theme Setup
add_action( 'after_setup_theme', 'pictures_setup' );
if ( ! function_exists( 'pictures_setup' ) ):
	function pictures_setup() 
	{
	  add_theme_support( 'post-thumbnails' );
	  add_image_size( 'banner70', 950, 70, true );
	  add_image_size( 'banner100', 950, 100, true );
	  add_image_size( 'banner150', 950, 150, true );
	  add_image_size( 'banner200', 950, 200, true );
	  add_image_size( 'bannerGossip', 180, 410, true );
	  add_image_size( 'bannerV410', 200, 410, true );
	  add_image_size( 'bannerV200', 200, 200, true );
	  add_image_size( 'single', 650, 300, true );
	  add_image_size( 'lastmoment', 950, 250, true );
	  add_image_size( 'featured', 500, 300, true );
	  add_image_size( 'headlines', 200, 120, true );
	  add_image_size( 'flashnews', 200, 170, true );
	  add_image_size( 'gossipbig', 320, 240, true ); 
	  add_image_size( 'gossipsmall', 195, 195, true );
	  add_image_size( 'sidebanner', 300, 250, true );
	  
	  //add_theme_support( 'automatic-feed-links' );
	  
	  register_nav_menus( array(
	    'topmenu' => __( 'Main Navigation', 'aliwebnews' ),
	  ));
	  register_nav_menus( array(
	    'footmenu' => __( 'Foot Navigation', 'aliwebnews' ),
	  ));
	  
	}
endif;

update_option('image_default_link_type','none');

add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 100 );
add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 100 );

function remove_thumbnail_dimensions( $html ) {
    $html = preg_replace( '/width=\"\d*\"\s/', "", $html );
    $html = preg_replace( '/height=\"\d*\"\s/', "", $html );
    $html = preg_replace( '/alt=\"\d*\"\s/', "", $html );
    $html = preg_replace( '/class=\"\d*\"\s/', "class='single-img'", $html );
    return $html;
}

//remove class from the_post_thumbnail
/*function the_post_thumbnail_remove_class($output) {
        $output = preg_replace('/class=".*?"/', 'class="single-img"', $output);
        $output = preg_replace('/width=".*?"/', '', $output);
        $output = preg_replace('/height=".*?"/', '', $output);
        $output = preg_replace('/alt=".*?"/', '', $output);
        return $output;
}
add_filter('post_thumbnail_html', 'the_post_thumbnail_remove_class',100);*/

// Limit Chars
function string_limit_words($string, $word_limit) {
  $words = explode(' ', $string, ($word_limit + 1));
  if(count($words) > $word_limit) {
  array_pop($words);
  echo implode(' ', $words)."..."; } else {
  echo implode(' ', $words); }
}


remove_shortcode('gallery', 'gallery_shortcode');

/* Fire our meta box setup function on the post editor screen. */
add_action( 'load-post.php', 'post_meta_gallery_setup' );
add_action( 'load-post-new.php', 'postnew_meta_gallery_setup' );

function add_my_meta_boxes() 
{
	add_meta_box('meta-box-gallery', 'Galeria de Fotos', 'show_my_meta_box', 'post', 'side', 'high');
	add_meta_box('meta-box-journalist', 'Redactor', 'meta_box_journalist', 'post', 'side', 'high');
}


/* Meta box setup function. */
function postnew_meta_gallery_setup() 
{
	add_action('add_meta_boxes', 'add_my_meta_boxes');
}

/* Meta box setup function. */
function post_meta_gallery_setup() 
{
	add_action('add_meta_boxes', 'add_my_meta_boxes');
	/*$post=get_post($_REQUEST['post']);
	$post_content=$post->post_content;
	$post_content=preg_replace('/\[gallery.(.*).\]/','',$post_content );
	$my_post = array();
	$my_post['ID'] =$post->ID;
	$my_post['post_content'] = trim($post_content);*/
	
	// unhook this function so it doesn't loop infinitely
	//remove_action('save_post', 'save_meta_tag_gallery');

	// update the post, which calls save_post again
	//wp_update_post( $my_post );

	// re-hook this function
	add_action( 'save_post', 'save_meta_tag_gallery',99,2 );

	/* Save the meta box's post metadata. */
	function save_meta_tag_gallery( $post_id, $post ) 
	{
		// verify if this is an auto save routine. 
	  // If it is our form has not been submitted, so we dont want to do anything
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return;
			
		// AJAX? Not used here
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) 
			return;
	
		/* Get the post type object. */
		$post_type = get_post_type_object( $post->post_type );
			
		// If this is just a revision or autosave, return
		    if ( wp_is_post_revision( $post_id )) 
			return;	
		
		/* Verify the nonce before proceeding. */
		if ( !isset( $_POST['meta-gallery_nonce'] ) || !wp_verify_nonce( $_POST['meta-gallery_nonce'], basename( __FILE__ ) ) )
			return $post_id;
	
		/* Check if the current user has permission to edit the post. */
		if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
			return $post_id;
	
		/* Get the posted data and sanitize it for use as an HTML class. */
		/*$post_content=$post->post_content;
		$get_ids=strip_meta_gallery_ids($post_content);
		if(!(is_null($get_ids))) 
		{
			$_POST['meta-gallery']=$get_ids;
		}*/
		$new_meta_value = ( isset( $_POST['meta-gallery'] ) ? $_POST['meta-gallery']  : '' );
		
		
		/* Get the meta key. */
		$meta_key = 'meta-gallery';
		
		/* Get the meta value of the custom field key. */
		$meta_value = get_post_meta( $post_id, $meta_key, true );
	
		/* If a new meta value was added and there was no previous value, add it. */
		if ( $new_meta_value && '' == $meta_value )
			add_post_meta( $post_id, $meta_key, $new_meta_value, true );
	
		/* If the new meta value does not match the old value, update it. */
		elseif ( $new_meta_value && $new_meta_value != $meta_value )
			update_post_meta( $post_id, $meta_key, $new_meta_value );
	
		/* If there is no new meta value but an old value exists, delete it. */
		elseif ( '' == $new_meta_value && $meta_value )
			delete_post_meta( $post_id, $meta_key, $meta_value );
			
		$new_meta_value_j = ( isset( $_POST['meta-journalist'] ) ? $_POST['meta-journalist']  : '' );
		
		
		/* Get the meta key. */
		$meta_key_j = 'meta-journalist';
		
		/* Get the meta value of the custom field key. */
		$meta_value_j = get_post_meta( $post_id, $meta_key_j, true );
	
		/* If a new meta value was added and there was no previous value, add it. */
		if ( $new_meta_value_j && '' == $meta_value_j )
			add_post_meta( $post_id, $meta_key_j, $new_meta_value_j, true );
	
		/* If the new meta value does not match the old value, update it. */
		elseif ( $new_meta_value_j && $new_meta_value_j != $meta_value_j )
			update_post_meta( $post_id, $meta_key_j, $new_meta_value_j );
	
		/* If there is no new meta value but an old value exists, delete it. */
		elseif ( '' == $new_meta_value_j && $meta_value_j )
			delete_post_meta( $post_id, $meta_key_j, $meta_value_j );
		
	}
}


function strip_meta_gallery_ids($content) 
{
	$ids=null;
	$start=strpos($content,'ids=');
	if($start!=false) 
	{				
		$ends=strpos($content,'"',($start+6));
		$ids=substr($content,$start+6,$ends-($start+6));
	}
	return $ids;
}


function show_my_meta_box($object, $box) 
{
	
	wp_nonce_field( basename( __FILE__ ), 'meta-gallery_nonce' );
	$meta =get_post_meta( $object->ID, 'meta-gallery', false );
?>
<div>
	<input type="text" name="meta-gallery" id="meta-gallery" class="gallerytags" placeholder="Ingrese aqui" value="<?php (!empty($meta))? print($meta[0]):'';?>">
</div>
<?php
}


function meta_box_journalist($object, $box) 
{
	
	wp_nonce_field( basename( __FILE__ ), 'meta-journalist_nonce' );
	$meta =get_post_meta( $object->ID, 'meta-journalist', false );
?>
<div>
	<input type="text" name="meta-journalist" id="meta-journalist" class="meta-journalist" placeholder="Ingrese aqui" value="<?php (!empty($meta))? print($meta[0]):'';?>">
</div>
<?php
}


function an_remove_gallery_from_content($post_content) 
{
	$get_ids=strip_meta_gallery_ids($post_content);
	if(!(is_null($get_ids))) 
	{
		$_POST['meta-gallery']=$get_ids;
	}
	
	$post_content=preg_replace('/\[gallery.(.*).\]/','',$post_content );
	return $post_content;	
}
add_action('content_save_pre', 'an_remove_gallery_from_content');

//Configuro las clases que deseo que queden en el menu dentro del array, el resto son eliminadas.
add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1);
add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1);
function my_css_attributes_filter($var) {
  return is_array($var) ? array_intersect($var, array('menu-item',"current-menu-item","current-category-parent")) : '';
}


// Cambiar el pie de pagina del panel de Administración
add_filter('admin_footer_text', 'change_footer_admin');
function change_footer_admin() 
{  
    echo '&amp;copy;2013 Copyright Diario EsNoticia. Todos los derechos reservados - Web creada por <a href="http://www.aliweb.com.ar">Aliweb Desarrollo</a>';  
}  



/*function get_farmaciasdeturno() 
{
	$farmtur=array();
	$j=file_get_contents("http://www.turnos.colfarmamdp.com.ar/");
	if($j!="") 
	{
		$begin=strrpos($j,"<tbody >");
		$end=strrpos($j,"</tbody>");
		$j=substr($j,$begin,$end-$begin);
		$j=str_replace("<td >","<td>",$j);
		$x=explode("<tbody >,",$j);
		$i=explode("<tr>",$x[0]);
		$n=0;
		foreach($i as $p)
		{
			if($n!=0) 
			{
				$m=explode("<td>",$p);
				foreach($m as $l=>$t)
				{
					if($l!=1) 
					{
						$farmtur[$n][$l]=strip_tags($t);
					}
				}
			}
			$n++;
		}
	}
	return $farmtur;
}*/

include_once "functions-clima.php";

include_once "functions-estrenos.php";

// JavaScript Functions
function an_load_custom_wp_scripts() 
{
	wp_deregister_script('jquery');
	wp_register_script('jquery', get_template_directory_uri().'/js/jquery.min.js', false, '1.10.2', false);
	wp_enqueue_script('jquery');
	if(is_single()) 
	{
		wp_enqueue_style( 'colorbox-style', get_template_directory_uri()."/css/colorbox.css" );
		
		wp_register_script('colorbox', get_template_directory_uri().'/js/jquery.colorbox.js', array( 'jquery' ), '1.4.28', false);
		wp_enqueue_script('colorbox');
	
		wp_register_script('colorbox-es', get_template_directory_uri().'/js/jquery.colorbox-es.js', array( 'jquery','colorbox' ), '1.4.28', false);
		wp_enqueue_script('colorbox-es');
	}
	wp_register_script('an_scriptmain', get_template_directory_uri().'/js/esnoticia.js', array( 'jquery' ), '1.2', false);
	wp_enqueue_script('an_scriptmain');
	
	wp_register_script('an_scriptIE', get_template_directory_uri().'/js/html5shiv.js', false, '3.6.2', false);
	wp_enqueue_script('an_scriptIE');
}
add_action('wp_enqueue_scripts', 'an_load_custom_wp_scripts',20); 


// Removing wordpress version from script and styles
add_action("wp_head", "firmasite_remove_version_from_assets",1);
function firmasite_remove_version_from_assets(){
	function remove_cssjs_ver( $src ) {
		if( strpos( $src, '?ver=3.6' ) )
			$src = remove_query_arg( 'ver', $src );
		return $src;
	}
	add_filter( 'style_loader_src', 'remove_cssjs_ver', 999 );
	add_filter( 'script_loader_src', 'remove_cssjs_ver', 999 );
}

function remove_category_rel($output)
{
    $output = str_replace(' rel="category tag"', '', $output);
    return $output;
}
add_filter('the_category', 'remove_category_rel');

remove_action('wp_head', 'wp_generator');

remove_action('wp_head', 'noindex', 1);
remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');
@ini_set('pcre.backtrack_limit', 500000);
?>