<?php
/*------------------------------------------------------------------------
# Aliweb News V1.0 Julio 2013
# ------------------------------------------------------------------------
# Copyright (C) 2013 Aliweb Desarrollo. All Rights Reserved.
# @licencia - Aliweb News Theme esta protegida bajo los terminos de las licencias GNU General Public License.
# Autor: http://www.aliweb.com.ar - Juan Manuel Piñeiro
-------------------------------------------------------------------------*/
get_header();
$PostIDs=array();
$TagPost=array(
			'lastmoment'=>1,
			'featured'=>2,
			'headlines'=>6,
			'newsflash1'=>8,
			'gossip'=>3,
			'travels'=>3,
			'newsflash2'=>8,
			'extra1'=>6,
			'featured2'=>2,
			'headlines2'=>3,
			'newsflash3'=>8
			);
			
			
$banner1_id=get_option('an_banner1_id');
if(wp_get_attachment_url($banner1_id))
{
	?>
	<!--Banner Informativo 950 X 70-->
	<div class="Banner70 Banner">
	<?php
	$banner1=wp_get_attachment_image_src($banner1_id,"banner70");
	$banner1_url=get_option('an_banner1_url');
	if(trim($banner1_url)!=="") 
	{
		?>
		<a href="<?=$banner1_url?>" target="_blank">
			<img src="<?=$banner1[0]?>" alt="" >
		</a>
	
	<!--Fin Banner Informativo 950 X 70-->
		<?php
	}else 
	{
		?>
		<img src="<?=$banner1[0]?>" alt="" >
		<?php
	}
	?>
	</div>
	<?php
}


query_posts('showposts=1&tag=lastmoment');
if (have_posts()) : the_post();
	$PostIDs[get_the_id()]="lastmoment";
	?>
	<section id="LastMoment" class="SiteCnt">
	<?php the_post_thumbnail("lastmoment",$attr);?>
		<h1>ULTIMO MOMENTO</h1>
		<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?> </a>
	</section>
	<?php
endif;
wp_reset_query();
?>
	<!--Seccion Noticias Principales-->
	<section class="SiteCnt CntPrincipal">
	<!--Noticias Principales-->
		<div class="CntNewsDest">
<?php 
$np=0;
$ps=0;
while($TagPost['featured']>$ps) 
{
	query_posts("showposts=1&tag=featured&offset=$np");
   if (have_posts()) : the_post();
   	$postid = get_the_ID();
   	if(!isset($PostIDs[$postid])) 
   	{
		   ?>
   	   <article class="NewsDest">
			<?php 
			if(has_post_thumbnail()) 
			{
				$attr = array(
				'class'	=> "news_dest_img"
				);
				the_post_thumbnail("featured",$attr);
			}else 
			{
			}
			?> 
      		<div class="NewsCopete">
	      		<label class="categoria"><?php the_category(' '); ?></label>
   				<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="NTitle"><?php the_title(); ?> 
   					<p class="ExtractDest"><?php $excerpt = get_the_excerpt(); echo string_limit_words($excerpt,20); ?></p>
   				</a>
      		</div>
      	</article>
			<?php
			$PostIDs[$postid]='featured';
			$ps++;
		} 
	endif;
	wp_reset_query();
	$np++;
}
?>
		</div>
		<!--Fin Noticias Principales-->
		<!--Inicio Noticias Destacadas-->
		<div class="CntNewsPrinc">
<?php 
$np=0;
$ps=0;
while($TagPost['headlines']>$ps) 
{
	query_posts("showposts=1&tag=headlines&offset=$np");
	if (have_posts()) : the_post();
		$postid = get_the_ID();
   	if(!isset($PostIDs[$postid])) 
   	{
			?>
			<article class="NewsPrinc">			
			<?php
			if(has_post_thumbnail()) 
			{
				$attr = array(
				'class'	=> "news_princ_img"
				);
				(the_post_thumbnail("headlines",$attr));
			}else 
			{
			}
			?> 
      		<label class="categoria"><?php the_category(' '); ?></label>
      		<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="NTitle"><?php the_title(); ?></a>
			</article>
			<?php
			$PostIDs[$postid]='headlines';
			$ps++;
		} 
	endif;
	wp_reset_query();
	$np++;
}
?>
		</div>
		<!--Fin Noticias Destacadas-->
	</section>
	<!--Fin Seccion Noticias Principales-->
	
	
	<!--Banner Publicidad2 200 X 950-->
