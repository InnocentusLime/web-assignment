<?php

require_once "db_utils.php";

if(!isset($_POST["submit"])) {
    echo "wat";
    exit;
}

if(!isset($_POST["name"])) {
    echo "No name";
    exit;
}

if(!isset($_POST["price"])) {
    echo "No price";
    exit;
}

if(!isset($_POST["descr"])) {
    echo "No descr";
    exit;
}


connect_to_db();
$next_id = get_next_item_id();
$target_dir = "../img/product/";
$uploadOk = 1;
$imageFileType = strtolower(pathinfo(basename($_FILES["img"]["name"]),PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["img"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
  echo "Sorry, only JPG, JPEG, PNG files are allowed.";
  $uploadOk = 0;
}

$target_file_base = "product" . $next_id . "." . $imageFileType;
$target_file = $target_dir . $target_file_base;

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Failed to serve your request.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["img"]["name"])). " has been uploaded.";
    // TODO use get_last_insert() and update the img_url field instead.
    insert_item_info(
        $_POST["name"],
        $_POST["price"],
        $_POST["descr"],
        $target_file_base
    );
    echo "Record added to Database";
    disconnect_from_db();
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}