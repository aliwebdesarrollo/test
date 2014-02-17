<?php
remove_shortcode('gallery', 'gallery_shortcode');

/* Fire our meta box setup function on the post editor screen. */
add_action( 'load-post.php', 'post_meta_gallery_setup' );
add_action( 'load-post-new.php', 'postnew_meta_gallery_setup' );

function add_my_meta_boxes() 
{
	add_meta_box('meta-box-gallery', 'Galeria de Fotos', 'show_my_meta_box', 'post', 'side', 'high');
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
	
		$new_meta_value = ( isset( $_POST['meta-gallery'] ) ? $_POST['meta-gallery']  : '');
		
		
		/* Get the meta key. */
		$meta_key = 'meta-gallery';
		
		/* Get the meta value of the custom field key. */
		$meta_value = get_post_meta( $post_id, $meta_key, true );

		/* If a new meta value was added and there was no previous value, add it. */
		if ( trim($new_meta_value)!="" && trim($meta_value)=="" )
			add_post_meta( $post_id, $meta_key, $new_meta_value, true );
			
		/* If the new meta value does not match the old value, update it. */
		elseif ( trim($new_meta_value)!="")
		{
			if(trim($new_meta_value) != trim($meta_value) )
			{
				$ar_ids=explode(",",trim($new_meta_value));
	
				$end_id=end($ar_ids);
				foreach($ar_ids as $id)
				{
					$ret_id.=( intval( $id ) != 0 )? ( $end_id != $id )? intval($id)."," : intval($id) : "";
				}
				$new_meta_value=( isset( $ret_id ) )? ( trim($meta_value) != "" )? $meta_value.",".$ret_id : $ret_id : '';

			update_post_meta( $post_id, $meta_key, $new_meta_value );
			}		
		
		/* If there is no new meta value but an old value exists, delete it. */
		}else{
			delete_post_meta( $post_id, $meta_key, $meta_value );
		}
		
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

function alr_remove_gallery_from_content($post_content) 
{
	$get_ids=strip_meta_gallery_ids($post_content);
	if(!(is_null($get_ids))) 
	{
		$_POST['meta-gallery']=$get_ids;
	}
	$post_content=preg_replace('/\[gallery.(.*).\]/','',$post_content );
	return $post_content;	
}
add_action('content_save_pre', 'alr_remove_gallery_from_content');
?>