<?php
$banner2_id=get_option('an_banner2_id');
if(wp_get_attachment_url($banner2_id))
{
	?>
	<div class="Banner200 Banner">
	<?php
	$banner2=wp_get_attachment_image_src($banner2_id,"banner200");
	$banner2_url=get_option('an_banner2_url');
	if(trim($banner2_url)!=="") 
	{
		?>
		<a href="<?=$banner2_url?>" target="_blank">
			<img src="<?=$banner2[0]?>" alt="" >
		</a>
		<?php
	}else 
	{
		?>
		<img src="<?=$banner2[0]?>" alt="" >
		<?php
	}
	?>
	</div>
	<?php
}
?>
	<!--Fin Banner Publicidad2 200 X 950-->
	
	
	<!--Seccion Primer Flash de Noticias-->
	<section id="Flash1" class="SiteCnt CntFlash">
		<!--Inicio Flash1 de Noticias-->
<?php 
$np=0;
$ps=0;
while($TagPost['newsflash1']>$ps) 
{
	query_posts("showposts=1&tag=newsflash1&offset=$np");
	if (have_posts()) : the_post();
		$postid = get_the_ID();
   	if(!isset($PostIDs[$postid])) 
   	{				
			if($ps<4) 
			{
				?>
			<article class="NewsFls">
				<?php
			}else 
			{
				?>
			<article class="NewsFls NotBtmBorder">
				<?php
			}	 
			if(has_post_thumbnail()) 
			{
				$attr = array(
				'class'	=> "news_flash_img"
				);
				the_post_thumbnail("flashnews",$attr);
			}else 
			{
			}
			?> 
	      	<label class="categoria"><?php the_category(' '); ?></label>
	      	<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="NTitle"><?php the_title(); ?></a>
			</article>
			<?php
			$PostIDs[$postid]='newsflash1';
			$ps++; 
		} 
	endif;
	wp_reset_query();
	$np++;
}
?>
		<!--Fin Flash1 de Noticias-->
	</section>
	<!--Fin Seccion Primer Flash de Noticias-->
	
		<!--Banner Publicidad3 200 X 200-->
<?php
$banner3_1_id=get_option('an_banner3_1_id');
if(wp_get_attachment_url($banner3_1_id))
{
	?>
	<div class="BannerV200 Banner">
	<?php
	$banner3_1=wp_get_attachment_image_src($banner3_1_id,"bannerV200");
	$banner3_1_url=get_option('an_banner3_1_url');
	if(trim($banner3_1_url)!=="") 
	{
		?>
		<a href="<?=$banner3_1_url?>" target="_blank">
			<img src="<?=$banner3_1[0]?>" alt="" >
		</a>
		<?php
	}else 
	{
		?>
		<img src="<?=$banner3_1[0]?>" alt="" >
		<?php
	}
	?>
	</div>
	<?php
}
?>
	<!--Fin Banner Publicidad3 Izquierda 200 X 200-->


<!--Banner Publicidad3 Derecha 200 X 200-->
<?php
$banner3_2_id=get_option('an_banner3_2_id');
if(wp_get_attachment_url($banner3_2_id))
{
	?>
	<div class="BannerV200 Banner">
	<?php
	$banner3_2=wp_get_attachment_image_src($banner3_2_id,"bannerV200");
	$banner3_2_url=get_option('an_banner3_2_url');
	if(trim($banner3_2_url)!=="") 
	{
		?>
		<a href="<?=$banner3_2_url?>" target="_blank">
			<img src="<?=$banner3_2[0]?>" alt="" >
		</a>
		<?php
	}else 
	{
		?>
		<img src="<?=$banner3_2[0]?>" alt="" >
		<?php
	}
	?>
	</div>
	<?php
}
?>
	<!--Fin Banner Publicidad3 Derecha 200 X 200-->
	<!--Seccion Noticias Farandula-->
	<section id="CntGsp" class="SiteCnt">
		<!--Noticias Farandula-->
		<div id="CntGspB">
