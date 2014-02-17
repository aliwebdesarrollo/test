<?php get_header();?>
<?php
	$exclude=array();
?>
<div class="container">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<?php

$args = array(
	'post_type' => 'post',
	'showposts' => 1,
	'tax_query' => array(
		array(
			'taxonomy' => 'display',
			'field' => 'slug',
			'terms' => 'destacada'
		)
	)
);
$query = new WP_Query( $args );
if ($query->have_posts()) : $query->the_post();
	array_push($exclude,$query->posts[0]->ID);
	?>
		<article class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			
			<div class="thumbnail  ">
				<?php
				if(has_post_thumbnail()) 
				{
					$attr = array(
						'class'	=> "center-block img-responsive img-full-width"
					);
					?>
				<div class="prev-thumb">
					<?php	the_post_thumbnail("destacada",$attr);	?>
				</div>
					<?php
				}
				?>
				
				<div class="caption" ><h3><a href="<?php the_permalink()?>" ><?php the_title();?></a></h3></div>
			</div>
		</article>
<?php
endif;

$args = array(
	'post_type' => 'post',
	'showposts' => 2,
	'tax_query' => array(
		array(
			'taxonomy' => 'display',
			'field' => 'slug',
			'terms' => 'secundaria'
		)
	),
	'post__not_in' => $exclude
);
$query2 = new WP_Query( $args );
if($query2->have_posts()): 
	while ($query2->have_posts()) : $query2->the_post();
		array_push($exclude,$query2->posts[0]->ID);
	?>
		<article class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
			
			<div class="thumbnail  ">
				<?php
				if(has_post_thumbnail()) 
				{
					$attr = array(
						'class'	=> "center-block img-responsive img-full-width"
					);
					?>
				<div class="prev-thumb">
					<?php	the_post_thumbnail("general",$attr);	?>
				</div>
					<?php
				}
				?>
				<div class="caption" >
					<h4><a href="<?php the_permalink()?>" ><?php the_title();?></a></h4>
					<p><?php echo substr(get_the_excerpt(),0,175)?></p>
				</div>
			</div>
		</article>
<?php
	endwhile;
endif;
?>
	</div>
	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<?php
$args = array(
	'post_type' => 'post',
	'showposts' => 3,
	'tax_query' => array(
		array(
			'taxonomy' => 'display',
			'field' => 'slug',
			'terms' => 'general'
		)
	),
	'post__not_in' => $exclude
);
$query3 = new WP_Query( $args );
if($query3->have_posts()): 
	while ($query3->have_posts()) : $query3->the_post();
		array_push($exclude,$query3->posts[0]->ID);
		$query3->current_post;
		?>
		<article class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
			
			<div class="thumbnail  ">
				<?php
				if(has_post_thumbnail()) 
				{
					$attr = array(
						'class'	=> "center-block img-responsive img-full-width"
					);
					?>
				<div class="prev-thumb">
					<?php	the_post_thumbnail("general",$attr);	?>
				</div>
					<?php
				}
				?>
				<div class="caption" >
					<h4><a href="<?php the_permalink()?>" ><?php the_title();?></a></h4>
					<p><?php echo substr(get_the_excerpt(),0,175)?></p>
				</div>
			</div>
		</article>
	<?php
	endwhile;
endif;
?>
	</div>
	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
<?php
query_posts('showposts=6&display=general&offset=1');
if (have_posts()) : 
	while (have_posts()) : the_post();?>
		<article class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
			
			<div class="thumbnail  ">
				<?php
				if(has_post_thumbnail()) 
				{
					$attr = array(
						'class'	=> "center-block img-responsive img-full-width"
					);
					?>
				<div class="prev-thumb">
					<?php	the_post_thumbnail("general",$attr);	?>
				</div>
					<?php
				}
				?>
				<div class="caption" >
					<h4><a href="<?php the_permalink()?>" ><?php the_title();?></a></h4>
					<p><?php echo substr(get_the_excerpt(),0,175)?></p>
				</div>
			</div>
		</article>
	<?php
	endwhile;
