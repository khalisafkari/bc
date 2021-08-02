    

    <? if(!($user->isAdmin() || $user->isMod())){ header('Location: ../index.html'); } ?>
    <div class="col-lg-4">
      <div class="list-group">
        <a href="index.html" class="list-group-item active">
          <h4 class="list-group-item-heading"><i class="glyphicon glyphicon-briefcase"></i> <?=$l['FW_INFORMATION']?></h4>
          <p class="list-group-item-text">
            <strong><?=$l['FW_NAME']?></strong>:  <?=$fw['name']?> <br />
            <strong><?=$l['FW_VERSION']?></strong>:  <?=$fw['version']?> <br />
            <strong><?=$l['FW_HOMEPAGE']?></strong>:  <?=$fw['Homepage']?> <br />
            <strong><?=$l['The_time']?></strong>: <span id="tickticktick"></span> <br />
          </p>
        </a>
        <?=($user->isAdmin() ? '
        <a href="user_management.html" class="list-group-item">
          <h4 class="list-group-item-heading"><i class="glyphicon glyphicon-user"></i> '.$l["User_Management"].'</h4>
          <p class="list-group-item-text">'.$l["User_Management_ex"].'</p>
        </a>
        <a href="configuration.html" class="list-group-item">
          <h4 class="list-group-item-heading"><i class="glyphicon glyphicon-cog"></i> '.$l['Configuration'].'</h4>
          <p class="list-group-item-text">'.$l['Configuration_ex'].'</p>
        </a>
		' : '')?>
      </div>

      <?php 
        foreach($apps as $key => $value){
          include ROOT_DIR.'/app/'.$value.'/acp/views/sidebar.php';
        }
      ?>
    </div>  