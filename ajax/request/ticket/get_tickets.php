<?php
require("../../../config/db.php");

session_start();
error_reporting(0);

$ticketStatus = array();

if(checkUserSession($db) !== False){
    $ticketStatus["success"] = true;
} else {
    $ticketStatus["success"] = false;
}

echo json_encode($response);
?>
