      <div class="col-lg-4 col-lg-offset-4">
        <? if(!$user->isLoggedIn()){
            $user->ajaxForm('signin','index.html');
        ?>
       
        <form id="signin_form" class="form-signin" method="POST" action="../controllers/cont.userForm.php?action=login&token=<?=$_SESSION['token']?>">
	      	   
          <h2 class="form-signin-heading">Login</h2>
          
          <div id='signin_output' class='form_output'></div>
          <input type="text" class="form-control" placeholder="Email address" name="email" autofocus>
          <input type="password" class="form-control" placeholder="Password" name="password">

          <label class="checkbox">
          
            <input type="checkbox" value="1" name="isRemember"> Remember
          </label>
          <button id='signin_submit' class="btn btn-lg btn-primary btn-block" type="submit"><i class="glyphicon glyphicon-log-in"></i> Login</button>
          <a href="register.html" class="btn btn-sm btn-success btn-block"><i class="glyphicon glyphicon-user"></i> Register</a>
          <a href="forgot.html" class="btn btn-sm btn-danger btn-block"><i class="glyphicon glyphicon-user"></i> Forgot Password</a>
        </form>
        <? } else {
			//header('Location: /ucp');
			header('Location: /index.php');
		} ?>
      </div>
      