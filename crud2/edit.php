<? 
include 'connect_db.php';
include 'open_db.php';
if (isset($_GET['id']) ) { 
$id = (int) $_GET['id']; 
if (isset($_POST['submitted'])) { 
foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); } 
$sql = "UPDATE `user` SET  `email` =  '{$_POST['email']}' ,  `theme` =  '{$_POST['theme']}' ,  `fontsize` =  '{$_POST['fontsize']}'   WHERE `id` = '$id' "; 

mysql_query($sql) or die(mysql_error()); 
echo (mysql_affected_rows()) ? "Edited row.<br />" : "Nothing changed. <br />"; 
echo "<a href='list.php'>Back To Listing</a>"; 
} 
$row = mysql_fetch_array ( mysql_query("SELECT * FROM `user` WHERE `id` = '$id' ")); 
?>

<form action='' method='POST'> 
<p><b>Email:</b><br /><input type='text' name='email' value='<?= stripslashes($row['email']) ?>' /> 
<p><b>Theme:</b><br /><input type='text' name='theme' value='<?= stripslashes($row['theme']) ?>' /> 
<p><b>Fontsize:</b><br /><input type='text' name='fontsize' value='<?= stripslashes($row['fontsize']) ?>' /> 
<p><input type='submit' value='Edit Row' /><input type='hidden' value='1' name='submitted' /> 
</form> 
<? } ?> 
