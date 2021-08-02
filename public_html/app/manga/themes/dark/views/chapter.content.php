<?php
$c_id = $thisChapter['id'];

if (!isset($_COOKIE['history'])) {
	setcookie('history', '', time() + 60*60*24*365, '/');
	$data[$thisManga['id']] = $thisChapter['id'];
	$result = json_encode($data);
	setcookie('history', $result, time() + 60*60*24*365, '/');
} else {
	$data = json_decode($_COOKIE['history'], true);
	$add[$thisManga['id']] = $thisChapter['id'];
	$arr = $add + $data;

	if (count($arr) > 20) {
		$i = 0;
		foreach ($arr as $key => $value) {
			if ($i >= 20) {
				unset($arr[$key]);
			}
			$i++;
		}
	}
	$result = json_encode($arr);
	setcookie('history', $result, time() + 60*60*24*365, '/');
}

if(!isset($_SESSION['c_'.$c_id])){

	// TOTAL VIEWS
	mysqli_query($db->Connect(),"UPDATE ".APP_TABLES_PREFIX."manga_mangas SET views = views + 1 WHERE id = '".$c_id."'");

	$_SESSION['c_'.$c_id] = '1';

}
$proxy = '';
?>
<?php
			$thisChapter['content'] = str_replace("https://s4.imfaclub.com/images/20200715/image_5f0ecf23aed2e.png","",$thisChapter['content']);
			//$thisChapter['content'] = str_replace('/backend/','/images/',$thisChapter['content']);
			
			//$thisChapter['content'] = str_replace('https://s4.imfaclub.com/images/','https://s4.imfaclub.com/manga/',$thisChapter['content']);
			//$thisChapter['content'] = str_replace('/images/','/backend/',$thisChapter['content']);
			$thisChapter['content'] = str_replace('h4.klimv1.xyz','s4.ihlv1.xyz',$thisChapter['content']);	
			$thisChapter['content'] = str_replace('imfaclub.com','ihlv1.xyz',$thisChapter['content']);
