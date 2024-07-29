<?php
require("../../config/db.php");

session_start();
error_reporting(0);

if(checkUserSession($db) !== False){
	$user = searchUser_bSession($db, $_COOKIE["user_session"]);


} else {
	$changeStatus = array("success" => false, "message" => "Require login");
}
