<ol itemscope="" itemtype="http://schema.org/BreadcrumbList" class="breadcrumb"> 
	<li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
		<a itemscope="" itemtype="http://schema.org/Thing" itemprop="item" href="<?=DOMAIN?>/" title="Home">
			<span itemprop="name"><?=$lang['Home']?></span>
		</a>
		<meta itemprop="position" content="1">
	</li> 
	<li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
		<a itemscope="" itemtype="http://schema.org/Thing" itemprop="item" href="<?=DOMAIN?>/manga-list.html" title="List of Manga A-Z">
			<span itemprop="name"><?=$lang['List_manga']?></span>
		</a>
		<meta itemprop="position" content="2">
	</li>
</ol>
<?php
$limit = 20; // EDIT THIS FIELD FOR MANGA SHOW PER PAGE

function print_url($page,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type){
	if ($_GET['history']) {
		return "manga-post.html?listType=pagination&page=$page&artist=$artist&author=$author&group=$group&m_status=$m_status&name=$name&genre=$genre&ungenre=$ungenre&sort=$sort&sort_type=$sort_type&history=1";
	} else {
		return "manga-post.html?listType=pagination&page=$page&artist=$artist&author=$author&group=$group&m_status=$m_status&name=$name&genre=$genre&ungenre=$ungenre&sort=$sort&sort_type=$sort_type";
	}
}
// HANDLE SORTING
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'views' ; 
$sort_type = isset($_GET['sort_type']) ? $_GET['sort_type'] : 'DESC';

if($sort_type != 'ASC' && $sort_type != 'DESC'){ $sort_type = 'ASC'; } // PROTECT FROM SQL INJECTION
if($sort != 'views' && $sort != 'last_update' && $sort != 'name'){ $sort = 'name'; } // PROTECT FROM SQL INJECTION

$sort_query = "ORDER BY $sort $sort_type";

// HANDLE FILTERING
$genre = str_replace(array('\'', '"'), '', urldecode($_GET['genre']));
$ungenre = str_replace(array('\'', '"'), '', $_GET['ungenre']);

if ($genre) {
	$genres = explode(',', $genre);
	foreach ($genres as $g) {
		$text_genre .= " AND genres LIKE '%".$g."%' "; 
	}
}

if ($ungenre) {
	$ungenres = explode(',', $ungenre);
	foreach ($ungenres as $ug) {
		$text_ungenre .= " AND genres NOT LIKE '%".$ug."%' "; 
	}

}

$WHERE = NULL;

$_GET['author'] = str_replace(array('\'', '"'), '', urldecode($_GET['author']));
$author = isset($_GET['author']) ? addslashes($_GET['author']) : NULL ; 
$WHERE .= isset($author) ? " AND authors LIKE '%".$author."%' " : NULL;

$_GET['artist'] = str_replace(array('\'', '"'), '', urldecode($_GET['artist']));
$artist = isset($_GET['artist']) ? addslashes($_GET['artist']) : NULL ; 
$WHERE .=  isset($artist) ? " AND artists LIKE '%".$artist."%' " : NULL;

$g = isset($text_genre) ? $text_genre : NULL ;
$WHERE .=  isset($g) ? $g : NULL;

$ug = isset($text_ungenre) ? $text_ungenre : NULL ; 
$WHERE .=  isset($ug) ? $ug : NULL;

$_GET['group'] = str_replace(array('\'', '"'), '', urldecode($_GET['group']));
$group = isset($_GET['group']) ? addslashes($_GET['group']) : NULL ; 
$WHERE .=  isset($group) ? " AND magazine LIKE '%".$group."%' " : NULL;

$m_status = isset($_GET['m_status']) ? $_GET['m_status'] : NULL;
$WHERE .= isset($m_status) ? "AND m_status LIKE '%".$m_status."%' ": NULL;

