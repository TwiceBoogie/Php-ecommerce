<?php

define('WEBSITE_NAME', 'Evolve Tech');
define('WEBSITE_DOMAIN', 'http://localhost/');

define('SCRIPT_URL', 'http://localhost/php-ecommerce');


define('DB_HOST', 'localhost');
define('DB_TYPE', 'mysql');
define('DB_USER', 'username');
define('DB_PASS', 'password');
define('DB_NAME', 'dbname');


//LOGIN CONFIGURATION
define('SUCCESS_LOGIN_REDIRECT', serialize(array('default' => "index.php", 'system_workers' => "index.php")));

//PASSWORD CONFIGURATION
define('PASSWORD_ENCRYPTION', "bcrypt");
define('PASSWORD_BCRYPT_COST', "13");
define('PASSWORD_SALT', "lf38wco0JJrAiC4x5bOeAQ");
define('PASSWORD_RESET_KEY_LIFE', 60);

define("R_PATH", __DIR__);
define("F_PATH", R_PATH . '/../uploads');

define("F_SIZE", "5M");
