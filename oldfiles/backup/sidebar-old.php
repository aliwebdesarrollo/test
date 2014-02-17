<?php
/*------------------------------------------------------------------------
# Global News WordPress Theme v1.1 - August 2012
# ------------------------------------------------------------------------
# Copyright (C) 2008 instantShift. All Rights Reserved.
# @license - Global News WordPress Theme is available under the terms of the GNU General Public License.
# Author: http://www.rapidxhtml.com
# Websites:  http://www.instantshift.com
-------------------------------------------------------------------------*/
get_header();
?>
  
  <!-- advert -->
  <div class="advert">
    <!--<?php echo stripslashes(get_option('gbn_ad_300x250_pri_singlepage')); ?>-->
    <?php
		$banner_id=get_option('an_bannerside_300_X_250');
		if(wp_get_attachment_url($banner_id))
		{
			$banner=wp_get_attachment_image_src($banner_id,"sidebanner");
			$banner_url=get_option('an_bannerside_url');
			if(trim($banner_url)!=="") 
			{
				?>
	<a href="<?=$banner_url?>" target="_blank">
		<img src="<?=$banner[0]?>" alt="" >
	</a>
				<?php
			}else 
			{
				?>
	<img src="<?=$banner[0]?>" alt="" >
				<?php
			}
		}
		?>
  </div>
  <!-- advert -->

  
  
  <!-- advert -->
  <!--<div class="advert">
    <?php echo stripslashes(get_option('gbn_ad_300x250_sec_singlepage')); ?>
  </div>-->
  <!-- advert -->

<?php  if ( ! dynamic_sidebar( 'secondary-widget-area' ) ) : endif; ?>
