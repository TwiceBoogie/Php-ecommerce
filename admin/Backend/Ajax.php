<?php

include_once 'Global.php';

$action = $_POST['action'];

switch ($action) {
    case 'checkLogin':
        app('login')->userLogin($_POST['email'], $_POST['password']);
        break;

    case "registerUser":
        app('register')->register($_POST['user']);
        break;

    case "updatePassword":
        app('user')->updatePassword(
            SecureSession::get("user_id"),
            array(
                "old_password" => $_POST['oldPass'],
                "new_password" => $_POST['newPass'],
                "new_password_confirmation" => $_POST['newPassConfirm']
            )
        );
        break;

    case "updateDetails":
        app('user')->updateDetails(SecureSession::get("user_id"), $_POST['details']);
        break;

    case "changeRole":
        onlyAdmin();

        $result = app('user')->changeRole($_POST['userId'], $_POST['role']);
        respond(array('role' => ucfirst($result)));
        break;

    case "deleteUser":
        onlyAdmin();

        $userId = (int) $_POST['userId'];
        $users = app('user');

        // Checking if the user we are about to delete is not admin
        if (!$users->isAdmin($userId)) {
            $users->deleteUser($userId);
            respond(array('status' => 'success'));
        }
        respond(array('error' => 'Forbidden.'), 403);
        break;

    case "getUserDetails":
        onlyAdmin();

        respond(
            app('user')->getAll($_POST['userId'])
        );
        break;

    case "addUser":
        onlyAdmin();

        respond(
            app('user')->add($_POST['user'])
        );
        break;

    case "updateUser":
        onlyAdmin();

        app('user')->updateUser($_POST['user']['user_id'], $_POST['user']);

        break;

    case "addProductImg":
        if (count($_FILES['imgUpload']['name']) !== 4) {
            respond(array("error" => "You Must Upload 4 Images at Once"), 406);
        }

        app('upload')->uploadImage('products', $_POST['productID'], $_FILES['imgUpload']);

        break;

    case "getUser":
        onlyAdmin();

        respond(
            app('user')->getAll($_POST['userId'])
        );

        break;

    case "deleteProduct":
        onlyAdmin();

        app('product')->deleteProduct($_POST['product_id']);
        respond(array('status' => 'success'));

        break;

    case "getProductDetails":
        respond(app('product')->getAll($_POST['productId']));

        break;

    case "updateProduct":
        onlyAdmin();

        app('product')->updateProduct($_POST['product']['product_id'], $_POST['product']);
        break;

    case "addProduct":
        onlyAdmin();

        respond(app('product')->add($_POST['product']));

        break;

    case "getProduct":
        onlyAdmin();

        respond(
            app('product')->getAll($_POST['itemId'])
        );

        break;

    default:
        break;
}

function onlyAdmin()
{
    if (!(app('login')->isLoggedIn() && app('current_user')->is_admin)) {
        respond(array('error' => 'Forbidden.'), 403);
    }
}

function onlyManager()
{
    if (!(app('login')->isLoggedIn() && app('current_user')->user_role === 'manager')) {
        respond(array('error' => 'Forbidden.'), 403);
    }
}
