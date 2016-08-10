<?php 
//session_start(); // FOR STORING CAPTCHA

// BAN IP ADDRESSES
//include('inc/banip.inc.php');

// This is if the form is submitted too quickly.  Uses the hidden field on form.  Gets current time when form is loaded, then subtract seconds for how long it takes to submit form  Number in If is # of seconds
$loadtime = $_POST['loadtime'];
$totaltime = time() - $loadtime;
if($totaltime < 10)
{
   header("Location:http://www.google.com");
   exit();
}

// CONNECT TO DATABASE
include ("inc/connect.inc.php");

// CONTACT FORM VARIABLES
$name = $_POST['name'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$message = $_POST['message'];
$ip_address = $_POST['ip_address'];

$today = date('Y-m-d');

// VARIABLE REPLACE BAD CHARACTERS
$name = preg_replace( "#[^a-zA-Z0-9\.\!\?\* ]#", "", $name);
$message = preg_replace( "#[^a-zA-Z0-9\.\!\?\* ]#", "", $message);				

$result = $conn->query("INSERT INTO contact VALUES ('','$name','$today','$email','$phone_number','$message','$ip_address')");

//EMAIL TO SELF
$to = 'semillerjr@managelog.com'; 
$from = "semillerjr@managelog.com";
$headers = "MIME-Version: 1.0" . "\n";
$headers .= "Content-type:text/html;charset=iso-8859-1" . "\n";
$headers .= "From: $from" . "\n";

$emailmessage = "
<p>A new contact form has been sent from <strong>$name</strong>.<br>
All submitted information is listed below.
</p>

<p>Contact Information:</p>

<p>
<strong>Name:</strong> $name <br />

<strong>Email:</strong> $email <br />

<strong>Phone Number:</strong> $phone_number <br />

<strong>Message:</strong> $message
</p>
";
mail( $to, "Manage Log Contact Form", $emailmessage, $headers );

//EMAIL TO PERSON MAKING CONTACT
$to = $_POST['email']; 
$from = "semillerjr@managelog.com";
$headers = "MIME-Version: 1.0" . "\n";
$headers .= "Content-type:text/html;charset=iso-8859-1" . "\n";
$headers .= "From: $from" . "\n";

$emailmessage = "
<h4>$name , </h4>

<p>Thank you for contacting us.  Listed below are the details of the information you recently sent to us. <br> It is our effort to respond within 24-48 hours upon receiving your contact information. <br> If immediate assistance is necessary, please call our business office at 410-952-9748.<p>
</p>


<p>Contact Information:</p>

<p>
<strong>Name:</strong> $name <br />

<strong>Email:</strong> $email <br />

<strong>Phone Number:</strong> $phone_number <br />

<strong>Message:</strong> $message
</p>
<p>
If any changes are necessary to the information provided, please click <a href='http://www.managelog.com/contact.php'><u>HERE</u></a> to contact us.
</p>
<p>
Thank you for contacting Manage Log Service Toolkit
</p>
<p>
Stephen Miller
</p>
";
mail( $to, "Manage Log Contact Form", $emailmessage, $headers );

// HEADER AFTER FORM SUBMITTED
header ("Location: contact.php?contact_sent=yes");
exit();

?>