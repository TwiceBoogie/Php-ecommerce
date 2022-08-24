<?php

/**
 * PasswordHasher class
 */
class PasswordHasher
{
    /**
     * Hash provided password.
     * 
     * @param $password
     * @return string
     */
    public function hashPassword($password)
    {
        $salt = "$2a$" . PASSWORD_BCRYPT_COST . "$" . PASSWORD_SALT;

        return crypt($password, $salt);
    }
}
