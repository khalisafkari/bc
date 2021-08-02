
      <div class="col-lg-4 col-lg-offset-4">
        <? if(!$user->isLoggedIn()){ 
            $user->ajaxForm('register');
        ?>
        <form id="register_form" class="form-signin" method="POST" action="../controllers/cont.userForm.php?action=register&token=<?=$_SESSION['token']?>">
          <h2 class="form-signin-heading"><?=$l['Register']?></h2>
          <div id='register_output' class='form_output'></div>
          <input type="text" class="form-control" placeholder="Email address" name="email" autofocus>
          <input type="password" class="form-control password1" placeholder="Password" name="password">
          <input type="password" class="form-control" placeholder="Re-type Password" name="password2">
          <label for="exampleInputPassword1"><a class="captcha"><img class="captcha" src="/controllers/cont.main.php?type=captcha"></a><a class="chance-captcha"><img width="5%" src="assets/images/chance-load.gif"></a></label>
          <input type="text" class="form-control" placeholder="Enter captcha" name="captcha">
          <label class="checkbox">
            <?=$l['agree_to_term']?>
          </label>
          <button id='register_submit' class="btn btn-lg btn-primary btn-block" type="submit"><i class="glyphicon glyphicon-log-in"></i> <?=$l['btn_register'] ?></button>
          <a href="login.html" class="btn btn-sm btn-success btn-block"><i class="glyphicon glyphicon-log-in"></i> <?=$l['btn_already_has_account']?></a>
          <a href="forgot.html" class="btn btn-sm btn-danger btn-block"><i class="glyphicon glyphicon-user"></i> <?=$l['btn_forgot']?></a>
        </form>
        <? } else {
			header('Location: /ucp'); 
		}
		?>
    <script>
      $(document).ready(function(e) {
        $('a.chance-captcha').click(function(event) {
          $.ajax({
            url: '/controllers/cont.main.php?type=captcha',
            type: 'GET',
            datatype: 'html',
            data: {

            },success: function(data) {
              $('img.captcha').attr('src','/controllers/cont.main.php?type=captcha');
            }
          })
          
        });
      });
    </script>
      </div>