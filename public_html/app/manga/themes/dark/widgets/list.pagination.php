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

<div class="btn-group btn-block">
	<button class="btn btn-sm btn-info" disabled> <?=$lang['STYLE-LIST']?></button>
	<!--a href="manga-list.html?listType=allABC" class="btn btn-sm btn-info <?php echo $listType == 'allABC' ? 'active' : ''; ?>"><i class="glyphicon glyphicon-th"></i> <?=$lang['ALL-IN-ONE-PAGE']?></a>
	<a href="manga-list.html?listType=pagination" class="btn btn-sm btn-info <?php echo $listType == 'pagination' ? 'active' : ''; ?>"><i class="glyphicon glyphicon-th-list"></i> <?=$lang['PAGINATION']?></a-->
	<a href="/search" class="btn btn-sm btn-success pull-right"><i class="glyphicon glyphicon-filter"></i> <?=$lang['Search_advenced']?></a>
</div>
<?php
$limit = 20; // EDIT THIS FIELD FOR MANGA SHOW PER PAGE

function print_url($page,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type){
	if ($_GET['history']) {
		return "manga-list.html?listType=pagination&page=$page&artist=$artist&author=$author&group=$group&m_status=$m_status&name=$name&genre=$genre&ungenre=$ungenre&magazine=$magazine&sort=$sort&sort_type=$sort_type&history=1";
	} else {
		return "manga-list.html?listType=pagination&page=$page&artist=$artist&author=$author&group=$group&m_status=$m_status&name=$name&genre=$genre&ungenre=$ungenre&magazine=$magazine&sort=$sort&sort_type=$sort_type";
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

$magazine = str_replace(array('\'', '"'), '', urldecode($_GET['magazine']));

if ($magazine) {
	$magazines = explode(',', $magazine);
	foreach ($magazines as $m) {
		$text_magazine .= " AND magazines LIKE '".$m."' "; 
	}
}

$WHERE = NULL;

$m = isset($text_magazine) ? $text_magazine : NULL ;
$WHERE .=  isset($m) ? $m : NULL;

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
$WHERE .=  isset($name) ? "AND (name LIKE '%".$name."%' OR other_name LIKE '%".$name."%' OR authors LIKE '%".$name."%')" : NULL; 
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

	@$query = "SELECT id,name,slug,cover,last_chapter,views,genres,magazines,last_update FROM ".APP_TABLES_PREFIX."manga_mangas WHERE hidden = '0' $WHERE $sort_query LIMIT $start, $limit";
	$thisQuery = @mysqli_query($db->Connect(),$query);
}


?>
<hr>
<div class="col-md-8 block">

	<div class="btn-group">
		<button class="btn btn-sm btn-info" disabled>Page <?php echo $page;?> of <?php echo $lastpage;?></button>
		<a href="<?php echo print_url($prev,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type); ?>" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-chevron-left"></i></a>
		<a href="<?php echo print_url($next,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type); ?>" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-chevron-right"></i></a>
	</div>
	<div class="btn-group asc">
		<a href="<?php echo print_url($page,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,'ASC'); ?>" class="btn btn-sm btn-info <?php echo $sort_type == 'ASC' ? 'active' : ''; ?>"><i class="glyphicon glyphicon-sort-by-attributes"></i> ASC</a>
		<a href="<?php echo print_url($page,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,'DESC'); ?>" class="btn btn-sm btn-info <?php echo $sort_type == 'DESC' ? 'active' : ''; ?>"><i class="glyphicon glyphicon-sort-by-attributes-alt"></i> DESC</a>
	</div>
	<div class="btn-group soft-by">
		<button class="btn btn-sm btn-info" disabled><?=$lang['sort-by']?></button>
		<a href="<?php echo print_url($page,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,'name',$sort_type); ?>" class="btn btn-sm btn-info <?php echo $sort == 'name' ? 'active' : ''; ?>"><i class="glyphicon glyphicon-sort-by-alphabet"></i> A-Z</a>
		<a href="<?php echo print_url($page,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,'views',$sort_type); ?>" class="btn btn-sm btn-info <?php echo $sort == 'views' ? 'active' : ''; ?>"><i class="glyphicon glyphicon-eye-open"></i> <?=$lang['most-view']?></a>
		<a href="<?php echo print_url($page,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,'last_update',$sort_type); ?>" class="btn btn-sm btn-info <?php echo $sort == 'last_update' ? 'active' : ''; ?>"><i class="glyphicon glyphicon-calendar"></i> <?=$lang['Last_update']?></a>
	</div>
</div>
<div class="row">
	<div class="col-md-8">
		<div class="clear-fix"><br /></div>

		<div class="card card-dark">
			<div class="card-header d-flex p-0">
				<h3 class="card-title p-3"><?=$lang['List_manga']?></h3>
				<?php if ($_GET['history']) {
					echo '<button type="button" class="btn btn-danger btn-xs pull-right" onclick="delete_all()">Delete all</button>';
				} ?>
			</div>
			<div class="card-body bg-dark">
				<div class="row-last-update" id="history">

					<?php
					if ($_GET['history']) {
						if ($data) {
							foreach ($data as $manga => $chapter) {
								$thisManga = $db->Query(APP_TABLES_PREFIX.'manga_mangas', 'name, slug, cover, views, genres, magazines', array('id'=>$manga), null, null, null, null);
								$thisManga = $thisManga[0];
								$cover = preg_replace('#\?imgmax=.*#is', '', $thisManga['cover']);
								$thisChapter = $db->Query(APP_TABLES_PREFIX.'manga_chapters', 'chapter', array('id'=>$chapter), null, null, null, null);
								$thisChapter = $thisChapter['0'];
								?>
								<div class="thumb-item-flow col-6 col-md-2" id="<?=$manga?>">
									<div class="thumb-wrapper">
										<a href="/<?=$manga?>/<?=$chapter?>/" title="<?=$thisManga['name']?>">
											<div class="a6-ratio">
												<div
												class="content img-in-ratio"
												style="
												background-image: url('<?=$cover?>?imgmax=100');
												background-position: initial;
												background-size: cover !important;
												background-repeat: initial;
												background-attachment: initial;
												background-origin: initial;
												background-clip: initial;
												background-color: initial;
												"
												></div>
											</div>
										</a>
										<div class="thumb-detail">
											<div class="thumb_attr chapter-title text-truncate btn btn-xs btn-warning" style="background-color: #5c2040; border-color: #5c2040; width: 100%; font-size: 14px" title="<?=$thisManga['name']?>">
												<a href="/<?=$manga?>/<?=$chapter?>/" title="<?=$lang['Continue-reading']?>: <?=$thisChapter['chapter']?>"><i class="fa fa-angle-double-right"></i> <i><?=$lang['Continue-reading']?> <?=$thisChapter['chapter']?></i></a>
											</div>
										</div>
										<div class="action-wrapper">
											<button onclick="delete_manga(<?=$manga?>)" class="btn btn-xs btn-danger"><i class="fa fa-times mr-1"></i><?=$lang['Delete']?></button>
										</div>
									</div>
									<div class="thumb_attr series-title"><a href="/<?=$manga?>/" title="<?=str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($thisManga['name']))))?>"><?=str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($thisManga['name']))))?></a></div>
								</div>

								<?php
							}
						}
						
					} else {
						while($thisManga = @mysqli_fetch_assoc($thisQuery)){
							$thisManga = $huy->clearXss($huy->stripSlashes($thisManga));
							$cover = preg_replace('#\?imgmax=.*#is', '', $thisManga['cover']);
							?>
							<div class="thumb-item-flow col-6 col-md-3">
								<div class="thumb-wrapper" data-id="<?=$thisManga['id']?>" data-is-loaded="0">
									<?php if($thisManga['last_chapter'] !== ''){ ?><a href="/<?=$thisManga['id']?>/<?=$h0manga->chapter_id($thisManga['id'], $thisManga['last_chapter'])?>/"><?php } ?>
										<div class="a6-ratio">
											<div class="content img-in-ratio lazyloaded" data-bg="<?=$cover?>" style="background-image: url('<?=$cover?>')"  onmouseleave="out_show()" onmouseenter="show(<?=$thisManga['id']?>)"></div>
										</div>
									</a>
									<div class="thumb-detail">
										<div class="thumb_attr chapter-title text-truncate btn btn-xs btn-warning" style="background-color: #5c2040; border-color: #5c2040; width: 100%; font-size: 14px" title="Chap <?=$thisManga['last_chapter']?>">
											<?php if($thisManga['last_chapter'] !== ''){ ?><a href="/<?=$thisManga['id']?>/<?=$h0manga->chapter_id($thisManga['id'], $thisManga['last_chapter'])?>/"><?=$lang['Last_chapter']?>: <?=$thisManga['last_chapter']?></a><?php } ?>
										</div>
									</div>
									<div class="manga-badge">
										<span class="badge badge-info">
											<time class="timeago" title="<?=$huy->ago($thisManga['last_update'])?>"><?=$huy->ago($thisManga['last_update'])?></time>
										</span>
									</div>
								</div>
								<div class="thumb_attr series-title">
									<a href="/<?=$thisManga['id']?>/" title="<?=str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($thisManga['name']))))?>"><?=str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($thisManga['name']))))?></a>
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
						$list_pagination .= '<li><a href="'.print_url($prev,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">&laquo;</a></li>';
					} else {
						$list_pagination .= '<li><a class="disabled">&laquo;</a></li>';
					}
					if ($page == 1) {
						$list_pagination .= '<li><a class="active">1</a></li>';
					} else {
						$list_pagination .= '<li><a href="'.print_url(1,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">1</a></li>';
					}
					if ($page == 1) {
						$list_pagination .= '<li><a href="'.print_url(($page+1),$name,$author,$group,$m_status,$artist,$genre,$magazine,$ungenre,$sort,$sort_type).'">'.($page+1).'</a></li><li><a href="'.print_url(($page+2),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">'.($page+2).'</a></li><li><a class="disabled">...</a></li><li>';
					} else if ($page == 2) {
						$list_pagination .= '<li><a class="active" href="'.print_url($page,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">'.$page.'</a></li><li><a href="'.print_url(($page+1),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">'.($page+1).'</a></li><li><a href="'.print_url(($page+2),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">'.($page+2).'</a></li><li><a class="disabled">...</a></li>';
					} elseif($page == 3) {
						$list_pagination .= '<li><a href="'.print_url(($page-1),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">'.($page-1).'</a></li><li><a class="active" href="'.print_url($page,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">'.$page.'</a></li><li><a href="'.print_url(($page+1),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">'.($page+1).'</a></li><li><a href="'.print_url(($page+2),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">'.($page+2).'</a></li><li><a class="disabled">...</a></li>';
					} elseif($page == 4) {
						$list_pagination .= '<li><a href="'.print_url(($page-2),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">'.($page-2).'</a></li><li><a href="'.print_url(($page-1),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">'.($page-1).'</a></li><li><a class="active" href="'.print_url($page,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">'.$page.'</a></li><li><a href="'.print_url(($page+1),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">'.($page+1).'</a></li><li><a href="'.print_url(($page+2),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">'.($page+2).'</a></li><li><a class="disabled">...</a></li>';
					} elseif ($page > 4 && $page <= ($lastpage-4)) {
						$list_pagination .= '<li><a class="disabled">...</a></li><li><a href="'.print_url(($page-2),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">'.($page-2).'</a></li><li><a href="'.print_url(($page-1),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">'.($page-1).'</a></li><li><a class="active" href="'.print_url($page,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">'.$page.'</a></li><li><a href="'.print_url(($page+1),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">'.($page+1).'</a></li><li><a href="'.print_url(($page+2),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">'.($page+2).'</a></li><li><a class="disabled">...</a></li>';
					} else if($page == ($lastpage-3)) {
						$list_pagination .= '<li><a class="disabled">...</a></li><li><a href="'.print_url(($page-2),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">'.($page-2).'</a></li><li><a href="'.print_url(($page-1),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">'.($page-1).'</a></li><li><a class="active" href="'.print_url($page,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">'.$page.'</a></li><li><a href="'.print_url(($page+1),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">'.($page+1).'</a></li><li><a href="'.print_url(($page+2),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">'.($page+2).'</a></li>';
					}elseif($page == ($lastpage-2)) {
						$list_pagination .= '<li><a class="disabled">...</a></li><li><a href="'.print_url(($page-2),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">'.($page-2).'</a></li><li><a href="'.print_url(($page-1),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">'.($page-1).'</a></li><li><a class="active" href="'.print_url($page,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">'.$page.'</a></li><li><a href="'.print_url(($page+1),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">'.($page+1).'</a></li>';
					} elseif($page == ($lastpage-1)) {
						$list_pagination .= '<li><a class="disabled">...</a></li><li><a href="'.print_url(($page-2),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">'.($page-2).'</a></li><li><a href="'.print_url(($page-1),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">'.($page-1).'</a></li><li><a class="active" href="'.print_url($page,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">'.$page.'</a></li>';
					} elseif($page = $lastpage) {
						$list_pagination .= '<li><a class="disabled">...</a></li><li><a href="'.print_url(($page-2),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">'.($page-2).'</a></li><li><a href="'.print_url(($page-1),$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">'.($page-1).'</a></li>';
					}
					if ($page == $lastpage) {
						$list_pagination .= '<li><a class="active">'.$lastpage.'</a></li>';
					} else {
						$list_pagination .= '<li><a href="'.print_url($lastpage,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">'.$lastpage.'</a></li>';
					}
					if ($page < $lastpage) {
						$list_pagination .= '<li><a href="'.print_url($next,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">&raquo;</a></li>';
					} else {
						$list_pagination .= '<li><a class="disabled">&raquo;</a></li>';
					}
				} else {
					for ($i=1;$i<=$lastpage;$i++) {
						if ($page == $i) {
							$list_pagination .= '<li><a class="active" href="'.print_url($page,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">'.$page.'</a></li>';
						} else {
							$list_pagination .= '<li><a href="'.print_url($i,$name,$author,$group,$m_status,$artist,$genre,$ungenre,$magazine,$sort,$sort_type).'">'.$i.'</a></li>';
						}
					}
				}
				?>
				<div class="pagination-wrap">
					<ul class="pagination pagination-v4">
						<?=$list_pagination?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div id="pop_manga"></div>
	<div class="col-md-4">
		<div class="clear-fix"><br></div>
		<?php include 'list.listGenre.php' ?>
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
	function delete_all() {
		var element = document.getElementById('history');
		element.remove();
		document.cookie = "history=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
	}
</script>
