<?php
 	if(!$user->isAdmin()){ header('Location: ../index.html'); }
	if($_POST && $_POST['token'] == $_SESSION['token']){
		$string = '<?php
			$config[\'siteTitle\'] = "'.$_POST['siteTitle'].'";
			$config[\'locale\'] = "'.$_POST['locale'].'";
			$config[\'timezone\'] = "'.$_POST['timezone'].'";
			$config[\'user_activate\'] = "'.$_POST['user_activate'].'";
			$config[\'default_avatar\'] = "'.$_POST['default_avatar'].'";
			$config[\'default_app\'] = "'.$_POST['default_app'].'"; 
		';
		$fp = fopen(ROOT_DIR."/includes/settings.php", "w");
		fwrite($fp, $string);
		fclose($fp);
		header('Location: configuration.html?ref=1');
	}
?>
 <div class="col-lg-8">
	 <div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title"><?=$l['Configuration']?></h3>
	  </div>
	  <div class="panel-body">
	   	<div id="UserTableContainer" style="width: 100%;">
	   		<form role="form" method="POST" action="configuration.html">
	   		  <input type="hidden" name="token" value="<?=$_SESSION['token']?>">
			  <div class="form-group">
			    <label for="exampleInputEmail1"><?=$l['Site_title']?></label>
			    <input type="text" class="form-control" name="siteTitle" value="<?=$config['siteTitle']?>">
			  </div>
		     <div class="form-group">
		     <label for="exampleInputEmail1"><?=$l['Site_title']?></label>
			  <select class="form-control" name="locale">
				<?=$admin->listLocale();?>	
			  </select>
		     </div>
		     <div class="form-group">
		     <label for="exampleInputEmail1">Timezone (Get the value from <a href="http://php.net/manual/en/timezones.php" target="_blank">this table</a>)</label>
		     <input type="text" class="form-control" name="timezone" value="<?=$config['timezone']?>">
		     </div>
		     <div class="form-group">
		     <label for="exampleInputEmail1"><?=$l['Application']?></label> <?=$l['Default_app_ex']?>
			  <select class="form-control" name="default_app">
				<?=$admin->listAPP($apps);?>	
			  </select>
		     </div>
			 <hr> 
			 <h3>User</h3>
		      <div class="form-group">
		      <label for="exampleInputEmail1"><?=$l['confirm_need']?></label>  <?=$l['confirm_need_ex']?>
			   <select class="form-control" name="user_activate">
				<option value="1" <?=($config['user_activate'] == 1 ? 'selected' : '')?>><?=$l['Yes']?></option>
				<option value="0" <?=($config['user_activate'] == 0 ? 'selected' : '')?>><?=$l['No']?></option>	
			   </select>
		      </div>
			  <div class="form-group">
			    <label for="exampleInputEmail1"><?=$l['default_avatar']?></label> <?=$l['default_avatar_ex']?>
			    <input type="text" class="form-control" name="default_avatar" value="<?=$config['default_avatar']?>">
			  </div>

			  <button type="submit" class="btn btn-default"><?=$l['Submit']?></button>
			</form>

	   	</div>
	  </div>
	</div>
 </div>	