<!--INICIO SIDEBAR-->
	<aside class="hidden-sm hidden-xs col-md-3 col-lg-3 pull-right">
		<div class="col-md-12 col-lg-12">
			<div class="panel-sidebar bgc-azul-pastel">
				<h3 class="sidebar-font sidebar-title text-center">
					<i class="fa fa-folder-open"></i> 
					<?php echo get_the_title()?>		
				</h3>
			</div>
			<div class="text-center nav-tree bgc-pastel">
				<?php alr_category_tree($cat);?>
			</div>
		</div>
		<?php
		if(isset($_SESSION['alr_clima_id']))
		{
			$clima=alr_clima_values($_SESSION['alr_clima_id']);?>
		<div class="col-md-12 col-lg-12">
			<div class="panel-sidebar bgc-rojo-pastel">
				<h3  class="sidebar-font sidebar-title">El Clima</h3>
				<h5  class="sidebar-font sidebar-subtitle"><?php echo $clima['localidad'];?></h5>
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
		<?php
		}
		?>
		
		<?php	$args_ads=array('post_type' => 'publicidad',
								'tax_query' => array(
									array('taxonomy' => 'aviso','field' => 'slug','terms' => 'categoria')),
								'orderby' => 'date', 'order' => 'ASC', 
								'post__not_in' => $_SESSION['exclude']);
		$query_ads = new WP_Query( $args_ads );
		
		if($query_ads->have_posts()): 
			while ($query_ads->have_posts()) : $query_ads->the_post();
				array_push($_SESSION['exclude'],$post->ID);
				get_template_part("col","publicidad");
			endwhile;
		endif;
		?>
	</aside>
	<!--FIN SIDEBAR-->