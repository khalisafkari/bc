<?php
	/**
	 * This class is used to access a MySQL database
	 *
	 * @package Huy's
	 * @author  Huy
	 */

	class manga extends huy {

		function listGenre($columns, $rawHtml = '') {
			global $lang;
			$rawHtml .= '<ul class="dropdown-menu megamenu">
			<li>
			<div class="col-sm-3 col-xs-6">
			<ul class="nav">';
			$listGenre = $this->_database->Query(APP_TABLES_PREFIX.'manga_genres', 'name, slug');
			$totalValue = count($listGenre);
			$rows = ceil($totalValue/$columns);
			for ($i=1; $i <= $columns; $i++) { 
				foreach ($listGenre as $key => $value) {
					$rawHtml .= '<li><a data-title="Genre '.$value['name'].'" href="/'.$lang['slug_genres'].'-'.$value['slug'].'.html" target="_self">'.$value['name'].'</a></li>';
					if ($key == $rows*$i) {
						$rawHtml .= '</ul>
						</div>
						<div class="col-sm-3 col-xs-6">
						<ul class="nav">';
						break;
					}
					unset($listGenre[$key]);
				}
			}
			$rawHtml .= '</ul>
			</div>
			<div class="col-sm-12 hidden-xs">
			<p class="tip"></p>
			</div>
			</li>
			</ul>';
			return $rawHtml;
		}
		function listGenres() {
			$result = $this->_database->Query(APP_TABLES_PREFIX.'manga_genres', 'name, slug');
			return $result;
		}
		function listMagazines() {
			$result = $this->_database->Query(APP_TABLES_PREFIX.'manga_magazines', 'name, slug');
			return $result;
		}

		function count_rating($manga) {
			$result = $this->_database->Query(APP_TABLES_PREFIX.'h0_ratings', 'vote_count', array('slug'=>$manga),null,null,null,null);
			$count = $result[0]['vote_count'];
			return $count;
		}

		function count_bookmark($manga) {
			$result = $this->_database->Query(APP_TABLES_PREFIX.'manga_bookmark', 'user', array('manga'=>$manga),null,null,null,null);
			$count = count($result);
			return $count;
		}

		function manga_info($field,$value){
			$result = $this->_database->Query(APP_TABLES_PREFIX.'manga_mangas','*',array($field=>$value),null,null,null,'1');
			return $result[0];
		}

		function chapter_info($field,$value){
			$result = $this->_database->Query(APP_TABLES_PREFIX.'manga_chapters','*',array($field=>$value),null,null,null,'1');
			return $result[0];
		}
		function chapter_id($mid, $chapter) {
			$result = $this->_database->Query(APP_TABLES_PREFIX.'manga_chapters','id',array('mid'=>$mid, 'chapter' => $chapter),null,null,null,null);
			return $result[0]['id'];
		}
		function group_info($id) {
			$result = $this->_database->Query(APP_TABLES_PREFIX. 'manga_groups', '*', array('id'=>$id));
			return $result[0];
		}
		function listGroup($group = NULL){
			$result = $this->_database->Query(APP_TABLES_PREFIX.'manga_groups','*');
			foreach($result as $value){
				echo "<option value='".$value['id']."' ".($group == $value['id'] ? 'selected' : '').">$value[name]</option>";
			}
		}

		function listThemes($default = NULL){
			$dir    = ROOT_DIR.'/app/manga/themes';
			$files = scandir($dir);
			foreach($files as $file){
				$name = explode('.',$file);
				$name = $name[0];
				if($name != NULL){ echo "<option value='$name' ".($default == $name ? 'selected' : '').">".ucfirst($name)."</option>"; }
			}
		}
		function status($number){
			global $lang;
			$status = '';
			if ($number == '1') {
				$status .= '<a href="/'.$lang['slug_completed'].'.html" class="btn btn-xs btn-success">'.$lang['Completed'].'</a>';
			} else if ($number == 2) {
				$status .= '<a href="/'.$lang['slug_on_going'].'.html" class="btn btn-xs btn-success">'.$lang['On_going'].'</a>';
			} elseif($number == 3) {
				$status .= '<a href="/'.$lang['slug_drop'].'.html" class="btn btn-xs btn-success">Drop</a>';
			}
			return $status;
		}
		function splitGroups($str,$lang){
			$str = trim($str);
			$tag = explode(",", $str);
			$tag_out = '';
			foreach ($tag as &$value) {   
				$value = trim($value);
				$sex = str_replace('+', '', $value);
				$tag_out .= '<a class="btn btn-xs btn-warning" href=\'/'.$lang['list_slug'].'-'.$lang['group_slug'].'-'. $sex.'.html\'>'.$value.'</a>  ';
			}
			return mb_substr($tag_out, 0, -2); 
		}
		function splitGenres($str,$lang){
			$str = trim($str);
			$tag = explode(",", $str);
			$tag_out = '';
			$buildData = '';
			foreach ($tag as $value) {   
				$buildData .= "'$value',";
			}
			$result = $this->_database->Query(APP_TABLES_PREFIX.'manga_genres', 'name, slug', 'slug IN ('.rtrim($buildData, ',').')');
			foreach ($result as $row) {
				$tag_out .= '<a class="btn btn-xs btn-danger" href=\'/'.$lang['list_slug'].'-'.$lang['genre_slug'].'-'.$row['slug'].'.html\'>'.$row['name'].'</a>  ';
			}
			return mb_substr($tag_out, 0, -2); 
		}
		function splitGenre($str,$lang){
			$str = trim($str);
			$tag = explode(",", $str);
			$tag_out = '';
			$buildData = '';
			foreach ($tag as $value) {   
				$buildData .= "'$value',";
			}
			$result = $this->_database->Query(APP_TABLES_PREFIX.'manga_genres', 'name, slug', 'slug IN ('.rtrim($buildData, ',').')');
			foreach ($result as $row) {
				$tag_out .= $row['name'].',  ';
			}
			return trim(mb_substr($tag_out, 0, -2), ','); 
		}
		function splitMagazines($str,$lang){
			$str = trim($str);
			$tag = explode(",", $str);
			$tag_out = '';
			$buildData = '';
			foreach ($tag as $value) {   
				$buildData .= "'$value',";
			}
			$result = $this->_database->Query(APP_TABLES_PREFIX.'manga_magazines', 'name, slug', 'slug IN ('.rtrim($buildData, ',').')');
			foreach ($result as $row) {
				$tag_out .= '<a class="btn btn-xs btn-warning" href=\'/'.$lang['list_slug'].'-magazine-'.$row['slug'].'.html\'>'.$row['name'].'</a>  ';
			}
			return mb_substr($tag_out, 0, -2); 
		}
		function splitAuthors($str,$slug){
			$str = trim($str);
			$tag = explode(",", $str);
			$tag_out = '';
			foreach ($tag as &$value) {    
				$value = trim($value);    
				$tag_out .= '<a class="btn btn-xs btn-info" href=\'/'.$slug.'-'. $value.'.html\'>'.$value.'</a>  ';
			}
			return mb_substr($tag_out, 0, -2); 
		}
		function splitArtists($str,$slug){
			$str = trim($str);
			$tag = explode(",", $str);
			$tag_out = '';
			foreach ($tag as &$value) {    
				$value = trim($value);    
				$tag_out .= '<a class="btn btn-xs btn-success btn-artists" href=\'/'.$slug.'-'. $value.'.html\'>'.$value.'</a>  ';
			}
			return mb_substr($tag_out, 0, -2); 
		}
		function save_image($inPath){ 
				//Download images from remote server 
			$rand = md5(rand(0, 9999999999).time());
			$in= fopen($inPath, "rb"); 
			$out= fopen(ROOT_DIR.'/app/manga/uploads/covers/'.$rand.'.jpg', "wb"); 
			while ($chunk = fread($in,8192)){ 
				fwrite($out, $chunk, 8192); 
			} 
			fclose($in); 
			fclose($out); 
			return 'app/manga/uploads/covers/'.$rand.'.jpg';
		}
		function displayRating($slug){
			$total = $this->_database->Query(APP_TABLES_PREFIX.'h0_ratings','total,vote_count',array('slug'=>$slug),null,null,null,'1');
			$rating = (count($total) > 0 ? ceil(5*( $total['0']['total']/( $total['0']['vote_count']*5))) : '0');
			echo "<div style='display: block'>";
			for ($i = 1; $i <= $rating; $i++){
				echo "<a class=\"h0_ratings_on h0_ratings_inactive\" href=\"javascript:\" rel=\"".$i."\"></a>";
			}
			for ($i = ($rating+1); $i <= 5; $i++){
				echo "<a class=\"h0_ratings_off h0_ratings_inactive\" href=\"javascript:\" rel=\"".$i."\"></a>";
			}
			echo "</div>";
		}
		function save_images($inPath,$folders){ 
			$img = explode("http://", $inPath);
			$imgs = count($img);
			for($i = 1; $i < $imgs; $i++){
				$in= fopen('http://'.$img[$i], "rb"); 
				$out= fopen(ROOT_DIR.'/app/manga/uploads/'.$folders.'/'.$i.'.jpg', "wb"); 
				while ($chunk = fread($in,8192)){ 
					fwrite($out, $chunk, 8192); 
				} 
				fclose($in); 
				fclose($out); 
				$content .= 'app/manga/uploads/'.$folders.'/'.$i.'.jpg';
			}	
			return $content;
		}
		function count_comment($manga) {
			$query = $this->_database->Query(APP_TABLES_PREFIX.'manga_comments', 'count(id) as id', array('manga'=>$manga));
			return $query['0']['id'];
		}
	}

	$h0manga = new manga();