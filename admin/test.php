<?php

echo '<pre>';
if (isset($_POST)) {
    print_r($_POST);
    print_r($_FILES);

    $files = $_FILES;
    foreach ($files as $file) {
        print_r($file);
    }
}
