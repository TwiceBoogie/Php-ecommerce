<?php

class Role
{

    private $db = null;

    private $validator;

    public function __construct(Database $db, Validator $validator)
    {
        $this->db = $db;
        $this->validator = $validator;
    }

    public function getId($name)
    {
        $result = $this->db->select(
            "SELECT `role_id` FROM `user_roles` WHERE `role` = :r",
            array('r' => $name)
        );

        return $result
            ? $result[0]['role_id']
            : null;
    }

    public function add($name)
    {
        if ($this->validator->roleExist($name)) {
            respond(array(
                "errors" => array("name" => 'role_taken')
            ), 422);
        }

        $this->db->insert(
            "roles",
            array("role" => strtolower(strip_tags($_POST['role'])))
        );

        respond(array(
            "status" => "success",
            "role_name" => strip_tags($_POST['role']),
            "role_id" => $this->db->lastInsertId()
        ));
    }

    public function delete($id)
    {
        //default user roles can't be deleted
        if (in_array($_POST['roleId'], array(1, 2, 3))) {
            exit();
        }

        $this->db->delete("user_roles", "role_id = :id", array("id" => $id));

        // Since provided role is deleted, we will
        // update all users who had this role to use
        // default "User" role now.
        $this->db->update(
            "users",
            array('user_role' => "1"),
            "user_role = :r",
            array("r" => $id)
        );

        respond(array('status' => 'success'));
    }
}