<?php 
$np=0;
$ps=0;
while($TagPost['gossip']>$ps) 
{
	query_posts("showposts=1&tag=gossip&offset=$np");
	if (have_posts()) : the_post();
		$postid = get_the_ID();
   	if(!isset($PostIDs[$postid])) 
   	{		
   		if($np==0) 
			{
				?>
			<article id="GossipBig">
				<?php
				$attr = array(
				'class'	=> "news_gspb_img"
				);
				(the_post_thumbnail("gossipbig",$attr));
				?>	 
				<a href="<?php the_permalink() ?>" class="P2Copete">
					<span class="NTitle"><?php the_title(); ?></span>
					<span class="NBody"><?php $excerpt = get_the_excerpt(); echo string_limit_words($excerpt,40); ?></span>
				</a>
			</article>
				<?php
			}else
			{
				?>
			<article class="GossipNews" id="SctFtd<?=$ps?>">
				<?php
				$attr = array(
				'class'	=> "news_gsps_img"
				);
				(the_post_thumbnail("gossipsmall",$attr));
				?>	 
				<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="F2Copete">
					<?php  string_limit_words(the_title(),12); ?>
				</a>
			</article>
				<?php
			}
			$PostIDs[$postid]='gossip';
			$ps++; 
		} 
	endif;
	wp_reset_query();
	$np++;
}
?>
		</div>

		<!--Banner Gossip 180 X 410-->
		<div class="BannerGossip Banner">
<?php
$bannerG_id=get_option('an_bannerG_id');
if(wp_get_attachment_url($bannerG_id))
{
	$bannerG=wp_get_attachment_image_src($bannerG_id,"bannerGossip");
	$bannerG_url=get_option('an_bannerG_url');
	if(trim($bannerG_url)!=="") 
	{
		?>
			<a href="<?=$bannerG_url?>" target="_blank">
				<img src="<?=$bannerG[0]?>" alt="" >
			</a>
		<?php
	}else 
	{
		?>
			<img src="<?=$bannerG[0]?>" alt="" >
		<?php
	}
	?>
	
	<?php
}
?>
		</div>
		<!--Fin Banner Gossip 180 X 410-->
		
		
		<div id="Cartelera">
			<h2>Estrenos de Cine</h2>
<?php
$feed_movies = "http://feeds.feedburner.com/cinesargentinos-pelis?format=xml";
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL,"$feed_movies");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
$xmlMovies = curl_exec($curl);
curl_close($curl);
$xml = simplexml_load_string($xmlMovies);
$m=0;
foreach ($xml->channel->item as $item) 
{
	$img=$item->guid;
	$img=str_replace("/pelicula/","/poster/",$img);
	$img=substr($img,0,strlen($img)-1)."_168.jpg";
	if($m==0) 
	{
		?>
			<div class="InfoShows activeShow" id="Show<?=$m?>">
		<?php
	}else 
	{
		?>
			<div class="InfoShows" id="Show<?=$m?>">
		<?php
	}
	?>
				<img src="<?=$img?>" alt="" >
				<h4><?=$item->title?></h4>
			</div>
	<?php
	$m++;   
}
$z=0;
while($z<$m) 
{
	if($z==0) 
	{
		?>
			<nav>
				<p title="Show<?=$z?>" onclick="ShowFilm(this)"><?=$z+1?></p>
		<?php
	}elseif($z==5)  
	{
		?>
				<p title="Show<?=$z?>" onclick="ShowFilm(this)"><?=$z+1?></p>
			</nav>
	<?php
	}else 
	{
		?>
				<p title="Show<?=$z?>" onclick="ShowFilm(this)"><?=$z+1?></p>
		<?php
	}
	$z++;	
}
?>	
		</div>
		<!--Noticias Farandula-->
	</section>
	<!--Seccion Noticias Farandula-->	
	
	
	<!--Banner Publicidad4 950 X 150-->
<?php
$banner4_id=get_option('an_banner4_id');
if(wp_get_attachment_url($banner4_id))
{
	?>
	<div class="Banner150 Banner">
	<?php
	$banner4=wp_get_attachment_image_src($banner4_id,"banner150");
	$banner4_url=get_option('an_banner4_url');
	if(trim($banner4_url)!=="") 
	{
		?>
		<a href="<?=$banner4_url?>" target="_blank">
			<img src="<?=$banner4[0]?>" alt="" >
		</a>
		<?php
	}else 
	{
		?>
		<img src="<?=$banner4[0]?>" alt="" >
		<?php
	}
	?>
	</div>
	<?php
}
?>
	<!--Fin Banner Publicidad4 950 X 150-->
	
	<!--Seccion Noticias Tema1-->
	<section id="CntTrv" class="SiteCnt">
		
