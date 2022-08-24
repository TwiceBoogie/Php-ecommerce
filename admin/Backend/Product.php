<?php

/**
 * Product class
 */
class Product
{

    private $db;

    private $validator;

    /**
     * Class constructor
     * @param Database $db
     * @param Validator $validator
     */
    public function __construct(Database $db, Validator $validator)
    {
        $this->db = $db;
        $this->validator = $validator;
    }

    /**
     * Get all product details
     * @param $productId int product's id.
     * @return array Product details or null if product with given id doesn't exist.
     */
    public function getAll($productId)
    {
        $query = "SELECT * FROM `products` WHERE `product_id` = :id";

        $result = $this->db->select($query, array('id' => $productId));

        return count($result) > 0 ? $result[0] : null;
    }

    /**
     * Add new product using data provided by either admin or manager.
     * @param $data array All data filled in "Add Product" form.
     */
    public function add($data)
    {
        if ($errors = $this->validateInput($data)) {
            respond(array("errors" => $errors), 422);
        }

        $this->db->insert('products', array(
            'product_name' => $data['product_name'],
            'product_description' => $data['product_desc'],
            'product_price' => $data['product_price'],
            'product_color' => $data['product_color'],
            'product_category' => $data['product_category'],
        ));


        respond(array(
            "status" => "success",
            "message" => "Product Added Succesfully"
        ), 201);
    }

    public function updateProduct($productId, array $data)
    {
        if ($errors = $this->validateProductUpdate($data)) {
            respond(array("errors" => $errors), 422);
        }

        $productInfo = array(
            "product_name" => $data['product_name'],
            "product_description" => $data['product_desc'],
            "product_price" => $data['product_price'],
            "product_color" => $data['product_color'],
            "product_category" => $data['product_category']
        );

        $this->db->update(
            "products",
            $productInfo,
            "`product_id` = :id",
            array("id" => $productId)
        );

        respond(array(
            'status' => "success",
            'message' => 'Updated Successfully'
        ));
    }

    /**
     * Validate admin/manager provided fields.
     * @param $data array Admin/Manager provided fields
     * @return array Array with errors if there are some, empty array otherwise.
     */
    public function validateInput($data)
    {
        $errors = array();

        // Check if name is not empty
        if ($this->validator->isEmpty($data['product_name'])) {
            $errors['product_name'] = 'Name Required';
        }

        // Check if desc is not empty
        if ($this->validator->isEmpty($data['product_desc'])) {
            $errors['product_desc'] = 'Description Required';
        }

        // Check if color is not empty
        if ($this->validator->isEmpty($data['product_color'])) {
            $errors['product_color'] = 'Color Required';
        }

        // Check for duplicates
        if (!isset($errors['product_name']) && $this->validator->productNameExist($data['product_name'])) {
            $errors['product_name'] = 'Duplicate Found';
        }

        // Check if price is not empty
        if ($this->validator->isEmpty($data['product_price'])) {
            $errors['product_price'] = 'Price Required';
        }

        // Check if category is not empty
        if ($this->validator->isEmpty($data['product_category'])) {
            $errors['product_category'] = 'Category Required';
        }

        return $errors;
    }

    public function validateProductUpdate($data)
    {
        $errors = array();

        // Check if name is not empty
        if ($this->validator->isEmpty($data['product_name'])) {
            $errors['product_name'] = 'Name Required';
        }

        // Check if desc is not empty
        if ($this->validator->isEmpty($data['product_desc'])) {
            $errors['product_desc'] = 'Description Required';
        }

        // Check if color is not empty
        if ($this->validator->isEmpty($data['product_color'])) {
            $errors['product_color'] = 'Color Required';
        }

        // Check if price is not empty
        if ($this->validator->isEmpty($data['product_price'])) {
            $errors['product_price'] = 'Price Required';
        }

        // Check if category is not empty
        if ($this->validator->isEmpty($data['product_category'])) {
            $errors['product_category'] = 'Category Required';
        }

        return $errors;
    }

    /**
     * Delete product
     * @param $productId.
     */
    public function deleteProduct($productId)
    {
        $this->db->delete("products", "product_id = :id", array("id" => $productId));
    }
}
