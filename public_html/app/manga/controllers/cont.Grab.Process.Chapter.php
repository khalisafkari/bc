<?php 
include '../../../controllers/cont.main.php';
if(!$user->isAdmin()){ header('Location: ../index.html'); }
if ($_POST && MANGA && $_POST['token'] === $_SESSION['token']) {

	// Lấy ra chương mới nhất của truyện đó
	$query = $db->Query(APP_TABLES_PREFIX.'manga_chapters',array('max(chapter) as chapter'),array('manga'=>$_POST['slug']),NULL,null,null,1);
	$grab_tap = empty(abs($query[0]['chapter'])) ? '-1' : abs($query[0]['chapter']);
	$url = $_POST['url'];
	$string = $huy->curl($url);

	// Bắt đầu phân loại từng trang để sử lý
	if ($_POST['site'] === 'loveheaven') {
			// Lấy ra danh sách chwong
		preg_match_all('#<a class="chapter" href=\'(.*)\' title="(.*)">#imsU', $string, $list_chap);

		$list_chapter[1] = array_reverse($list_chap[1]);
		$list_chapter[2] = array_reverse($list_chap[2]);

			// Loại bỏ những chương đã có
		foreach ($list_chapter[2] as $key => $nameChapter) {
			preg_match('#Chapter ([\d.]+)#is', $nameChapter, $num);
			if (abs($num[1]) > $grab_tap) {
				break;
			}
			unset($list_chapter[2][$key]);
			unset($list_chapter[1][$key]);
		}

			// Update chương mới nhất vào truyện
		//$lastChapterArray = array_slice($list_chapter[2], -1, 1);
		foreach ($list_chapter[2] as $key =>$value) {
			preg_match('#Chapter ([\d.]+)#is', $value, $chapter);
			$chap_max = abs($chapter[1]);
			$a = $chap_max;
			$result = $db->Update(APP_TABLES_PREFIX.'manga_mangas',array('slug'=>$_POST['slug']),array('last_update'=>$now, 'last_chapter'=>$chap_max));
		}
	}
	// End phân loại

	// Thêm thông báo chương mới cho thành viên theo dõi truyện
	$mid = $_POST['id'];
	$manga = $_POST['slug'];
	$name = $_POST['name'];
	

	// End thông báo
	$chapterURL = '"'.implode('","', $list_chapter[1]).'"';
	$chapterNAME = '"'.trim(implode('","', $huy->addSlashes(preg_replace( "/\r|\n/", "",$list_chapter[2])))).'"';
	$chapterNAME = preg_replace("/\r|\n/", "", $chapterNAME);
}
?>
<script>
	$(document).ready(function(e) {
		var _listURL = [<?=$chapterURL?>],
		_listName = [<?=$chapterNAME?>],
		_token = '<?=$_SESSION[token]?>',
		_site = '<?=$_POST['site']?>',
		_slug = '<?=$manga?>',
		_mid = '<?=$mid?>',
		_name_manga = '<?=$name?>',
		_load = 0,
		_part = 100/_listURL.length;
		function ajax_chapters(index) {
			$.ajax({
				url: siteURL + '/app/manga/controllers/cont.Grab.Chapter.php',
				type: 'POST',
				dataType: 'html',
				data: {
					url: _listURL[index],
					name: _listName[index],
					site: _site,
					slug: _slug,
					mid: _mid,
					name_manga: _name_manga,
					token: _token,
				},
				success: function(data) {
					$(".end").prepend(data);
					_load = _load + _part;
					$('.progress').css({opacity:1});
					$('.progress-bar').css({
						width: _load+'%',
					});
					$('.progress-bar').html(Math.round(_load)+' %');
					if (index+1 < _listURL.length) {
						ajax_chapters(index+1);
					}
				}
			})
			.fail(function() {
				console.log("Post chapter bị lỗi!");
			});
		}
		if (_listURL[0] != '') {
			ajax_chapters(0);
		}
	});
</script>
<br />
<div class="col-md-12 process">
	<div class="progress" style="opacity: 0;">
		<div class="progress-bar progress-bar-striped bg-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style></div>
	</div>
</div>
<div class="col-md-12">
	<div class="end"></div>
</div>
<?php

?>