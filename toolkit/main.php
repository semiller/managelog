<?php
  // require configuration file
  require_once 'config/init.php';
  
  $warning = new Warnings();
  $training = new Training();
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"> -->
<title>Manage Log</title>
<link href="css/desktop.css" rel="stylesheet" type="text/css" />

</head>
<body>
<div class="main">
  
<?php include 'inc/header.inc.php'; ?>
<?php include 'inc/menu.inc.php'; ?>
<div class="clr"></div>
  <div class="body">
    <div class="body_resize">
    
    <?php // display these instructions if manager has not set up any employees
	if ($warning->detectDepartment() == false) {
		echo "<div class='setup_warning'><p><img src='images/warning_icon.png' alt=''>Initial setup required.  Please create a minimum of one <a href='department_category.php'>department</a> for your account to get started.</p></div>"; 
	} // end if
	?>
    
    <div class="dashboard">
    <h3>Dashboard</h3>
    
    <?php // only display if there is an employee past due with training Header info included in method
	$training->showTrainingRedFlag();
	?>
    
    <div class="training_graph_container">
    <h3>Training Completion Status (5 most recent)</h3>
    <?php
	$training = new Training();
	$training->showTrainingGraph();
	?>
    <!-- end training_graph_container --></div>
    
    <!-- Not necessary, but keeping for reference on how to only show options based on managers role -->
        <?php
		// create manager object and display these options only for managers with a role of '4 or below'
		$manager = new Manager();
		if($manager->getManagerRole() <= '4') { // all=1 manager=2 asst. manager=3, supervisor=4
		?>
    <div class="adminmenu_dashboard">
    <h3>Customization Menu</h3>
    	<ul>
<?php if ($_SESSION['managerDepartment'] == 'All') { // only for managers who oversee entire account ?>
<li><a href="department_category.php"><img src="images/department.png" alt="Departments">Departments</a></li>
<?php } // end if ?>
<li><a href="manager.php"><img src="images/user.png" alt="Managers">Managers</a></li>
<li><a href="training_category.php"><img src="images/training.png" alt="Training Categories">Training Categories</a></li>
<li><a href="jobtitle_category.php"><img src="images/jobtitle.png" alt="Job Titles">Job Titles</a></li>
<li><a href="project_category.php"><img src="images/project.png" alt="Project Categories">Project Categories</a></li>
<li><a href="journal_category.php"><img src="images/journal.png" alt="Journal Categories">Journal Categories</a></li>
<li><a href="workorder_category.php"><img src="images/workorder.png" alt="Work Order Categories">Work Order Categories</a></li>
<li><a href="safetrack_category.php"><img src="images/safetrack.png" alt="Safety Tracker Categories">Safety Tracker Categories</a></li>
</ul>
    <!-- end .adminmenu_dashboard --></div>
    <?php } // end if managerRole 
		?>
    
    <div class="clr"></div>
    
    <div class="workorder_dashboard">
    <h3>Recent Work Orders</h3>
    
    <?php
	$workorder = new WorkOrder();
	$workorder->workorderDashboardDisplay();
	?>
    <!-- end .workorder_dashboard --></div>
    
    <div class="project_dashboard">
    <h3>Recent Projects</h3>
    <?php
	$project = new Projects();
	$project->projectDashboardDisplay();
	?>
    <!-- end .project_dashboard --></div>
    
    
    
    <div class="safetrack_dashboard">
    <h3>Safety Tracker</h3>
    <?php
	// display most recent safety tracker discrepancies
	$safetrack = new SafeTrack();
	$safetrack->safetrackDashboardDisplay();
	?>
    <!-- end .safetrack_dashboard --></div>
    
    
    
    <div class="journal_dashboard">
    <h3>Journal Entries for <?php $today = date("F d, Y"); echo $today; ?></h3>
    <?php
	// display journal entries from today
	$journal = new Journal();
	$journal->journalDashboardDisplay();
	?>
    <!-- end .journal_dashboard --></div>
    
    <div class="clr"></div>
    <!-- end .dashboard --></div>
  
      
      <!-- end .body_resize --></div>
    <!-- end .body --></div>
 
 <div class="clr"></div>
 
<?php include 'inc/footer.inc.php'; ?>
 
  <!-- end .main --></div>

</body>
</html>