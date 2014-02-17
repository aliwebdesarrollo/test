<!--INICIO SIDEBAR-->
<aside class="hidden-sm hidden-xs col-md-3 col-lg-3 pull-right">
<?php
	//GALERIA DE IMAGENES DE LA NOTICIA
	$gallery=get_post_meta($post->ID,'meta-gallery',true);
	if(trim($gallery)!=""){?>
	<div class="col-md-12 col-lg-12">
		<div class="panel-sidebar bgc-verde-pastel">
			<h3 class="sidebar-font sidebar-title"><span class="fa fa-camera"></span> Galeria de Imagenes</h3>
		</div>
		<div id="gallery-container" class="col-md-12 col-lg-12 bgc-pastel">
	<?php
	$imgs=explode(",",$gallery);
	//$post_img=get_post_thumbnail_id();
	$exist_img=false;
	foreach($imgs as $img){
		if($img==$post_img){$exist_img=true;}
	}
	//if(!$exist_img){array_unshift($imgs,$post_img);}
	$x=0;
	while(count($imgs)>$x){			
		$image_url = wp_get_attachment_image_src( $imgs[$x],"thumbnail");
		$image_gallery = wp_get_attachment_image_src( $imgs[$x],"gallery");
		if($image_url!=""){ ?>
		<div class="thumbnail col-md-2 thumb-hold">
			<div class="prev-thumb">
				<a href="<?php echo $image_gallery[0]?>" class="pic-list" rel="pic-list">
					<img src="<?php echo $image_url[0]?>" class='img-responsive' >
				</a>
			</div>
		</div>
		<?php	}
		$x++;
	}?>
		</div>
	</div>
<?php } //FIN GALERIA DE IMAGENES

//TOP DE NOTICIAS MAS VISTAS
$cat_id=get_the_category($post->ID);
$post_mv=alr_post_most_view($cat_id[0]->term_id, $post->ID);
if($post_mv!=false){ ?>
	<div class="col-md-12 col-lg-12" id="top-view-posts">
		<div class="panel-sidebar bgc-gris">
			<h3 class="sidebar-font sidebar-title"><i class="fa fa-camera"></i> Top <?php echo count($post_mv);?> mas vistas</h3>
		</div>
		<div class="col-md-12 col-lg-12 bgc-pastel">
	<?php
	foreach ($post_mv as $p){ ?>
				<h5 class="view-posts"><a href="<?php echo get_permalink($p->ID);?>" class="post-most-view"><i class="fa fa-star"></i> <?php echo get_the_title($p->ID);?></a></h5>
	<?php } ?>
		</div>
	</div>
<?php } //FIN TOP NOTICIAS MAS VISTAS 

//INICIO ETIQUETAS MAS UTILIZADAS?>
	<div class="col-md-12 col-lg-12" id="tags-more-used">
		<div class="bgc-azul panel-sidebar">
			<h3 class="sidebar-font sidebar-title"><i class="fa fa-tags"></i> Tags mas utilizadas</h3>
		</div>
		<div class="col-md-12 col-lg-12 text-center bgc-pastel">
	<?php
	$tags=alr_tags_more_used();
	$tags_total=alr_tags_total($tags);
	foreach ($tags as $tag){?>
			<span class="tags-used"><a href="<?php echo get_tag_link($tag->id);?>" ><?php echo $tag->name;?></a></span>
	<?php } ?>
		</div>
	</div>
	<?php
//FIN ETIQUETAS MAS UTILIZADOS

//INICIO CLIMA
		if(isset($_SESSION['alr_clima_id'])){
			$clima=alr_clima_values($_SESSION['alr_clima_id']);?>
	<div class="col-md-12 col-lg-12">
		<div class="panel-sidebar bgc-rojo-pastel">
			<h3 class="sidebar-font sidebar-title">El Clima</h3>
			<h5 class="sidebar-font sidebar-subtitle"><?php echo $clima['localidad'];?></h5>
		</div>
		<div class="col-md-12 col-lg-12 bgc-pastel">
			<?php
			foreach($clima['clima'] as $v){ ?>
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
				<?php	} ?>		
		</div>	
	</div>
<?php }//FIN CLIMA?>

<?php	$args_ads=array('post_type' => 'publicidad',
	'tax_query' => array(
	array('taxonomy' => 'aviso','field' => 'slug','terms' => 'noticias')),
		'orderby' => 'date', 'order' => 'ASC', 
		'post__not_in' => $_SESSION['exclude']);
	$query_ads = new WP_Query( $args_ads );
	if($query_ads->have_posts()):
		while ($query_ads->have_posts()) : $query_ads->the_post();
			array_push($_SESSION['exclude'], $post->ID);
			get_template_part("col","publicidad");
		endwhile;
	endif;?>
</aside>
<!--FIN SIDEBAR-->