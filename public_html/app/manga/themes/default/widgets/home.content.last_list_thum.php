<div id="contentstory">
	<div class="page-header">
		<div class="title_doctruyen moicapnhat">
			<div class="bg leftbar3"></div>
			<div class="bg rightbar3"></div>
			<div class="centertext"><?=$lang['last_manga_released']?>
				<a href="/<?=$lang['list_slug']?>.html" class="link_right"><?=$lang['View_all']?> »</a>
			</div>
		</div>
	</div>
	<div class="doreamon">
		<?php

		$thisMangaList100 = $db->Query(APP_TABLES_PREFIX.'manga_mangas', array('id','name','released','slug','last_chapter','last_update','m_status', 'views', 'cover'), array('hidden'=>0), NULL, NULL, array('last_update'=>'DESC'),50);

		foreach ($thisMangaList100 as $row) {
			$time_ago = $huy->ago($row['last_update']);
			$row = $huy->clearXss($huy->stripSlashes($row));
			$cover = preg_replace('#\?imgmax=.*#is', '', $row['cover']);
			$imgmax = '';
			if (preg_match('#blogspot.com#', $cover)) {
				$imgmax = '?imgmax=150';
			}

			?> 
			<div class="itemupdate">
				<a href="<?=$lang['manga_slug']?>-<?=$row['slug']?>.html" class="cover">
					<img class="lazy" alt="<?=$row['name']?>" width="100" height="120" src="<?=$cover.$imgmax?>" onmouseleave="out_show()" onmouseenter="show(<?=$row['id']?>)">
				</a>
				<ul class="group">
					<li>
						<a class="title-h3-link" href="<?=$lang['manga_slug']?>-<?=$row['slug']?>.html">
							<h3 class="title-h3"><?=$row['name']?></h3>
						</a>
					</li>
					<li>
						<a class="chapter" title="<?=$lang['Chapter']?> <?=$row['last_update']?>" href="<?=$lang['read_slug']?>-<?=$row['slug']?>-<?=$lang['chapter_slug']?>-<?=$row['last_chapter']?>.html" target="_blank"><?=$lang['Chapter']?> <?=$row['last_chapter']?></a>
					</li>
					<li>
						<p class="view"><?=$row['views']?> <?=$lang['view']?></p>
					</li>
					<li>
						<time><?=$time_ago?></time>
					</li>
				</ul>
			</span>
		</div>

		<?php
	}
	?>
	<div id="pop_manga"></div>
</div>
<div class="xt">
<a class="xem-them" href="/<?=$lang['list_slug']?>.html">» <?=$lang['View_all_mangas']?> »</a>
</div>
</div>
