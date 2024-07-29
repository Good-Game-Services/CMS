<?php 
if(!session_id()){
    session_start();
}
require("config/db.php");
$title = "Support";
require("layout/head.php"); // $title = "page title"

if(checkUserSession($db) !== True){
    header("location: $_SUPPORT_FILE");
    exit; //$_SUPPORT_FILE --> /config/value.php
}

$user = searchUser_bSession($db, $_COOKIE["user_session"]);
?>

<html>
<head>
    <title><?php echo $title; ?></title>
    <!-- Include your head content here -->
</head>
<body class=" pace-done">
<div class="pace pace-inactive">
    <div class="pace-progress" data-progress-text="100%" data-progress="99" style="transform: translate3d(100%, 0px, 0px);">
        <div class="pace-progress-inner"></div>
    </div>
    <div class="pace-activity"></div>
</div>

<div id="wrapper">
    <?php
    $support = "active";
    $userName = $user["firstName"] . " " . $user["lastName"];
    require("layout/menu.php");
    ?>
    <div id="page-wrapper" class="gray-bg" style="min-height: 1263px;">
        <?php require("layout/navtop.php"); ?>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>Support</h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="support.php">Support</a>
                    </li>
                </ol>
            </div>
            <div class="col-lg-2">
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Support</h5>
                        </div>
                        <div class="ibox-content">
                            <div id="messageStatus"></div>

                            <form id="supportForm" method="POST">
                                <div class="form-group">
                                    <label for="subject">Subject:</label>
                                    <input type="text" class="form-control" id="subject" name="subject" required>
                                </div>
                                <div class="form-group">
                                    <label for="message">Message:</label>
                                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Send</button>
                            </form>

                            <hr>

                            <div id="ticketsList">
                                <h3>Your Tickets</h3>
                                <ul id="tickets"></ul>
                            </div>

                            <div id="ticketDetails" style="display: none;">
                                <h3 id="ticketSubject"></h3>
                                <div id="messages"></div>
                                <form id="addMessageForm">
                                    <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                                    <button type="submit" class="btn btn-primary">Add Message</button>
                                </form>
                            </div>

                            <?php
                            if(!empty($_SESSION["error_log"])){
                                echo $_SESSION["error_log"];
                                unset($_SESSION["error_log"]);
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- footer -->
        <?php require("layout/footer.php") ?>
        <!-- ./footer -->
    </div>
</div>

<!-- Mainly scripts -->
<script src="assets/js/jquery-3.1.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="assets/js/inspinia.js"></script>
<script src="assets/js/plugins/pace/pace.min.js"></script>
<script src="assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script>
$(document).ready(function() {
    function loadTickets() {
        $.ajax({
            type: 'POST',
            url: 'ajax/request/ticket/get_tickets.php',
            success: function(response) {
                let res = JSON.parse(response);
                if(res.success) {
                    let ticketsList = $('#tickets');
                    ticketsList.empty();
                    res.tickets.forEach(function(ticket) {
                        ticketsList.append('<li><a href="#" class="ticket-link" data-id="' + ticket.id + '">' + ticket.subject + '</a></li>');
                    });
                } else {
                    $('#ticketsList').html('<div class="alert alert-danger">' + res.message + '</div>');
                }
            }
        });
    }

    loadTickets();

    $('#supportForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            type: 'POST',
            url: 'ajax/request/ticket/support_ticket.php',
            data: $(this).serialize(),
            success: function(response) {
                let res = JSON.parse(response);
                if(res.success) {
                    $('#messageStatus').html('<div class="alert alert-success">' + res.message + '</div>');
                    $('#supportForm')[0].reset();
                    loadTickets();
                } else {
                    $('#messageStatus').html('<div class="alert alert-danger">' + res.message + '</div>');
                }
            }
        });
    });

    $('#tickets').on('click', '.ticket-link', function(e) {
        e.preventDefault();
        let ticketId = $(this).data('id');
        
        $.ajax({
            type: 'POST',
            url: 'ajax/request/ticket/get_ticket_details.php',
            data: { ticket_id: ticketId },
            success: function(response) {
                let res = JSON.parse(response);
                if(res.success) {
                    $('#ticketsList').hide();
                    $('#ticketDetails').show();
                    $('#ticketSubject').text(res.ticket.subject);
                    let messagesDiv = $('#messages');
                    messagesDiv.empty();
                    res.messages.forEach(function(message) {
                        messagesDiv.append('<p>' + message.message + ' <small>by User ' + message.user_id + ' on ' + message.created_at + '</small></p>');
                    });
                    $('#addMessageForm').data('ticket-id', ticketId);
                } else {
                    alert(res.message);
                }
            }
        });
    });

    $('#addMessageForm').on('submit', function(e) {
        e.preventDefault();
        let ticketId = $(this).data('ticket-id');
        let message = $('#message').val();
        
        $.ajax({
            type: 'POST',
            url: 'ajax/request/ticket/add_ticket_message.php',
            data: { ticket_id: ticketId, message: message },
            success: function(response) {
                let res = JSON.parse(response);
                if(res.success) {
                    $('#message').val('');
                    $('#ticketDetails .ticket-link[data-id="' + ticketId + '"]').click();
                } else {
                    alert(res.message);
                }
            }
        });
    });
});
</script>
</body>
</html>
