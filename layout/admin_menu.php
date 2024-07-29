<?php error_reporting(0);

$parts = explode('/', __FILE__);
$filename = $parts[count($parts) - 1];

if (strpos($_SERVER["SCRIPT_URI"], $filename) !== false) {
	exit("illegal method");
}
?>
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> 
				<span><img alt="image" class="img-circle" src="<?= $profilePicture ?>" width="50px" height="50px"></span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"> 
							<span class="block m-t-xs"> 
								<strong class="font-bold"><?= $userName ?><?php if($isVerified): ?> --- Verified<?php endif; ?></strong>
                             </span> 
								<!-- <span class="text-muted text-xs block">Art Director <b class="caret"></b></span> -->
							 </span> 
					</a>
                    <!-- <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="profile.html">Profile</a></li>
                        <li><a href="contacts.html">Contacts</a></li>
                        <li><a href="mailbox.html">Mailbox</a></li>
                        <li class="divider"></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul> -->
                </div>
                <div class="logo-element">
                    GGS
                </div>
            </li>
			<li class="<?= $homeChatMenu ?>">
                <a href="<?= $_HOME_FILE ?>"><i class="fa fa-home"></i> <span class="nav-label">Home</span></a>
            </li>
			
			<?php if($inLogin): ?>
			<li class="<?= $accountMenu ?>">
                <a href="account.php"><i class="fa fa-user-o"></i> <span class="nav-label">Account</span></a>
            </li>
            <li class="<?= $support ?>">
				<a href="support.php"><i class="fa fa-th-large"></i> <span class="nav-label">Support</span></a>
            </li>
			<?php endif; ?>
			<?php if($inLogin): if($isAdmin): if($adminArea !== "active"):?>
			<li class="">
                <a href="gci-cloud.php"><i class="fa fa-cogs"></i> <span class="nav-label">GCI Cloud</span></a>
            </li>
			<?php else: ?>
			<li class="active">
                <a href="gci-cloud.php"><i class="fa fa-cogs"></i> <span class="nav-label">GCI Cloud</span></a>
            </li>
			<?php endif;endif; ?>
 			<li>
                <a href="logout.php"><span class="nav-label"><i class="fa fa-sign-out"></i> Logout</span></a>
            </li>
			<?php endif; ?>
        </ul>
    </div>
</nav>
