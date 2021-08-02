
<div class="card card-dark">
	<div class="card-header">
		<h3 class="card-title">
			<i class="fa fa-newspaper-o" aria-hidden="true"></i>  &nbsp; 
			<?=$lang['New-manga-update']?>
		</h3>
	</div>
	<div class="card-body bg-dark">
		<div class="row-last-update">
			<?php

			$thisMangaList27 = $db->Query(APP_TABLES_PREFIX.'manga_mangas', array('id','name','last_chapter','last_update', 'views', 'cover'), array('hidden'=>0), NULL, NULL, array('last_update'=>'DESC'),27);

			foreach ($thisMangaList27 as $row) {
				$time_ago = $huy->ago($row['last_update']);
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
			<div class="thumb-item-flow col-6 col-md-3 see-more">
				<div class="thumb-wrapper">
					<div class="a6-ratio">
						<div class="content img-in-ratio" style="background-image: url('app/manga/themes/dark/assets/images/no-cover.png');"></div>
					</div>
					<a href="/<?=$lang['list_slug']?>.html?sort=last_update">
						<div class="thumb-see-more">
							<div class="see-more-inside">
								<div class="see-more-content">
									<div class="see-more-icon">
										<i class="fa fa-arrow-right" aria-hidden="true"></i>
									</div>
									<div class="see-more-text"><?=$lang['See-more']?></div>
								</div>
							</div>
						</div>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="pop_manga"></div>