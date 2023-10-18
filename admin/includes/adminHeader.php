<?php
include '../backend/Global.php';

if (!app('login')->isLoggedIn()) {
    redirect('login.php');
}

$currentUser = app('current_user');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="assets/css-dash/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="assets/css-dash/style.css" />
    <title><?php echo $site; ?> Page</title>
</head>

<body>
    <!-- top navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand me-auto ms-lg-0 ms-3 text-uppercase fw-bold" href="./">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNavBar" aria-controls="topNavBar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <!-- top navigation bar -->

    <div class="content">
        <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark ht" style="width: 280px">
            <hr />
            <ul class="nav nav-pills flex-column mb-auto mt-4">
                <li>
                    <a href="./users.php" class="nav-link text-white <?= $site == 'Users' ? 'active' : '' ?>">
                        System Users
                    </a>
                </li>
                <li>
                    <a href="./products.php" class="nav-link text-white <?= $site == 'Products' ? 'active' : '' ?>">
                        Products
                    </a>
                </li>
            </ul>
            <hr />
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown">

                    <strong><?= ucfirst($currentUser->role_name) ?></strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="../index.php">Go back to website?</a></li>
                </ul>
            </div>
        </div>