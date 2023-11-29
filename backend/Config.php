<?php

define('WEBSITE_NAME', 'Evolve Tech');
define('WEBSITE_DOMAIN', 'https://ecommerce.twiceb.dev/');

define('SCRIPT_URL', 'https://ecommerce.twiceb.dev/');


define('DB_HOST', $_SERVER['DB_HOST']);
define('DB_TYPE', 'mysql');
define('DB_USER', $_SERVER['DB_USER']);
define('DB_PASS', $_SERVER['DB_PASSWORD']);
define('DB_NAME', $_SERVER['DB_NAME']);


define('SESSION_SECURE', true);
define('SESSION_HTTP_ONLY', true);
define('SESSION_USE_ONLY_COOKIES', true);



//PASSWORD CONFIGURATION
define('PASSWORD_ENCRYPTION', "bcrypt");
define('PASSWORD_BCRYPT_COST', "13");
define('PASSWORD_SALT', $_SERVER['PASSWORD_SALT']);
define('PASSWORD_RESET_KEY_LIFE', 60);

define("R_PATH", __DIR__);
define("F_PATH", R_PATH . '/../uploads');

define("F_SIZE", "5M");
