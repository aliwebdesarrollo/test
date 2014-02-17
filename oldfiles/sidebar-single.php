<?php
/*------------------------------------------------------------------------
# Aliweb News V1.0 Julio 2013
# ------------------------------------------------------------------------
# Copyright (C) 2013 Aliweb Desarrollo. All Rights Reserved.
# @licencia - Aliweb News Theme esta protegida bajo los terminos de las licencias GNU General Public License.
# Autor: http://www.aliweb.com.ar - Juan Manuel Piñeiro
-------------------------------------------------------------------------*/
?>
<div id="LastPostList">
<label id="LPTitle" class="LPLine">&Uacute;ltimas Noticias</label>
<?php
$args = array(
    'numberposts' => 5,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'post__not_in' =>array($post->ID),
    'post_type' => 'post',
    'post_status' => 'publish',
    'suppress_filters' => true );

    $recent_posts = wp_get_recent_posts( $args, $output = ARRAY_A );
    foreach ($recent_posts as $recent)
    {
    	$id=intval($recent["ID"]);
    	$title=$recent["post_title"];
    	?>
	<label class="LPLine"><a href="<?=get_permalink($id); ?>" title="<?=$title?>" class="LPLink" ><?=$recent["post_title"]?></a></label>
    	<?php
    }
?>

</div>
<div class="Advert">
<?php
if(is_single()) 
{
	$cB=0;
	$MaxAds=5;
	global $wpdb;
	$qb=$wpdb->get_results("SELECT a.ads_id AS id, b.anb_image AS img, b.anb_url AS link, s.anbs_height AS h, s.anbs_width AS w, a.ads_maxheight AS maxh, a.ads_maxwidth AS maxw FROM wp_an_ads_publicidad AS a LEFT JOIN wp_an_ads_banners AS b ON a.ads_anb_id=b.anb_id LEFT JOIN wp_an_ads_banners_size AS s ON b.anb_anbs_id=s.anbs_id WHERE a.ads_anp_id =4 ORDER BY a.ads_id",OBJECT_K);
	foreach($qb as $banner)
	{
		if(!is_null($banner->img))
		{
			if(wp_get_attachment_url($banner->img))
			{
				$ban=wp_get_attachment_image_src($banner->img,"banner{$banner->w}x{$banner->h}");
				if(trim($banner->link)!=="") 
				{
					?>
		<div class="Banner<?=$banner->w?>x<?=$banner->h?> Banner BannerClear">
			<a href="<?=$banner->link?>" target="_blank">
				<img src="<?=$ban[0]?>" alt="" >
			</a>
		</div>
					<?php
				}else 
				{
					?>
		<div class="Banner<?=$banner->w?>x<?=$banner->h?> Banner BannerClear">
			<img src="<?=$ban[0]?>" alt="" >
		</div>
				<?php
				}
				$cB++;
			}
		}
	}

	if(($MaxAds-$cB)>0)
	{
		$queryA=$wpdb->prepare("SELECT a.ana_id AS id, a.ana_code AS code, s.anas_height AS h, s.anas_width AS w FROM wp_an_ads_adsense AS a LEFT JOIN wp_an_ads_adsense_size AS s ON a.ana_anas_id=s.anas_id WHERE a.ana_anp_id =4 ORDER BY a.ana_id LIMIT %d",intval($MaxAds-$cB));
		$qads=$wpdb->get_results($queryA,OBJECT_K);

		foreach($qads as $ads) 
		{
			if(($MaxAds-$cB)>0)
			{	
				?>
		<div class="AdSense BannerClear">
			<div class="AdSense-cnt Adsense<?=$ads->w?>x<?=$ads->h?>">
			<?=stripslashes($ads->code)?>
			</div>
		</div>
				<?php
			}
		}
	}
}
?>
</div>
