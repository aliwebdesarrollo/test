<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<div id="Single-post">
  <h1 id="Single-tit" title="<?php the_title(); ?>"><?php the_title(); ?></h1>
	<?php
	$uploaddir=wp_upload_dir();
   $nothumb=true;  
	if(has_post_thumbnail())
	{
		$image_link = wp_get_attachment_image_src( get_post_thumbnail_id(),'large');
		$image = wp_get_attachment_metadata(get_post_thumbnail_id());
		if(isset($image['sizes']['single'])) 
		{			
			$image_url=$uploaddir['basedir']."/{$image['sizes']['single']['file']}";
		}elseif(isset($image['file'])) 
		{
			$image_url=$uploaddir['basedir']."/{$image['file']}";
		}
		if(file_exists($image_url)) 
		{
			?>
	<div class="post-image">  
		<a class="pic-list" href="<?=$image_link[0]?>" rel="pic-list">
			<?php
			$attr = array(
			'class'	=> "single"
			);
			the_post_thumbnail("single",$attr);
			?>
		</a>
		<figure id="galery-icon"></figure>
	</div>
			<?php
			$nothumb=false;
		}else 
		{
			
		}
	}
	$metaimg=get_post_meta( get_the_ID(),'meta-gallery', true );
	if(!empty($metaimg)) 
	{
		$imgs=explode(",",$metaimg);
		$x=0;
		while(count($imgs)>$x)
		{			
			if($nothumb) 
			{
				$image_url = wp_get_attachment_image_src( $imgs[$x],"single");
			}else 
			{
				$image_url = wp_get_attachment_image_src( $imgs[$x],"large");
			}
			if($image_url!="") 
			{
				if($nothumb) 
				{
					?>
	<div class="post-image"> 
		<a class="pic-list " href="<?=$image_url[0]?>" rel="pic-list">
			<img src="<?=$image_url[0]?>" <?=($nothumb)?'class="single"':'';?> alt="" >
		</a>
		<figure id="galery-icon"></figure>
	</div>
					<?php
					$nothumb=false;
				}else 
				{
					?>
		<a class="pic-list " href="<?=$image_url[0]?>" rel="pic-list">
			<img src="<?=$image_url[0]?>" <?=($nothumb)?'class="single"':'';?> alt="" >
		</a>
					<?php
				}
			}
			$x++;
		}
	}
	?>
	<div id="post-content">
		<?php
			$autor_id=intval(get_post_meta( get_the_ID(), 'meta-journalist', true ));
			global $wpdb;
			$query_autor=$wpdb->prepare("SELECT scl_name FROM wp_an_staff_list WHERE scl_id=%d",$autor_id);
			$autor=$wpdb->get_results($query_autor);
			if($wpdb->num_rows!=0) 
			{
				?>
				<span id="post-autor">Por <?=$autor[0]->scl_name?></span>
				<?php
			}
			$wpdb->flush();
			$content=get_the_content();
			$content=nl2br($content);
			$content=strip_tags($content,"<a><br><em><strong><img><ul><ol><li><div><object><embed><param>");
			$content=preg_replace('/<img.*?class="single-img.*?"/', '<img class="single-img pic-list" rel="pic-list"', $content );
			echo $content; 
		?>
	</div>
</div>

<?php endwhile; ?>