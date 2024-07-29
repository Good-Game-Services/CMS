<?php
require("../../../config/db.php");

session_start();
error_reporting(0);

$response = array();

if (checkUserSession($db) !== True) {
    $response["success"] = false;
    $response["message"] = "User not logged in";
} else {
    $ticketId = $_POST["ticket_id"];
    $message = $_POST["message"];
    $userId = searchUser_bSession($db, $_COOKIE["user_session"])["id"];

    $stmt = $db->prepare("INSERT INTO ticket_messages (ticket_id, user_id, message) VALUES (?, ?, ?)");
    if ($stmt->execute([$ticketId, $userId, $message])) {
        $response["success"] = true;
        $response["message"] = "Message added successfully!";
    } else {
        $response["success"] = false;
        $response["message"] = "There was an error adding your message. Please try again.";
    }
}

echo json_encode($response);
?>