<?php
$np=0;
$ps=0;
while($TagPost['travels']>$ps) 
{
	query_posts("showposts=1&tag=travels&offset=$np");
	if (have_posts()) : the_post();
		$postid = get_the_ID();
   	if(!isset($PostIDs[$postid])) 
   	{	
			?>
	<article class="TrvNews">
			<?php
			the_post_thumbnail("flashnews");
			?> 
		<label class="categoria"><?php the_category(' '); ?></label>
		<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="TrvCopete NTitle">
			<?php  string_limit_words(the_title(),15); ?>
		</a>
	</article>
			<?php
			$PostIDs[$postid]='travels';
			$ps++; 
		} 
	endif;
	wp_reset_query();
	$np++;
}
?>
<article class="TrvNews">
	<a href="http://www.lared913.com.ar/radioONLINE.html"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/lared913.png" id="RadioLaRed" alt="Radio La Red"></a>
</article>
	</section>
	<!--Fin Seccion Noticias Tema1-->
	
	
		<!--Banner Publicidad5 950 X 100-->
<?php
$banner5_id=get_option('an_banner5_id');
if(wp_get_attachment_url($banner5_id))
{
	?>
	<div class="Banner100 Banner">
	<?php
	$banner5=wp_get_attachment_image_src($banner5_id,"banner100");
	$banner5_url=get_option('an_banner5_url');
	if(trim($banner5_url)!=="") 
	{
		?>
		<a href="<?=$banner5_url?>" target="_blank">
			<img src="<?=$banner5[0]?>" alt="" >
		</a>
		<?php
	}else 
	{
		?>
		<img src="<?=$banner5[0]?>" alt="" >
		<?php
	}
	?>
	</div>
	<?php
}
?>
	<!--Fin Banner Publicidad5 950 X 100-->
	<!--Inicio Flash2 de Noticias-->
	<section id="Flash2" class="SiteCnt CntFlash">

<?php 
$np=0;
$ps=0;
while($TagPost['newsflash2']>$ps) 
{
	query_posts("showposts=1&tag=newsflash2&offset=$np");
	if (have_posts()) : the_post();
		$postid = get_the_ID();
   	if(!isset($PostIDs[$postid])) 
   	{	
			if($j<4) 
			{
				?>
			<article class="NewsFls">
				<?php
			}else 
			{
				?>
			<article class="NewsFls NotBtmBorder">
				<?php
			}	 
			if(has_post_thumbnail()) 
			{
				$attr = array(
				'class'	=> "news_flash_img"
				);
				the_post_thumbnail("flashnews",$attr);
			}else 
			{
			}
			?> 
	      	<label class="categoria"><?php the_category(' '); ?></label>
	      	<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="NTitle"><?php the_title(); ?></a>
			</article>
			<?php 
			$PostIDs[$postid]='newsflash2';
			$ps++;
		} 
	endif;
	wp_reset_query();
	$np++;
}
?>
	</section>
		<!--Fin Flash2 de Noticias-->
		
	<!--Banner Publicidad6 950 X 200-->
<?php
$banner6_id=get_option('an_banner6_id');
if(wp_get_attachment_url($banner6_id))
{
	?>
	<div class="Banner200 Banner">
	<?php
	$banner6=wp_get_attachment_image_src($banner6_id,"banner200");
	$banner6_url=get_option('an_banner6_url');
	if(trim($banner6_url)!=="") 
	{
		?>
		<a href="<?=$banner6_url?>" target="_blank">
			<img src="<?=$banner6[0]?>" alt="" >
		</a>
		<?php
	}else 
	{
		?>
		<img src="<?=$banner6[0]?>" alt="" >
		<?php
	}
	?>
	</div>
	<?php
}
?>
	<!--Fin Banner Publicidad6 950 X 200-->
	<!--Inicio Extra1 de Noticias-->
	<section id="Extra1" class="SiteCnt CntExtra">
		<div class="CntExtraNews">
