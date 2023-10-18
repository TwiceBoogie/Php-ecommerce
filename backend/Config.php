<?php

define('WEBSITE_NAME', 'Evolve Tech');
define('WEBSITE_DOMAIN', 'https://ecommerce.twiceb.dev/');

define('SCRIPT_URL', 'https://ecommerce.twiceb.dev/');


define('DB_HOST', $_ENV['DB_HOST']);
define('DB_TYPE', 'mysql');
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASS', $_ENV['DB_PASSWORD']);
define('DB_NAME', $_ENV['DB_NAME']);
// define('DB_HOST', 'localhost');
// define('DB_TYPE', 'mysql');
// define('DB_USER', 'sebastian');
// define('DB_PASS', 'Twice_Mina1');
// define('DB_NAME', 'Php_project');

define('SESSION_SECURE', true);
define('SESSION_HTTP_ONLY', true);
define('SESSION_USE_ONLY_COOKIES', true);



//PASSWORD CONFIGURATION
define('PASSWORD_ENCRYPTION', "bcrypt");
define('PASSWORD_BCRYPT_COST', "13");
define('PASSWORD_SALT', $_ENV['PASSWORD_SALT']);
define('PASSWORD_RESET_KEY_LIFE', 60);

define("R_PATH", __DIR__);
define("F_PATH", R_PATH . '/../uploads');

define("F_SIZE", "5M");
