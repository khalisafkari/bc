<?php
set_time_limit(0);
include 'controllers/cont.main.php';
$url = 'https://lhnovels.net/manga-list.html?listType=pagination&page=1&artist=&author=&group=&m_status=&name=&genre=&ungenre=&sort=last_update&sort_type=DESC';
$string = $huy->create_dom($url);
preg_match_all('#<a href="(.*)" onmouseleave="out_show\(\)" onmouseenter=".*">(.*)</a>#', $string, $listManga);
$list_manga = array_combine($listManga[1], $listManga[2]);

//$list_manga = ['manga-ouyake-onna-denka-no-katei-kyoushi-manga-raw.html' => 'Koujyo Denka no Katei Kyoushi (Manga) - Raw'];
//var_dump($list_manga);
if (MANGA) {
	foreach ($list_manga as $aUrl => $aName) {
        $html = $huy->create_dom('https://lhnovels.net/'.$aUrl);
		$slug = $huy->slug(trim($aName));
        $checker = $db->Query(APP_TABLES_PREFIX. 'manga_mangas', 'id', array('slug'=>$slug));
		$mid = $checker[0]['id'];
		if (count($checker)) {
			$query = $db->Query(APP_TABLES_PREFIX.'manga_chapters','max(chapter) AS chapter',array('manga'=>$slug),NULL,null,null,NULL);
			$grab_tap = !empty($query[0]['chapter']) ? $query[0]['chapter'] : '0';
			preg_match_all('#<a class="chapter" href=\'(.*)\' title="(.*)">#imsU', $html, $list_chap);

			$arr = array_reverse(array_combine($list_chap[1], $list_chap[2]));
			foreach ($arr as $key => $value) {
				preg_match("#Chapter ([\d.]+)#si",$value,$ass);
				if (abs($ass[1]) > $grab_tap) {
					break;
				}
				unset($arr[$key]);
			}
		
			foreach ($arr as $url_chapter => $value) {
				$html = $huy->create_dom(trim('https://lhnovels.net/'.$url_chapter));
				preg_match('#Chapter ([\d.]+)#is', $value, $so_chapter);
				$st =  abs($so_chapter[1]);
				$other_name = 'Chapter '.$st;
				preg_match_all('#data-original=\'(.*)\'#imsU', $html, $img2);

				$img_full = '';
				$img_full = implode(chr(13), $img2[1]);
				if ($st > $grab_tap) {
					$result = $db->Create(APP_TABLES_PREFIX.'manga_chapters',array('mid'=>$mid, 'chapter'=>$st,'name'=>$other_name, 'manga'=>$slug, 'content'=>$img_full,'last_update'=>$now));
				}
			}
			if (count($arr)) {

				$thisChapter = $db->Query(APP_TABLES_PREFIX. 'manga_chapters','max(chapter) as chapter', array('manga'=>$slug),null,null,null,1);
				$chap_max = $thisChapter[0]['chapter'];
				$result_2 = $db->Update(APP_TABLES_PREFIX.'manga_mangas',array('slug'=>$slug),array('last_update'=>$now,'last_chapter'=>$chap_max));
				if ($result_2) {
					$thisManga = $db->Query(APP_TABLES_PREFIX. 'manga_mangas',array('id','name'), array('slug'=>$slug),null,null,null,1);
					$thisManga[0] = $huy->addSlashes($thisManga[0]);
					$mid = $thisManga['0']['id'];
					$thisChapter = $db->Query(APP_TABLES_PREFIX. 'manga_chapters','id', array('manga'=>$slug, 'chapter'=>$chap_max),null,null,null,1);
					$cid = $thisChapter[0]['id'];
					$whoBookmark = $db->Query(APP_TABLES_PREFIX. 'manga_bookmark', 'user', array('manga'=>$mid));
					foreach($whoBookmark as $one){
						$db->Create(APP_TABLES_PREFIX . 'manga_notification', array('type'=>2,'mid'=>$mid, 'cid'=>$cid, 'name'=>$thisManga[0]['name'], 'slug'=>$slug, 'url'=>'/'.$mid.'/'.$cid.'/','chapter'=>$chap_max,'content'=>'The Manga '.$thisManga[0]['name'].' you are following has a new chapter '.$chap_max.'.', 'user'=>$one['user'], 'time'=>$now));
					}
				$huy->cacheClear('list-chapter-manga-'.$slug);
				$huy->cacheClear('home_content');
				$huy->cacheClear('chapter/chapterList-'.$mid);
				}
			}
		} else {
			preg_match('#class="manga-info">(.*)</ul>#imsU', $html, $content);
		$ctx = explode('<li>', $content[1]);
		preg_match('#<h1>(.*)</h1>#imsU', $ctx[0], $name);
		preg_match('#</b>:(.*)</li>#imsU', $ctx[2], $other_name);
		preg_match_all('#<a.*>(.*)</a>#imsU', $ctx[3], $authors);
		preg_match_all('#<a.*>(.*)</a>#imsU', $ctx[4], $genres);
		preg_match('#<a.*>(.*)</a>#imsU', $ctx[5], $m_status);
		//preg_match_all('#<a.*>(.*)</a>#imsU', $ctx[6], $trans_group);
		preg_match_all('#<a.*>(.*)</a>#imsU', $ctx[6], $trans_group);
		preg_match('#Description</h3>(.*)<center>#imsU', $html, $desc);
		preg_match('#<img class="thumbnail".*src="(.*)">#imsU', $html, $cover);

		$manga['other_name'] = !empty($other_name[1]) ? trim($other_name[1]) : 'Updating';
		$manga['name'] = !empty($name[1]) ? trim($name[1]) : '';
		$manga['authors'] = !empty($authors[1]) ? trim(implode(',',$authors[1])) : 'Updating';
		$manga['artists'] = !empty($authors[1]) ? trim(implode(',',$authors[1])) : 'Updating';
		$manga['trans_group'] = !empty($trans_group[1]) ? trim(implode(',', $trans_group[1])) : 'Updating';
		
		$manga['genres'] = !empty($genres[1]) ? $huy->koDau(trim(implode(',',$genres[1]))) : 'Updating';
		$manga['cover'] = !empty($cover[1]) ? strip_tags(trim($cover[1])) : '';
		if (preg_match('#app/manga#is', $cover[1])) {
			$manga['cover'] = 'https://lhnovels.net/'.$cover[1];
		} else {
			$manga['cover'] = !empty($cover[1]) ? preg_replace('#(http://images1|http://images2|https://images2).*url=#imsU', '', $cover[1]) : '';
		}
		
		$manga['description'] = !empty($desc[1]) ? trim(strip_tags($desc[1])) : 'Updating';
		$manga['magazine'] = !empty($trans_group[1]) ? $huy->koDau(trim(implode(',',$trans_group[1]))) : 'Updating';
		$manga['magazines'] = $huy->slug($manga['magazine']);
		$manga['slug'] = $huy->slug($manga['name']);
		$manga['submitter'] = $_SESSION['userId'];

		if (preg_match('#On Going#is', $m_status[1])) {
			$manga['status'] = 2;
		} else {
			$manga['status'] = 1;
		}
			$manga = $huy->addSlashes($manga);
			$query = 1;
			$mid = $query = $db->Create(APP_TABLES_PREFIX.'manga_mangas',array('name'=>$manga['name'],'slug'=>$manga['slug'],'m_status'=>$manga['status'],'authors'=>$manga['authors'],'artists'=>$manga['artists'],'trans_group'=>$manga['trans_group'],'genres'=>$manga['genres'],'magazine'=>$manga['magazine'],'magazines'=>$manga['magazines'],'other_name'=>$manga['other_name'],'description'=>$manga['description'],'submitter'=>$manga['submitter'],'cover'=>$manga['cover'],'views'=>'1','post'=>$now));
			if ($query) {
				preg_match_all('#<a class="chapter" href=\'(.*)\' title="(.*)">#imsU', $html, $list_chapter);
				$arr = array_reverse(array_combine($list_chapter[1], $list_chapter[2]));
				//var_dump($arr);
				foreach ($arr as $list_chap => $name_chap) {
					$html = $huy->create_dom(trim('https://lhnovels.net/'.$list_chap));
					preg_match('#Chapter ([\d.]+)#is', $name_chap, $so_chapter);
					$so_tap = abs($so_chapter[1]);
					$other_name = 'Chapter '.$so_tap;
					preg_match_all('#data-original=\'(.*)\'#imsU', $html, $img);

					$img_full = '';
					$img_full = implode(chr(13), $img[1]);
					$result = $db->Create(APP_TABLES_PREFIX.'manga_chapters',array('mid'=>$mid,'chapter'=>$so_tap,'name'=>$other_name, 'manga'=>$manga['slug'],'content'=>$img_full,'views'=>'1','last_update'=>$now));

				}

				if ($result) {
					$thisChapter = $db->Query(APP_TABLES_PREFIX. 'manga_chapters', 'max(chapter) as chapter', array('manga'=>$manga['slug']),null,null,null,1);
					$chap_max = $thisChapter[0]['chapter'];
					$result_2 = $db->Update(APP_TABLES_PREFIX.'manga_mangas',array('slug'=>$manga['slug']),array('last_update'=>$now, 'last_chapter'=>$chap_max));
					$message =  ' Truyện <a href="/truyen-'.$manga['slug'].'.html" target="_blank" style="color:red">'.$manga['name'].'</a>' .' lấy thành công<br />';
				}
			}
		}
	}
}
?>