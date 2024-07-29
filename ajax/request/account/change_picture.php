<?php
require("../../../config/db.php");

session_start();
error_reporting(0);

$uploadStatus = array();

if (checkUserSession($db) !== False) {
    if (isset($_FILES["profileImage"]) && $_FILES["profileImage"]["error"] == 0) {
        $targetDir = "../../../data/profile/";
        $fileName = basename($_FILES["profileImage"]["name"]);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $randomFileName = uniqid() . '.' . $fileExt; // Generiert einen eindeutigen Dateinamen
        $targetFile = $targetDir . $randomFileName;
        
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["profileImage"]["tmp_name"]);
        if ($check !== false) {
            // Check file size
            if ($_FILES["profileImage"]["size"] <= 500000) {
                // Allow certain file formats
                if ($fileExt == "jpg" || $fileExt == "png" || $fileExt == "jpeg" || $fileExt == "gif") {
                    if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $targetFile)) {
                        $user = searchUser_bSession($db, $_COOKIE["user_session"]);
                        mysqli_query($db, "UPDATE user SET profilePicture = '$targetFile' WHERE username = '{$user["username"]}'") or die(json_encode(array("success" => false, "message" => "Fehler beim Aktualisieren der SQL-Abfrage")));
                        
                        $uploadStatus = array("success" => true, "message" => "The picture has been uploaded and the profile picture has been updated.");
                    } else {
                        $uploadStatus = array("success" => false, "message" => "Sorry, there was an error uploading your file.");
                    }
                } else {
                    $uploadStatus = array("success" => false, "message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
                }
            } else {
                $uploadStatus = array("success" => false, "message" => "Sorry, your file is too large.");
            }
        } else {
            $uploadStatus = array("success" => false, "message" => "File is not an image.");
        }
    } else {
        $uploadStatus = array("success" => false, "message" => "Empty data");
    }
} else {
    $uploadStatus = array("success" => false, "message" => "Require login");
}

echo json_encode($uploadStatus);