<!--INICIO SIDEBAR-->

	<div class="hidden-sm hidden-xs col-md-4 col-lg-4 pull-right">
		<?php
		if(isset($_SESSION['alr_clima_id']))
		{
			$clima=alr_clima_values($_SESSION['alr_clima_id']);?>
		<div class="col-md-12 col-lg-12">
			<div class="panel-sidebar panel-rojo-pastel">
				<h3 id="sidebar-title" class="sidebar-font">El Clima</h3>
				<h5 id="sidebar-subtitle" class="sidebar-font"><?php echo $clima['localidad'];?></h5>
			</div>
			<div class="col-md-12 col-lg-12 panel-pastel">
			<?php
			foreach($clima['clima'] as $v)
			{
				?>
				<div class="col-md-12 col-lg-12" id="pronostico_hoy">
					<div class="col-md-5 col-lg-5">
						<img src="<?php echo get_template_directory_uri()?>/images/clima/iconos/<?php echo $v['ico']?>.png" alt="<?php echo $v['estado']?>" title="<?php echo $v['estado']?>">
					</div>
					<div class="col-md-7 col-lg-7 clima-info">
						<h3><?php echo $v['dia']?></h3>
						<p id="Tmax">Max: <span><?php echo $v['Tmax']?></span></p>
						<p id="Tmin">Min: <span><?php echo $v['Tmin']?></span></p>
					</div>
					<div class="col-md-12 col-lg-12">
						<p id="Testado"><?php echo $v['estado']?></p>
						<a href="http://www.tiempo.com/mar-del-plata.htm" id="logo-tiempocom" target="_blank"></a>
					</div>
				</div>
				<?php
			}
			?>		
			</div>	
		</div>
		<?php
		}
		?>
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			
			<div class="thumbnail  ">
				<div class="prev-thumb">
					<img src="<?php echo get_template_directory_uri().'/images/test/col-lg-9.jpg';?>" alt="" class="center-block img-responsive img-full-width" >
				</div>
			</div>
		</article>
		
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			
			<div class="thumbnail  ">
				<div class="prev-thumb">
					<img src="<?php echo get_template_directory_uri().'/images/test/Todoestilo.jpg';?>" alt="" class="center-block img-responsive img-full-width" >
				</div>
			</div>
		</article>
		
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			
			<div class="thumbnail  ">
				<div class="prev-thumb">
					<img src="<?php echo get_template_directory_uri().'/images/test/col-lg-6.jpg';?>" alt="" class="center-block img-responsive img-full-width" >
				</div>
			</div>
		</article>

		<?php
		$args=array('post_type' => 'post','showposts' => 1,'tax_query' => array(
					array('taxonomy' => 'display','field' => 'slug','terms' => 'lateral')),
				'post__not_in' => $exclude);
		$query = new WP_Query( $args );
		
		if($query->have_posts()): 
			while ($query->have_posts()) : $query->the_post();
				array_push($_SESSION['exclude'],$post->ID);
				get_template_part("col","lg-12-lat");
			endwhile;
		endif;
		?>

		<!--CARTELERA DE CINE-->
		<div class="col-md-12 col-lg-12">
			<div class="panel-sidebar panel-pastel-oscuro">
				<h3 id="sidebar-title" class="sidebar-font">Estrenos de Cine</h3>
			</div>
			<!--<ul class="rslides panel-gris">-->
			<?php
			$estrenos=get_Estrenos();
			foreach($estrenos as $estreno)
			{
			?>
			<!--<div class="thumbnail  ">
				<div class="prev-thumb">-->
				<!--<li>
					<div class="panel-sidebar panel-gris panel-titlemovie">
						<div class="col-md-8 col-lg-8">
							<img src="<?php echo $estreno['img'];?>" alt="" class="center-block img-responsive" >
						</div>
						<div class="col-md-4 col-lg-4">
							<h4 class="title-movies"><?php echo $estreno['titulo']?></h4>
						</div>						
					</div>
				</li>-->
				<!--</div>
			</div>-->
			<img src="<?php echo $estreno['img'];?>" alt="<?php echo $estreno['titulo']?>" title="<?php echo $estreno['titulo']?>" class="center-block img-movies" >
			<?php	} ?>
			<!--</ul>-->
			<div class="col-md-12 col-lg-12 panel-gris">
				<a href="http://www.cinesargentinos.com.ar/" id="logo-cinesargentinos" target="_blank"></a>
			</div>
		</div>
		<!--FIN CARTELERA DE CINE-->
		
		
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			
			<div class="thumbnail  ">
				<div class="prev-thumb">
					<img src="<?php echo get_template_directory_uri().'/images/test/col-lg-3.jpg';?>" alt="" class="center-block img-responsive img-full-width" >
				</div>
			</div>
		</article>
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			
			<div class="thumbnail  ">
				<div class="prev-thumb">
					<img src="<?php echo get_template_directory_uri().'/images/test/radio.jpg';?>" alt="" class="center-block img-responsive img-full-width" >
				</div>
			</div>
		</article>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<!--<div class="panel-footer"><h3><?php echo get_term( get_term_by( "slug", "seccion-1", "display")->term_id , "display" )->description;?></h3>	</div>-->
			<div class="panel-sidebar panel-celeste-pastel">
				<h3 id="sidebar-title" class="sidebar-font">Video Insolito</h3>	
			</div>
			<div class="thumbnail  ">
				<div class="prev-thumb">
					<img src="<?php echo get_template_directory_uri().'/images/test/radio.jpg';?>" alt="" class="center-block img-responsive img-full-width" >
				</div>
			</div>
		</div>
	</div>
	<!--FIN SIDEBAR-->