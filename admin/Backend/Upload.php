<?php

class Upload
{

    private $db;

    private $validator;

    public function __construct(
        Database $db,
        Validator $validator
    ) {
        $this->db = $db;
        $this->validator = $validator;
    }

    public function uploadImage($table, $id, $file)
    {
        $errors = array();
        $temp = array();
        $imgNameDB = array();

        if ($errors = $this->validateImage($file)) {
            unlink($file['tmp_name']);
            respond(array("errors" => $errors));
        }
        for ($i = 0; $i < count($file['name']); $i++) {
            $ext = explode('.', basename($file['name'][$i]));
            $file_extension = end($ext);
            $imgNameDB[$i] = "prod" . $id . "-" . $i . "." . $file_extension;
            $temp[$i] = "../../assets/imgs/prod" . $id . "-" . $i . "." . $file_extension;
        }


        $data = array(
            "product_image" => $imgNameDB[0],
            "product_image2" => $imgNameDB[1] ?? 'no-data.jpg',
            "product_image3" => $imgNameDB[2] ?? 'no-data.jpg',
            "product_image4" => $imgNameDB[3] ?? 'no-data.jpg'
        );
        for ($i = 0; $i < count($file['name']); $i++) {
            move_uploaded_file($file['tmp_name'][$i], $temp[$i]);
        }

        $this->db->update($table, $data, "`product_id` = :id", array('id' => $id));

        for ($i = 0; $i < count($temp); $i++) {
            if (isset($file['temp_name'][$i]) && file_exists($file['temp_name'][$i]) && is_file($file['temp_name'][$i])) {
                unlink($file['temp_name'][$i]);
            }
        }


        respond(array(
            "status" => "success",
            "message" => "Files Uploaded Successfully",
            "data" => $data
        ), 201);
    }

    public function validateImage($file)
    {
        $errors = array();


        for ($i = 0; $i < count($file['name']); $i++) {
            if (empty($file['tmp_name'][$i])) {
                $errors['phpError'] = 'img_exceeds_max_server_file_size';
            }

            if (!$this->check_img_size($file['tmp_name'][$i])) {
                $errors['imgSize'] = 'img_exceeds_max_file_size: ' . F_SIZE;
            }

            if (!$this->check_img_mime($file['tmp_name'][$i])) {
                $errors['mime_type'] = 'mime_type_not_allowed';
            }

            if (!is_uploaded_file($file['tmp_name'][$i])) {
                $errors['image_upload'] = 'no_file';
            }
        }

        return $errors;
    }

    // https://stackoverflow.com/questions/38509334/full-secure-image-upload-script
    // User: icecub
    /* Checks if the image isn't to large */
    private function check_img_size($tmpname)
    {
        $size_conf = substr(F_SIZE, -1);
        $max_size = (int)substr(F_SIZE, 0, -1);

        switch ($size_conf) {
            case 'k':
            case 'K':
                $max_size *= 1024;
                break;
            case 'm':
            case 'M':
                $max_size *= 1024;
                $max_size *= 1024;
                break;
            default:
                $max_size = 1024000;
        }

        if (filesize($tmpname) > $max_size) {
            return false;
        } else {
            return true;
        }
    }

    // https://stackoverflow.com/questions/38509334/full-secure-image-upload-script
    // User: icecub
    /* Checks the true mime type of the given file */
    private function check_img_mime($tmpname)
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mtype = finfo_file($finfo, $tmpname);
        $this->mtype = $mtype;
        if (strpos($mtype, 'image/') === 0) {
            return true;
        } else {
            return false;
        }
        finfo_close($finfo);
    }
}
