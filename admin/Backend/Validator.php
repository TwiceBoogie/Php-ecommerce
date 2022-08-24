<?php

/**
 * Class Validator
 */
class Validator
{

    private $db;

    /**
     * Class constructor
     * @param Database $db
     */
    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    /**
     * Check if provided input is empty.
     * 
     * @param $input array|string Input to be checked.
     * @return bool TRUE if input is empty, FALSE otherwise.
     */
    public function isEmpty($input)
    {
        if (is_array($input)) {
            return empty($input);
        }

        if ($input == '') {
            return true;
        }

        return false;
    }

    /**
     * Check if email has valid format.
     * 
     * @param string $email Email to be checked.
     * @return boolean TRUE if email has valid format, FALSE otherwise.
     */
    public function emailValid($email)
    {
        return preg_match("/^[_a-z0-9-]+(\.[_a-z0-9+-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $email);
    }

    /**
     * Check if provided email exists.
     * @param $email string Email to be checked.
     * @return bool TRUE if email exist, FALSE otherwise.
     */
    public function emailExist($email)
    {
        return $this->exist('users', 'user_email', $email);
    }

    public function productNameExist($name)
    {
        return $this->exist('products', 'product_name', $name);
    }

    /**
     * Check if provided role exists.
     * @param $role string Role to be checked.
     * @return bool TRUE if role exist, FALSE otherwise.
     */
    public function roleExist($role)
    {
        return $this->exist('roles', 'role_name', $role);
    }

    /**
     * Check if provided value exist in provided database table and provided db column.
     * 
     * @param $table string Database table
     * @param $column string Database column
     * @param $value string|int Column value
     * @return bool TRUE if value exist in given table and column, FALSE otherwise.
     */
    private function exist($table, $column, $value)
    {
        $result = $this->db->select(
            "SELECT * FROM `$table` WHERE `$column` = :val",
            array('val' => $value)
        );

        return count($result) > 0;
    }
}
