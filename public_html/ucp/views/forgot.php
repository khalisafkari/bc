      <div class="col-lg-4 col-lg-offset-4">
        <? if(!$user->isLoggedIn()){ 
            $user->ajaxForm('forgot','/index.html');
        ?>
        <form id="forgot_form" class="form-signin" method="POST" action="/controllers/cont.userForm.php?action=forgot_password&token=<?=$_SESSION['token']?>">
          <h2 class="form-signin-heading">Enter the email address where you registered your account here. We will send you an email so you can retrieve your password.</h2>
          <div id='forgot_output' class='form_output'></div>
          <input type="text" class="form-control" placeholder="Email address" name="email" autofocus>
          <br />
          <button id='forgot_submit' class="btn btn-lg btn-primary btn-block" type="submit"><i class="glyphicon glyphicon-log-in"></i> Send</button>
		  <a href="login.html" class="btn btn-sm btn-success btn-block"><i class="glyphicon glyphicon-user"></i> Login</a>
          <a href="register.html" class="btn btn-sm btn-danger btn-block"><i class="glyphicon glyphicon-user"></i> Register</a>
        </form>
        <? } ?>
      </div>