<html>
<?php 
if(!session_id()){
	session_start();
}
require("config/db.php");
$title = "Admin Area";
require("layout/head.php"); // $title = "page title"

if(checkUserSession($db) !== True){
	header("location: $_LOGIN_FILE");exit; //$_LOGIN_FILE --> /config/value.php
}

$user = searchUser_bSession($db, $_COOKIE["user_session"]);

if($user["admin"] != 1){
	error("You are not admin.", $_HOME_FILE);exit;
}
?>

<body class=" pace-done">
<div id="wrapper">

<?php
$adminArea = "active";
$userName = $user["firstName"] . " " . $user["lastName"];
require("layout/admin_menu.php");
?>
        <div id="page-wrapper" class="gray-bg" style="min-height: 1263px;">
        <?php
		require("layout/navtop.php");
		?>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Admin Area</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="">Admin</a>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeIn">
            <div class="row">
				<!-- ROOM -->
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Admin</h5>
                        </div>
                        <div class="ibox-content">
						    
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<!-- footer -->
		<?php require("layout/footer.php") ?>
		<!-- ./fotter -->
	</div>
</div>

<!-- Mainly scripts -->
<script src="assets/js/jquery-3.1.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/plugins/toastr/toastr.min.js"></script>
<script src="assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="assets/js/inspinia.js"></script>
<script src="assets/js/plugins/pace/pace.min.js"></script>

<script src="assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script>

function delete_room(room_id){
	var c = confirm("Are you sure? Press OK if you wanna delete this room!");
	if (c == true) {
		$.ajax({
			url: "ajax/request/admin/delete_room.php",
			type: "POST",
			data: {
				room_id: room_id
			},
			dataType:  'json',
			beforeSend: function () {
				
			},
			success: function(r) {
				if(r.success){
					$("#room-" + room_id).remove()
					toastr.success(r.message)
				} else {
					toastr.error(r.message)
				}
			},
			error: function(){
				toastr.error("Unkown error?!")
			},
			complete: function(){
				
			}
	   });
	}
}

//delete user
function delete_user(user_id){
	var c = confirm("Are you sure? Press OK if you wanna delete this user!");
	if (c == true) {
		$.ajax({
			url: "ajax/request/admin/delete_user.php",
			type: "POST",
			data: {
				user_id: user_id
			},
			dataType:  'json',
			beforeSend: function () {
				
			},
			success: function(r) {
				if(r.success){
					$("#user-id-" + user_id).remove()
					toastr.success(r.message)
				} else {
					toastr.error(r.message)
				}
			},
			error: function(){
				toastr.error("Unkown error?!")
			},
			complete: function(){
				
			}
	   });
	}
}

//ban user
function ban_user(user_id){
	var reason;
	var input = prompt("Reason you ban this user:", "Violation of rules");
	reason = input;
	
	if (reason != null && reason != "") {
	  $.ajax({
			url: "ajax/request/admin/ban_user.php",
			type: "POST",
			data: {
				user_id: user_id,
				reason: reason
			},
			dataType:  'json',
			beforeSend: function () {
				
			},
			success: function(r) {
				if(r.success){
					$("#ban-user-id-" + user_id).hide()
					$("#unban-user-id-" + user_id).show()
					toastr.success(r.message)
				} else {
					toastr.error(r.message)
				}
			},
			error: function(){
				toastr.error("Unkown error?!")
			},
			complete: function(){
				
			}
	   });
	} 
}

//un ban user
function unban_user(user_id){
	var c = confirm("Are you sure? Press OK if you wanna do this");
	
	if (c == true) {
	  $.ajax({
			url: "ajax/request/admin/unban_user.php",
			type: "POST",
			data: {
				user_id: user_id
			},
			dataType:  'json',
			beforeSend: function () {
				
			},
			success: function(r) {
				if(r.success){
					$("#ban-user-id-" + user_id).show()
					$("#unban-user-id-" + user_id).hide()
					toastr.success(r.message)
				} else {
					toastr.error(r.message)
				}
			},
			error: function(){
				toastr.error("Unkown error?!")
			},
			complete: function(){
				
			}
	   });
	} 
}

function promote_user(user_id){
	var c = confirm("Are you sure? Press OK if you wanna do this");
	
	if (c == true) {
	  $.ajax({
			url: "ajax/request/admin/promote_user.php",
			type: "POST",
			data: {
				user_id: user_id,
				role: 1
			},
			dataType:  'json',
			beforeSend: function () {
				
			},
			success: function(r) {
				if(r.success){
					$("#promote-admin-id-" + user_id).hide()
					$("#unpromote-admin-id-" + user_id).show()
					toastr.success(r.message)
				} else {
					toastr.error(r.message)
				}
			},
			error: function(){
				toastr.error("Unkown error?!")
			},
			complete: function(){
				
			}
	   });
	} 
}

function unpromote_user(user_id){
	var c = confirm("Are you sure? Press OK if you wanna do this");
	
	if (c == true) {
	  $.ajax({
			url: "ajax/request/admin/promote_user.php",
			type: "POST",
			data: {
				user_id: user_id,
				role: 0
			},
			dataType:  'json',
			beforeSend: function () {
				
			},
			success: function(r) {
				if(r.success){
					$("#promote-admin-id-" + user_id).show()
					$("#unpromote-admin-id-" + user_id).hide()
					toastr.success(r.message)
				} else {
					toastr.error(r.message)
				}
			},
			error: function(){
				toastr.error("Unkown error?!")
			},
			complete: function(){
				
			}
	   });
	} 
}
</script>
</body>
</html>