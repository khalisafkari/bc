<!-- After images -->
<!-- Modal báo lỗi -->

<div id="report_error" class="headroom chapter-content">
	<a title="Báo lỗi - Góp ý" class="btn btn-primary btn_report" id="btn_report" data-toggle="modal" href='#modal_baoloi'><i class="glyphicon glyphicon-info-sign"></i> Report</a>
</div>
<div class="modal fade" id="modal_baoloi" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Report To Admin</h4>
			</div>
			<div class="modal-body">
				<form method="POST" role="form">
					<textarea name="content" id="content" class="form-control counted" rows="5" id="" placeholder="Please describe the error you encountered such as: The photo is dead, or the chapter lacks photos ..."></textarea>
					<h6 class="pull-right" id="counter">(250 characters left)</h6>
					<input type="hidden" name="manga" id="manga" value=<?=$thisManga['id']?>>
					<input type="hidden" name="chapter" id="chapter" value=<?=$thisChapter['id']?>>

				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary btn-report">Report</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<!-- Seo chapter -->
<div class="container">
	<div class="chapter-content-top">
		<ol itemscope="" itemtype="http://schema.org/BreadcrumbList" class="breadcrumb"> 
			<li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a itemscope="" itemtype="http://schema.org/Thing" itemprop="item" href="<?=DOMAIN?>/" title="Trang chủ Đọc truyện tranh từ A đến Z"><span itemprop="name"><?=$lang['Home']?></span></a>
				<meta itemprop="position" content="1"></li> 
				<li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a itemscope="" itemtype="http://schema.org/Thing" itemprop="item" href="<?=DOMAIN?>/danh-sach-truyen.html" title="Danh Sách truyện từ A-Z"><span itemprop="name"><?=$lang['List_manga']?></span></a>
					<meta itemprop="position" content="2"></li> 
					<li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a itemscope="" itemtype="http://schema.org/Thing" itemprop="item" href="<?=DOMAIN?>/<?=$lang['manga_slug']?>-<?=$thisManga['slug']?>.html" title="<?=$thisManga['name']?>"><span itemprop="name"><?=$thisManga['name']?></span>
						<img itemprop="image" src="<?=$thisManga['cover']?>" alt="<?=$thisManga['name']?>" class="hide">
					</a>
					<meta itemprop="position" content="3"></li>
					<li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a itemscope="" itemtype="http://schema.org/Thing" itemprop="item" href="<?=DOMAIN?>/<?=$lang['read_slug']?>-<?=$thisManga['slug']?>-<?=$lang['chapter_slug']?>-<?=$thisChapter['chapter']?>.html" title="<?=$thisManga['name']?> chap <?=$thisChapter['chapter']?>"><span itemprop="name">Chap <?=$thisChapter['chapter']?></span>
						<img itemprop="image" src="<?=$thisManga['cover']?>" alt="<?=$thisManga['name']?> Chap <?=$thisChapter['chapter']?>" class="hide">
					</a>
					<meta itemprop="position" content="4"></li>
				</ol>
			</div>
		</div>
		<div class="mrb10">
			<b>If you can't see the manga, please change another photo server. If you can't see it, please report it to us! Thank you.</b>
			<div class="mrt10">
				<a rel="nofollow" href="javascript:void(0)" data-server="1" class="loadchapter btn btn-success mrb5">Server 1</a>
				<a rel="nofollow" href="javascript:void(0)" data-server="2" class="loadchapter btn btn-primary mrb5">Server 2</a>
				<a rel="nofollow" href="javascript:void(0)" data-server="3" class="loadchapter btn btn-primary mrb5">Server 3</a>
			</div>
		</div>