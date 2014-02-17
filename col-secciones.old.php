<article class="col-xs-12 col-sm-12 <?php ($wp_query->current_post==0)? print("col-md-12 col-lg-12"):print("col-md-6 col-lg-6"); ?>">
	<div class="thumbnail  ">
	<?php
	if(has_post_thumbnail()) 
	{
		$attr = array(
			'class'	=> "center-block img-responsive img-full-width"
		);
		?>
		<div class="prev-thumb">
		<?php	
		($wp_query->current_post==0)? the_post_thumbnail("seccion",$attr):the_post_thumbnail("general",$attr);	?>
		</div>
		<?php
	}
	?>
		<div class="caption" >
			<h4><a href="<?php the_permalink()?>" ><?php the_title();?></a></h4>
			<?php if($wp_query->current_post!=0){?><p><?php echo substr(get_the_excerpt(),0,175)?></p><?php }?>
		</div>
	</div>
</article>