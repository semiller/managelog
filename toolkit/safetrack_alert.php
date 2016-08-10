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
<title>Manage Log | Safety Tracker Discrepancy | Safety Alert</title>
<link rel="stylesheet" href="css/paper_printing.css" type="text/css" />
<link rel="stylesheet" href="css/paper_printing_print.css" type="text/css" media="print" /> 

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
         <div class="paper_printing">
		<?php
		if(isset($_GET['safetrackId'])) { // if safetrackId is set
			// create SafeTrack object  
			$safetrack = new SafeTrack();
			// use GET to get safetrack information from SafeTrack class
			$safetrack->setSafeTrackValues($_GET['safetrackId']);
		?>
        
        <?php if ($safetrack->getViewAuth()) // if get value is not part of account, do not allow view (true to view, false fo no)
		 { ?>
        
       
        <form><input type="button" value=" Print this page " onclick="window.print();return false;" /></form> 
        <h2>SAFETY ALERT</h2>
        
        <p><span>Audience:</span> <?php echo $safetrack->getSafeTrackDepartment(); ?></p>
        <p><span>From:</span> <?php echo $safetrack->getSafeTrackSubmittedBy(); ?></p>
        <p><span>Date:</span> <?php echo date('F j, Y'); ?></p>
        <p><span>Subject: <?php echo $safetrack->getSafeTrackTitle(); ?></span></p>
        <hr>
        <h3>Category</h3>
        <p><?php echo $safetrack->getSafeTrackCategory(); ?></p>
        
     	<h3>Description</h3>
        <p><?php echo $safetrack->getSafeTrackDescription(); ?></p>
        
        <h3>Action Plan</h3>
        <p><?php echo $safetrack->getSafeTrackAction(); ?></p>
   
        <h3>Before / After Image</h3>
        <p><?php echo $safetrack->getSafeTrackBeforePic(); ?></p>
        
        <p><?php echo $safetrack->getSafeTrackAfterPic(); ?></p>
		<div class="clr"></div>
        <?php } // end getViewAuth ?>
        
		<?php	
		} // end if GET is set
		?>
        
        <!-- end .paper_printing --></div>

</body>
</html>