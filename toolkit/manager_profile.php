<?php
  // require configuration file
  require_once 'config/init.php';
  
  $warning = new Warnings();
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" > -->
<title>Manage Log | Manager Profile</title>
<link href="css/desktop.css" rel="stylesheet" type="text/css" />
<link href="css/print_report.css" rel="stylesheet" type="text/css" media="print" />

<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){	
	// THIS IS HOW TO REMOVE A MEESAGE AFTER A CERTAIN TIME PERIOD
	setTimeout('$(".createMessage").fadeOut(1500)',1500);
	// or just use hide() instead of fadeout
});
</script>


</head>
<body>
<div class="main">
  
<?php include 'inc/header.inc.php'; ?>
<?php include 'inc/menu.inc.php'; ?>
  
  <div class="body">
    <div class="body_resize">
         
    <?php include 'inc/manager_menu.inc.php'; ?>
    <div class="clr"></div>
        
		<?php
		if(isset($_GET['managerId'])) { // if managerId is set
			// create Manager object  
			$manager = new Manager();
			
			// use GET to get manager information from Manager class
			$manager->setManagerValues($_GET['managerId']);
		?>
        
        
        
        <?php if ($manager->getViewAuth()) // if get value is not part of account, do not allow view (true to view, false fo no)
		 { ?>
        
        <div class="left">
        
        <!-- make link for editing and deleting this employee -->
        <h3>Manager Information<img src="images/printer.png" alt="Print Report" class="print_report_btn" onclick="window.print();return false;"></h3>
        
        <div class="profile_display">
        <ol>
        <li><label>Id #:</label>
        <div class="profile_data">
        <?php echo $manager->getManagerNumber(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Name:</label>
        <div class="profile_data">
        <?php echo $manager->getManagerFirstName() . " " . $manager->getManagerLastName(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Email:</label>
        <div class="profile_data">
        <?php echo $manager->getManagerEmail(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Phone:</label>
        <div class="profile_data">
        <?php echo $manager->getManagerPhone(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Department:</label>
        <div class="profile_data">
        <?php echo $manager->getManagerDepartment(); ?>
        <!-- end .profile_data --></div>
        </li>
        
        <div class="clr"></div>
        </ol>
        <!-- end .profile_display --></div>
        
        <!-- end .left --></div>
        
       <?php } // end getViewAuth ?>
        
			
			
		<?php	
		} // end if GET is set
		?>
        
        <div class="right">
    <?php include 'inc/admin_submenu.inc.php'; ?>
    <!-- end .right --></div>
    
        
    <!-- end .body_resize --></div>
    <!-- end .body --></div>
 
 <div class="clr"></div>
 
<?php include 'inc/footer.inc.php'; ?>
 
  <!-- end .main --></div>

</body>
</html>