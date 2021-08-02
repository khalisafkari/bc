<ol itemscope="" itemtype="http://schema.org/BreadcrumbList" class="breadcrumb"> 
	<li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
		<a itemscope="" itemtype="http://schema.org/Thing" itemprop="item" href="<?=DOMAIN?>/" title="Trang chủ Đọc truyện tranh từ A đến Z">
			<span itemprop="name"><?=$lang['Home']?></span>
		</a>
		<meta itemprop="position" content="1">
	</li> 
	<li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
		<a itemscope="" itemtype="http://schema.org/Thing" itemprop="item" href="<?=DOMAIN?>/danh-sach-truyen.html" title="Danh Sách truyện từ A-Z">
			<span itemprop="name"><?=$lang['List_manga']?></span>
		</a>
		<meta itemprop="position" content="2">
	</li>
</ol>
<div class="btn-group btn-block">
	<button class="btn btn-sm btn-info" disabled> <?=$lang['STYLE-LIST']?></button>
	<a href="manga-list.html?listType=allABC" class="btn btn-sm btn-info <?php echo $listType == 'allABC' ? 'active' : ''; ?>"><i class="glyphicon glyphicon-th"></i> <?=$lang['ALL-IN-ONE-PAGE']?></a>
	<a href="manga-list.html?listType=pagination" class="btn btn-sm btn-info <?php echo $listType == 'pagination' ? 'active' : ''; ?>"><i class="glyphicon glyphicon-th-list"></i> <?=$lang['PAGINATION']?></a>
	<a href="/search" class="btn btn-sm btn-success pull-right"><i class="glyphicon glyphicon-filter"></i> Tìm kiếm nâng cao</a>
</div>
<?php
$limit = 20; // EDIT THIS FIELD FOR MANGA SHOW PER PAGE

