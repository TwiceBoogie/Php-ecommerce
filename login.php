<?php
include 'backend/Global.php';

if (app('login')->isLoggedIn()) {
  redirect('account');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />

  <link rel="stylesheet" href="assets/css/style.css" />

</head>

<body>
  <!--
        Change Nav element names
    -->
  <!--NavBar-->
  <nav class="navbar navbar-expand-lg bg-white py-3 fixed-top">
    <div class="container">
      <!--Change Later if we want-->
      <a href="/"><img class="logo" src="assets/imgs/logo.jpg"></a>
      <!--<h2 class="brand">Evolve Tech</h2>-->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse nav-buttons" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="/">Home</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="shop">Shop</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contact">Contact Us</a>
          </li>
          <li class="nav-item">
            <a href="cart"><i class="fas fa-shopping-bag"></i></a>
            <a href="account"><i class="fas fa-user"></i></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>









  <!--Login-->
  <div class="container-fluid">
    <section class="my-5 py-5">
      <div class="container text-center mt-3 pt-5">
        <h2 class="form-weight-bold">Login</h2>
        <hr class="mx-auto">
      </div>
      <div class="mx-auto container">
        <form id="login-form">
          <div class="form-group">
            <label>Email</label>
            <input type="text" class="form-control" id="login-email" name="email" placeholder="Email" />
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" id="login-password" name="password" placeholder="Password" />
          </div>
          <div class="form-group">
            <input type="submit" class="btn" id="login-btn" name="login_btn" value="Login" />
          </div>
          <div class="form-group">
            <a id="register-url" href="register.php" class="btn" href="#">Don't Have Account? Register</a>
          </div>
        </form>
      </div>
    </section>

  </div>







  <!--Footer-->
  <footer class="mt-5 py-5">
    <div class="row container mx-auto pt5">
      <div class="footer-one col-lg-3 col-md-6 col-sm-12">
        <img class="logo" src="assets/imgs/logo.jpg" />
        <p class="pt-3">We provide the best products for the most affordable prices</p>
      </div>
      <div class="footer-one col-lg-3 col-md-6 col-sm-12">
        <h5 class="pb-2"></h5>Featured</h5>
        <ul class="text-uppercase">
          <li><a href="shop.php">Mice</a></li>
          <li><a href="shop.php">Keyboards</a></li>
        </ul>
      </div>
      <div class="footer-one col-lg-3 col-md-6 col-sm-12">
        <h5 class="pb-2">Contact Us</h5>
        <div>
          <h6 class="text-uppercase">Address</h6>
          <p>1234 Street Name, City</p>
        </div>
        <div>
          <h6 class="text-uppercase">Phone</h6>
          <p>+1 (555) 555-5555</p>
        </div>
        <div>
          <h6 class="text-uppercase">Email</h6>
          <p>user@domain.com</p>
        </div>
      </div>
      <div class="footer-one col-lg-3 col-md-6 col-sm-12">
        <h5 class="pb-2">Instagram</h5>
        <div class="row">
          <img src="assets/imgs/featured5.jpg" class="img-fluid w-25 h-100 m-2" />
          <img src="assets/imgs/featured2.jpg" class="img-fluid w-25 h-100 m-2" />
          <img src="assets/imgs/featured3.jpg" class="img-fluid w-25 h-100 m-2" />
          <img src="assets/imgs/featured4.jpg" class="img-fluid w-25 h-100 m-2" />
          <img src="assets/imgs/prod2.4.jpg" class="img-fluid w-25 h-100 m-2" />
        </div>
      </div>
    </div>


    <div class="copyright mt-5">
      <div class="row container mx-auto">
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
          <img src="assets/imgs/payment.jpg" />
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4 text-nowrap mb-2">
          <p>A Malik Daniels & Mack Ruby Production</p><br>
          <p>@ 2022 All Rights Reserved</p>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
          <a href="#"><i class="fab fa-facebook"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
        </div>
      </div>
    </div>
  </footer>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js" integrity="sha512-E8QSvWZ0eCLGk4km3hxSsNmGWbLtSCSUcewDQPQWZF6pEU8GlT8a5fF32wOl1i8ftdMhssTrF/OhyGWwonTcXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="./assets/js/setup.js"></script>
  <script src="./assets/js/common.js"></script>
  <script src="./assets/js/login.js"></script>
</body>

</html>