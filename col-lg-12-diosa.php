<article class="col-xs-12 col-sm-12 col-lg-6 col-md-6">
	<div class="thumbnail">
	<?php $term_diosa=get_terms(array("display"),array('name__like'    => "diosa"));?>
		<div class="panel-top<?php (($sec_color=get_option('alr_color_'.$term_diosa[0]->term_id, false))!=false)? print(' bgc-'.$sec_color['color']):''?>">
			<!--<h3 class="panel-title"><?php echo get_term( get_term_by( "slug", "diosa", "display")->term_id , "display" )->description;?></h3>-->
			<h3 class="panel-title">LA DIOSA - <?php the_title(); ?></h3>	
		</div>
	<?php
	if(has_post_thumbnail()){
		$attr = array('class'	=> "center-block img-responsive img-full-width", "id"=>"den-diosa");?>
		<div class="cell-info">
			<a href="<?php echo get_permalink($post->ID) ?>" class="image">
		<?php the_post_thumbnail("destacada",$attr);?>
			</a>
		</div>
<?php	} ?>
	</div>
</article>