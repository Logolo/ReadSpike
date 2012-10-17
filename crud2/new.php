<? 
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

include 'connect_db.php';
include 'open_db.php';



if (isset($_POST['submitted'])) { 
  foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); } 
  $sql = "INSERT INTO `user` ( `email` ,  `theme` ,  `fontsize`  ) VALUES(  '{$_POST['email']}' ,  '{$_POST['theme']}' ,  '{$_POST['fontsize']}'  ) "; 
  setcookie("email",$_POST['email']);
  setcookie("theme",$_POST['theme']);
  setcookie("fontsize",$_POST['fontsize']);
  
  mysql_query($sql) or die(mysql_error()); 
  echo "Added row.<br />"; 
  echo "<a href='list.php'>Back To Listing</a>"; 
} 
?>

<form action='' method='POST'> 
<p><b>Email:</b><br /><input type='text' name='email'/> 
<p><b>Theme:</b><br /><input type='text' name='theme'/> 
<p><b>Fontsize:</b><br /><input type='text' name='fontsize'/> 
<p><input type='submit' value='Add Row' /><input type='hidden' value='1' name='submitted' /> 
</form> 
