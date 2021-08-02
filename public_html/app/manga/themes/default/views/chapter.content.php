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
	mysqli_query($db->Connect(),"UPDATE ".APP_TABLES_PREFIX."manga_chapters SET views = views + 1 WHERE id = '".$c_id."'");

	$_SESSION['c_'.$c_id] = '1';

}
$proxy = '';
?>
<!-- Done view plus --> 
<? if($c_manga['read_type'] == '1'){ ?>
	<!-- WEBTOON -->

	<div class="chapter-content">
		<?
		$img = explode("http", $thisChapter['content']);
		$imgs = count($img);
		$img_type = '1';
		$img_display = 'http';
		if($imgs == '1'){ 
			$img = explode("app/manga/uploads", $thisChapter['content']);
			$imgs = count($img);
			$img_type = '2';
			$img_display = 'app/manga/uploads';
			if($imgs == '1'){
				$img = explode("app/manga/uploads", $thisChapter['content']);
				$imgs = count($img);
				$img_type = '3';
				$img_display = 'https://';
			}
		}

		for($i = 1; $i < $imgs; $i++){
			echo "<img class='_lazy chapter-img' src='".$img_display.$img[$i]."' data-original='".$img_display.$img[$i]."' alt='".$thisManga['name']." ".$lang['Chapter']." ".$thisChapter['chapter']." - Truyentranhaz.net'></br>";
		}

		include 'chapter.content.before.php';
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
				$img = explode("app/manga/uploads", $thisChapter['content']);
				$imgs = count($img);
				$img_type = '2';
				$img_display = 'app/manga/uploads';
				if($imgs == '1'){
					$img = explode("app/manga/uploads", $thisChapter['content']);
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
				echo "<a href='".$lang['read_slug']."-".$slug."-".$lang['chapter_slug']."-".$thisChapter['chapter']."-".$lang['page_slug']."-".$next_page.".html'><img class='chapter-img' src='".$img_display.$img[$page]."' data-original='".$img_display.$img[$page]."' class='chapter-img'></a>";
				if (function_exists($next_page)) {
					echo "<img class='_lazy chapter-img' src='".$img_display.$img[$next_page]."' data-original='".$img_display.$img[$next_page]."' style='display:none' alt='".$thisManga['name']." ".$lang['Chapter']." ".$thisChapter['chapter']." - Truyentranhaz.net'>";
				}

			}
			echo '<br /><br />';
			page_select($page,$img,$thisChapter);
			include 'chapter.content.before.php';
			?>
		</div>
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
				$img = explode("app/manga/uploads", $thisChapter['content']);
				$imgs = count($img);
				$img_type = '2';
				$img_display = 'app/manga/uploads';
				if($imgs == '1'){
					$img = explode("app/manga/uploads", $thisChapter['content']);
					$imgs = count($img);
					$img_type = '3';
					$img_display = 'https://';
				}
			}

			for($i = 1; $i < $imgs; $i++){
				echo '<div class="swiper-slide white-slide">';
				echo "<img class='_lazy chapter-img' src='".$img_display.$img[$i]."' data-original='".$img_display.$img[$i]."' class='chapter-img chapter-img-touch' alt='".$thisManga['name']." ".$lang['Chapter']." ".$thisChapter['chapter']." - Truyentranhaz.net'></br></br></br>";
				echo '</div>';
			}
			echo '<br /><br />';
			echo '<div class="swiper-slide white-slide">';
			include 'chapter.content.before.php';
			include 'chapter.comment.php';

			echo '</div>';

			?>
		</div>
		<div class="chapter-pagination"></div>

	</div>

	<script>
		var mySwiper = new Swiper('.swiper-container',{
			pagination: '.chapter-pagination',
			onTouchEnd: function(swiper){
				document.body.scrollTop = document.documentElement.scrollTop = 0;
			},
			paginationClickable: true,
			keyboardControl: true,
			onSlideClick: function(next_slide){
				mySwiper.swipeNext()
			},
		})
	</script>	

	<? } ?>