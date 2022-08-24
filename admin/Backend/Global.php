<?php

include_once 'Upload.php';
include_once 'Product.php';

include_once dirname(__FILE__) . '/../vendor/autoload.php';

SecureSession::startSession();

// Pimple allows you to wire together an object and all of its recursive dependencies ONCE, 
// and then use that object multiple places by simple calling that object.
$container = new Pimple\Container();

$container['db'] = function () {
    try {
        $db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
        $db->debug(true);
        return $db;
    } catch (PDOException $e) {
        die('Connection failed: ' . $e->getMessage());
    }
};

// By default, each time you get a service, Pimple returns the same instance of it.
// If you want a different instance to be returned for all calls, wrap your anonymous function with the factory() method.
// Now, each call to $container['name'] returns a new instance of the 'name'
// https://github.com/silexphp/Pimple
$container['hasher'] = $container->factory(function () {
    return new PasswordHasher;
});

$container['validator'] = $container->factory(function ($c) {
    return new Validator($c['db']);
});

$container['login'] = $container->factory(function ($c) {
    return new Login($c['db'], $c['hasher']);
});

$container['register'] = $container->factory(function ($c) {
    return new Register($c['db'], $c['validator'], $c['hasher']);
});

$container['upload'] = $container->factory(function ($c) {
    return new Upload($c['db'], $c['validator']);
});

$container['user'] = $container->factory(function ($c) {
    return new User($c['db'], $c['hasher'], $c['validator'], $c['register']);
});

$container['product'] = $container->factory(function ($c) {
    return new Product($c['db'], $c['validator']);
});

$container['role'] = $container->factory(function ($c) {
    return new Role($c['db'], $c['validator']);
});

$container['current_user'] = function ($c) {
    if (!$c['login']->isLoggedIn()) {
        return null;
    }

    $result = $c['db']->select(
        "SELECT `users`.*, `roles`.`role_name` FROM `users` LEFT JOIN `roles` ON `users`.`user_role` = `roles`.`role_id` WHERE `user_id` = :id",
        array("id" => SecureSession::get('user_id'))
    );


    if (!$result) {
        return null;
    }

    $result = $result[0];

    return (object) array(
        'id' => (int) $result['user_id'],
        'name' => $result['user_name'],
        'email' => $result['user_email'],
        'role_id' => (int) $result['user_role'],
        'role_name' => strtolower($result['role_name']),
        'confirmed' => $result['confirmed'],
        'is_admin' => $result['user_role'] === '1' ? 'Y' : 'N',
        'register_date' => $result['register_date']
    );
};

Container::setContainer($container);
