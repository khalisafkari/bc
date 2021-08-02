<?php
	$isAdult = strpos($genads,'Adult');
	$isEcchi = strpos($genads,'Ecchi');
	if(!($isAdult || $isEcchi)){
	?>
		<center>
			<h5><font color="white">
				Advertisement
				<hr width="30%" size="5px" align="center">
			</font></h5>
				<div id="protag-in_content"></div>
				<script type="text/javascript">
				   window.googletag = window.googletag || { cmd: [] };
				   window.protag = window.protag || { cmd: [] };
				   window.protag.cmd.push(function () {
					 window.protag.display("protag-in_content");
				   });
				</script>
		</center>
<?php } ?>
