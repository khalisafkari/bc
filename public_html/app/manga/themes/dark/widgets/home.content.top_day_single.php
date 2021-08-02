<div class="col-md-12">
	<div class="card card-dark">
		<div class="card-header">
			<h3 class="card-title">
				<i class="fa fa-fire" aria-hidden="true"></i>  &nbsp; 
				<?=$lang['Popular-manga']?>
			</h3>
		</div>
		<div class="card-body bg-dark">
			<div class="row owl-carousel owl-theme owl-loaded owl-drag">
				<div class="owl-stage-outer">
					<div class="owl-stage">
						<?php
						$day = date('z');
						$year = date('Y');
						$thisManga = $db->Query(APP_TABLES_PREFIX.'manga_views',array('manga'),array('type' => 1,'day'=>$day,'year'=>$year),NULL,NULL,array('views'=>'DESC'),10);
						if (!empty($thisManga)) {
							$listManga = '';
							$listViews = array();
							for ($i=0; $i < count($thisManga); $i++) { 
								$listManga .= $thisManga[$i][manga].',';
							}
							$listManga = trim($listManga, ',');
							$thisMangaDay = $db->Query(APP_TABLES_PREFIX. 'manga_mangas', 'id, name, last_chapter, cover, last_update', 'id IN ('.$listManga.') AND hidden = 0', null, null, null, null);
							foreach ($thisMangaDay as $manga_views_day) {
								$manga_views_day = $huy->clearXss($huy->stripSlashes($manga_views_day));
								$cover = preg_replace('#\?imgmax=.*#is', '', $manga_views_day['cover']);
								?>
								<div class="owl-item" style="width: 225px;">
									<div class="popular-thumb-item col-12">
										<div class="thumb-wrapper" data-id="">
											<a href="/<?=$manga_views_day['id']?>/<?=$h0manga->chapter_id($manga_views_day['id'], $manga_views_day['last_chapter'])?>/">
												<div class="a6-ratio">
													<div class="content img-in-ratio" style='background-image: url("<?=$cover?>");'></div>
												</div>
											</a>
											<div class="thumb-detail">
												<div class="thumb_attr chapter-title text-truncate" title="Chap <?=$manga_views_day['last_chapter']?>">
													<a href="/<?=$manga_views_day['id']?>/<?=$h0manga->chapter_id($manga_views_day['id'], $manga_views_day['last_chapter'])?>/" title="Chap <?=$manga_views_day['last_chapter']?>">Chap <?=$manga_views_day['last_chapter']?></a>
												</div>
											</div>
											<div class="manga-badge">
												<span class="badge badge-info">
													<time class="timeago" title="<?=$huy->ago($manga_views_day['last_update'])?>"><?=$huy->ago($manga_views_day['last_update'])?></time>
												</span>
											</div>
										</div>
										<div class="thumb_attr series-title">
											<a href="/<?=$manga_views_day['id']?>/" title="<?=$manga_views_day['name']?>"><?=$manga_views_day['name']?></a>
										</div>
									</div>
								</div>
								<?php
							}
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
			// OWl setup top day
			$(document).ready(function() {
				$('.owl-carousel').owlCarousel({
					items : 5,
					scrollPerPage : true ,
					lazyLoad : true,
					autoplay: true,
					nav: false,
					loop: true,
					dots: true,
					autoplayTimeout: 2000,
					autoplayHoverPause: true,
					responsiveClass: true,
					responsive: {
						0: {
							items: 2
						},
						768: {
							items: 3
						},
						980: {
							items: 4
						},
						1200: {
							items: 4
						},
						1420: {
							items: 5
						}
					}
				});
			});
		</script>