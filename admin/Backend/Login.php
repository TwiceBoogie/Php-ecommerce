<?php

class Login
{

    private $db = null;

    private $hasher;

    public function __construct(Database $db, PasswordHasher $hasher)
    {
        $this->db = $db;
        $this->hasher = $hasher;
    }

    public function isLoggedIn()
    {
        if (SecureSession::get("user_id") == null) {
            return false;
        }

        return true;
    }

    public function userLogin($email, $password)
    {
        $errors = $this->validateLoginFields($email, $password);

        // validation errors
        if ($errors) {
            respond(array(
                'status' => 'error',
                'errors' => $errors
            ), 401);
        }

        // hash password and get data from db
        $password = $this->hashPassword($password);
        $result = $this->db->select(
            "SELECT * FROM `users`
                 WHERE `user_email` = :e AND `user_password` = :p",
            array("e" => $email, "p" => $password)
        );

        // db error
        if (count($result) !== 1) {
            respond(array(
                'status' => 'error',
                'errors' => array(
                    'email' => '',
                    'password' => 'Wrong Email and/or Password'
                )
            ), 401);
        }

        // check if user is confirmed
        // all users are confirmed.
        if ($result[0]['confirmed'] == "N") {
            respond(array(
                'status' => 'error',
                'errors' => array(
                    'email' => '',
                    'password' => 'User Not Confirmed'
                )
            ), 401);
        }

        // credentials are valid
        SecureSession::set("user_id", $result[0]['user_id']);
        SecureSession::regenerate();

        respond(array(
            'status' => 'success',
            'page' => 'account.php'
        ));
    }

    public function logout()
    {
        SecureSession::destroySession();
    }

    private function validateLoginFields($email, $password)
    {
        $errors = array();

        if ($email == "") {
            $errors['email'] = 'Email Required';
        }

        if ($password == "") {
            $errors['password'] = 'Password Required';
        }

        return $errors;
    }

    private function hashPassword($password)
    {
        return $this->hasher->hashPassword($password);
    }
}
