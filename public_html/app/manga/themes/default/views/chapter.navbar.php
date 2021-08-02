<div id="header" class="navbar navbar-inverse navbar-fixed-top navbar-responsive-collapse">
	<div class="container">
		<div class="navbar-header">
			<a href="<?=$lang['manga_slug']?>-<?=$thisManga['slug']?>.html" class="navbar-brand manga-name"><?=$thisManga['name']?></a>
			<button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<div class="navbar-collapse collapse" id="navbar-main">
			<ul class="nav navbar-nav">
				<li class="active"><a href="index.html"><span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;<?=$lang['Back_to_home']?></a></li>
				<? if($c_manga['read_type_choose'] == '1'){ ?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=$lang['Reading_type']?>&nbsp;&nbsp;<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a onclick="$('#type').val('1'); $('#readtype_form').submit()"><i class="glyphicon glyphicon-sort"></i> <?=$lang['Webtoon']?></a></li>
							<li><a onclick="$('#type').val('2'); $('#readtype_form').submit()"><i class="glyphicon glyphicon-transfer"></i> <?=$lang['Page_by_page']?></a></li>
							<li><a onclick="$('#type').val('3'); $('#readtype_form').submit()"><i class="glyphicon glyphicon-transfer"></i> <?=$lang['Page_by_page']?> (Touch support)</a></li>
						</ul>
					</li>
				<? } ?>
			</ul>
			<?=$user->ajaxForm('readtype',$huy->thisPage())?>
			<div id="readtype_output" style="display: none"></div>
			<form action="<?=$huy->thisPage()?>" method="POST" id="readtype_form">
				<input type="hidden" name="token" value="<?=$_SESSION['token']?>">
				<input type="hidden" name="action" value="type">
				<input id="type" type="hidden" name="type" value="">
			</form>
				<ul class="nav navbar-nav navbar-right chapter_select">
					<li>
						<a href class="prev"><span class='glyphicon glyphicon-chevron-left'></span> <?=$lang[Previous_chapter]?></a>
					</li>
					<li>
						<form class="navbar-form">
							<? chapter_select($thisChapter, 1); ?>
						</form>
					</li>
					<li>
						<a href class="next"><?=$lang[Next_chapter]?> <span class='glyphicon glyphicon-chevron-right'></span></a>
					</li>
				</ul>
		</div>
	</div>
</div>