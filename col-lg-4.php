<article class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
	<div class="thumbnail thumb-lg-block">
		<?php	if(has_post_thumbnail()){
			$attr = array('class' => "center-block img-responsive img-full-width"); ?>
			<div class="cell-info">
				<?php if(!is_tag()){if(($tagpost=alr_get_title($post->ID)) != false ) {?>
				<h5 class="cat-post"><a href="<?php echo get_tag_link($tagpost->term_id)?>" ><span class="label label-success"><?php echo $tagpost->name; ?></span></h5>
			<?php } }?>
				<div class="image">
			<?php	the_post_thumbnail("general",$attr);	?>
				</div>
				<div class="cover">
				<?php alr_post_preview($post->ID) ?>					
				</div>
			</div>
			<?php	} ?>
		<div class="caption" >
			<h4><a href="<?php the_permalink()?>" ><?php the_title();?></a></h4>
			<!--<p><?php echo substr(get_the_excerpt(),0,175)?></p>-->
			<p><?php the_excerpt()?></p>
		</div>
	</div>
</article>