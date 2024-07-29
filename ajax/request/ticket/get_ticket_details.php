<?php
require("../../../config/db.php");

session_start();
error_reporting(0);

if (checkUserSession($db) !== True) {
    $ticketStatus = array();

    $ticketId = $_POST["ticket_id"];
    $user = searchUser_bSession($db, $_COOKIE["user_session"]);
    $userId = $user["id"];
    $stmt = $db->prepare("SELECT * FROM tickets WHERE id = ? AND user_id = ?");
    $stmt->execute([$ticketId, $userId]);
    $ticket = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($ticket) {
        $stmt = $db->prepare("SELECT * FROM ticket_messages WHERE ticket_id = ?");
        $stmt->execute([$ticketId]);
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response["success"] = true;
        $response["ticket"] = $ticket;
        $response["messages"] = $messages;
    } else {
        $response["success"] = false;
        $response["message"] = "Ticket not found or access denied";
    }
    
}


echo json_encode($ticketStatus);
?>
