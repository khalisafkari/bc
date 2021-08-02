<?php include 'controllers/cont.main.php'; ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<?php
$gpage = $_GET['gpage'];
!empty($gpage) ? $gpage : 1;
$url = 'https://lhnovels.net/manga-list.html?listType=pagination&page='.$gpage.'&artist=&author=&group=&m_status=&name=&genre=&ungenre=&sort=last_update&sort_type=DESC';
$html = '';
$html = $huy->create_dom($url);
$terror = 'Too many connections';

preg_match_all('#<a href="(.*)" onmouseleave="out_show\(\)" onmouseenter=".*">(.*)</a>#', $html, $list_link);

$list_manga = array_combine($list_link[1], $list_link[2]);
//$list_manga = array('manga-futago-no-ane-ga-miko-toshite-hikitorarete-watashi-wa-suterareta-kedo-tabun-watashi-ga-miko-de-aru.html');
$link_error = array(
 
);
foreach ($link_error as $error) {
 foreach ($list_manga as $key => &$link_remove) {
  if ($error == $link_remove) {
 unset($list_manga[$key]);
}
}
}

if (MANGA) {
 foreach ($list_manga as $url => $name) {
  $html = $huy->create_dom('https://lhnovels.net/'.$url);
  $slug = $huy->slug(trim($name));
  //$slug = substr($url,6);
  //$slug = str_replace('.html','',$slug);
    $checker = $db->Query(APP_TABLES_PREFIX. 'manga_mangas', 'id', array('slug'=>$slug));
  if ($checker) {
 $mid = $checker[0]['id'];
 $query = $db->Query(APP_TABLES_PREFIX.'manga_chapters','max(chapter) AS chapter',array('manga'=>$slug),NULL,null,null,NULL);
 $grab_tap = !empty($query[0]['chapter']) ? $query[0]['chapter'] : '-1';
 preg_match('#<tbody>(.*)</tbody>#imsU', $html, $c_content);
 preg_match_all('#class="chapter" href=\'(.*)\'.*><b>(.*)</b>.*</a>#imsU', $c_content[0], $list_chap);
 $arr = array_combine($list_chap[1], $list_chap[2]);
 foreach ($arr as $key => $value) {
  $value = strip_tags($value);
  preg_match('#Chapter ([\d\.]+)#is', $value, $ass);
  if (abs($ass[1]) <= $grab_tap) {
 unset($arr[$key]);
}
}
foreach ($arr as $url_chapter => $value) {
  $html = $huy->create_dom(trim('https://lhnovels.net/'.$url_chapter));
  $value = strip_tags($value);
  preg_match('#Chapter ([\d.]+)#is', $value, $so_chapter);
  $st =  abs($so_chapter[1]);
  $other_name = 'Chapter '.$st;
  preg_match_all('#class=\'chapter-img\'.*src=\'(.*)\'.*>#imsU', $html, $img2);
  $img_full = '';
  $img_full = implode(chr(13), $img2[1]);
  $img_full = preg_replace('#(http://images1|http://images2|https://images2).*url=#imsU', '', $img_full);
  $img_full = str_replace('app/manga/uploads','https://lhnovels.net/app/manga/uploads',$img_full);
  $img_full = urldecode($img_full);
  if ($st > $grab_tap) {
 $result = $db->Create(APP_TABLES_PREFIX.'manga_chapters',array('mid'=>$mid, 'chapter'=>$st, 'name'=>$other_name, 'manga'=>$slug,'content'=>$img_full,'last_update'=>$now));
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
}
}
} else {
 preg_match('#class="manga-info">(.*)</ul>#imsU', $html, $content);
 $contents = explode('<li>', $content[1]);
 preg_match ('#<h1>(.*)</h1>#imsU', $contents[0], $name);
 preg_match ('#</b>:(.*)</li>#imsU', $contents[2], $other_name);
 preg_match_all('#<a.*>(.*)</a>#imsU', $contents[3], $authors);
 preg_match_all("#<a.*>(.*)</a>#imsU", $contents[4], $genres);
 preg_match('#<a.*>(.*)</a>#imsU', $contents[5], $m_status);
 preg_match_all('#<a.*>(.*)</a>#imsU', $contents[6], $trans_group);
 preg_match_all('#<a.*>(.*)</a>#imsU', $contents[6], $magazine);
 preg_match('#class="thumbnail".*src="(.*)">#imsU', $html, $cover);
 preg_match('#Description</h3>(.*)<center>#imsU', $html, $desc);

 $manga['other_name'] = !empty($other_name[1]) ? trim($other_name[1]) : '';
 $manga['name'] = !empty($name[1]) ? trim($name[1]) : '';
 $manga['authors'] = !empty($authors[1]) ? trim(implode(',', $authors[1])) : 'Updating';
 $manga['artists'] = !empty($authors[1]) ? trim(implode(',', $authors[1])) : 'Updating';
 $manga['trans_group'] = !empty($trans_group[1]) ? trim(implode(',', $trans_group[1])) : '';
 $manga['magazine'] = !empty($magazine[1]) ? $huy->koDau(trim(implode(',',$magazine[1]))) : '';
 $manga['genres'] = !empty($genres[1]) ? $huy->koDau(trim(implode(',',$genres[1]))) : '';
 if (preg_match('#app/manga#is', $cover[1])) {
  $manga['cover'] = 'https://lhnovels.net/'.$cover[1];
 } else {
   $manga['cover'] = !empty($cover[1]) ? preg_replace('#(http://images1|http://images2|https://images2).*url=#imsU', '', $cover[1]) : '';
 }
 $manga['description'] = !empty($desc[1]) ? trim($desc[1]) : '';
 $manga['slug'] = $huy->slug($manga['name']);
 $manga['submitter'] = $_SESSION['userId'];

 if (preg_match('#Going#is', $m_status[1])) {
  $manga['status'] = 2;
} elseif (preg_match('#Completed#is', $m_status[1])) {
  $manga['status'] = 1;
} else {
  $manga['status'] = 4;
}

$manga = $huy->addSlashes($huy->clearXss($manga));

if(!empty($query1)){
} else {
  $query = 1;
  $mid = $query = $db->Create(APP_TABLES_PREFIX.'manga_mangas',array('name'=>$manga['name'],'slug'=>$manga['slug'],'m_status'=>$manga['status'],'authors'=>$manga['authors'],'artists'=>$manga['artists'],'trans_group'=>$manga['trans_group'],'magazines'=>$manga['magazine'],'genres'=>$manga['genres'],'other_name'=>$manga['other_name'],'description'=>$manga['description'],'submitter'=>$manga['submitter'],'cover'=>$manga['cover'],'views'=>'1','last_update'=>$now));

  if ($query) {
 preg_match('#<tbody>(.*)</tbody>#imsU', $html, $c_content);
 preg_match_all('#class="chapter" href=\'(.*)\'.*><b>(.*)</b>.*</a>#imsU', $c_content[0], $list_chapter);
 $arr = array_combine($list_chapter[1], $list_chapter[2]);
 foreach ($arr as $list_chap => $name_chap) {
  $html = $huy->create_dom(trim('https://lhnovels.net/'.$list_chap));
  preg_match('#Chapter ([\d.]+)#is', $name_chap, $so_chapter);
  $so_tap = abs($so_chapter[1]);
  $other_name = 'Chapter '.$so_tap;
  preg_match_all('#class=\'chapter-img\'.*src=\'(.*)\'.*>#imsU', $html, $img2);
  $img_full = '';
  $img_full = implode(chr(13), $img2[1]);
  $img_full = preg_replace('#(http://images1|http://images2|https://images2).*url=#imsU', '', $img_full);
  $img_full = str_replace('app/manga/uploads','https://lhnovels.net/app/manga/uploads',$img_full);
  $img_full = urldecode($img_full);
  $result = $db->Create(APP_TABLES_PREFIX.'manga_chapters',array('mid'=>$mid,'chapter'=>$so_tap,'name'=>$other_name,'manga'=>$manga['slug'],'content'=>$img_full,'views'=>'1','last_update'=>$now));

}

if ($result) {
  $thisChapter = $db->Query(APP_TABLES_PREFIX. 'manga_chapters', 'max(chapter) as chapter', array('manga'=>$manga['slug']),null,null,null,1);
  $chap_max = $thisChapter[0]['chapter'];
  $result_2 = $db->Update(APP_TABLES_PREFIX.'manga_mangas',array('slug'=>$manga['slug']),array('last_update'=>$now, 'last_chapter'=>$chap_max));
  $message =  'Manga <a href="/manga-'.$manga['slug'].'.html" target="_blank" style="color:red">'.$manga['name'].'</a>' .' get complete<br />';
  $huy->cacheClear('home_content');
  $huy->cacheClear('manga-option-list');
  $huy->cacheClear('list_abc');
	}
	}
	}
	}
	} 
	}

?>