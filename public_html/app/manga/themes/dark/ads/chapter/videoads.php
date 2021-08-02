	<!-- Vidazoo -->
<!--script src="https://static.vidazoo.com/basev/vwpt.js" data-widget-id="5ff62fd7c4063e0004e85353" defer></script-->
	<!-- Viads -->
<!--script src="https://video.your-notice.com/html_101983.js" defer  charset="UTF-8" ></script--> 
	<!-- One Page Galak -->
<!--script data-cfasync="false" async type="text/javascript" src="//drawnperink.com/fDprLvZAdlap7/26123"></script-->
	
<?php 
	$isAdult = strpos($genads,'Adult');
	$isEcchi = strpos($genads,'Ecchi');
	if($isAdult || $isEcchi) { ?>
					
	<?	} else {?>													
		<!--Aniview -->
			<script async id="AV604774b91031511d9e50f1e6" type="text/javascript" src="https://tg1.aniview.com/api/adserver/spt?AV_TAGID=604774b91031511d9e50f1e6&AV_PUBLISHERID=603b9e7a41ccef48a775d9c4"></script>
		<!-- Adipolo -->
				<div id='vid555'>
				  <script>
					googletag.cmd.push(function() { googletag.display('vid555'); });
				  </script>
				</div>
<?php }	?>
