<?php 
/* 
* Anass Houlout
* Output 5 - Licence expiration warning (mail)
* Technical note: This php file needs to be run with the help of UNIX cronjobs in order to send emails when a month is a left of a client's licence.
*/

// Require config file to establish database connection
require('');

// Client ID
$clientID = mysqli_real_escape_string($DBConnect, $_GET["clientid"]);

// Client row
$sql = "SELECT * FROM CLIENT WHERE ClientID = '$clientID'";
$result = mysqli_query($DBConnect, $sql);
$client = mysqli_fetch_assoc($result);

// Licence row
$sql2 = "SELECT * FROM LICENSE WHERE ClientID = '$clientID'";
$result2 = mysqli_query($DBConnect, $sql2);
$license = mysqli_fetch_assoc($result2);

// Mail configuration
$to = $client['ClientEmail'];
$subject = 'License Expiration Warning';
$from = 'support@whitestone.com';
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Create email headers
$headers .= 'From: '.$from."\r\n".
    'Reply-To: '.$from."\r\n" .
    'X-Mailer: PHP/' . phpversion();
	
// HTML email message
$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
$message .= '<html xmlns="http://www.w3.org/1999/xhtml">';
$message .= '<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>License Expiration Warning</title><meta name="viewport" content="width=device-width, initial-scale=1.0"/></head><body>';
$message .= '<table align="center" border="1" cellpadding="0" cellspacing="0" width="700">';
$message .= '<tr><td bgcolor="#0077ca" style="padding: 5px; color: #fff">License Expiration Warning</td></tr>';
$message .= '<tr><td style="padding: 5px">Dear '.$client['ClientName'].',<br>';
$message .= 'This email is to inform you that your licence on White Stone Support Desk <b>will expire in one month.</b><br><br>';
$message .= '<b>Client Name:</b> '.$client['ClientName'].'<br>';
$message .= '<b>Address:</b> '.$client['Adress'].'<br>';
$message .= '<b>License Id:</b> '.$license['LicenseID'].'<br>';
$message .= '<b>Expiration Date:</b> '.$license['ExpiryDate'].'<br>';
$message .= '<br><b>Thank you for your comprehension!</b><br> Kind regards,<br> White Stone Support';
$message .= '</td></tr></table>';
$message .= '</body></html>';
 
// Sending email
if(mail($to, $subject, $message, $headers)){
    echo 'Mail successfully sent.';
} else{
    echo 'Unable to send email. Please try again.';
}
?>
