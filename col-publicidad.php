<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
<?php if ( has_post_thumbnail($post->ID) ) {
	$image_id=get_post_thumbnail_id($post->ID);
	$image=wp_get_attachment_image_src($image_id,"summary"); 
	if(filter_var($post->post_title, FILTER_VALIDATE_URL)){?>
	<a href="<?php echo $post->post_title; ?>" target="_blank">
		<img src="<?php echo $image[0] ?>" class="center-block img-responsive img-full-width" >
	</a>
	<?php }else { ?>
	<img src="<?php echo $image[0] ?>" class="center-block img-responsive img-full-width" >
	<?php } ?>
<?php } ?>
</article>