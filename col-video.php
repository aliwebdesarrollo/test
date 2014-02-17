<?php $meta_youtube =get_post_meta( $post->ID, 'meta-alr-youtube', false );
	if($meta_youtube!=false){?>
<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 youtube-sidebar">
	<div class="panel-sidebar bgc-rojo-pastel">
		<h3 class="sidebar-title sidebar-font"><i class="fa fa-desktop"></i> Video Insolito</h3>	
	</div>
	<iframe class="youtube-responsive" src="//www.youtube.com/embed/<?php echo $meta_youtube[0] ?>" frameborder="0" allowfullscreen ></iframe>
</div>
<?php } ?>