<?php 
$np=0;
$ps=0;
while($TagPost['extra1']>$ps) 
{
	query_posts("showposts=1&tag=extra1&offset=$np");
	if (have_posts()) : the_post();
		$postid = get_the_ID();
   	if(!isset($PostIDs[$postid])) 
   	{	
			if($j<4) 
			{
				?>
			<article class="NewsExtra">
				<?php
			}else 
			{
				?>
			<article class="NewsExtra NotBtmBorder">
				<?php
			}	 
			if(has_post_thumbnail()) 
			{
				$attr = array(
				'class'	=> "news_extra_img"
				);
				the_post_thumbnail("flashnews",$attr);
			}else 
			{
			}
			?> 
				<label class="categoria"><?php the_category(' '); ?></label>
	      	<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"  class="NTitle"><?php the_title(); ?></a>
			</article>
			<?php 
			$PostIDs[$postid]='extra1';
			$ps++;
		} 
	endif;
	wp_reset_query();
	$np++;
}
?>
		</div>
		<!--<iframe src="http://widgets.datafactory.la/es/primeraa/posiciones.html#championship=primeraa&amp;appIdTrack=2011&amp;show-descentTable=1&amp;team=-1&amp;lang=es&amp;show-positionsTable=1&amp;show-PlayedGames=1&amp;show-Goals=0&amp;show-AgainstGoals=0&amp;show-WinGames=1&amp;show-TieGames=1&amp;show-LostGames=1&amp;show-Diff=1&amp;show-DescentPlayedGames=1&amp;show-DescentPoints=1&amp;show-fixtureTable=1&amp;show-nameDays=1&amp;dateFormat=mmdd&amp;show-goalsTable=1&amp;show-GoalsColumnTeams=1&amp;show-GoalsDetails=1&amp;css-width=280&amp;css-backgroundColor=%23FFFFFF&amp;css-textColor=%23343434&amp;css-desTxtColor=%23BD0926&amp;css-lineColor=%23D1D3D4&amp;css-desEquipoBgColor=%23F1F2F2&amp;css-desEquipoTxtColor=%23BD0926&amp;css-navBgColorSel=%23BD0926&amp;css-navColorSel=%23FFFFFF&amp;css-navBgColor=%236F7072&amp;css-navColor=%23FFFFFF&amp;css-titleFontFamily=%22Exo%22%2C%20sans-serif&amp;css-titlePoints=14&amp;css-titleWeight=1&amp;css-titleItalic=0&amp;css-tabsFontFamily=Arial%2CHelvetica%2Csans-serif&amp;css-tabsPoints=11&amp;css-tabsWeight=0&amp;css-tabsItalic=0&amp;css-mainFontFamily=Arial%2CHelvetica%2Csans-serif&amp;css-mainPoints=11&amp;css-mainWeight=0&amp;css-mainItalic=0&amp;css-height=520&amp;css-tabsColor=%23FFFFFF&amp;css-rowColor=%23BD0926&amp;css-textRowColor=%23FFFFFF&amp;css-borderColor=%23D1D3D4&amp;css-golColor=%23BD0926&amp;css-estadoColor=%23BD0926"  width="280"  height="615" id="TablaDePosiciones" ></iframe>-->
	</section>
		<!--Fin Flash2 de Noticias-->		
	
	<!--Seccion Noticias Principales2-->
	<section class="SiteCnt CntPrincipal">
	<!--Noticias Featured2-->
		<div class="CntNewsDest">
<?php 
$np=0;
$ps=0;
while($TagPost['featured2']>$ps) 
{
	query_posts("showposts=1&tag=featured2&offset=$np");
   if (have_posts()) : the_post();
   	$postid = get_the_ID();
   	if(!isset($PostIDs[$postid])) 
   	{
   		?>
   	   <article class="NewsDest">
			<?php 
			if(has_post_thumbnail()) 
			{
				$attr = array(
				'class'	=> "news_dest_img"
				);
				the_post_thumbnail("featured",$attr);
			}else 
			{
			}
			?> 
      		<div class="NewsCopete">
	      		<label class="categoria"><?php the_category(' '); ?></label>
     				<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="NTitle"><?php the_title(); ?> 
     					<p class="ExtractDest"><?php $excerpt = get_the_excerpt(); echo string_limit_words($excerpt,20); ?></p>
     				</a>
      		</div>
      	</article>
			<?php 
		$PostIDs[$postid]='featured2';
			$ps++;
		} 
	endif;
	wp_reset_query();
	$np++;
}
?>
		</div>
		<!--Fin Noticias Featured2-->
		<!--Inicio Noticias Headlines2-->
		<div class="CntNewsPrinc">
