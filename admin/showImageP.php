<?php

$image = FALSE;
$name = (!empty($_GET['name'])) ? $_GET['name'] : 'print image';

if (isset($_GET['image']) && isset($_GET['name'])) {

    // Full image path:
    $image = './uploadsProduct/' . $_GET['image'];

    // Check that the images exists and is a file:
    if (!file_exists($image) || (!is_file($image))) {
        $image = FALSE;
    }
} // End of $_GET['image'] IF.

// If there was a problem, use the default image:
if (!$image) {
    $image = 'assets/img/no-data.jpg';
    $name = 'unavailable.png';
}

// Get the image information:
$info = getimagesize($image);
$fs = filesize($image);

// Send the content information:
header("Content-Type: {$info['mime']}\n");
header("Content-Disposition: inline; filename=\"$name\"\n");
header("Content-Length: $fs\n");

// Send the file:
readfile($image);
