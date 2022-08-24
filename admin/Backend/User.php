<?php

/**
 * User class.
 */
class User
{

    private $db;

    private $hasher;

    private $validator;

    private $registrator;

    /**
     * Class constructor
     * @param Database $db
     * @param PasswordHasher $hasher
     * @param Validator $validator
     * @param Login $login
     * @param Register $registrator
     */
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

    /**
     * Get all user details, request comes from admin
     * @param $userId int User's id.
     * @return array User details or null if user with given id doesn't exist.
     */
    public function getAll($userId)
    {
        $query = "SELECT `users`.`user_name`, `users`.`user_email`, `user_details`.*
                FROM `users`, `user_details`
                WHERE `users`.`user_id` = :id
                AND `users`.`user_id` = `user_details`.`user_id`";

        $result = $this->db->select($query, array('id' => $userId));

        return count($result) > 0 ? $result[0] : null;
    }

    /**
     * Add new user using data provided by administrator from admin panel.
     * @param $data array All data filled in administrator's "Add User" form
     */
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

    /**
     * Update user's details.
     * @param $userId int User's id.
     * @param $data array User data.
     */
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

    /**
     * Check if user with provided id is admin.
     * @param $userId User's id.
     * @return bool TRUE if user is admin, FALSE otherwise.
     */
    public function isAdmin($userId)
    {
        return $userId && strtolower($this->getRole($userId)) === "admin";
    }

    /**
     * Updates user's password.
     *
     * @param $userId
     * @param array $data
     */
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

    /**
     * @param $userId
     * @param array $data
     * @return array
     */
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

    /**
     * Changes user's role. If user's role was editor it will be set to user and vice versa.
     * @param $userId int User's id.
     * @param $role int New user's role.
     * @return string New user role.
     */
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

    /**
     * Get current user's role.
     * @param $userId
     * @return string Current user's role.
     */
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

    /**
     * Get basic user info.
     * @param $userId int User's unique id.
     * @return array User info array.
     */
    public function getInfo($userId)
    {
        $result = $this->db->select(
            "SELECT * FROM `users` WHERE `user_id` = :id",
            array("id" => $userId)
        );

        return count($result) > 0 ? $result[0] : null;
    }

    /**
     * Updates user info.
     * @param $userId int User's unique id.
     * @param array $data Associative array where keys are database fields that need
     * to be updated.
     */
    public function updateInfo($userId, $data)
    {
        $this->db->update(
            "users",
            $data,
            "`user_id` = :id",
            array("id" => $userId)
        );
    }

    /**
     * Get user details (City, Address and Phone)
     * @param $userId int User's id.
     * @return array User details array.
     */
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


    /**
     * Updates user details.
     *
     * @param $userId int The ID of the user to update.
     * @param array $details Associative array where keys are database fields.
     */
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

    /**
     * Validate data provided during user update
     * @param $userInfo
     * @param $data
     * @return array
     */
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

    /**
     * Hash provided password.
     * @param string $password Password that needs to be hashed.
     * @return string Hashed password.
     */
    private function hashPassword($password)
    {
        return $this->hasher->hashPassword($password);
    }
}
