<?php


class Register
{

    private $db = null;

    private $validator;

    private $hasher;

    public function __construct(
        Database $db,
        Validator $validator,
        PasswordHasher $hasher
    ) {
        $this->db = $db;
        $this->validator = $validator;
        $this->hasher = $hasher;
    }

    public function register($data)
    {
        //validate provided data
        if ($errors = $this->validateUser($data)) {
            respond(array(
                "status" => "error",
                "errors" => $errors
            ), 422);
        }

        //insert new user to database
        $this->db->insert('users', array(
            "user_email" => $data['email'],
            "user_name" => strip_tags($data['name']),
            "user_password" => $this->hashPassword($data['password']),
        ));

        $id = $this->db->lastInsertId();
        $this->db->insert('user_details', array(
            'user_id' => $id,
        ));

        SecureSession::set("user_id", $id);
        SecureSession::regenerate();

        //prepare and output success message
        respond(array(
            "status" => "success",
            "message" => "Successfully Registered"
        ));
    }

    public function hashPassword($password)
    {
        return $this->hasher->hashPassword($password);
    }

    public function validateUser($data)
    {
        $errors = array();

        //check if username is not empty
        if ($this->validator->isEmpty($data['name'])) {
            $errors['name'] = 'Fullname Required';
        }

        //check if email is not empty
        if ($this->validator->isEmpty($data['email'])) {
            $errors['email'] = 'Email Required';
        }

        //check if email doesn't exist already
        if (!isset($errors['email']) && $this->validator->emailExist($data['email'])) {
            $errors['email'] = 'Email Already Exist';
        }

        // Check if password is not empty.
        if ($this->validator->isEmpty($data['password'])) {
            $errors['password'] = 'Password Required';
        }

        //check if password and confirm password are the same
        if ($data['password'] !== $data['passwordConfirm']) {
            $errors['confirmPassword'] = 'Passwords Don"t Match';
        }

        //check if email format is correct
        if (!isset($errors['email']) && !$this->validator->emailValid($data['email'])) {
            $errors['email'] = 'Email Wrong Format';
        }

        return $errors;
    }
}
