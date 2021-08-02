<div class="navbar navbar-default">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">Hi, <?=$_SESSION['thisUser']['name']?></a>
		</div>
		<div class="navbar-collapse collapse navbar-responsive-collapse navbar-index">
			<ul class="nav navbar-nav">
				<li class="active"><a href="/"><span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;Trang chủ</a></li>
				<li><a href="/ucp">Tài khoản</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Quản lý truyện <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="/quan-ly/thong-bao.html">Thông báo</a></li>
						<li><a href="/dang-truyen.html">Đăng truyện</a></li>
						<li><a href="/quan-ly/danh-sach-truyen.html">Truyện bạn đã đăng</a></li>
						<li><a href="/quan-ly/truyen-theo-doi.html">Truyện bạn đang theo dõi</a></li>
						<li><a href="/quan-ly/danh-sach-truyen-cua-nhom.html">Truyện nhóm bạn đã đăng</a></li>
					</ul>
				</li>		  
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a onclick="$('#logout_form').submit()"><i class="glyphicon glyphicon-off"></i> Thoát</a></li>
				<form method="POST" id="logout_form" action="/controllers/cont.userForm.php?action=logout&amp;token=<?=$_SESSION['token']?>"></form>
				<div id="logout_output" style="display:hidden"></div>
				<?=$user->ajaxForm('logout',$huy->thisPage());?>
			</ul>
		</div><!-- /.nav-collapse -->
	</div><!-- /.container -->
</div>