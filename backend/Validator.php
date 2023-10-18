<?php

class Validator
{

    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

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

    public function emailValid($email)
    {
        return preg_match("/^[_a-z0-9-]+(\.[_a-z0-9+-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $email);
    }

    public function emailExist($email)
    {
        return $this->exist('users', 'user_email', $email);
    }

    public function productNameExist($name)
    {
        return $this->exist('products', 'product_name', $name);
    }

    public function roleExist($role)
    {
        return $this->exist('roles', 'role_name', $role);
    }

    private function exist($table, $column, $value)
    {
        $result = $this->db->select(
            "SELECT * FROM `$table` WHERE `$column` = :val",
            array('val' => $value)
        );

        return count($result) > 0;
    }
}
