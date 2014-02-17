<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
	<div class="thumbnail thumb-sc-section">
	<?php	if(has_post_thumbnail()){
		$attr = array('class'	=> "center-block img-responsive img-full-width");?>
		<div class="cell-info">
			<?php if(!is_tag()){if(($tagpost=alr_get_title($post->ID)) != false ) {?>
				<h4 class="cat-post"><a href="<?php echo get_tag_link($tagpost->term_id)?>" ><span class="label label-success"><?php echo $tagpost->name; ?></span></a></h4>
			<?php } }?>
			<div class="image">
		<?php the_post_thumbnail("seccion",$attr);?>
			</div>
			<div class="cover">
			<?php alr_post_preview($post->ID) ?>
			</div>
		</div>
		<?php	} ?>
		<div class="caption" >
			<h3><a href="<?php the_permalink()?>" > <?php the_title();?></a></h3>
		</div>
	</div>
</article>