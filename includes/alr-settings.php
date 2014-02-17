<?php
	add_filter('show_admin_bar', '__return_false');
	
	add_action( 'after_setup_theme', 'alr_image_sizes' );
	function alr_image_sizes() 
	{
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'general', 350, 350, true ); //images General
		add_image_size( 'destacada', 800, 600, true );//images Destacada
		add_image_size( 'seccion', 500, 250, true );//images Section Destacada
  	  
	}
	
	//Remuevo los valores por default que carga con las imagenes en el contenido, class, width, alt, height

	add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions_content', 30 );
	add_filter( 'the_content', 'remove_thumbnail_dimensions_content', 30 );
	function remove_thumbnail_dimensions_content( $html ) 
	{
 		$html = preg_replace( '/height=\"\d*\"\s/', "", $html );
 		$html = preg_replace( '/width=\"\d*\"\s/', "", $html );
 		$html=preg_replace('/alt=\".*?\"/', '', $html );
 		$html=preg_replace('/<img.*?(src=\".*\").*?class=".*?"/', '<img $1 class="single-img pic-list" rel="pic-list"', $html );
 		return $html;
	}
	
	add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions_posts', 30 );
	function remove_thumbnail_dimensions_posts( $html ) {
 		$html = preg_replace( '/height=\"\d*\"\s/', "", $html );
 		$html = preg_replace( '/width=\"\d*\"\s/', "", $html );
 		$html=preg_replace('/alt=\".*?\"/', '', $html );
 		$html=preg_replace('/<img.*?(src=\".*\").*?class="(.*?)wp-post-image(.*?)"/', '<img $1 class="$2 $3"', $html );
 		return $html;
	}	

	// Limit Chars
	add_filter('the_excerpt', 'string_limit_words');
	add_filter('get_the_excerpt', 'string_limit_words');
	
	function string_limit_words($string) {
		$word_limit=30;
		$words = explode(' ', $string, ($word_limit + 1));
		if(count($words) > $word_limit) {
		array_pop($words);
		return implode(' ', $words)."..."; } else {
		return implode(' ', $words); }
	}

	  register_nav_menus( array(
	    'topmenu' => __( 'Menu Principal', 'Aliweb-Responsive' )
	  ));
	  
	  register_nav_menus( array(
	    'suplementos' => __( 'Menu Suplementos', 'Aliweb-Responsive' )
	  ));
	 
	 

	function my_manage_columns( $columns ) {
		unset($columns['author']);
		unset($columns['comments']);
		return $columns;
	}

	function my_column_init() {
  		add_filter( 'manage_posts_columns' , 'my_manage_columns' );
	}
	add_action( 'admin_init' , 'my_column_init' );

	// Cambiar el pie de pagina del panel de Administración
	add_filter('admin_footer_text', 'change_footer_admin');
	function change_footer_admin() 
	{  
	    echo '&copy;2013 Copyright Diario EsNoticia. Todos los derechos reservados - Web creada por <a href="http://www.aliweb.com.ar">Aliweb Desarrollo</a>';  
	}
	
	add_action( 'init', 'create_post_type' );
	function create_post_type() {
		register_post_type( 'publicidad',
			array(
				'labels' => array(
					'name' => __( 'Publicidad' ),
					'singular_name' => __( 'Publicidad' )
				),
				'public' => true,
				'has_archive' => true,
				'show_in_menu' => true, 
    			'query_var' => true,
    			'rewrite' => true,
    			'capability_type' => 'post',
    			'has_archive' => true, 
    			'hierarchical' => false,
    			'menu_position' => null,
    			'supports' => array( 'title', 'thumbnail')
			)
		);
	}
	
	//Register Specific Taxonomy Template
	add_action( 'init', 'alr_create_aviso' );
	function alr_create_aviso() {
 		$labels = array(
			'name' => _x( 'Aviso', 'taxonomy general name' ),
			'singular_name' => _x( 'Aviso', 'taxonomy singular name' ),
			'search_items' =>  __( 'Buscar Aviso' ),
			'all_items' => __( 'Todos los Avisos' ),
			'edit_item' => __( 'Editar' ), 
			'update_item' => __( 'Actualizar' ),
			'add_new_item' => __( 'Agregar Nuevo' ),
			'new_item_name' => __( 'Nuevo Aviso' ),
		); 	
 
		register_taxonomy(
			'aviso','publicidad',array(
				'hierarchical' => false,
				'labels' => $labels,
			)
		);
	}
	
	add_theme_support( 'post-thumbnails', array( 'publicidad' ) ); 
?>