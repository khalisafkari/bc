<?php
	$isAdult = strpos($genads,'Adult');
	$isEcchi = strpos($genads,'Ecchi');
	if(!($isAdult || $isEcchi)){
	?>
		</br><center>
			<!-- GPT AdSlot 2 for Ad unit '' ### Size: [[300,250],[336,280]] -->
				<div id='div-gpt-ad-8176806-2'>
				  <script>
					googletag.cmd.push(function() { googletag.display('div-gpt-ad-8176806-2'); });
				  </script>
				</div>
			<!-- End AdSlot 2 -->
			<!--h5><font color="white">
				Advertisement
				<hr width="30%" size="5px" align="center">
			</font></h5-->
		</center></br>
<?php } ?>