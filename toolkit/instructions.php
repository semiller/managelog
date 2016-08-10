<?php
  // require configuration file
  require_once 'config/init.php';
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" > -->
<title>Manage Log | Instructions</title>
<link href="css/desktop.css" rel="stylesheet" type="text/css" />

</head>
<body>
<div class="main">
  
<?php include 'inc/header.inc.php'; ?>
<?php include 'inc/menu.inc.php'; ?>
  
  <div class="body">
    <div class="body_resize">
    
      <div class="left">
      <h3>Instructions</h3>
      <p>Set up account by using the main menu and customization menu.</p>
        <h3>Admin Instructions</h3>
        <ul>
        <li>Step 1: Create Department Listing for your facility</li>
        <li>Step 2: Create Managers based on their role and department</li>
        <li>Step 3: Give appropriate managers their login access to the system</li>
        </ul>
        <h3>Manager Instructions</h3>
        <ul>
        <li>Step 1: Create Managers for your department</li>
        <li>Step 2: Create Job Titles for your employees</li>
        <li>Step 3: Add Employees to the system</li>
        <li>Step 4: Create Categories for each task</li>
        <li>Step 5: Begin adding content to each task</li>
        
        </ul>
        
        <!-- end .left --></div>
        <div class="right">
        <?php include 'inc/admin_submenu.inc.php'; ?>
    	<div class="clr"></div>
        <!-- end .right --></div>
      <!-- end .body_resize --></div>
    <!-- end .body --></div>
 
 <div class="clr"></div>
 
<?php include 'inc/footer.inc.php'; ?>
 
  <!-- end .main --></div>

</body>
</html>