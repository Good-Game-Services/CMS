<?php 
if(!session_id()){
	session_start();
}
require("config/db.php");
$title = "Redirect...";
require("layout/head.php"); // $title = "page title"

if(checkUserSession($db) !== False){
	header("location: $_HOME_FILE");
}
else
{
    header("location: login.php");
}
?>