$_GET['name'] = str_replace(array('\'', '"'), '', urldecode($_GET['name']));
$name = isset($_GET['name']) ? addslashes($_GET['name']) : NULL ; 
$WHERE .=  isset($name) ? " AND name LIKE '%".$name."%' " : NULL;
if ($_GET['history']) {
	$data = json_decode($_COOKIE['history'], true);
	$total_pages = count($data);
	$page = isset($_GET['page']) ? (int)$_GET['page'] : '1';
	$lastpage = ceil($total_pages/$limit);
	if (!is_numeric($page) || $page < 1){
		$page = 1;
	}
	if ($page >= $lastpage) {
		$page = $lastpage;
	}
	$prev = $page - 1;
	$next = $page + 1;
	if ($next > $lastpage) {
		$next = $lastpage;
	}
	if ($prev <= 0) {
		$page = 1;
	} elseif ($next >= $total_pages) {
		$page = $total_pages;
	}
	$start = (is_numeric($page) ? ($page - 1) * $limit : 0);

} else {
	@$query = mysqli_query($db->Connect(),"SELECT COUNT(id) as num FROM ".APP_TABLES_PREFIX."manga_mangas WHERE hidden = '0' $WHERE $sort_query");

	@$total_pages = mysqli_fetch_assoc($query);
	$total_pages = $total_pages['num'];
	@$page = isset($_GET['page']) ? (int)$_GET['page'] : '1';
	$lastpage = ceil($total_pages/$limit);  

	if (!is_numeric($page) || $page < 1){
		$page = 1;
	}
	if ($page >= $lastpage) {
		$page = $lastpage;
	}
	$prev = $page - 1;
	$next = $page + 1;
	if ($next > $lastpage) {
		$next = $lastpage;
	}
	if ($prev <= 0) {
		$page = 1;
	} elseif ($next >= $total_pages) {
		$page = $total_pages;
	}
	$start = (is_numeric($page) ? ($page - 1) * $limit : 0);

	@$query = "SELECT id,name,slug,cover,last_chapter,views,genres,last_update FROM ".APP_TABLES_PREFIX."manga_mangas WHERE hidden = '0' $WHERE $sort_query LIMIT $start, $limit";
	$thisQuery = @mysqli_query($db->Connect(),$query);
}


?>
<hr>
<div class="row">
	<div class="col-md-8">
		<div class="clear-fix"><br /></div>

<div class="card card-dark">
	<div class="card-header">
		<h3 class="card-title">
			<i class="fa fa-newspaper-o" aria-hidden="true"></i>  &nbsp; 
			<?=$lang['New-manga-post']?>
		</h3>
	</div>
	<div class="card-body bg-dark">
		<div class="row-last-update">
			<?php

			$thisMangaList20 = $db->Query(APP_TABLES_PREFIX.'manga_mangas', array('id','name','released','slug','last_chapter','post','m_status', 'views', 'cover'), array('hidden'=>0), NULL, NULL, array('post'=>'DESC'),20);

			foreach ($thisMangaList20 as $row) {
				$time_ago = $huy->ago($row['post']);
				$row = $huy->clearXss($huy->stripSlashes($row));
				$cover = preg_replace('#\?imgmax=.*#is', '', $row['cover']);
				$imgmax = '';
				if (preg_match('#blogspot.com#', $cover)) {
					$imgmax = '?imgmax=150';
				}

				?> 
				<div class="thumb-item-flow col-6 col-md-3">
					<div class="thumb-wrapper" data-id="5293" data-is-loaded="0">
						<a href="/<?=$row['id']?>/<?=$h0manga->chapter_id($row['id'], $row['last_chapter'])?>/">
							<div class="a6-ratio">
								<div class="content img-in-ratio lazyloaded" data-bg="<?=$cover.$imgmax?>" style="background-image: url('<?=$cover.$imgmax?>')" onmouseleave="out_show()" onmouseenter="show(<?=$row['id']?>)"></div>
							</div>
						</a>
						<div class="thumb-detail">
							<div class="thumb_attr chapter-title text-truncate btn btn-xs btn-warning" style="background-color: #5c2040; border-color: #5c2040; width: 100%; font-size: 14px" title="<?=$lang['Chapter']?> <?=$row['last_chapter']?>">
								<a href="/<?=$row['id']?>/<?=$h0manga->chapter_id($row['id'], $row['last_chapter'])?>/" title="<?=$lang['Chapter']?> <?=$row['last_chapter']?>"><?=$lang['Chapter']?> <?=$row['last_chapter']?></a>
							</div>
						</div>
						<div class="manga-badge">
							<span class="badge badge-info">
								<time class="timeago" title="2020-09-20 12:54:59"><?=$time_ago?></time>
							</span>
						</div>
					</div>
					<div class="thumb_attr series-title">
						<a href="/<?=$row['id']?>/" title="<?=str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($row['name']))))?>"><?=str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($row['name']))))?></a>
					</div>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</div>
<div id="pop_manga"></div>
	
		</div>
			<div class="col-md-4">
			<div class="clear-fix"><br></div>
			<?php include 'list.listGenre.php' ?>
		</div>
	</div>