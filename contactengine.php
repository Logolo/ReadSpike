<?php

$EmailFrom = "felix@blackspike.com";
$EmailTo = "felix@blackspike.com";
$Subject = "Email from website contact form";
$Name = Trim(stripslashes($_POST['name'])); 
$Email = Trim(stripslashes($_POST['email'])); 
$Message = Trim(stripslashes($_POST['message'])); 

// validation
$validationOK=true;
if (!$validationOK) {
  print "<meta http-equiv=\"refresh\" content=\"0;URL=contacterror.htm\">";
  exit;
}

// prepare email body text
$Body = "";
$Body .= "Name: ";
$Body .= $Name;
$Body .= "\n";
$Body .= "\n";
$Body .= "Email: ";
$Body .= $Email;
$Body .= "\n";
$Body .= "\n";
$Body .= "Message: ";
$Body .= $Message;
$Body .= "\n";
$Body .= "\n";

// send email 
$success = mail($EmailTo, $Subject, $Body, "From: <$EmailFrom>");

// redirect to success page 
/*
  if ($success){
  print "<meta http-equiv=\"refresh\" content=\"0;URL=contactthanks.htm\">";
}
else{
  print "<meta http-equiv=\"refresh\" content=\"0;URL=contacterror.htm\">";
}

*/


?>