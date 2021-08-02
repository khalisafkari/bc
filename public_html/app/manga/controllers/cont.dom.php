<?php

function create_dom($url,$follow=1)
{
	global $huy;
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_USERAGENT, " Google Mozilla/5.0 (compatible; Googlebot/2.1;)" );
    if($follow==1)
    {
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt( $ch, CURLOPT_REFERER, "http://www.google.com/bot.html" );
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5000);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5000);
    $result = curl_exec($ch);
    return $result;
}

// ================= MANGA ==================
// =================  FOX  ==================

function mangafox_manga($url){
	global $huy;
    $string = create_dom($url);
    
    preg_match('/<title>(.*?) Manga - Read (.*?) Manga Online for Free<\/title>/i',$string,$name);
    preg_match('/<div id="title">(.*)<\/table>/isU',$string,$info);
    preg_match('/<h3>(.*?)<\/h3>/is',$info[1],$other_name);
    preg_match_all('/<a href=".*?\/genres\/.*?">(.*?)<\/a>/is',$info[1],$genres);
    preg_match_all('/<a href=".*?\/author\/.*?">(.*?)<\/a>/is',$info[1],$author);
    preg_match('/<a .*?>(\d+)<\/a>/is',$info[1],$year);
    preg_match_all('/<a href=".*?\/artist\/.*?">(.*?)<\/a>/is',$info[1],$artist);
    preg_match('/<img .*?src="(.*?)\?\d+" alt=".*?" \/>/is',$string,$thumb);
    preg_match('/<p class="summary">(.*?)<\/p>/is',$string,$desc);
    preg_match('/<div id="series_info">(.*)<div class="data">/is',$string,$series_info);

    $manga['other_name'] = strip_tags($other_name['1']);
    if (strpos($series_info['1'],'Completed') !== false) {
        $manga['m_status'] = '1';
    }else{ $manga['m_status'] = '2'; }
    $manga['name']=$name[1];
    $manga['authors']=implode(',',$author[1]);
    $manga['artists']=implode(',',$artist[1]);
    $manga['genres']=implode(',',$genres[1]);
  //  $manga['cover']=$thumb[1];
    $manga['released']=$year[1];
    $manga['description']=$desc[1];

    return $manga;
}


//================= MANGA ==================
//=============  BLOGTRUYEN  ==================

function blogtruyen_manga($url){
	global $huy;
    $string = create_dom($url);
    
    
    preg_match ('#<span>.*&gt;(.*)</span>#imsU', $string, $name);
    preg_match('#<div class="content">(.*)</div>#imsU', $string, $desc);
    preg_match('#<p>.*\/nhom-dich\/.*>(.*)</a>.*</p>#imsU', $string, $nd);
    preg_match_all('#class="category".*\/theloai\/.*>(.*)</a></span>#imsU', $string, $genres);
    preg_match('#class="thumbnail".*<img src="(.*)".*><\/div>#imsU', $string, $cover);
    preg_match_all('#class="color-red">(.*)</span>#imsU', $string, $huy->decimal($series_info));
    preg_match('#<a.*class="color-green">(.*)</a>#imsU', $string, $authors);
    
    if ($series_info['1']['0'] == 'Đang tiến hành' || $series_info[1][0] == 'Đã hoàn thành') {
    if (strpos($huy->decimal($series_info['1']['0']),'Đã hoàn thành') !== false) {
        $manga['m_status'] = '1';
    }else{
    $manga['m_status'] = '2'; 
    }
    $manga['other_name'] = 'Đang cập nhật';
    } else {
    if (strpos($huy->decimal($series_info['1']['1']),'Đã hoàn thành') !== false) {
        $manga['m_status'] = '1';
    }else{
    $manga['m_status'] = '2'; 
    }
    $manga['other_name'] = $huy->decimal($series_info['1']['0']);
    }
    $manga['name']= $huy->decimal(trim($name[1]));
    $manga['authors']=$huy->decimal($authors[1]);
    $manga['artists']=$huy->decimal($authors[1]);
    $manga['genres']= implode(',',$huy->decimal($genres[1]));
    $manga['cover']=$cover[1];
    $manga['description']=$huy->decimal($desc[1]);
    if ($nd[1]!= NULL){
    $manga['nhom_dich']=$huy->decimal($nd[1]);
    } else {
    $manga['nhom_dich']='Đang cập nhật';
    }

    return $manga;
}

//================= MANGA ==================
//=============  VECHAI  ==================

function vechai_manga($url){
	global $huy;
    $string = create_dom($url);
    
    
    preg_match('#class="active".*>(.*)</li>#imsU',$string, $name);
    preg_match('#<div class="IntroText">(.*)</div>#imsU', $string, $desc);
    preg_match_all('#class="CateName">(.*)</a>#imsU', $string, $genres);
    preg_match('#<div class="col-md-2 col-xs-3">(.*)</div>#imsU', $string, $anh);
    preg_match('#<img src="(.*)" class="Thumb" alt=".*" />#', $anh[1], $cover);
    preg_match_all('#<dd>(.*)</dd>#imsU', $string, $author);
    if (strpos($author[0][2],'N/a') !== false){
    $manga['authors']= 'Đang cập nhật';
    $manga['artists']= 'Đang cập nhật';
    }else{
    preg_match_all('#<a.*>(.*)</a>#imsU', $author[0][2], $authors);
    $manga['authors'] = implode(',',$authors[1]);
    $manga['artists'] = implode(',',$authors[1]);
    }
    preg_match('#<a.*>(.*)</a>#imsU', $author[0][3], $series_info);
    
    
    if (strpos($series_info['1'],'Hoàn thành') !== false) {
        $manga['m_status'] = '1';
    }else{ 
    $manga['m_status'] = '2';
    }
    $manga['name']=trim($name[1]);
    $manga['genres']=implode(',',$genres[1]);
    $manga['cover']=$cover[1];
    $manga['description']=$desc[0];

    return $manga;
}