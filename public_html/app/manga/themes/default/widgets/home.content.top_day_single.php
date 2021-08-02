<div class="topday">
	<div class="title_doctruyen manga">
		<div class="bg left_bar"></div>
		<div class="bg rightbar"></div>
		<div class="centertext">
			<?=$lang['Popular_manga']?>
		</div>
	</div>
	<div class="owl-carousel owl-theme">
		<?php
		$day = date('z');
		$year = date('Y');
		$thisManga = $db->Query(APP_TABLES_PREFIX.'manga_views',array('manga','views'),array('day'=>$day,'year'=>$year),NULL,NULL,array('views'=>'DESC'),20);
		foreach ($thisManga as $manga_views) {
			$thisMangaDay = $db->Query(APP_TABLES_PREFIX.'manga_mangas','*',array('id'=>$manga_views['manga'],'hidden'=>0),NULL,NULL,NULL,20);
			foreach ($thisMangaDay as $manga_views_day) {
				$manga_views_day = $huy->clearXss($huy->stripSlashes($manga_views_day));
				$cover = preg_replace('#\?imgmax=.*#is', '', $manga_views_day['cover']);
				?>
				<div class="item">
					<a class="item-name" href="<?=$lang['manga_slug']?>-<?=$manga_views_day['slug']?>.html">
						<img class="owl-lazy item item-top-day" data-src="<?=$cover?>?imgmax=200">
						<h3><?=$manga_views_day['name']?></h3></a>
						<a class="item-chapter" href="<?=$lang['read_slug']?>-<?=$manga_views_day['slug']?>-<?=$lang['chapter_slug']?>-<?=$manga_views_day['last_chapter']?>.html">Chap <?=$manga_views_day['last_chapter']?></a>	
					</div>
					<?php
				}
			}
			?>
		</div>
	</div>
	<script type="text/javascript">
			// OWl setup top day
			$(document).ready(function() {
				$('.owl-carousel').owlCarousel({
					items : 8,
					scrollPerPage : true ,
					lazyLoad : true,
					autoplay: true,
					nav: true,
					loop: true,
					dots: false,
					navText: ['<b>Prev</b>', '<b>Next<b'],
					autoplayTimeout: 2000,
					autoplayHoverPause: true,
					responsiveClass: true,
					responsive: {
						0: {
							items: 2,
						},
						320: {
							items: 3
						},
						600: {
							items: 5
						},
						1000: {
							items: 8
						},
						1440: {
						    items: 9
						}
					}
				});
			});
		</script>