function print_url($page,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type){
	if ($_GET['history']) {
		return "manga-list.html?listType=pagination&page=$page&artist=$artist&author=$author&group=$group&m_status=$m_status&name=$name&genre=$genre&ungenre=$ungenre&sort=$sort&sort_type=$sort_type&history=1";
	} else {
		return "manga-list.html?listType=pagination&page=$page&artist=$artist&author=$author&group=$group&m_status=$m_status&name=$name&genre=$genre&ungenre=$ungenre&sort=$sort&sort_type=$sort_type";
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
$WHERE .=  isset($group) ? " AND trans_group LIKE '%".$group."%' " : NULL;

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

	@$query = "SELECT id,name,slug,cover,last_chapter,views,genres FROM ".APP_TABLES_PREFIX."manga_mangas WHERE hidden = '0' $WHERE $sort_query LIMIT $start, $limit";
	$thisQuery = @mysqli_query($db->Connect(),$query);
}


?>
<hr>
<div class="row">
	<div class="col-lg-9 col-md-8">

		<div class="btn-group">
			<button class="btn btn-sm btn-info" disabled>Page <?php echo $page;?> of <?php echo $lastpage;?></button>
			<a href="<?php echo print_url($prev,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type); ?>" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-chevron-left"></i></a>
			<a href="<?php echo print_url($next,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type); ?>" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-chevron-right"></i></a>
		</div>
		<div class="btn-group asc">
			<a href="<?php echo print_url($page,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,'ASC'); ?>" class="btn btn-sm btn-info <?php echo $sort_type == 'ASC' ? 'active' : ''; ?>"><i class="glyphicon glyphicon-sort-by-attributes"></i> ASC</a>
			<a href="<?php echo print_url($page,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,'DESC'); ?>" class="btn btn-sm btn-info <?php echo $sort_type == 'DESC' ? 'active' : ''; ?>"><i class="glyphicon glyphicon-sort-by-attributes-alt"></i> DESC</a>
		</div>
		<div class="btn-group soft-by">
			<button class="btn btn-sm btn-info" disabled><?=$lang['sort-by']?></button>
			<a href="<?php echo print_url($page,$name,$author,$group,$m_status,$artist,$genre,$ungenre,'name',$sort_type); ?>" class="btn btn-sm btn-info <?php echo $sort == 'name' ? 'active' : ''; ?>"><i class="glyphicon glyphicon-sort-by-alphabet"></i> A-Z</a>
			<a href="<?php echo print_url($page,$name,$author,$group,$m_status,$artist,$genre,$ungenre,'views',$sort_type); ?>" class="btn btn-sm btn-info <?php echo $sort == 'views' ? 'active' : ''; ?>"><i class="glyphicon glyphicon-eye-open"></i> <?=$lang['most-view']?></a>
			<a href="<?php echo print_url($page,$name,$author,$group,$m_status,$artist,$genre,$ungenre,'last_update',$sort_type); ?>" class="btn btn-sm btn-info <?php echo $sort == 'last_update' ? 'active' : ''; ?>"><i class="glyphicon glyphicon-calendar"></i> <?=$lang['Last_update']?></a>
		</div>
		<div class="clear-fix"><br /><br /></div>
		<div class="row top" style="background: white;">
			<div style="margin-top: 12px">
			<?php
			if ($_GET['history']) {
				foreach ($data as $manga => $chapter) {
					$thisManga = $db->Query(APP_TABLES_PREFIX.'manga_mangas', 'name, slug, cover, views, genres', array('id'=>$manga), null, null, null, null);
					$thisManga = $thisManga[0];
					$cover = preg_replace('#\?imgmax=.*#is', '', $thisManga['cover']);
					$thisChapter = $db->Query(APP_TABLES_PREFIX.'manga_chapters', 'chapter', array('id'=>$chapter), null, null, null, null);
					$thisChapter = $thisChapter['0'];
					?>
					<div class="col-lg-6 col-md-12 row-list" id="<?=$manga?>">
						<div class="media">
							<a class="pull-left link-list" href="<?=$lang['manga_slug']?>-<?=$thisManga['slug']?>.html">
								<img class="media-object img-thumb" src="<?=$cover?>?imgmax=100" alt="<?=$thisManga['name']?>" width="100px" height="120px" onmouseleave="out_show()" onmouseenter="show(<?=$thisManga['id']?>)">
							</a>
							<div class="media-body">
								<h3 class="media-heading" id="tables"><a href="<?=$lang['manga_slug']?>-<?=$thisManga['slug']?>.html"><?=$thisManga['name']?></a></h3>
								<small><?php echo $h0manga->splitGenres($thisManga['genres'],$lang)?></small><br />
								<span class="display:block"><i><?=$lang['Views'] ?>: <?=$thisManga['views']?></i><button onclick="delete_manga(<?=$manga?>)" type="button" class="btn btn-info pull-right btn-xs"><i class="fa fa-times"></i> <i>xóa</i></button></span> <br />
								<a href="<?=$lang['read_slug']?>-<?=$thisManga['slug']?>-<?=$lang['chapter_slug']?>-<?=$thisChapter['chapter']?>.html"> <i class="fa fa-angle-double-right"></i> <i>Đọc tiếp chap <?=$thisChapter['chapter']?></i></a>
							</div>
						</span>
					</div>
				</div>

				<?php
			}
		} else {
			while($thisManga = @mysqli_fetch_assoc($thisQuery)){
				$thisManga = $huy->clearXss($huy->stripSlashes($thisManga));
				$cover = preg_replace('#\?imgmax=.*#is', '', $thisManga['cover']);
				?>
				<div class="col-lg-6 col-md-12 row-list">
					<div class="media">
						<a class="pull-left link-list" href="<?=$lang['manga_slug']?>-<?=$thisManga['slug']?>.html">
							<img class="media-object img-thumb" src="<?=$cover?>?imgmax=100" alt="<?=$thisManga['name']?>" width="100px" height="120px" onmouseleave="out_show()" onmouseenter="show(<?=$thisManga['id']?>)">
						</a>
						<div class="media-body">
							<h3 class="media-heading" id="tables"><a href="<?=$lang['manga_slug']?>-<?=$thisManga['slug']?>.html"><?=$thisManga['name']?></a></h3>
							<small><?php echo $h0manga->splitGenres($thisManga['genres'],$lang)?></small><br />
							<span class="display:block"><?=$lang['Views'] ?>: <?=$thisManga['views']?></span> <br />
							<?php if($thisManga['last_chapter'] !== ''){ ?><?=$lang['Last_chapter']?>: <a href="<?=$lang['read_slug']?>-<?=$thisManga['slug']?>-<?=$lang['chapter_slug']?>-<?=$thisManga['last_chapter']?>.html"><?=$thisManga['last_chapter']?></a><?php } ?>
						</div>
					</span>
				</div>
			</div>
			<?php
		}
	}
	?>
</div>
<?php 
$list_pagination = '';


if ($lastpage > 8) {
	if ($page > 1) {
		$list_pagination .= '<li><a href="'.print_url($prev,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">&laquo;</a></li>';
	} else {
		$list_pagination .= '<li><a class="disabled">&laquo;</a></li>';
	}
	if ($page == 1) {
		$list_pagination .= '<li><a class="active">1</a></li>';
	} else {
		$list_pagination .= '<li><a href="'.print_url(1,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">1</a></li>';
	}
	if ($page == 1) {
		$list_pagination .= '<li><a href="'.print_url(($page+1),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.($page+1).'</a></li><li><a href="'.print_url(($page+2),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.($page+2).'</a></li><li><a class="disabled">...</a></li><li>';
	} else if ($page == 2) {
		$list_pagination .= '<li><a class="active" href="'.print_url($page,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.$page.'</a></li><li><a href="'.print_url(($page+1),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.($page+1).'</a></li><li><a href="'.print_url(($page+2),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.($page+2).'</a></li><li><a class="disabled">...</a></li>';
	} elseif($page == 3) {
		$list_pagination .= '<li><a href="'.print_url(($page-1),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.($page-1).'</a></li><li><a class="active" href="'.print_url($page,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.$page.'</a></li><li><a href="'.print_url(($page+1),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.($page+1).'</a></li><li><a href="'.print_url(($page+2),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.($page+2).'</a></li><li><a class="disabled">...</a></li>';
	} elseif($page == 4) {
		$list_pagination .= '<li><a href="'.print_url(($page-2),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.($page-2).'</a></li><li><a href="'.print_url(($page-1),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.($page-1).'</a></li><li><a class="active" href="'.print_url($page,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.$page.'</a></li><li><a href="'.print_url(($page+1),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.($page+1).'</a></li><li><a href="'.print_url(($page+2),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.($page+2).'</a></li><li><a class="disabled">...</a></li>';
	} elseif ($page > 4 && $page <= ($lastpage-4)) {
		$list_pagination .= '<li><a class="disabled">...</a></li><li><a href="'.print_url(($page-2),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.($page-2).'</a></li><li><a href="'.print_url(($page-1),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.($page-1).'</a></li><li><a class="active" href="'.print_url($page,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.$page.'</a></li><li><a href="'.print_url(($page+1),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.($page+1).'</a></li><li><a href="'.print_url(($page+2),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.($page+2).'</a></li><li><a class="disabled">...</a></li>';
	} else if($page == ($lastpage-3)) {
		$list_pagination .= '<li><a class="disabled">...</a></li><li><a href="'.print_url(($page-2),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.($page-2).'</a></li><li><a href="'.print_url(($page-1),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.($page-1).'</a></li><li><a class="active" href="'.print_url($page,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.$page.'</a></li><li><a href="'.print_url(($page+1),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.($page+1).'</a></li><li><a href="'.print_url(($page+2),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.($page+2).'</a></li>';
	}elseif($page == ($lastpage-2)) {
		$list_pagination .= '<li><a class="disabled">...</a></li><li><a href="'.print_url(($page-2),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.($page-2).'</a></li><li><a href="'.print_url(($page-1),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.($page-1).'</a></li><li><a class="active" href="'.print_url($page,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.$page.'</a></li><li><a href="'.print_url(($page+1),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.($page+1).'</a></li>';
	} elseif($page == ($lastpage-1)) {
		$list_pagination .= '<li><a class="disabled">...</a></li><li><a href="'.print_url(($page-2),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.($page-2).'</a></li><li><a href="'.print_url(($page-1),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.($page-1).'</a></li><li><a class="active" href="'.print_url($page,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.$page.'</a></li>';
	} elseif($page = $lastpage) {
		$list_pagination .= '<li><a class="disabled">...</a></li><li><a href="'.print_url(($page-2),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.($page-2).'</a></li><li><a href="'.print_url(($page-1),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.($page-1).'</a></li>';
	}
	if ($page == $lastpage) {
		$list_pagination .= '<li><a class="active">'.$lastpage.'</a></li>';
	} else {
		$list_pagination .= '<li><a href="'.print_url($lastpage,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.$lastpage.'</a></li>';
	}
	if ($page < $lastpage) {
		$list_pagination .= '<li><a href="'.print_url($next,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">&raquo;</a></li>';
	} else {
		$list_pagination .= '<li><a class="disabled">&raquo;</a></li>';
	}
} else {
	for ($i=1;$i<=$lastpage;$i++) {
		if ($page == $i) {
			$list_pagination .= '<li><a class="active" href="'.print_url($page,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.$page.'</a></li>';
		} else {
			$list_pagination .= '<li><a href="'.print_url($i,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$sort,$sort_type).'">'.$i.'</a></li>';
		}
	}
}
?>
</div>
<div class="pagination-wrap">
	<ul class="pagination pagination-v4">
		<?=$list_pagination?>
	</ul>
</div>

</div>

<div class="col-lg-3 col-md-4">
	<div class="panel panel-default">
		<div class="panel-heading">Browse by Genres (<a href="/danh-sach-truyen.html">All</a>)</div>
		<div class="panel-body">
			<div class="pull-left">
				<a href="/<?=$lang['slug_genres']?>-action.html">Action</a><br>
				<a href="/<?=$lang['slug_genres']?>-18.html">18+</a><br>
				<a href="/<?=$lang['slug_genres']?>-adult.html">Adult </a><br>
				<a href="/<?=$lang['slug_genres']?>-anime.html">Anime</a><br> 
				<a href="/<?=$lang['slug_genres']?>-comedy.html">Comedy</a><br> 
				<a href="/<?=$lang['slug_genres']?>-comic.html">Comic</a><br> 
				<a href="/<?=$lang['slug_genres']?>-doujinshi.html">Doujinshi</a><br> 
				<a href="/<?=$lang['slug_genres']?>-drama.html">Drama</a><br> 
				<a href="/<?=$lang['slug_genres']?>-ecchi.html">Ecchi</a><br> 
				<a href="/<?=$lang['slug_genres']?>-fantasy.html">Fantasy</a><br> 
				<a href="/<?=$lang['slug_genres']?>-gender bender.html">Gender Bender</a><br> 
				<a href="/<?=$lang['slug_genres']?>-harem.html">Harem</a><br>
				<a href="/<?=$lang['slug_genres']?>-historical.html">Historical</a><br>
				<a href="/<?=$lang['slug_genres']?>-horror.html">Horror</a><br>
				<a href="/<?=$lang['slug_genres']?>-josei.html">Josei</a><br>
				<a href="/<?=$lang['slug_genres']?>-live action.html">Live action</a><br>
				<a href="/<?=$lang['slug_genres']?>-manhua.html">Manhua</a><br>
				<a href="/<?=$lang['slug_genres']?>-manhwa.html">Manhwa</a><br>
				<a href="/<?=$lang['slug_genres']?>-martial art.html">Martial Art</a><br>
				<a href="/<?=$lang['slug_genres']?>-mature.html">Mature</a><br>
			</div>
			<div class="pull-right">
				<a href="/<?=$lang['slug_genres']?>-mecha.html">Mecha</a><br>
				<a href="/<?=$lang['slug_genres']?>-mystery.html">Mystery</a><br>
				<a href="/<?=$lang['slug_genres']?>-one shot.html">One shot</a><br>
				<a href="/<?=$lang['slug_genres']?>-psychological.html">Psychological</a><br>
				<a href="/<?=$lang['slug_genres']?>-romance.html">Romance</a><br>
				<a href="/<?=$lang['slug_genres']?>-school life.html">School Life</a><br>
				<a href="/<?=$lang['slug_genres']?>-sci-fi.html">Sci-fi</a><br>
				<a href="/<?=$lang['slug_genres']?>-seinen.html">Seinen</a><br>
				<a href="/<?=$lang['slug_genres']?>-shoujo.html">Shoujo</a><br>
				<a href="/<?=$lang['slug_genres']?>-shoujou ai.html">Shojou Ai</a><br>
				<a href="/<?=$lang['slug_genres']?>-shounen.html">Shounen</a><br>
				<a href="/<?=$lang['slug_genres']?>-shounen ai.html">Shounen Ai</a><br>
				<a href="/<?=$lang['slug_genres']?>-slice of life.html">Slice of Life</a><br> 
				<a href="/<?=$lang['slug_genres']?>-smut.html">Smut</a><br> 
				<a href="/<?=$lang['slug_genres']?>-sports.html">Sports</a><br> 
				<a href="/<?=$lang['slug_genres']?>-supernatural.html">Supernatural</a><br> 
				<a href="/<?=$lang['slug_genres']?>-tragedy.html">Tragedy</a><br>
				<a href="/<?=$lang['slug_genres']?>-adventure.html">Adventure</a><br> 
				<a href="/<?=$lang['slug_genres']?>-yaoi.html">Yaoi</a>
			</div>
		</div>
	</div>
</div>
</div>
<div id="pop_manga"></div>
<script>
	function delete_manga(manga) {
		var xhttp = new XMLHttpRequest();
		xhttp.open("GET", "/app/manga/controllers/cont.deleteManga.php?id=" + manga, true);
		xhttp.send();
		var el = document.getElementById(manga);
		el.parentNode.removeChild(el);
	}
</script>