?>
<!-- Done view plus --> 
<? if($c_manga['read_type'] == '1'){ ?>
	<!-- WEBTOON -->
	<?php
	if($detech -> isMobile()){
	?>
	<div class="chapter-content">
	
	<?php } else {?>
	<div class="chapter-content" style="margin: 0 auto;width: 1000px;">
	<?php }?>
		<?
		$img = explode("http", $thisChapter['content']);
		$imgs = count($img);
		$img_type = '1';
		$img_display = 'http';
		if($imgs == '1'){ 
			$img = explode("/app/manga/uploads", $thisChapter['content']);
			$imgs = count($img);
			$img_type = '2';
			$img_display = '/app/manga/uploads';
			if($imgs == '1'){
				$img = explode("/app/manga/uploads", $thisChapter['content']);
				$imgs = count($img);
				$img_type = '3';
				$img_display = 'https://';
			}
		}

		for($i = 1; $i < $imgs; $i++){
			echo "<img class='lazyload chapter-img' src='/uploads/lazy_loading.gif' data-srcset='".$img_display.$img[$i]."' data-aload='".$img_display.$img[$i]."' data-sizes='auto' alt='".$thisManga['name']." ".$lang['Chapter']." ".$thisChapter['chapter']." - lovehug.net'></br>";
			//echo "<img class='chapter-img' src='/shower.html?data=".$img_display.$img[$i]."' style='width: 100%;' alt='".$thisManga['name']." ".$lang['Chapter']." ".$thisChapter['chapter']." - lovehug.net'></br>";
			//if($i===2){
				//insert your ads
				//include ROOT_DIR.'/app/manga/themes/dark/ads/chapter/mid/page.2.php';
			//}
			if($i===3){
				//insert your ads
				include ROOT_DIR.'/app/manga/themes/dark/ads/chapter/mid/page.3.php';
			}
			if($i===4){
				//insert your ads
				include ROOT_DIR.'/app/manga/themes/dark/ads/chapter/mid/page.4.php';
			}
			//if($i===5){
				//insert your ads
				//include ROOT_DIR.'/app/manga/themes/dark/ads/chapter/mid/page.5.php';
			//}
			//if($i===6){
				//insert your ads
				//include ROOT_DIR.'/app/manga/themes/dark/ads/chapter/mid/page.6.php';
			//}
		}
		//include ROOT_DIR.'/app/manga/themes/dark/ads/chapter/bot/on.credit.php';
		echo "<img class='chapter-img' src='https://s4.ihlv1.xyz/images/20210124/LoveHug_600cfd96e98ff.jpg' alt='".$thisManga[name]." ".$lang[Chapter]." ".$thisChapter[chapter]." - lovehug.net'></br>";
		include 'chapter.section.php';
		include 'chapter.content.after.php';
		//include ROOT_DIR.'/app/manga/themes/dark/ads/chapter/bot/last.php';
		include 'chapter.comment.php';
		?>
	</div>	
	<!-- END WEBTOON -->
	<? }else if($c_manga['read_type'] == '2'){ ?>
		<!-- PAGE BY PAGE -->
		<div class="chapter-content">
			<?
			$img = explode("http", $thisChapter['content']);
			$imgs = count($img);
			$img_type = '1';
			$img_display = 'http';
			if($imgs == '1'){ 
				$img = explode("/app/manga/uploads", $thisChapter['content']);
				$imgs = count($img);
				$img_type = '2';
				$img_display = '/app/manga/uploads';
				if($imgs == '1'){
					$img = explode("/app/manga/uploads", $thisChapter['content']);
					$imgs = count($img);
					$img_type = '3';
					$img_display = 'https://';
				}
			}

			page_select($page,$img,$thisChapter);
			$next_page = $page+1;
			$prev_page = $page-1;
			if($next_page > $imgs){
				// Comment box :)
				include 'chapter.comment.php';
			} else {
				echo "<a href='/".$thisChapter['mid']."/".$thisChapter['id']."/".$next_page."/'><img class='chapter-img' src='".$img_display.$img[$page]."' data-original='".$img_display.$img[$page]."' class='chapter-img'></a>";
				if (function_exists($next_page)) {
					echo "<img class='_lazy chapter-img' src='".$img_display.$img[$next_page]."' data-original='".$img_display.$img[$next_page]."' style='display:none' alt='".$thisManga['name']." ".$lang['Chapter']." ".$thisChapter['chapter']." - lovehug.net'>";
				}

			}
			echo '<br /><br />';
			page_select($page,$img,$thisChapter);
			include 'chapter.content.after.php';
			?>
		</div>
		<? include 'chapter.section.php'; ?>
		<!-- KEYBOARD NAVIGATION -->
		<script>
			$(document.documentElement).keyup(function (event) {
				let total = Number('<?=$imgs?>');
				let max = Number('<?=$next_page?>');
				let min = Number('<?=$prev_page?>');
	  // handle cursor keys
	  if (event.keyCode == 37 && min > 0) {  
	  	window.location.href = '<?=$lang['read_slug']."-".$slug."-".$lang['chapter_slug']."-".$thisChapter['chapter']."-".$lang['page_slug']."-".$prev_page.".html"?>';
	  } else if (event.keyCode == 39 && max <= total) {
	  	window.location.href = '<?=$lang['read_slug']."-".$slug."-".$lang['chapter_slug']."-".$thisChapter['chapter']."-".$lang['page_slug']."-".$next_page.".html"?>';
	  }
	});	
</script>
<!-- END PAGE BY PAGE -->
<? }else if($c_manga['read_type'] == '3'){ ?>
	<div class="swiper-container">
		<div class="swiper-wrapper">
			<?
			$img = explode("http", $thisChapter['content']);
			$imgs = count($img);
			$img_type = '1';
			$img_display = 'http';
			if($imgs == '1'){ 
				$img = explode("/app/manga/uploads", $thisChapter['content']);
				$imgs = count($img);
				$img_type = '2';
				$img_display = '/app/manga/uploads';
				if($imgs == '1'){
					$img = explode("/app/manga/uploads", $thisChapter['content']);
					$imgs = count($img);
					$img_type = '3';
					$img_display = 'https://';
				}
			}

			for($i = 1; $i < $imgs; $i++){
				echo '<div class="swiper-slide white-slide">';
				echo "<img class='_lazy chapter-img' src='".$img_display.$img[$i]."' data-original='".$img_display.$img[$i]."' class='chapter-img chapter-img-touch' alt='".$thisManga['name']." ".$lang['Chapter']." ".$thisChapter['chapter']." - lovehug.net'></br></br></br>";
				echo '</div>';
			}
			echo '<br /><br />';
			echo '<div class="swiper-slide white-slide">';
			include 'chapter.content.after.php';
			include 'chapter.comment.php';
			echo '</div>';

			?>
		</div>
		<div class="chapter-pagination"></div>

	</div>
	<? include 'chapter.section.php'; ?>
	<script>
		var mySwiper = new Swiper('.swiper-container',{
			pagination: '.chapter-pagination',
			paginationClickable: true,
			keyboardControl: true,
			onSlideClick: function(next_slide){
				mySwiper.swipeNext()
			},
		})
	</script>	

	<? } ?>