    

    <? if(!($user->isAdmin() || $user->isMod())){ header('Location: login.html'); } ?>
       <div class="panel-group col-lg-4 col-lg-offset-4" id="accordion">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                  <img class='avatar thumbnail' src="<?='../'.$avtFolder.$_SESSION['thisUser']['avatar']?>"> <span class="name"><?=$l['Hi']?>, <strong><?=$_SESSION['thisUser']['name']?></strong></span>
                  <span style="padding-left: 95px;">Information</span></a>
              </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in">
              <div class="panel-body">
                <h4><?=$l['Basic_info']?></h4>
                <strong><?=$l['Your_name']?></strong>: <?=$_SESSION['thisUser']['name']?> <br />
                <strong><?=$l['Your_ID']?></strong>: <?=$_SESSION['thisUser']['id']?> <br />
                <strong><?=$l['Register_email']?></strong>: <?=$_SESSION['thisUser']['email']?> <br />
                <strong><?=$l['Register_date']?></strong>: <?=date("d/m/y", strtotime($_SESSION['thisUser']['register_date']))?> <br />

              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                <i class="glyphicon glyphicon-pencil"></i>  <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><?=$l['Update_info']?></a>
              </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse">
              <div class="panel-body">
                <div id="update_info_output"></div>
                <form id="update_info_form" class="form-signin" method="POST" action="../controllers/cont.userForm.php?action=update_info&token=<?=$_SESSION['token']?>">
                  <div id='signin_output' class='form_output'></div>
                  <input type="text" class="form-control" value="<?=$_SESSION['thisUser']['email']?>" disabled>
                  <input data-toggle="tooltip" data-placement="left" title="" data-original-title="<?=$l['Your_name']?>" type="text" class="form-control middle" placeholder="<?=$l['Your_name']?>" value="<?=$_SESSION['thisUser']['name']?>" name="name">
                  <input data-toggle="tooltip" data-placement="left" title="" data-original-title="<?=$l['Pw_change_tooltip']?>" type="password" class="form-control" placeholder="New Password" name="password">
                  <input type="hidden" name="old_name" class="form-control" value="<?=$_SESSION['thisUser']['name']?>">
                  <button id='signin_submit' class="btn btn-lg btn-primary btn-block" type="submit"><i class="glyphicon glyphicon-check"></i> <?=$l['Submit']?></button>
                </form> 
                <? $user->ajaxForm('update_info','index.html'); ?>
              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                <i class="glyphicon glyphicon-picture"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree"><?=$l['Change_avatar']?></a>
              </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse">
              <div class="panel-body">
                <div id="change_avatar_output"></div>
                <form id="change_avatar_form" action="../controllers/cont.changeAvatar.php?token=<?=$_SESSION['token']?>" method="post" enctype="multipart/form-data">
                    <p><input name="ImageFile" type="file" /></p>
                    <input type="submit" class="btn btn-primary" id="SubmitButton" value="<?=$l['Submit']?>" />
                </form> 
                <? $user->ajaxForm('change_avatar','index.html'); ?>
              </div>
            </div>
          </div>
        </div>
        <div class="clear"></div>
        <div class="col-lg-4 col-lg-offset-4">
          <?php if($user->isAdmin()){ echo '<a href="../acp/index.html" class="btn btn-sm btn-primary btn-block"><i class="glyphicon glyphicon-briefcase"></i> ADMIN CP</a><br />'; } ?>
          <a href="/manage.html" class="btn btn-sm btn-default btn-block"><i class="glyphicon glyphicon-th-list"></i> Manage Manga</a><br />
          <a href="/index.php" class="btn btn-sm btn-success btn-block"><i class="glyphicon glyphicon-briefcase"></i> Home</a><br />
          
          <form method="POST" id="logout_form" action="../controllers/cont.userForm.php?action=logout&token=<?=$_SESSION['token']?>">
            <div id="logout_output"></div>
			<button type="SUBMIT" class="btn btn-sm btn-danger btn-block"><i class="glyphicon glyphicon-off"></i> <?=$l['btn_logout']?></button>
          </form>  
          <?=$user->ajaxForm('logout','index.html')?>
        </div>