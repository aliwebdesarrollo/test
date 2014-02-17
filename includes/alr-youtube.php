<?php

/* Fire our meta box setup function on the post editor screen. */
add_action( 'load-post.php', 'post_meta_alr_youtube' );
add_action( 'load-post-new.php', 'postnew_meta_alr_youtube' );

function add_metabox_alr_youtube() 
{
	add_meta_box('meta-box-alr-youtube', 'Video de Youtube', 'show_alr_youtube', 'post', 'side', 'high');
}


/* Meta box setup function. */
function postnew_meta_alr_youtube() 
{
	add_action('add_meta_boxes', 'add_metabox_alr_youtube');
}

/* Meta box setup function. */
function post_meta_alr_youtube() 
{
	add_action('add_meta_boxes', 'add_metabox_alr_youtube');

	// re-hook this function
	add_action( 'save_post', 'save_meta_alr_youtube',99,2 );

	/* Save the meta box's post metadata. */
	function save_meta_alr_youtube( $post_id, $post ) 
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
		if ( !isset( $_POST['meta-alr-youtube_nonce'] ) || !wp_verify_nonce( $_POST['meta-alr-youtube_nonce'], basename( __FILE__ ) ) )
			return $post_id;
	
		/* Check if the current user has permission to edit the post. */
		if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
			return $post_id;
	
		$new_meta_value = ( isset( $_POST['meta-alr-youtube'] ) ? $_POST['meta-alr-youtube']  : '');
		
		
		/* Get the meta key. */
		$meta_key = 'meta-alr-youtube';
		
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
				update_post_meta( $post_id, $meta_key, $new_meta_value );
			}		
		
		/* If there is no new meta value but an old value exists, delete it. */
		}else{
			delete_post_meta( $post_id, $meta_key, $meta_value );
		}
		
	}
}

function show_alr_youtube($object, $box) 
{
	
	wp_nonce_field( basename( __FILE__ ), 'meta-alr-youtube_nonce' );
	$meta =get_post_meta( $object->ID, 'meta-alr-youtube', false );
?>
<div>
	<input type="text" name="meta-alr-youtube" id="meta-alr-youtube" class="gallerytags" placeholder="ID video Youtube" value="<?php (!empty($meta))? print($meta[0]):'';?>">
</div>
<?php
}

?>