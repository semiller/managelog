<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="description" content="The Manage Log Service Toolkit is designed with the service manager in mind.  Let us assist with your daily tracking of all your daily activities and operations. ">
<meta name="keywords" content="manage, log, toolkit, service, tracker, training, safety, projects, work orders, journal">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" > 
<title>Manage Log | Contact Us</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script>

<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

</head>
<body>
<div class="main">
  <?php include 'inc/header.inc.php'; ?>
  <?php include 'inc/menu.inc.php'; ?>
  
  <?php include 'inc/banner.inc.php' ?>
   
  <div class="clr"></div>
  
  <div class="body">
    <div class="body_content">
     
      
      <div class="left">
        <h2>Contact Manage Log</h2>
        <?php 
	// VARIABLE AND ECHO TO STATE IF WRONG CAPTCHA HAVE BEEN POSTED
		if (isset($_GET['wrong_captcha'])) {
			echo "
			<p>
			<strong style='color: red'>You have entered an incorrect or blank verification on our contact form. Please resubmit your contact information.</strong>
			</p>
			";
		} // END IF STATEMENT FOR WRONG CAPTCHA
		?>
        <?php 
		if (isset($_GET['contact_sent'])) {
			echo "
			<p>
			<strong style='color: red'>We have received your contact information.  It is our goal to respond within 24-48 hours.  Should you need emergency assistance, please contact 410-952-9748.</strong>
			</p>
			";
		} 
		?>
        <form method="post" action="processcontact.php" class="generalform">
          <!-- HIDDEN FIELD TO BAN CERTAIN IP ADDRESSES -->
          <input type="hidden" name="ip_address" value=" <?php echo " $_SERVER[REMOTE_ADDR] "; ?> " />
          <p> Please ensure all fields are complete before submitting the contact form. </p>
          <ol>
            <li> <span id="sprytextfield1">
              <label for="name">Name:</label>
              <input type="text" name="name" id="name" class="text" />
              <div class="clr"></div>
              <span class="textfieldRequiredMsg">Please enter your name.</span></span> </li>
            <li> <span id="sprytextfield2">
              <label for="email">Email:</label>
              <input type="text" name="email" id="email" class="text" />
              <div class="clr"></div>
              <span class="textfieldRequiredMsg">Please enter your email address.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span> </li>
            <li> <span id="sprytextfield3">
              <label for="phone_number">Phone Number:</label>
              <input type="text" name="phone_number" id="phone_number" class="text" />
              <div class="clr"></div>
              <span class="textfieldRequiredMsg">Please enter your phone number.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span> </li>
            
            <li>
              <label for="message">Message:</label>
              <textarea cols="20" rows="5" name="message"></textarea>
            </li>
  
         
            <!-- This gets the current timestamp on form load.  deduct from process page to see if form submitted too quickly -->
           <input type="hidden" name="loadtime" value="<?php echo time(); ?>" />
            <li class="buttons">
              <input type="image" src="images/submit_btn.png" />
            </li>
          </ol>
        </form>
      <!-- end .left --></div>
      
      
      <div class="right">
      
      <?php include 'inc/join_today.inc.php'; ?>
      <?php include 'inc/tracking_features.inc.php'; ?>
      <!-- .right --></div>
      <div class="clr"></div>
    <!-- end .body_content --></div>
  <!-- end .body --></div>
<!-- end .main --></div>

<?php include 'inc/footer.inc.php'; ?>
</body>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "email");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "phone_number", {useCharacterMasking:true, format:"phone_custom", pattern:"000-000-0000"});
//-->
</script>
</html>
