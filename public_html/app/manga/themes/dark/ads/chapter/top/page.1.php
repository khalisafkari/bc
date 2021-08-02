<?php
	$isAdult = strpos($genads,'Adult');
	$isEcchi = strpos($genads,'Ecchi');
	if($detech -> isMobile() && !($isAdult || $isEcchi)){
	?>
		<!--div class = "aplvideo1">
			<script async id="AV6086ba97c979b40b712ace46" type="text/javascript" src="https://tg1.modoro360.com/api/adserver/spt?AV_TAGID=6086ba97c979b40b712ace46&AV_PUBLISHERID=60095c900c0799791c46d8d4"></script>
		</div--
		<!-- At the place -> m.lovehug.net_ROS_Rectangle1 -->
		<div class="spolecznoscinet" id="spolecznosci-8143" data-max-width="750"></div>
<?php } elseif (!($isAdult || $isEcchi)){
	?>	
		<!--div class = "aplvideo1">
			<script async id="AV6086ba97c979b40b712ace46" type="text/javascript" src="https://tg1.modoro360.com/api/adserver/spt?AV_TAGID=6086ba97c979b40b712ace46&AV_PUBLISHERID=60095c900c0799791c46d8d4"></script>
		</div-->
		<!-- At the place -> Lovehug.net_ROS_Rectangle1 -->
		<div class="spolecznoscinet" id="spolecznosci-8142" data-min-width="750"></div>
<? } ?>