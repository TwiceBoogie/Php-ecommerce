<?php

class PasswordHasher
{

    public function hashPassword($password)
    {
        $salt = "$2a$" . PASSWORD_BCRYPT_COST . "$" . PASSWORD_SALT;

        return crypt($password, $salt);
    }
}
