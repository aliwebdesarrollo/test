<!--INICIO SIDEBAR-->

	<aside class="col-md-4 col-lg-4 pull-right" id="main-sidebar">
		<?php
		if(isset($_SESSION['alr_clima_id']))
		{
			$clima=alr_clima_values($_SESSION['alr_clima_id']);?>
		<div class="col-md-12 col-lg-12">
			<div class="panel-sidebar bgc-rojo-pastel">
				<h3 id="" class="sidebar-font sidebar-title">El Clima</h3>
				<h5 id="" class="sidebar-font sidebar-subtitle"><?php echo $clima['localidad'];?></h5>
			</div>
			<div class="col-md-12 col-lg-12 bgc-pastel">
			<?php
			foreach($clima['clima'] as $v)
			{
				?>
				<div class="col-md-12 col-lg-12" id="pronostico_hoy">
					<div class="col-md-5 col-lg-5">
						<img src="<?php echo get_template_directory_uri()?>/images/clima/iconos/<?php echo $v['ico']?>.png" alt="<?php echo $v['estado']?>" title="<?php echo $v['estado']?>" class="img-responsive">
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
		<?php	}?>

		<?php	$args_ads=array('post_type' => 'publicidad',
								'tax_query' => array(
									array('taxonomy' => 'aviso','field' => 'slug','terms' => 'pagina-principal')),
								'orderby' => 'date', 'order' => 'ASC', 
								'post__not_in' => $_SESSION['exclude']);
		$query_ads = new WP_Query( $args_ads );
		
		if($query_ads->have_posts()): $query_ads->the_post();
			array_push($_SESSION['exclude'],$post->ID);
			get_template_part("col","publicidad");
		endif;
		?>
		
			
		<?php
		//Noticias LATERAL
		$args=array('post_type' => 'post','showposts' => 1,'tax_query' => array(
					array('taxonomy' => 'display','field' => 'slug','terms' => 'lateral')),
				'post__not_in' => $_SESSION['exclude']);
		$query = new WP_Query( $args );
		
		if($query->have_posts()): 
			while ($query->have_posts()) : $query->the_post();
				array_push($_SESSION['exclude'],$post->ID);
				get_template_part("col","lg-12-lat");
			endwhile;
		endif;
		//Fin Noticias LATERAL
		
		$cotizacion=getCotizacion();
		if(($cotizacion['dolar']!=false) && ($cotizacion['euro']!=false)){ 
		?>
		<!--COTIZACION DOLAR-->
		<div class="col-md-12 col-lg-12" id="cotizaciones">
			<div class="panel-sidebar bgc-verde-oscuro">
				<h3 class="sidebar-title sidebar-font">Cotizaciones</h3>
			</div>
			<div class="col-md-12 col-lg-12 bgc-gris-claro no-padding">
				<div class="col-md-6 col-lg-6 no-padding">
					<div class="panel-cotiza bgc-negro">
						<h4 class="sidebar-font sidebar-subtitle text-center"> Dolar Venta</h4>
					</div>
					<h4 class="sidebar-font text-center valor-cotizacion"><?php echo str_replace(".",",",number_format($cotizacion['dolar'],2,".",","));?></h4>
				</div>
				<div class="col-md-6 col-lg-6 no-padding">
					<div class="panel-cotiza bgc-negro">
						<h4 class="sidebar-font sidebar-subtitle text-center">Euro Venta</h4>
					</div>
					<h4 class="sidebar-font text-center valor-cotizacion"><?php echo str_replace(".",",",number_format($cotizacion['euro'],2,".",",")); ?></h4>
				</div>
			</div>
		</div>
		<!--FIN COTIZACION DOLAR-->
		<?php } ?>
		
		<?php
		//PUBLICIDAD
		if($query_ads->have_posts()): $query_ads->the_post();
			array_push($_SESSION['exclude'],$post->ID);
			get_template_part("col","publicidad");
		endif;
		//FIN PUBLICIDAD
		?>
		
		<!--CARTELERA DE CINE-->
		<div class="col-md-12 col-lg-12" id="estrenos-cine">
			<div class="panel-sidebar bgc-pastel-oscuro">
				<h3 class="sidebar-title sidebar-font">Estrenos de Cine</h3>
			</div>
			<?php
			$estrenos=get_Estrenos();
			foreach($estrenos as $estreno){?>
			<img src="<?php echo $estreno['img'];?>" alt="<?php echo $estreno['titulo']?>" title="<?php echo $estreno['titulo']?>" class="center-block img-movies" >
			<?php	} ?>
			<div class="col-md-12 col-lg-12 bgc-gris">
				<a href="http://www.cinesargentinos.com.ar/" id="logo-cinesargentinos" title="Cines Argentinos" target="_blank"></a>
			</div>
		</div>
		<!--FIN CARTELERA DE CINE-->
		
		<?php
		//PUBLICIDAD
		if($query_ads->have_posts()): $query_ads->the_post();
			array_push($_SESSION['exclude'],$post->ID);
			get_template_part("col","publicidad");
		endif;
		//FIN PUBLICIDAD
		?>
		
		<?php
		//VIDEO INSOLITO
		$args=array('post_type' => 'post','showposts' => 1,'tax_query' => array(
					array('taxonomy' => 'display','field' => 'slug','terms' => 'video-insolito')),
				'post__not_in' => $_SESSION['exclude']);
		$query = new WP_Query( $args );
		
		if($query->have_posts()):$query->the_post();
				array_push($_SESSION['exclude'],$post->ID);
				get_template_part("col","video");
		endif;
		//Fin VIDEO INSOLITO
		?>
		
		<?php
		//PUBLICIDAD
		if($query_ads->have_posts()): 
			while ($query_ads->have_posts()) : $query_ads->the_post();
				array_push($_SESSION['exclude'],$post->ID);
				get_template_part("col","publicidad");
			endwhile;
		endif;
		//FIN PUBLICIDAD
		?>
		<div class="col-md-12 col-lg-12 text-center no-padding" id="facebook-like-box">
			<div class="fb-like-box" data-href="http://www.facebook.com/DiarioEsNoticia" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false"></div>
		</div>
	</aside>
	<!--FIN SIDEBAR-->