<?php
class Grab extends huy {
	function Loveheaven($url) {
		$string = parent::curl($url);
		preg_match('#class="manga-info">(.*)</ul>#imsU', $string, $content);
		$ctx = explode('<li>', $content[1]);
		preg_match('#<h1>(.*)</h1>#imsU', $ctx[0], $name);
		preg_match('#</b>:(.*)</li>#imsU', $ctx[2], $other_name);
		preg_match_all('#<a.*>(.*)</a>#imsU', $ctx[3], $authors);
		preg_match_all('#<a.*>(.*)</a>#imsU', $ctx[4], $genres);
		preg_match('#<a.*>(.*)</a>#imsU', $ctx[5], $m_status);
		//preg_match_all('#<a.*>(.*)</a>#imsU', $ctx[6], $magazine);
		preg_match_all('#<a.*>(.*)</a>#imsU', $ctx[6], $trans_group);
		preg_match('#Description</h3>(.*)<center>#imsU', $string, $desc);
		preg_match('#<img class="thumbnail".*src="(.*)">#imsU', $string, $cover);
		
		$manga['other_name'] = !empty($other_name[1]) ? trim($other_name[1]) : 'Updating';
		$manga['name'] = !empty($name[1]) ? trim($name[1]) : '';
		$manga['authors'] = !empty($authors[1]) ? trim(implode(',',$authors[1])) : 'Updating';
		$manga['artists'] = !empty($authors[1]) ? trim(implode(',',$authors[1])) : 'Updating';
		$manga['trans_group'] = !empty($trans_group[1]) ? trim($trans_group[1]) : 'Updating';
		$manga['genres'] = !empty($genres[1]) ? parent::koDau(trim(implode(',',$genres[1]))) : '';
		$manga['cover'] = !empty($cover[1]) ? strip_tags(trim($cover[1])) : '';
		$manga['description'] = !empty($desc[1]) ? trim(strip_tags($desc[1])) : '';
		$manga['magazine'] = !empty($trans_group[1]) ? trim(implode(',',$trans_group[1])) : '';
		$manga['magazines']= parent::slug($manga['magazine']);
		$manga['slug'] = parent::slug($manga['name']);
		$manga['submitter'] = $_SESSION['userId'];
		
		if (preg_match('#On Going#is', $m_status[1])) {
			$manga['status'] = 2;
		} else {
			$manga['status'] = 1;
		}
		$manga = parent::addSlashes(parent::clearXss($manga));
		return $manga;
	}
}

$Grab = new Grab();

?>