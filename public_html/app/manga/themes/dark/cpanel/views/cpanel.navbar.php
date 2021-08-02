<div class="navbar navbar-default">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#nav2">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="#">Hi, <?=$_SESSION['thisUser']['name']?></a>
	</div>
	<div id="nav2" class="navbar-collapse collapse navbar-index">
		<ul class="nav navbar-nav">
			<li class="active"><a href="/"><span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;Home</a></li>
			<li><a href="/ucp">Account</a></li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Manage Manga <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="/manage/notification.html">Notification(s)</a></li>
					<li><a href="/upload-manga.html">Upload Manga</a></li>
					<li><a href="/manage/list-manga.html">Manga uploaded</a></li>
					<li><a href="/manage/manga-bookmark.html">Bookmark</a></li>
					<li><a href="/manage/list-manga-group.html">List Manga Group Uploaded</a></li>
				</ul>
			</li>		  
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li><a onclick="$('#logout_form').submit()"><i class="glyphicon glyphicon-off"></i> Log out</a></li>
			<form method="POST" id="logout_form" action="/controllers/cont.userForm.php?action=logout&amp;token=<?=$_SESSION['token']?>"></form>
			<div id="logout_output" style="display:hidden"></div>
			<?=$user->ajaxForm('logout',$huy->thisPage());?>
		</ul>
	</div><!-- /.nav-collapse -->
</div>