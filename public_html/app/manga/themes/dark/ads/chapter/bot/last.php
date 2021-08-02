<?php
	$isAdult = strpos($genads,'Adult');
	$isEcchi = strpos($genads,'Ecchi');
	if(!($isAdult || $isEcchi)){
	?>
		</br>
		<div id="protag-native-after_content"></div>
		<script type="text/javascript">
		   window.googletag = window.googletag || { cmd: [] };
		   window.protag = window.protag || { cmd: [] };
		   window.protag.cmd.push(function () {
			 window.protag.display("protag-native-after_content");
		   });
		</script>
<?php } ?>

