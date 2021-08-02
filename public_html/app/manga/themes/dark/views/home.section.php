<section id="rd-side_icon">
    <a id="rd-info_blue" data-affect="#rd_sidebar.blues" class="rd_sd-button_item rd_top-left prev">
        <i class="fa fa-history" aria-hidden="true"></i>
    </a>
    <a class="rd_sd-button_item" href="/">
        <i class="fa fa-home" aria-hidden="true"></i>
    </a>
    <a id="rd-info_icon" data-affect="#rd_sidebar.chapters" class="rd_sd-button_item">
        <i class="fa fa-users" aria-hidden="true"></i>
    </a>
    <a id="rd-info_noti" data-affect="#rd_sidebar.notis" class="rd_sd-button_item rd_top-right next">
        <i class="glyphicon glyphicon-search" aria-hidden="true"></i>
    </a>
</section>

<section id="blues" class="rd_sidebar" style="display: none">
    <main class="rdtoggle_body">
		<?php
		$data = json_decode($_COOKIE['history'], true);
		?>
            <?php
		if ($_COOKIE['history']) {
		  $i = 1;
		  foreach ($data as $manga => $chapter) {
			$thisMangaSelection = $db->Query(APP_TABLES_PREFIX.'manga_mangas', 'id, name, cover', array('id'=>$manga), null, null, null, null);
			$thisChapter = $db->Query(APP_TABLES_PREFIX. 'manga_chapters', 'chapter', array('id'=>$chapter), null, null, null, null);
			?>
				<div class="rd_sidebar-header clear">
					<a class="img" href="/<?=$thisMangaSelection[0]['id']?>/" style="background: url('<?=$thisMangaSelection[0]['cover']?>') no-repeat"></a>
					<div class="thumb_attr series-title">
						<a class="rd_sidebar-name"></a>
						<h5>
							<a href="/<?=$thisMangaSelection[0]['id']?>/"><?=str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($thisMangaSelection[0]['name']))))?></a>
						</h5>
					</div>
				</div>
			  <?php
			  $i++;
			  if ($i > 10) {
				break;
			  }
			}
		  }
		  ?>
		<ul class="xt nav navbar-inverse" style="background-color: #5c2040"><a href="/manga-list.html?history=1"><span style="color: white"> » View All » </a></span></ul>
	</main>
<div class="blue-click" style="display:none"></div>
</section>

<section id="chapters" class="rd_sidebar" style="display: none">
    <main class="rdtoggle_body">
					<?php
					if($user->isLoggedIn()){
						?>
						<ul class="nav navbar-inverse">
						<li class="dropdown navbar-right">
							<a style="padding:10px;" href="#" class="dropdown-toggle" data-toggle="dropdown"><span style="color: white"> <?=$_SESSION['thisUser']['name']?> </span><img style="width:30px; height:30px; border-radius:50%;" src="<?='/'.$avtFolder.$_SESSION['thisUser']['avatar']?>"> </a>
						</li>
						</ul>
							<ul id="chap_list">
								<li><a href="/ucp/index.html"><i class="glyphicon glyphicon-briefcase"></i> User CP</a></li>
								<?=($user->isAdmin() || $user->isMod() ? '<li><a href="/acp/index.html"><i class="glyphicon glyphicon-tower"></i> Admin CP</a></li>' : '')?>
								<li><a href="/manage.html"><i class="glyphicon glyphicon-th-list"></i> <?=$lang['Cpanel']?></a></li>
								<li><a href="/upload-manga.html"><i class="glyphicon glyphicon-upload"></i> Upload Manga</a></li>
								<li class="divider"></li>
								<li><a onclick="$('#logout_form').submit()"><i class="glyphicon glyphicon-off"></i> <?=$lang['Log_out']?></a></li>
								<form method="POST" id="logout_form" action="/controllers/cont.userForm.php?action=logout&amp;token=<?=$_SESSION['token']?>"></form>
								<div id="logout_output" style="display:hidden"></div>
								<?=$user->ajaxForm('logout',$huy->thisPage());?>
							</ul>
					<? }else{ ?>
						<ul id="chap_list">
						<li><a data-toggle="modal" href="#login"><span class="glyphicon glyphicon-log-in"></span>&nbsp;&nbsp;<?=$lang['Login']?></a></li>
						<li class="divider"></li>
						<li><a data-toggle="modal" href="#register"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;<?=$lang['Register']?></a></li>
						</ul>
					<? } ?>
	</main>
	<div class="black-click" style="display:none"></div>
</section>

<section id="notis" class="rd_sidebar" style="display: none">
    <main class="rdtoggle_body">
			<form class="navbar-right" role="search" action="/manga-list.html">
				<button type="submit" class="btn-search"><i class="glyphicon glyphicon-search" aria-hidden="true"></i></button>
				<input type="text" id="search" rows="8" name="name" class="form-control" placeholder="Search...">
			</form>
	</main>
<div class="white-click" style="display:none"></div>
</section>

<div class="btn-back-to-top">
    <i class="fa fa-angle-double-up"></i>
</div>