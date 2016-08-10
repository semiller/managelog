<div class="header">
<div class="block_header">
<div class="logo"><img src="images/managelog_logo.png" alt="logo"></div>

<div class="login_details">
<p><img src="images/user.png" alt="Log Name" /><a href="manager_profile.php?managerId=<?php echo $_SESSION['managerId']; ?>"><?php echo $_SESSION['managerFirstName'] . " " . $_SESSION['managerLastName']; ?> @ <?php echo $_SESSION['accountName']; ?></a> | <a href="logout.php">Logout</a></p>
<!-- end .login_details --></div>
<!-- end .block_header --></div>
<!-- end .header --></div>