endif;
?>
		<hr></hr>
		<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
			<div class="panel-footer"><h3><?php echo get_term( get_term_by( "slug", "seccion-1", "display")->term_id , "display" )->description;?></h3>	</div>	
<?php
query_posts('showposts=3&display=seccion-1');
if (have_posts()) : 
	while (have_posts()) : the_post();?>
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
			<?php
	endwhile;
endif;
?>
		</div>
		<hr></hr>
		<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
			<div class="panel-footer"><h3><?php echo get_term( get_term_by( "slug", "seccion-1", "display")->term_id , "display" )->description;?></h3>	</div>	
<?php
query_posts('showposts=3&display=seccion-2');
if (have_posts()) : 
	while (have_posts()) : the_post();?>
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
			<?php
	endwhile;
endif;
?>
		</div>
	</div>
	<?php
	get_template_part("sidebar","");
	?>
	<div class="col-lg-12 col-md-12">
		<article class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
			
			<div class="thumbnail  ">
				<div class="prev-thumb">
					<img src="<?php echo get_template_directory_uri().'/images/test/col-lg-2.jpg';?>" alt="" class="center-block img-responsive img-full-width" style="height:200px; width:100%;">
				</div>
				<div class="caption" style="height:250px;">
					<h4>Esto es una prueba</h4>
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
				</div>
			</div>
		</article>
		<article class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
			
			<div class="thumbnail  ">
				<div class="prev-thumb">
					<img src="<?php echo get_template_directory_uri().'/images/test/col-lg-3.jpg';?>" alt="" class="center-block img-responsive img-full-width" style="height:200px; width:100%;">
				</div>
				<div class="caption" style="height:250px;">
					<h4>Esto es una prueba</h4>
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
				</div>
			</div>
		</article>
		<article class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
			
			<div class="thumbnail  ">
				<div class="prev-thumb">
					<img src="<?php echo get_template_directory_uri().'/images/test/col-lg-3.jpg';?>" alt="" class="center-block img-responsive img-full-width" style="height:200px; width:100%;">
				</div>
				<div class="caption" style="height:250px;">
					<h4>Esto es una prueba</h4>
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
				</div>
			</div>
		</article>
		<article class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
			
			<div class="thumbnail  ">
				<div class="prev-thumb">
					<img src="<?php echo get_template_directory_uri().'/images/test/col-lg-3.jpg';?>" alt="" class="center-block img-responsive img-full-width" style="height:200px; width:100%;">
				</div>
				<div class="caption" style="height:250px;">
					<h4>Esto es una prueba</h4>
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
				</div>
			</div>
		</article>
	</div>
	<div class="col-lg-12 col-md-12">
		<article class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
			
			<div class="thumbnail  ">
				<div class="prev-thumb">
					<img src="<?php echo get_template_directory_uri().'/images/test/col-lg-3.jpg';?>" alt="" class="center-block img-responsive img-full-width" style="height:200px; width:100%;">
				</div>
				<div class="caption" style="height:250px;">
					<h4>Esto es una prueba</h4>
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
				</div>
			</div>
		</article>
		<article class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
			
			<div class="thumbnail  ">
				<div class="prev-thumb">
					<img src="<?php echo get_template_directory_uri().'/images/test/col-lg-3.jpg';?>" alt="" class="center-block img-responsive img-full-width" style="height:200px; width:100%;">
				</div>
				<div class="caption" style="height:250px;">
					<h4>Esto es una prueba</h4>
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
				</div>
			</div>
		</article>
		<article class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<div class="panel-footer"><h3>LA DIOSA DE LA SEMANA</h3></div>
			<div class="thumbnail  ">
				<div class="prev-thumb">
					<img src="<?php echo get_template_directory_uri().'/images/test/col-lg-2.jpg';?>" alt="" class="center-block img-responsive img-full-width" style="height:350px; width:100%;">
				</div>
			</div>
		</article>
	</div>
</div>
<?php get_footer();?>