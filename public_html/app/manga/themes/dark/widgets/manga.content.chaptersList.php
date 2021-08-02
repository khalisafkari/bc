<div class="card card-dark">
	<div class="card-header">
		<h3 class="card-title"><?=$lang['Chapters']?></h3>
	</div>
	<div class="card-body bg-dark">
		<ul class="list-chapters at-series">
			<?php
			if (!$huy->checkFile('chapter/chapterList-'.$thisManga['id'])) {
				$result = $db->Query(APP_TABLES_PREFIX.'manga_chapters', array('id', 'chapter', 'name', 'mid', 'manga', 'views', 'last_update'), array('manga'=>$thisManga['slug'], 'hidden'=>0), null, null, 'chapter DESC', null);
				$data = serialize($result);
				$huy->cacheSqlEnd('chapter/chapterList-'.$thisManga['id'], $data);
			} else {
				$result = unserialize($huy->cacheSqlEnd('chapter/chapterList-'.$thisManga['id']));
			}
			foreach ($result as $row) {
				$row = $huy->clearXss($huy->stripSlashes($row));
				?>
				<a href="/<?=$thisManga['id']?>/<?=$row['id']?>/" target="_blank" title="Chapter <?=stripslashes($row['chapter'])?>">
					<li>
						<div class="chapter-name text-truncate">Chapter <?=stripslashes($row['chapter'])?></div>
						<div class="chapter-time"><?=$huy->ago($row['last_update'])?></div>
					</li>
				</a>
				<?php } ?>		
			</ul>
		</div>
	</div>
