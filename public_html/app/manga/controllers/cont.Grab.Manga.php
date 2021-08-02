<?php 
include '../../../controllers/cont.main.php';
include 'cont.Grab.php';
if(!$user->isAdmin()){ header('Location: ../index.html'); }
if ($_POST && MANGA && $_POST['token'] == $_SESSION['token']) {
	if ($_POST['site'] === 'loveheaven') {
		$url = $_POST['manga'];
		$string = $huy->curl($url);
		$manga = $Grab->Loveheaven($url);
		$query1 = $db->Query(APP_TABLES_PREFIX.'manga_mangas','id',array('slug'=>$manga['slug']), NULL,NULL,NULL,NULL);
		if(!empty($query1)){ 
			$message = ' Manga <a href="/'.$query1[0]['id'].'/" target="_blank" style="color:red">'.$manga['name'].'</a>' .' đã tồn tại<br />';
			echo $message;
		} else {
			$query = 1;
			$mid = $query = $db->Create(APP_TABLES_PREFIX.'manga_mangas',array('name'=>$manga['name'],'slug'=>$manga['slug'],'m_status'=>$manga['status'],'authors'=>$manga['authors'],'artists'=>$manga['artists'],'genres'=>$manga['genres'],'trans_group'=>$manga['magazine'],'other_name'=>$manga['other_name'],'description'=>$manga['description'],'magazine'=>$manga['magazine'],'magazines'=>$manga['magazines'],'submitter'=>$manga['submitter'],'cover'=>$manga['cover'],'views'=>'1','post'=>$now));
			$message =  ' Manga <a href="/'.$mid.'/" target="_blank" style="color:red">'.$manga['name'].'</a>' .' lấy thành công<br />';
			echo $message;
			if ($query) {
				//preg_match('#class="chapter-list">(.*)</ul>#imsU', $string, $content_chapter);
				preg_match_all('#<a class="chapter" href=\'(.*)\' title="(.*)">#imsU', $string, $list_chapter);
				foreach ($list_chapter[2] as $value) {
					preg_match('#Chapter ([\d.]+)#is', $value, $chapter);
					$chap_max = abs($chapter[1]);
					$result = $db->Update(APP_TABLES_PREFIX.'manga_mangas',array('slug'=>$manga['slug']),array('post'=>$now, 'last_chapter'=>$chap_max));
					break;
				}
				$list_chapter[1] = array_reverse($list_chapter[1]);
				$list_chapter[2] = array_reverse($list_chapter[2]);
				$chapterURL = '"'.implode('","', $list_chapter[1]).'"';
				$chapterNAME = '"'.trim(implode('","', $huy->addSlashes($list_chapter[2]))).'"';
			}

		}
	}
}
?>
<!--?php if (!$query1) {
	?>
	<script>
		$(document).ready(function(e) {
			var _listURL = [<--?=$chapterURL?>],
			_listName = [<--?=$chapterNAME?>],
			_token = '<--?=$_SESSION[token]?>',
			_site = '<--?=$_POST['site']?>',
			_slug = '<--?=$manga[slug]?>',
			_mid = '<--?=$mid?>',
			_name_manga = '<--?=$manga[name]?>',
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
	<!--?php
} ?!-->

<br />
<div class="col-md-12 process">
	<div class="progress" style="opacity: 0;">
		<div class="progress-bar progress-bar-striped bg-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style></div>
	</div>
</div>
<div class="col-md-12">
	<div class="end"></div>
</div>

