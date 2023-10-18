<?php

include('layouts/header.php');


if (app('login')->isLoggedIn()) {
  redirect('account.php');
}
?>



<!--Register-->
<section class="my-5 py-5">
  <div class="container text-center mt-3 pt-5">
    <h2 class="form-weight-bold">Register</h2>
    <hr class="mx-auto">
  </div>
  <div class="mx-auto container">
    <form id="register-form">
      <div class="form-group">
        <label>Name</label>
        <input type="text" class="form-control" id="register-name" name="name" placeholder="Name" />
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="text" class="form-control" id="register-email" name="email" placeholder="Email" />
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" class="form-control" id="register-password" name="password" placeholder="password" />
      </div>
      <div class="form-group">
        <label>Confirm Password</label>
        <input type="password" class="form-control" id="register-confirm-password" name="confirmPassword" placeholder="confirmPassword" />
      </div>
      <div class="form-group">
        <input type="submit" class="btn" id="register-btn" name="register" value="Register" />
      </div>
      <div class="form-group">
        <a id="login-url" href="login.php" class="btn" href="#">Already Have an Account? Login</a>
      </div>
    </form>
  </div>
</section>




<?php include('layouts/footer.php'); ?>