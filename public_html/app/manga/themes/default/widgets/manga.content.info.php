<?php
$m_id = $thisManga['id'];

if(!isset($_SESSION['m_'.$m_id])){
	
    // VIEWS BY DAY
	$huy->updateViewsByDay(1, $thisManga[id], 'day', date('z'), date('Y'));
	// VIEWS BY WEEK
	// 
	$huy->updateViewsByDay(2, $thisManga[id], 'week', date('W'), date('Y'));
	// VIEWS BY MONTH
	// 
	$huy->updateViewsByDay(3, $thisManga[id], 'month', date('n'), date('Y'));

	// Update view all
	$huy->updateViews($thisManga['slug']);

	$_SESSION['m_'.$m_id] = 1;

}
	if (!empty($thisManga)) {
		?>
		<div class="row">
			<div class="col-md-4">
				<div class="well info-cover">
					<img class="thumbnail" width="180" height="260" src="<?=$thisManga['cover']?>">
					<h4><?=$lang['Rate']?></h4>
					<div class="h0rating" slug="<?=$thisManga['slug']?>"></div><br />
					<?php
					if ($h0manga->count_rating($thisManga['slug']) > 0) {
						$mes = 'Has a total of '.$h0manga->count_rating($thisManga['slug']).' reviews!';
					} else {
						$mes = 'No reviews yet!';
					}

					?>
					<p class="text-center"><?=$mes?></p>
				</div>
			</div>

			<div class="col-md-8">
				<ul class="manga-info">
					<h1><?=mb_strtoupper($thisManga['name'], 'utf-8')?></h1>
					<li><b><i class="fa fa-book fa-md text-info" aria-hidden="true"></i> <?=$lang['Manga_name']?></b>: <?=mb_strtoupper($thisManga['name'], 'utf-8')?></li>
					<li><b><i class="fa fa-clone fa-md text-primary" aria-hidden="true"></i> <?=$lang['Other_name']?></b>: <?=$thisManga['other_name']?></li>
					<li><b><i class="fa fa-users fa-md text-danger" aria-hidden="true"></i> <?=$lang['Authors']?></b>: <small><?=$h0manga->splitAuthors($thisManga['authors'],$lang['author_slug'])?></small></li>
					<li><b><i class="fa fa-tags fa-md text-primary" aria-hidden="true"></i> <?=$lang['Genres']?></b>: <small><?=$h0manga->splitGenres($thisManga['genres'],$lang)?></small></li>
					<li><b><i class="fa fa-spinner fa-pulse fa-md fa-fw text-info"></i> <?=$lang['Status']?></b>: <?=$h0manga->status($thisManga['m_status'])?></li>
					<li><b><i class="fa fa-user-plus fa-md text-success" aria-hidden="true"></i> <?=$lang['Group']?></b>: <small><?=$h0manga->splitGroups($thisManga['trans_group'],$lang)?></small></li>
					<li><b><i class="fa fa-eye fa-md text-warning" aria-hidden="true"></i> <?=$lang['View']?></b>: <?=$thisManga['views']?></li>
				</ul>
				<br />
				<small>
					<div class="btn-group">
						<?php
						if (!$user->isLoggedIn()) { ?>
							<a data-toggle="modal" href="#register" class="btn btn-danger btn-md" href="#"><i class="fa fa-bookmark" aria-hidden="true"></i> <?=$lang['Bookmark']?></a>
						</div>
						<div class="btn-group">
						<?php } else {
							if ($h0manga->count_bookmark($thisManga['id']) > 0) {
								$mes = ''.$h0manga->count_bookmark($thisManga['id']).' '.$lang['fl'];
							} else {
								$mes = $lang['noti_bookmark'];
							}

							?>
							<a href="#" class="btn btn-primary"><i class="fa fa-bookmark" aria-hidden="true"></i> <?=$mes?></a>
							<?php
						} ?>
					</div>
					<div class="btn-group">
						<a class="btn btn-danger btn-md" href="/<?=$lang['read_slug']?>-<?=$thisManga['slug']?>-<?=$lang['chapter_slug']?>-<?=$thisManga['last_chapter']?>.html"><i class="fa fa-paper-plane" aria-hidden="true"></i>  <?=$lang['Read_the_last_chapter']?></a>
					</div>
				</small>
			</div>
		</div>

		<div class="row">
			<h3><?=$lang['Description']?></h3>
			<p><?=stripslashes($thisManga['description'])?></p>
		</div>

		<?php
	}
?>