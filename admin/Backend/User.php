<?php

class User
{

    private $db;

    private $hasher;

    private $validator;

    private $registrator;

    public function __construct(
        Database $db,
        PasswordHasher $hasher,
        Validator $validator,
        Register $registrator
    ) {
        $this->db = $db;
        $this->hasher = $hasher;
        $this->validator = $validator;
        $this->registrator = $registrator;
    }

    public function getAll($userId)
    {
        $query = "SELECT `users`.`user_name`, `users`.`user_email`, `user_details`.*
                FROM `users`, `user_details`
                WHERE `users`.`user_id` = :id
                AND `users`.`user_id` = `user_details`.`user_id`";

        $result = $this->db->select($query, array('id' => $userId));

        return count($result) > 0 ? $result[0] : null;
    }

    public function add($data)
    {
        if ($errors = $this->registrator->validateUser($data)) {
            respond(array("errors" => $errors), 422);
        }

        $this->db->insert('users', array(
            'user_email' => $data['email'],
            'user_name' => $data['name'],
            'user_password' => $this->hashPassword($data['password']),
            'register_date' => date('Y-m-d H:i:s')
        ));

        $this->db->insert('user_details', array(
            'user_id' => $this->db->lastInsertId(),
            'city' => $data['city'],
            'phone' => $data['phone'],
            'address' => $data['address']
        ));

        respond(array(
            "status" => "success",
            "message" => "User Added Successfully"
        ));
    }

    public function updateUser($userId, array $data)
    {
        $currInfo = $this->getInfo($userId);

        if ($errors = $this->validateUserUpdate($currInfo, $data)) {
            respond(array("errors" => $errors), 422);
        }

        $userInfo = array(
            'user_email' => $data['email'],
            'user_name' => $data['name']
        );

        if ($data['password']) {
            $userInfo['password'] = $this->hashPassword($data['password']);
        }

        if ($userInfo) {
            $this->updateInfo($userId, $userInfo);
            SecureSession::regenerate();
        }

        $this->updateDetails($userId, array(
            'phone' => $data['phone'],
            'city' => $data['city'],
            'address' => $data['address']
        ));

        respond(array(
            "status" => "success",
            "message" => "User Updated Successfully"
        ));
    }

    public function isAdmin($userId)
    {
        return $userId && strtolower($this->getRole($userId)) === "admin";
    }

    public function updatePassword($userId, array $data)
    {
        if ($errors = $this->validatePasswordUpdate($userId, $data)) {
            respond(array('errors' => $errors), 422);
        }

        $this->updateInfo($userId, array(
            "user_password" => $this->hashPassword($data['new_password'])
        ));

        SecureSession::regenerate();

        respond(array(
            'status' => 'success',
            'message' => 'Password Updated Successfully'
        ));
    }

    private function validatePasswordUpdate($userId, array $data)
    {
        $errors = array();

        $user = $this->getInfo($userId);


        if (!isset($data['old_password']) || $this->validator->isEmpty($data['old_password'])) {
            $errors['oldPass'] = 'Field Required';
        }

        if (!isset($data['new_password']) || $this->validator->isEmpty($data['new_password'])) {
            $errors['newPass'] = 'Field Required';
        }

        if (
            !isset($data['new_password_confirmation'])
            || $this->validator->isEmpty($data['new_password_confirmation'])
        ) {
            $errors['newPassConfirm'] = 'Field Required';
        }

        if ($data['new_password'] !== $data['new_password_confirmation']) {
            $errors['newPassConfirm'] = 'Passwords Don"t Match';
        }

        if ($this->hashPassword($data['old_password']) !== $user['user_password']) {
            $errors['oldPass'] = 'Wrong Old Password';
        }

        if ($this->hashPassword($data['new_password']) === $user['user_password']) {
            $errors['newPass'] = 'New Password Cannot Be The Same As Old Password';
            return $errors;
        }

        return $errors;
    }

    public function changeRole($userId, $role)
    {
        $result = $this->db->select(
            "SELECT * FROM `roles` WHERE `role_id` = :r",
            array("r" => $role)
        );

        if (count($result) == 0) {
            return null;
        }

        // set permissions to system

        $this->updateInfo($userId, array("user_role" => $role));

        SecureSession::regenerate();

        return ucfirst(strtolower($result[0]['role_name']));
    }

    public function getRole($userId)
    {
        $result = $this->db->select(
            "SELECT `roles`.`role_name` as role 
            FROM `roles`,`users`
            WHERE `users`.`user_role` = `roles`.`role_id`
            AND `users`.`user_id` = :id",
            array("id" => $userId)
        );

        return $result[0]['role'];
    }

    public function getInfo($userId)
    {
        $result = $this->db->select(
            "SELECT * FROM `users` WHERE `user_id` = :id",
            array("id" => $userId)
        );

        return count($result) > 0 ? $result[0] : null;
    }

    public function updateInfo($userId, $data)
    {
        $this->db->update(
            "users",
            $data,
            "`user_id` = :id",
            array("id" => $userId)
        );
    }

    public function getDetails($userId)
    {
        $result = $this->db->select(
            "SELECT * FROM `user_details` WHERE `user_id` = :id",
            array("id" => $userId)
        );

        if (count($result) == 0) {
            return array(
                "city" => "",
                "address" => "",
                "phone" => "",
                "empty" => true
            );
        }

        return $result[0];
    }


    public function updateDetails($userId, $details)
    {
        $currDetails = $this->getDetails($userId);

        if (isset($currDetails['empty'])) {
            $details["user_id"] = $userId;
            return $this->db->insert("user_details", $details);
        }

        $this->db->update(
            "user_details",
            $details,
            "`user_id` = :id",
            array("id" => $userId)
        );

        respond(array(
            'status' => 'success',
            'message' => 'Updated Successfully'
        ));
    }

    /**
     * Delete user, all his comments and connected social accounts.
     * @param $userId
     */
    public function deleteUser($userId)
    {
        $this->db->delete("users", "user_id = :id", array("id" => $userId));
        $this->db->delete("user_details", "user_id = :id", array("id" => $userId));
    }

    private function validateUserUpdate($userInfo, $data)
    {
        $errors = array();

        if ($userInfo == null) {
            $errors['email'] = 'User Doesn"t Exist';
            return $errors;
        }

        if ($this->validator->isEmpty($data['email'])) {
            $errors['email'] = 'Email Required';
        }

        if ($this->validator->isEmpty($data['name'])) {
            $errors['name'] = 'Name Required';
        }

        if ($data['password'] !== $data['passwordConfirm']) {
            $errors['passwordConfirm'] = 'Passwords Don"t Match';
        }

        if (!$this->validator->emailValid($data['email'])) {
            $errors['email'] = 'Email Wrong Format';
        }

        //check if email is available
        if ($data['email'] != $userInfo['user_email'] && $this->validator->emailExist($data['email'])) {
            $errors['email'] = 'Email Taken';
        }

        return $errors;
    }

    private function hashPassword($password)
    {
        return $this->hasher->hashPassword($password);
    }
}
