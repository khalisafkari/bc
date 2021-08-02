<div id="header" class="navbar navbar-inverse navbar-fixed-top navbar-responsive-collapse">
	<div class="container container_header">
		<div class="navbar-header">
		<? 
			if($detech -> isMobile()){
		?>
			<a href="/" class="navbar-brand" style="font-size: 20px"><!--?=$c_manga['site_title']?--><i class="fa fa-home" aria-hidden="true"></i></a>
		<? } else {?>
			<a href="/" class="navbar-brand"><i class="fa fa-home" style="font-size: 20px" aria-hidden="true"></i>&nbsp;<?=$c_manga['site_title']?></a>
		<? }?>
			<a href="/application/" class="navbar-brand" style="font-size: 14px"><i class="glyphicon glyphicon-phone" aria-hidden="true"></i>&nbsp;App</a>
			<button id="rd-info_noti" type="button" class="bsearch" data-target="#navbar-main" aria-expanded="true"><span class="glyphicon glyphicon-search"></button>
			<button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			</div>
			<div class="navbar-collapse collapse" id="navbar-main">
				<ul class="nav navbar-nav">
					<li class="active"><a href="/<?=$lang['list_slug']?>.html"><span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;<?=$lang['Manga_List']?></a></li>
					<li>
						<a href="/manga-list.html?history=1"><i class="fa fa-history" aria-hidden="true"></i> <?=$lang['history']?></a>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" target="_self" href="javascript:void(0);"><i class="fa fa-address-book" aria-hidden="true"></i></i> <?=$lang['List-genre']?> <b class="caret"></b></a>
						<?=$h0manga->listGenre(4)?>
					</li>
					<? if($detech -> isMobile()){
						?>
						
						<? } else {?>
							<li id="rd-info_noti" class="dropdown" aria-expanded="true"><a><i class="glyphicon glyphicon-search"></i> Search</a></li>
					<? }?>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<?php
					if($user->isLoggedIn()){
						include ROOT_DIR.'/app/manga/themes/dark/views/navbar_notification.php';
						?>
						<!--li class="dropdown">
							<a style="padding:10px;" href="#" class="dropdown-toggle" data-toggle="dropdown"><img style="width:30px; height:30px; border-radius:50%;" src="<?='/'.$avtFolder.$_SESSION['thisUser']['avatar']?>"> <?=$_SESSION['thisUser']['name']?> <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="/ucp/index.html"><i class="glyphicon glyphicon-briefcase"></i> User CP</a></li>
								<?=($user->isAdmin() ? '<li><a href="/acp/index.html"><i class="glyphicon glyphicon-tower"></i> Admin CP</a></li>' : '')?>
								<li><a href="/manage.html"><i class="glyphicon glyphicon-th-list"></i> <?=$lang['Cpanel']?></a></li>
								<li><a href="/upload-manga.html"><i class="glyphicon glyphicon-upload"></i> <?=$lang['Submit-manga']?></a></li>
								<li class="divider"></li>
								<li><a onclick="$('#logout_form').submit()"><i class="glyphicon glyphicon-off"></i> <?=$lang['Log_out']?></a></li>
								<form method="POST" id="logout_form" action="/controllers/cont.userForm.php?action=logout&amp;token=<?=$_SESSION['token']?>"></form>
								<div id="logout_output" style="display:hidden"></div>
								<?=$user->ajaxForm('logout',$huy->thisPage());?>
							</ul>
						</li-->
					<? }else{ ?>
						<!--li><a data-toggle="modal" href="#login"><span class="glyphicon glyphicon-log-in"></span>&nbsp;&nbsp;<?=$lang['Login']?></a></li>
						<li class="divider"></li>
						<li><a data-toggle="modal" href="#register"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;<?=$lang['Register']?></a></li-->
					<? } ?>
				</ul>
			</div>
		</div>
	</div>
	<? if(!$user->isLoggedIn()){ ?>
		<div id="login" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
			<div class="modal-dialog">
				<div class="modal-content">

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="myModalLabel"><?=$lang['Login']?></h4>
					</div>
					<div class="modal-body">
						<form id="signin_form" class="form-signin" method="POST" action="/controllers/cont.userForm.php?action=login&token=<?=$_SESSION['token']?>">
							<div id='signin_output' class='form_output'></div>
							<div class="form-group">
								<label for="exampleInputPassword1">Email</label>
								<input type="text" class="form-control" placeholder="Email address" name="email" autofocus>
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">Password</label>
								<input type="password" class="form-control" placeholder="Password" name="password">
							</div>
							<label class="checkbox">
								<input type="checkbox" value="1" name="isRemember"> <?=$l['btn_remember']?>
							</label>
							<button id='signin_submit' class="btn btn-sm btn-primary btn-block" type="submit"><i class="glyphicon glyphicon-log-in"></i> <?=$l['btn_login']?></button>
						</form>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-sm btn-default" data-dismiss="modal"> Close</button>
						<a data-dismiss="modal" data-toggle="modal" href="#register" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-user"></i> <?=$l['btn_register']?></a>
						<a data-dismiss="modal" data-toggle="modal" href="#forgot_password" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-log-in"></i> <?=$l['btn_forgot']?></a>
					</div>

				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div>

		<?=$user->ajaxForm('signin',$huy->thisPage());?>

		<div id="register" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
			<div class="modal-dialog">
				<div class="modal-content">

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="myModalLabel"><?=$lang['Register']?></h4>
					</div>
					<div class="modal-body">
						<form id="register_form" class="form-signin" method="POST" action="/controllers/cont.userForm.php?action=register&token=<?=$_SESSION['token']?>">
							<div id='register_output' class='form_output'></div>
							<div class="form-group">
								<label for="exampleInputPassword1">Email</label>
								<input type="text" class="form-control" placeholder="Email address" name="email" autofocus>
								<label class="checkbox">
									(<?=$l['note_email']?>)
								</label>
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">Password</label>	
								<input type="password" class="form-control password1" placeholder="Password" name="password">
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">Re-type Password</label>	         
								<input type="password" class="form-control" placeholder="Re-type Password" name="password2">
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1"><a class="captcha"><img class="captcha" src="/controllers/cont.main.php?type=captcha"></a><a class="chance-captcha"><img width="5%" src="/app/manga/themes/dark/assets/images/chance-load.gif"></a></label>
								<input type="text" class="form-control" placeholder="Enter captcha" name="captcha">
							</div>
							<label class="checkbox">
								<?=$l['agree_to_term']?>
							</label>
							<button id='register_submit' class="btn btn-primary btn-block" type="submit"><i class="glyphicon glyphicon-log-in"></i> <?=$l['btn_register'] ?></button>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
						<a data-dismiss="modal" data-toggle="modal" href="#login" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-log-in"></i> <?=$l['btn_already_has_account']?></a>
						<a data-dismiss="modal" data-toggle="modal" href="#forgot_password" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-log-in"></i> <?=$l['btn_forgot']?></a>
					</div>

				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div>

		<?=$user->ajaxForm('register',$huy->thisPage());?>


		<div id="forgot_password" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
			<div class="modal-dialog">
				<div class="modal-content">

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="myModalLabel"><?=$lang['forgot']?></h4>
					</div>
					<div class="modal-body">
						<form id="forgot_password_form" class="form-signin" method="POST" action="/controllers/cont.userForm.php?action=forgot_password&token=<?=$_SESSION['token']?>">
							<div id='forgot_password_output' class='form_output'></div>
							<label class="checkbox">
								<?=$l['tut_forgot_password']?>
							</label>
							<div class="form-group">
								<label for="exampleInputPassword1">Email</label>
								<input type="text" class="form-control" placeholder="Email address" name="email" autofocus>
							</div>
							<button id='forgot_submit' class="btn btn-sm btn-primary btn-block" type="submit"><i class="glyphicon glyphicon-log-in"></i> <?=$l['send']?></button>
						</form>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-sm btn-default" data-dismiss="modal"> Close</button>
						<a data-dismiss="modal" data-toggle="modal" href="#register" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-user"></i> <?=$l['btn_register']?></a>
						<a data-dismiss="modal" data-toggle="modal" href="#login" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-log-in"></i> <?=$l['btn_already_has_account']?></a>
					</div>

				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div>

		<?=$user->ajaxForm('forgot_password',$huy->thisPage());?>

		<? } ?>
