<?php if ( have_posts() ): the_post(); ?>
<div class="blog-main">
	<h1 id="Single-tit" title="<?php the_title(); ?>"><?php the_title(); ?></h1>
	<p><?php the_excerpt(); ?></p>
	<?php if ( has_post_thumbnail() ) {?>
	<figure id="post-image">
		<a href="<?php $img=wp_get_attachment_image_src( get_post_thumbnail_id(), 'full'); echo $img[0]; ?>" class="pic-list" rel="pic-list">
	<?php
	$attr = array(
	'class'	=> "center-block img-responsive img-full-width");	
  	the_post_thumbnail("seccion", $attr);?>
  		</a>
	</figure>
	<?php } ?>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="fb-like" data-href="<?php echo get_permalink()?>" data-layout="button" data-action="like" data-show-faces="false" data-share="true"></div>
		<div class="fb-send" data-href="<?php echo get_permalink()?>" data-colorscheme="light"></div>
<a href="https://twitter.com/share" class="twitter-share-button" data-lang="es" data-related="DiarioEsNoticia" hashtags="DiarioEsNoticia">Twittear</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
		<div class="pull-right">
			<span onclick="window.print();" class="single-icons"><i class="fa fa-print"></i></span>
			<span class="single-icons font-increase"><i class="fa fa-font">+</i></span>
			<span class="single-icons font-decrease"><i class="fa fa-font">-</i></span>
		</div>
	</div>
	<?php $tags=get_the_tags();
		if($tags!=false){?>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="single-tags">
		<h6><i class='fa fa-tags'></i><span> Tags: </span>
		<?php	foreach ($tags as $tag){
			echo "<a href='".get_tag_link($tag->term_id)."'>$tag->name</a>";
		} ?>
		</h6>
	</div>
	<?php } ?>
	<div id="post-content" class="blog-post" lang="">
	<?php
	$content=get_the_content();
	//$content=nl2br($content);
	$content=strip_tags($content,"<a><p><br><em><strong><img><ul><ol><li><div><object><embed><param>");
	$content=preg_replace('/<img.*?class="single-img.*?"/', '<img class="img-responsive pic-list" rel="pic-list"', $content );
	$content=nl2br($content);
	echo $content;
	$meta_youtube =get_post_meta( $post->ID, 'meta-alr-youtube', false );
	if($meta_youtube!=false)
	{?>
		<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 youtube">
  			<iframe class="youtube-responsive" src="//www.youtube.com/embed/<?php echo $meta_youtube[0] ?>" frameborder="0" allowfullscreen ></iframe>
  		</div>
  	<?php } ?>
  	<?php $redactores=alr_get_redactores($post->ID);
  	if($redactores!=false && count($redactores)>0){?>
  		<div id="row-redactor">
	  	<?php foreach($redactores as $redactor){?>
  			<p class="redactor">Por: <?php echo $redactor->name;?></p>
  		<?php }?>
  		</div>
  	<?php } ?>      
  	<?php $fuentes=alr_get_fuentes($post->ID);
  	if($fuentes!=false && count($fuentes)>0){?>
  		<div id="row-fuente">
  			Fuente: 
	  	<?php foreach($fuentes as $fuente){?>
  			<a href="<?php echo $fuente->description ?>" class="fuente" target="_blank"><?php echo $fuente->name;?></a>
  		<?php }?>
  		</div>
  	<?php } ?>
	</div>
</div>

<?php endif; ?>