<?php
$np=0;
$ps=0;
while($TagPost['headlines2']>$ps) 
{
	query_posts("showposts=1&tag=headlines2&offset=$np");
   if (have_posts()) : the_post();
   	$postid = get_the_ID();
   	if(!isset($PostIDs[$postid])) 
   	{
			?>
		<article class="NewsPrinc NewsHL2">			
			<?php
			if(has_post_thumbnail()) 
			{
				$attr = array(
				'class'	=> "news_princ_img"
				);
				the_post_thumbnail("headlines",$attr);
			}else 
			{
			}
			?> 
      		<label class="categoria"><?php the_category(' '); ?></label>
      		<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="NTitle"><?php the_title(); ?></a>
			</article>
			<?php 
			$PostIDs[$postid]='headlines2';
			$ps++;
		} 
	endif;
	wp_reset_query();
	$np++;
}
?>
		</div>
	<!--Fin Noticias Headlines2-->
	
	<!--Banner Publicidad7 410 X 200-->
<?php
$banner7_id=get_option('an_banner7_id');
if(wp_get_attachment_url($banner7_id))
{
	?>
	<div class="BannerV410 Banner">
	<?php
	$banner7=wp_get_attachment_image_src($banner7_id,"bannerV410");
	$banner7_url=get_option('an_banner7_url');
	if(trim($banner7_url)!=="") 
	{
		?>
		<a href="<?=$banner7_url?>" target="_blank">
			<img src="<?=$banner7[0]?>" alt="" >
		</a>
		<?php
	}else 
	{
		?>
		<img src="<?=$banner7[0]?>" alt="" >
		<?php
	}
	?>
	</div>
	<?php
}
?>
	<!--Fin Banner Publicidad7 410 X 200-->
	<!--Banner Publicidad8 200 X 200-->
<?php
$banner8_id=get_option('an_banner8_id');
if(wp_get_attachment_url($banner8_id))
{
	?>
	<div class="Banner8 BannerV200 Banner">
	<?php
	$banner8=wp_get_attachment_image_src($banner8_id,"bannerV200");
	$banner8_url=get_option('an_banner8_url');
	if(trim($banner8_url)!=="") 
	{
		?>
		<a href="<?=$banner8_url?>" target="_blank">
			<img src="<?=$banner8[0]?>" alt="" >
		</a>
		<?php
	}else 
	{
		?>
		<img src="<?=$banner8[0]?>" alt="" >
		<?php
	}
	?>
	</div>
	<?php
}
?>
	<!--Fin Banner Publicidad8 200 X 200-->		
	</section>
	<!--Fin Seccion Noticias Principales2-->
	
	<!--Banner Publicidad9 950 X 200-->
<?php
$banner9_id=get_option('an_banner9_id');
if(wp_get_attachment_url($banner9_id))
{
	?>
	<div class="Banner200 Banner">
	<?php
	$banner9=wp_get_attachment_image_src($banner9_id,"banner200");
	$banner9_url=get_option('an_banner9_url');
	if(trim($banner9_url)!=="") 
	{
		?>
		<a href="<?=$banner9_url?>" target="_blank">
			<img src="<?=$banner9[0]?>" alt="" >
		</a>
		<?php
	}else 
	{
		?>
		<img src="<?=$banner9[0]?>" alt="" >
		<?php
	}
	?>
	</div>
	<?php
}
?>
	<!--Fin Banner Publicidad9 950 X 200-->
	
	
	<section id="Flash3" class="SiteCnt CntFlash">
		<!--Inicio Flash3 de Noticias-->
<?php 
$np=0;
$ps=0;
while($TagPost['newsflash3']>$ps) 
{
	query_posts("showposts=1&tag=newsflash3&offset=$np");
	if (have_posts()) : the_post();
		$postid = get_the_ID();
   	if(!isset($PostIDs[$postid])) 
   	{	
			if($j<4) 
			{
				?>
			<article class="NewsFls">
				<?php
			}else 
			{
				?>
			<article class="NewsFls NotBtmBorder">
				<?php
			}	 
			if(has_post_thumbnail()) 
			{
				$attr = array(
				'class'	=> "news_flash_img"
				);
				the_post_thumbnail("flashnews",$attr);
			}else 
			{
			}
			?> 
	      	<label class="categoria"><?php the_category(' '); ?></label>
	      	<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="NTitle"><?php the_title(); ?></a>
			</article>
			<?php 
			$PostIDs[$postid]='headlines';
			$ps++;
		} 
	endif;
	wp_reset_query();
	$np++;
}
?>
	</section>
	<!--Fin Flash3 de Noticias-->	
	<!--Inicio Footer-->
<?php get_footer(); ?>
	<!--Fin Footer-->