$ads=1;
			$x=0;
			$isnull=!($ads<$rCa);
			while((!$isnull)&&($x<$rCa)) 
			{
				if(isset($qads[$ads])) 
				{
					$isnull=(!is_null($qads[$ads]->code))? (($qads[$ads]->h <= $qb1[$banner]->maxh)&&($qads[$ads]->w <= $qb1[$banner]->maxw))? true: false: false;
				
					$ads=(!is_null($qads[$ads]->code))? (($qads[$ads]->h <= $qb1[$banner]->maxh) && ($qads[$ads]->w <= $qb1[$banner]->maxw))? $ads: $ads+1: $ads+1;
				}else 
				{
					$ads++;
				}
				$x++;
			}
			
			if($ads<=$rCa) 
			{
				?>
	<div class="AdSenseGossip BannerLeft">
		<div class="AdSense-cnt Adsense<?=$qads[$ads]->w?>x<?=$qads[$ads]->h?>">
		<?=stripslashes($qads[$ads]->code)?>
		</div>
	</div>
			<?php
			unset($qads[$ads]);
		}